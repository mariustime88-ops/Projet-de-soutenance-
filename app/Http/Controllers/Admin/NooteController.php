<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enfant;
use App\Models\Matiere;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NooteController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Affiche la liste des notes avec filtres.
     */
    public function index(Request $request)
    {
        $query = Note::with(['enfant', 'matiere'])
                     ->orderBy('date_evaluation', 'desc')
                     ->orderBy('id', 'desc');

        // Filtre par élève (enfant)
        if ($request->filled('enfant_id')) {
            $query->where('enfant_id', $request->enfant_id);
        }

        // Filtre par matière
        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $notes = $query->paginate(20)->appends($request->all());

        $enfants = Enfant::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('admin.notes.index', compact('notes', 'enfants', 'matieres'));
    }

    /**
     * Affiche le formulaire de création de note.
     */
    public function create()
    {
        $enfants = Enfant::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        // Si aucune matière ou aucun enfant n'existe, on redirige avec une erreur
        if ($enfants->isEmpty()) {
            return redirect()->route('admin.enfants.index')->with('error', 'Veuillez d\'abord ajouter des élèves avant d\'enregistrer des notes.');
        }
        if ($matieres->isEmpty()) {
             return redirect()->route('admin.matieres.index')->with('error', 'Veuillez d\'abord ajouter des matières avant d\'enregistrer des notes.');
        }

        return view('admin.notes.create', compact('enfants', 'matieres'));
    }

    /**
     * Enregistre une nouvelle note.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'enfant_id' => 'required|exists:enfants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20', // Note sur 20
            'date_evaluation' => 'required|date',
            'type_evaluation' => ['required', Rule::in(['Interrogation', 'Devoir', 'Examen', 'Projet', 'Autre'])],
            'commentaire' => 'nullable|string|max:500',
        ]);

        Note::create($validatedData);

        return redirect()->route('admin.notes.index')->with('success', 'La note a été enregistrée avec succès.');
    }

    /**
     * Affiche le formulaire pour modifier une note existante.
     */
    public function edit(Note $note)
    {
        $enfants = Enfant::orderBy('nom')->get();
        $matieres = Matiere::orderBy('nom')->get();

        return view('admin.notes.edit', compact('note', 'enfants', 'matieres'));
    }

    /**
     * Met à jour les informations d'une note.
     */
    public function update(Request $request, Note $note)
    {
        $validatedData = $request->validate([
            'enfant_id' => 'required|exists:enfants,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'date_evaluation' => 'required|date',
            'type_evaluation' => ['required', Rule::in(['Interrogation', 'Devoir', 'Examen', 'Projet', 'Autre'])],
            'commentaire' => 'nullable|string|max:500',
        ]);

        $note->update($validatedData);

        return redirect()->route('admin.notes.index')->with('success', 'La note a été mise à jour avec succès.');
    }

    /**
     * Supprime une note.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('admin.notes.index')->with('success', 'La note a été supprimée.');
    }
}