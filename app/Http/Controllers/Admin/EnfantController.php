<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enfant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EnfantController extends Controller
{
    public function __construct()
    {
        // Applique le middleware 'admin' à toutes les actions de ce contrôleur
        $this->middleware('admin');
    }

    /**
     * Affiche la liste de TOUS les enfants/élèves du système avec option de recherche.
     */
    public function index(Request $request)
    {
        // 1. Initialiser la requête avec la relation 'user' (parent) et ordonner par nom
        $query = Enfant::with('user')->orderBy('nom', 'asc');

        // 2. Traitement de la recherche (si le champ 'search' est rempli)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            
            // Filtre : recherche par matricule, nom ou prénom
            $query->where(function ($q) use ($searchTerm) {
                $q->where('matricule', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('nom', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $searchTerm . '%');
            });
            // Optionnel : Si vous voulez rechercher aussi par nom de parent
            /*
            $query->orWhereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
            */
        }

        // 3. Récupérer les résultats paginés
        $enfants = $query->paginate(20)->appends(['search' => $request->search]); // Assure que le paramètre de recherche est conservé lors de la pagination

        return view('admin.enfants.index', compact('enfants'));
    }

    /**
     * Affiche le formulaire de création d'un enfant par l'administrateur.
     */
    public function create()
    {
        // Récupère tous les utilisateurs non-administrateurs pour lier l'enfant
        $parents = User::where('is_admin', 0)->orderBy('name')->get();
        return view('admin.enfants.create', compact('parents'));
    }

    /**
     * Enregistre un nouvel enfant créé par l'administrateur.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:18',
            'sexe' => ['required', Rule::in(['M', 'F', 'Autre'])],
            'classe' => 'required|string|max:255',
            'lieu_naissance' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'allergies' => 'nullable|string|max:500',
            'info_medicales' => 'nullable|string|max:500',
            'adresse' => 'nullable|string|max:255',
            'contact_urgence_nom' => 'nullable|string|max:255',
            'contact_urgence_numero' => 'nullable|string|max:20',
            'matricule' => 'nullable|string|max:50|unique:enfants,matricule',
        ]);

        $photoPath = null;
        // 1. Gestion de l'upload de photo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos_enfants', 'public');
        }

        // 2. Création de l'enfant
        $enfant = Enfant::create([
            'user_id' => $validatedData['user_id'],
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'age' => $validatedData['age'],
            'sexe' => $validatedData['sexe'],
            'classe' => $validatedData['classe'],
            'lieu_naissance' => $validatedData['lieu_naissance'],
            'date_naissance' => $validatedData['date_naissance'],
            'photo_url' => $photoPath,
            'allergies' => $validatedData['allergies'],
            'info_medicales' => $validatedData['info_medicales'],
            'adresse' => $validatedData['adresse'],
            'contact_urgence_nom' => $validatedData['contact_urgence_nom'],
            'contact_urgence_numero' => $validatedData['contact_urgence_numero'],
            'matricule' => $validatedData['matricule'] ?? null,
        ]);

        return redirect()->route('admin.enfants.index')->with('success', 'Élève ' . $enfant->prenom . ' a été créé et lié au parent.');
    }

    /**
     * Affiche le formulaire pour modifier un enfant/élève.
     */
    public function edit(Enfant $enfant)
    {
        $parents = User::where('is_admin', 0)->orderBy('name')->get();
        return view('admin.enfants.edit', compact('enfant', 'parents'));
    }

    /**
     * Met à jour les informations d'un enfant/élève.
     */
    public function update(Request $request, Enfant $enfant)
    {
        // Validation des données, en ignorant l'ID de l'enfant actuel pour la vérification 'unique' du matricule
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:18',
            'sexe' => ['required', Rule::in(['M', 'F', 'Autre'])],
            'classe' => 'required|string|max:255',
            'lieu_naissance' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'allergies' => 'nullable|string|max:500',
            'info_medicales' => 'nullable|string|max:500',
            'adresse' => 'nullable|string|max:255',
            'contact_urgence_nom' => 'nullable|string|max:255',
            'contact_urgence_numero' => 'nullable|string|max:20',
            'matricule' => ['nullable', 'string', 'max:50', Rule::unique('enfants')->ignore($enfant->id)],
        ]);

        $photoPath = $enfant->photo_url;

        // 1. Gestion de la mise à jour de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($enfant->photo_url) {
                Storage::disk('public')->delete($enfant->photo_url);
            }
            // Enregistrer la nouvelle photo
            $photoPath = $request->file('photo')->store('photos_enfants', 'public');
        }

        // 2. Mise à jour de l'enfant
        $enfant->update(array_merge($validatedData, ['photo_url' => $photoPath]));

        return redirect()->route('admin.enfants.index')->with('success', 'Élève ' . $enfant->prenom . ' mis à jour avec succès.');
    }

    /**
     * Supprime un enfant/élève.
     */
    public function destroy(Enfant $enfant)
    {
        // Suppression de la photo liée
        if ($enfant->photo_url) {
            Storage::disk('public')->delete($enfant->photo_url);
        }
        
        $enfant->delete();

        return redirect()->route('admin.enfants.index')->with('success', 'Élève supprimé avec succès.');
    }
}
