<?php

namespace App\Http\Controllers;

use App\Models\Enfant;
use Illuminate\Support\Facades\Auth;

class ConduiteController extends Controller
{
    /**
     * Affiche la page de sélection des enfants pour la conduite.
     */
    public function index()
    {
        // Récupère uniquement les enfants de l'utilisateur connecté
        $enfants = Auth::user()->enfants; 
        
        // La vue sera similaire à notes.index, mais nous allons la nommer conduite.index
        return view('conduite.index', compact('enfants'));
    }

    /**
     * Affiche la fiche de conduite pour l'enfant sélectionné.
     */
    public function show($enfantId)
    {
        // ... (Le code show() donné précédemment est correct) ...
        $enfant = Enfant::where('user_id', Auth::id())->findOrFail($enfantId);

        return view('conduite.show', compact('enfant'));
    }
}