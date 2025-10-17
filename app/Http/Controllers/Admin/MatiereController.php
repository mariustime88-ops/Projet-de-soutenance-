<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatiereController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Affiche la liste de toutes les matières.
     */
    public function index()
    {
        $matieres = Matiere::orderBy('nom')->paginate(10);
        return view('admin.matieres.index', compact('matieres'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle matière.
     */
    public function create()
    {
        return view('admin.matieres.create');
    }

    /**
     * Enregistre une nouvelle matière.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255|unique:matieres,nom', // Le nom de la matière doit être unique
            'coefficient' => 'required|numeric|min:0.5|max:10', // Coefficient de la matière (min 0.5, max 10)
        ]);

        Matiere::create($validatedData);

        return redirect()->route('admin.matieres.index')->with('success', 'La matière "' . $validatedData['nom'] . '" a été ajoutée avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier une matière existante.
     */
    public function edit(Matiere $matiere)
    {
        return view('admin.matieres.edit', compact('matiere'));
    }

    /**
     * Met à jour les informations d'une matière.
     */
    public function update(Request $request, Matiere $matiere)
    {
        $validatedData = $request->validate([
            // Le nom doit être unique, sauf pour la matière actuelle
            'nom' => ['required', 'string', 'max:255', Rule::unique('matieres')->ignore($matiere->id)], 
            'coefficient' => 'required|numeric|min:0.5|max:10',
        ]);

        $matiere->update($validatedData);

        return redirect()->route('admin.matieres.index')->with('success', 'La matière a été mise à jour avec succès.');
    }

    /**
     * Supprime une matière.
     */
    public function destroy(Matiere $matiere)
    {
        // ATTENTION : Si vous avez des notes liées à cette matière, 
        // la suppression en cascade (définie dans la migration) supprimera aussi ces notes.
        $nomMatiere = $matiere->nom;
        $matiere->delete();

        return redirect()->route('admin.matieres.index')->with('success', 'La matière "' . $nomMatiere . '" a été supprimée.');
    }
}