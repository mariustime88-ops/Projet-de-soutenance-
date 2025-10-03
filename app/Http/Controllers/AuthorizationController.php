<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index()
    {
        // Données pour la page
        $authorizations = [
            [
                'titre' => 'Livres et Fournitures',
                'contenu' => 'Tous les élèves doivent se présenter avec la liste complète des livres et fournitures scolaires dès le premier jour de la rentrée. La destruction ou la dégradation des manuels est formellement interdite.',
                'icon' => 'book'
            ],
            [
                'titre' => 'Habillement',
                'contenu' => 'Le port de l\'uniforme scolaire est obligatoire. Il doit être propre et repassé. Les tenues extravagantes, les pantalons déchirés, et les bijoux ostentatoires sont interdits.',
                'icon' => 'tshirt'
            ],
            [
                'titre' => 'Comportement et Discipline',
                'contenu' => 'Le respect des enseignants, du personnel administratif, et des autres élèves est primordial. Les actes d\'intimidation, les bagarres, et le langage grossier ne seront pas tolérés.',
                'icon' => 'smile'
            ],
        ];

        return view('autorisation.index', compact('authorizations'));
    }
}