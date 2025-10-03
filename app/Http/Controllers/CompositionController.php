<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompositionController extends Controller
{
    /**
     * Affiche la page des dates de composition.
     * Les données réelles devraient venir d'une base de données, 
     * mais nous utilisons des données de démonstration pour la structure.
     */
    public function index()
    {
        // --- Données de Démonstration ---
        // Dans une application réelle, ces données seraient extraites de la base de données (table "compositions" ou "emplois_du_temps").
        
        $maternelle = [
            ['date' => '2024-12-10', 'matiere' => 'Éveil et Jeux'],
            ['date' => '2024-12-11', 'matiere' => 'Activités Graphiques'],
            ['date' => '2024-12-12', 'matiere' => 'Chant et Musique'],
        ];

        $primaire = [
            ['date' => '2024-12-10', 'matiere' => 'Français (Dictée & Rédaction)'],
            ['date' => '2024-12-11', 'matiere' => 'Mathématiques (Calcul & Problèmes)'],
            ['date' => '2024-12-12', 'matiere' => 'Sciences et Vie Pratique'],
            ['date' => '2024-12-13', 'matiere' => 'Histoire-Géographie'],
        ];

        $secondaire = [
            ['date' => '2024-12-05', 'matiere' => 'Mathématiques (Algèbre & Géométrie)'],
            ['date' => '2024-12-06', 'matiere' => 'Physique-Chimie'],
            ['date' => '2024-12-07', 'matiere' => 'Français (Dissertation & Commentaire)'],
            ['date' => '2024-12-08', 'matiere' => 'Anglais'],
            ['date' => '2024-12-09', 'matiere' => 'Histoire-Géographie'],
        ];

        // On passe les données à la vue
        return view('composition', compact('maternelle', 'primaire', 'secondaire'));
    }
}