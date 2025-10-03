<?php

namespace App\Http\Controllers;

use App\Models\Recu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use ZipArchive; 

class RecuController extends Controller
{
    /**
     * Affiche la liste des reçus de l'utilisateur connecté.
     */
    public function index()
    {
        // Récupère uniquement les reçus associés à l'utilisateur authentifié, triés par tranche
        $recus = Auth::check() ? Auth::user()->recus->sortBy('tranche') : collect();
        return view('recus.index', compact('recus'));
    }

    /**
     * Affiche le formulaire de téléversement (Admin).
     */
    public function create()
    {
        $users = User::all();
        return view('recus.televerser', compact('users'));
    }

    /**
     * Gère la soumission du formulaire et stocke le reçu (Admin).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tranche' => 'required|string|max:255',
            'recu_fichier' => 'required|mimes:pdf|max:2048', 
        ]);

        $fichier = $request->file('recu_fichier');
        $nomFichier = time() . '_' . $fichier->getClientOriginalName();
        // IMPORTANT : Utilisez 'public' pour le disque si vous stockez dans storage/app/public
        $cheminStockage = $fichier->storeAs('recus', $nomFichier, 'public'); 

        Recu::create([
            'user_id' => $request->user_id,
            'tranche' => $request->tranche,
            'nom_fichier' => $nomFichier,
            'chemin' => $cheminStockage,
        ]);

        return redirect()->back()->with('success', 'Le reçu a été téléversé avec succès !');
    }

    /**
     * Télécharge un reçu unique par ID.
     */
    public function download($id) 
    {
        // 1. Rechercher l'objet Recu par l'ID
        $recu = Recu::find($id);

        if (!$recu) {
            abort(404, 'Reçu non trouvé.');
        }

        // 2. VÉRIFICATION DE SÉCURITÉ : L'utilisateur doit être authentifié ET le propriétaire du reçu.
        if (!Auth::check() || Auth::user()->id !== $recu->user_id) {
            abort(403, 'Accès non autorisé au téléchargement.');
        }

        // 3. Chemin du fichier: Utiliser le chemin stocké, sinon construire le chemin par défaut.
        // On utilise la fonction empty() pour vérifier si $recu->chemin est NULL ou une chaîne vide.
        $cheminFichier = !empty($recu->chemin) 
            ? $recu->chemin 
            : ('recus/' . $recu->nom_fichier);

        // 4. Vérifie si le fichier existe et le télécharge
        // Si $cheminFichier est vide ici, il y a une erreur dans les données de la DB.
        if (empty($cheminFichier)) {
             abort(404, 'Le chemin du fichier est invalide dans la base de données.');
        }

        if (Storage::disk('public')->exists($cheminFichier)) {
            // Storage::download échoue si le premier argument est une chaîne vide
            return Storage::disk('public')->download($cheminFichier, $recu->nom_fichier);
        }

        abort(404, 'Fichier de reçu non trouvé dans le système de stockage.');
    }
    
    /**
     * Télécharge TOUS les reçus de l'utilisateur connecté sous forme de fichier ZIP.
     */
    public function downloadAllUserRecus()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $recus = $user->recus;
        
        if ($recus->isEmpty()) {
            return redirect()->back()->with('error', "Aucun reçu trouvé pour votre compte.");
        }

        $zipFileName = 'recus_scolarite_' . $user->id . '_' . time() . '.zip';
        // Stockage temporaire dans le dossier public
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        // Crée le dossier temp s'il n'existe pas
        Storage::disk('public')->makeDirectory('temp');

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $disk = Storage::disk('public');
            foreach ($recus as $recu) {
                // Logique de chemin sécurisée pour chaque fichier
                $cheminFichierStocke = !empty($recu->chemin) 
                    ? $recu->chemin 
                    : ('recus/' . $recu->nom_fichier);

                if ($disk->exists($cheminFichierStocke)) {
                    $fileContents = $disk->get($cheminFichierStocke);
                    // Nom de l'entrée dans le ZIP, incluant la tranche pour plus de clarté
                    $zipEntryName = $recu->tranche . ' - ' . $recu->nom_fichier;
                    $zip->addFromString($zipEntryName, $fileContents);
                }
            }
            
            $zip->close();
            
            if (file_exists($zipPath)) {
                // Télécharge le fichier ZIP et le supprime après l'envoi
                $response = response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
                return $response;
            }
        }

        return redirect()->back()->with('error', 'Erreur lors de la création du fichier ZIP.');
    }

    /**
     * Télécharge tous les reçus d'un utilisateur sous forme de fichier ZIP (Admin).
     */
    public function downloadAllTranches($userId)
    {
         $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur non trouvé.');
        }
        
        $recus = $user->recus;
        if ($recus->isEmpty()) {
            return redirect()->back()->with('error', "Aucun reçu trouvé pour l'utilisateur {$user->name}.");
        }

        $zipFileName = 'reçus_scolarité_' . $user->id . '_' . time() . '.zip';
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        Storage::disk('public')->makeDirectory('temp');

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $disk = Storage::disk('public');
            foreach ($recus as $recu) {
                 // Logique de chemin sécurisée pour chaque fichier
                $cheminFichierStocke = !empty($recu->chemin) 
                    ? $recu->chemin 
                    : ('recus/' . $recu->nom_fichier);
                
                if ($disk->exists($cheminFichierStocke)) {
                    $fileContents = $disk->get($cheminFichierStocke);
                    $zipEntryName = $recu->tranche . ' - ' . $recu->nom_fichier;
                    $zip->addFromString($zipEntryName, $fileContents);
                }
            }
            
            $zip->close();
            
            if (file_exists($zipPath)) {
                $response = response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
                return $response;
            }
        }

        return redirect()->back()->with('error', 'Erreur lors de la création du fichier ZIP.');
    }
}
