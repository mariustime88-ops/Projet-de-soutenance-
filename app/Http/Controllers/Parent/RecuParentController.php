<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Recu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Enfant; // Assurez-vous d'importer Enfant

class RecuParentController extends Controller
{
    public function __construct()
    {
        // S'assurer que seul un utilisateur connecté peut accéder
        $this->middleware('auth'); 
    }

    /**
     * Affiche la liste des reçus du parent.
     */
    public function index()
    {
        $parent = Auth::user();

        // Méthode 1: Trouver les reçus via la relation user_id (si elle a été renseignée par l'admin)
        $recus = Recu::where('user_id', $parent->id)
                      ->with('enfant') 
                      ->orderBy('created_at', 'desc')
                      ->get();

        // Méthode 2: Trouver les reçus via les enfants (méthode de secours)
        if ($recus->isEmpty()) {
            $enfantsIds = $parent->enfants()->pluck('id'); 
            $recus = Recu::whereIn('enfant_id', $enfantsIds)
                          ->with('enfant')
                          ->orderBy('created_at', 'desc')
                          ->get();
        }
        
        // La vue gère l'affichage 'Aucun reçu' si $recus est vide.
        return view('recus.index', compact('recus')); 
    }

    /**
     * Permet le téléchargement d'un reçu individuel sécurisé.
     */
    public function downloadSingle(Recu $recu)
    {
        $parent = Auth::user();

        // SÉCURITÉ : Vérifier que le reçu est bien lié à l'utilisateur via enfant_id ou user_id
        if ($recu->user_id != $parent->id) {
            
            // Vérification de secours via l'enfant
            $enfantsIds = $parent->enfants()->pluck('id');
            if (!$enfantsIds->contains($recu->enfant_id)) {
                 // Si le reçu n'appartient ni au parent directement, ni à l'un de ses enfants
                return abort(403, 'Accès non autorisé à ce reçu. (403)');
            }
        }
        
        // Utilisation de la colonne 'chemin' pour le chemin réel du fichier
        if (Storage::disk('public')->exists($recu->chemin)) {
             // Utilisation de la colonne 'nom_fichier' pour le nom du téléchargement
             return Storage::disk('public')->download($recu->chemin, $recu->nom_fichier);
        }

        return redirect()->route('recus.index')->with('error', 'Fichier non trouvé ou a été déplacé.');
    }

    /**
     * Permet le téléchargement de tous les reçus (à implémenter en ZIP plus tard).
     */
    public function downloadAll()
    {
        // Logique pour générer et retourner un fichier ZIP
        return redirect()->route('recus.index')->with('error', 'La fonction de téléchargement ZIP sera bientôt disponible.');
    }
}
