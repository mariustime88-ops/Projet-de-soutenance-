<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use App\Models\Enfant; // Nouveau
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 
use ZipArchive; 

class RecuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Optionnel : Ajouter un middleware 'admin' pour create/store si nécessaire
    }
    
    /**
     * Affiche la liste des reçus de l'utilisateur connecté.
     */
    public function index()
    {
        // Récupère TOUS les reçus liés aux enfants de l'utilisateur connecté
        $recus = Auth::user()->enfants
                            ->load('recus') // Charge les reçus de chaque enfant
                            ->pluck('recus') // Récupère la collection de reçus
                            ->flatten() // Aplatit la collection
                            ->sortByDesc('created_at'); // Triez par date récente

        return view('recus.index', compact('recus'));
    }

    /**
     * [ADMIN] Affiche le formulaire pour téléverser un reçu.
     */
    public function create()
    {
        // Pour l'admin: Liste des enfants pour choisir le destinataire
        $enfants = Enfant::all(['id', 'nom', 'prenom', 'user_id']); 
        return view('recus.admin.televerser', compact('enfants'));
    }

    /**
     * [ADMIN] Enregistre le reçu dans le stockage et la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'enfant_id' => 'required|exists:enfants,id',
            'tranche' => 'required|string|max:255',
            'recu_fichier' => 'required|mimes:pdf|max:2048', 
        ]);

        $enfant = Enfant::findOrFail($request->enfant_id);
        
        $fichier = $request->file('recu_fichier');
        // Nom du fichier avec timestamp pour être unique
        $nomFichier = time() . '_' . $fichier->getClientOriginalName();
        
        // Stockage sur le disque 'public', dans le dossier 'recus'
        // Le chemin sera 'recus/123456_nom.pdf'
        $cheminStockage = $fichier->storeAs('recus', $nomFichier, 'public'); 

        Recu::create([
            'user_id' => $enfant->user_id, // Clé étrangère vers le parent de l'enfant
            'enfant_id' => $enfant->id,
            'tranche' => $request->tranche,
            'nom_fichier' => $nomFichier,
            'chemin' => $cheminStockage, 
        ]);

        return redirect()->back()->with('success', 'Le reçu a été téléversé et lié au parent avec succès !');
    }

    /**
     * Télécharge un reçu unique par ID (Parent/Utilisateur).
     */
    public function download($id) 
    {
        $recu = Recu::findOrFail($id);

        // 🚨 VÉRIFICATION DE SÉCURITÉ : L'utilisateur doit être le parent de l'enfant concerné.
        $enfant = $recu->enfant;
        if (!Auth::user()->enfants->contains($enfant)) {
            abort(403, 'Accès non autorisé au téléchargement de ce reçu.'); 
        }

        $cheminFichier = $recu->chemin;

        // Vérifie si le chemin est valide dans la DB
        if (empty($cheminFichier)) {
             abort(404, 'Le chemin du fichier est invalide dans la base de données.');
        }

        // Vérifie si le fichier existe et le télécharge (disque 'public')
        if (Storage::disk('public')->exists($cheminFichier)) {
            return Storage::disk('public')->download($cheminFichier, $recu->nom_fichier);
        }

        abort(404, 'Fichier de reçu non trouvé dans le système de stockage.');
    }
    
    /**
     * Télécharge TOUS les reçus de l'utilisateur connecté sous forme de fichier ZIP.
     */
    public function downloadAllUserRecus()
    {
        $user = Auth::user();
        // Récupère tous les reçus valides liés à tous les enfants de l'utilisateur
        $recus = $user->enfants
                      ->pluck('recus')
                      ->flatten()
                      ->filter(function($recu) {
                          // Filtre pour ne garder que les reçus avec un chemin valide
                          return !empty($recu->chemin) && Storage::disk('public')->exists($recu->chemin);
                      });
        
        if ($recus->isEmpty()) {
            return redirect()->back()->with('error', "Aucun reçu valide trouvé pour le téléchargement ZIP.");
        }

        $zipFileName = 'recus_scolarite_' . $user->id . '_' . time() . '.zip';
        $tempDir = storage_path('app/temp'); 
        $zipPath = $tempDir . '/' . $zipFileName;

        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0775, true);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $disk = Storage::disk('public');
            $filesAdded = 0;

            foreach ($recus as $recu) {
                $fullPath = $disk->path($recu->chemin);
                
                if (File::exists($fullPath)) {
                    // Nom du fichier dans le ZIP : [NomEnfant] - [Tranche] - [NomFichier]
                    $enfantNom = $recu->enfant->prenom . '_' . $recu->enfant->nom;
                    $zipEntryName = $enfantNom . ' - ' . $recu->tranche . ' - ' . $recu->nom_fichier;
                    $zip->addFile($fullPath, $zipEntryName);
                    $filesAdded++;
                }
            }
            
            $zip->close();
            
            if ($filesAdded > 0 && File::exists($zipPath)) {
                return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
            } else {
                if (File::exists($zipPath)) { File::delete($zipPath); }
                return redirect()->back()->with('error', 'Aucun fichier reçu valide trouvé pour le téléchargement ZIP.');
            }
        }

        return redirect()->back()->with('error', 'Erreur lors de la création du fichier ZIP.');
    }
}