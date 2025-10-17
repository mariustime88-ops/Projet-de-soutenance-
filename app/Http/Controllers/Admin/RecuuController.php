<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Recu;
use App\Models\Enfant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecuuController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Affiche la liste des reçus mis en ligne (Vue : index).
     */
    public function index()
    {
        // Récupère les reçus avec l'élève associé, ordonnés par date de création
        $recus = Recu::with('enfant')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.recus.index', compact('recus'));
    }

    /**
     * Affiche le formulaire pour mettre un nouveau reçu en ligne (Vue : televerser).
     */
    public function create()
    {
        $enfants = Enfant::orderBy('nom')->get();
        if ($enfants->isEmpty()) {
            return redirect()->route('admin.enfants.index')->with('error', 'Veuillez d\'abord ajouter des élèves avant de mettre des reçus en ligne.');
        }
        // Utilisation de la vue 'televerser'
        return view('admin.recus.televerser', compact('enfants'));
    }

    /**
     * Traite l'upload et enregistre un nouveau reçu (Action : store).
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $validatedData = $request->validate([
            'enfant_id' => 'required|exists:enfants,id',
            // Le champ 'titre' du formulaire sera stocké dans la colonne 'tranche'
            'titre' => 'required|string|max:255', 
            'periode' => 'required|string|max:10',
            // Le fichier est requis et doit être un PDF/image
            'fichier' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        $fileName = null;

        // 2. Gestion de l'upload du fichier dans storage/app/public/recus
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            
            // Stocke le chemin relatif du fichier
            $filePath = $file->store('recus', 'public');
            
            // Récupère le nom original du fichier
            $fileName = $file->getClientOriginalName();
        } 
        
        // VÉRIFICATION CRITIQUE: Si l'upload a échoué malgré la validation
        if (!$filePath || !$fileName) {
             return redirect()->back()->withInput()->with('error', 'Échec de l\'enregistrement du fichier.');
        }

        // 3. Récupérer l'ID du parent lié à l'enfant (pour la relation user_id)
        $enfant = Enfant::find($validatedData['enfant_id']);
        
        // SÉCURITÉ : Détermine l'ID de l'utilisateur. 
        // Si l'enfant n'a pas de parent lié ($enfant->user_id est null), 
        // on peut laisser la base de données gérer le NULL (si elle est nullable).
        // Sinon, on met null pour éviter l'erreur si l'enfant n'est pas lié à un parent.
        $userId = $enfant ? $enfant->user_id : null; 
        
        // 4. Création de l'entrée dans la base de données
        try {
            Recu::create([
                'enfant_id' => $validatedData['enfant_id'],
                'user_id' => $userId, 
                'tranche' => $validatedData['titre'], 
                'periode' => $validatedData['periode'],
                'nom_fichier' => $fileName,      
                'chemin' => $filePath,           
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Log l'erreur pour le débogage et supprime le fichier
            Storage::disk('public')->delete($filePath);
            
            // Si l'erreur persiste, c'est presque toujours un problème de base de données (NULL non autorisé, ou champ manquant)
            return redirect()->back()->withInput()->with('error', 'Erreur de base de données lors de l\'enregistrement : ' . $e->getMessage());
        }

        return redirect()->route('admin.recuus.index')->with('success', 'Le reçu a été mis en ligne avec succès.');
    }

    /**
     * Supprime un reçu et le fichier associé.
     */
    public function destroy(Recu $recuu)
    {
        // Suppression du fichier physique dans le stockage
        if ($recuu->chemin) { // IMPORTANT: Utiliser 'chemin', pas 'fichier_path'
            Storage::disk('public')->delete($recuu->chemin);
        }
        
        // Suppression de l'entrée en base
        $recuu->delete();

        return redirect()->route('admin.recuus.index')->with('success', 'Le reçu a été supprimé.');
    }
    
    /**
     * Permet le téléchargement du reçu.
     */
    public function download(Recu $recuu)
    {
        // Récupère le fichier et le télécharge avec un nom convivial
        // Utiliser 'chemin' et 'nom_fichier'
        if (Storage::disk('public')->exists($recuu->chemin)) {
            // Le nom du fichier est 'nom_fichier'
            return Storage::disk('public')->download($recuu->chemin, $recuu->nom_fichier); 
        }

        return redirect()->back()->with('error', 'Fichier non trouvé.');
    }
}
