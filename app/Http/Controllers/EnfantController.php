<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enfant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 

class EnfantController extends Controller
{
    /**
     * Affiche la liste des enfants inscrits.
     */
    public function index()
    {
        // Récupère tous les enfants (ou ajuster si vous voulez filtrer par utilisateur)
        $enfants = Enfant::all(); 
        return view('enfants.index', compact('enfants'));
    }

    /**
     * Affiche le formulaire d'inscription d'un nouvel enfant.
     */
    public function create()
    {
        return view('cool');
    }

    /**
     * Enregistre un nouvel enfant dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'required|integer',
            'sexe' => 'required|string',
            'classe' => 'required|string|max:255',
            'lieu_naissance' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            // Le champ du formulaire est 'photo'
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable', 
            'allergies' => 'nullable|string',
            'info_medicales' => 'nullable|string',
            'adresse' => 'required|string',
            'contact_urgence_nom' => 'required|string',
            'contact_urgence_numero' => 'required|string',
        ]);
        
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Stocke la photo dans storage/app/public/photos
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Enfant::create([
            'user_id' => Auth::id(), 
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'age' => $request->age,
            'sexe' => $request->sexe,
            'classe' => $request->classe,
            'lieu_naissance' => $request->lieu_naissance,
            'date_naissance' => $request->date_naissance,
            // Nom de colonne harmonisé : photo_url
            'photo_url' => $photoPath, 
            'allergies' => $request->allergies,
            'info_medicales' => $request->info_medicales,
            'adresse' => $request->adresse,
            'contact_urgence_nom' => $request->contact_urgence_nom,
            'contact_urgence_numero' => $request->contact_urgence_numero,
        ]);

        return redirect()->back()->with('success', 'Inscription de l\'enfant réussie !');
    }

    /**
     * Affiche le formulaire de modification d'un enfant spécifique.
     */
    public function edit(Enfant $enfant)
    {
        return view('enfants.edit', compact('enfant'));
    }

    /**
     * Met à jour les informations d'un enfant dans la base de données.
     */
    public function update(Request $request, Enfant $enfant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'required|integer',
            'sexe' => 'required|string',
            'classe' => 'required|string|max:255',
            'lieu_naissance' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            'allergies' => 'nullable|string',
            'info_medicales' => 'nullable|string',
            'adresse' => 'required|string',
            'contact_urgence_nom' => 'required|string',
            'contact_urgence_numero' => 'required|string',
        ]);
        
        if ($request->hasFile('photo')) {
            // Si une ancienne photo existe, la supprimer
            if ($enfant->photo_url) {
                Storage::disk('public')->delete($enfant->photo_url);
            }
            // Télécharger la nouvelle photo
            $photoPath = $request->file('photo')->store('photos', 'public');
            $enfant->photo_url = $photoPath; // Mettre à jour la colonne photo_url
        }
        
        // Mise à jour des autres champs...
        $enfant->nom = $request->nom;
        $enfant->prenom = $request->prenom;
        $enfant->age = $request->age;
        $enfant->sexe = $request->sexe;
        $enfant->classe = $request->classe;
        $enfant->lieu_naissance = $request->lieu_naissance;
        $enfant->date_naissance = $request->date_naissance;
        $enfant->allergies = $request->allergies;
        $enfant->info_medicales = $request->info_medicales;
        $enfant->adresse = $request->adresse;
        $enfant->contact_urgence_nom = $request->contact_urgence_nom;
        $enfant->contact_urgence_numero = $request->contact_urgence_numero;

        $enfant->save();

        return redirect()->route('enfants.index')->with('success', 'Informations de l\'enfant mises à jour !');
    }

    /**
     * Supprime un enfant de la base de données.
     */
    public function destroy(Enfant $enfant)
    {
        // 1. Gérer la suppression de la photo sur le serveur
        // Utilisation harmonisée de photo_url
        if ($enfant->photo_url) { 
            // Supprimer la photo de l'espace de stockage public
            Storage::disk('public')->delete($enfant->photo_url);
        }

        // 2. Supprimer l'enregistrement de l'enfant de la base de données
        $enfant->delete();

        // 3. Rediriger l'utilisateur avec un message de succès
        return redirect()->route('enfants.index')->with('success', 'L\'enfant a été supprimé avec succès.');
    }

    /**
     * Affiche le profil détaillé de l'enfant.
     */
    public function show(Enfant $enfant)
    {
        // CORRECTION DE L'ERREUR : La vue est 'show' (dans resources/views/show.blade.php)
        return view('show', compact('enfant'));
    }

    /**
     * Met à jour la photo de profil de l'enfant (méthode séparée, si besoin).
     */
    public function updatePhoto(Request $request, Enfant $enfant)
    {
        // 1. Validation de la nouvelle photo
        $request->validate([
            // Le champ dans le formulaire doit être 'new_photo'
            'new_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // 2. Supprimer l'ancienne photo si elle existe
        // Utilisation harmonisée de photo_url
        if ($enfant->photo_url) { 
            // On supprime l'ancien fichier de la photo du disque de stockage 'public'
            Storage::disk('public')->delete($enfant->photo_url);
        }

        // 3. Télécharger et enregistrer la nouvelle photo
        // CORRECTION: Assurez-vous d'utiliser le nom du champ de fichier correct (new_photo)
        $path = $request->file('new_photo')->store('photos', 'public'); 

        // 4. Mettre à jour le chemin de la nouvelle photo dans la base de données
        // Utilisation harmonisée de photo_url
        $enfant->photo_url = $path; 
        $enfant->save(); 

        // 5. Rediriger l'utilisateur vers la page de profil avec un message de succès
        return redirect()->route('enfants.show', $enfant->id)->with('success', 'La photo de profil a été mise à jour avec succès.');
    }
}