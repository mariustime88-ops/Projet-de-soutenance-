<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterclasseMatch;
use App\Models\EvenementCulturel;

class EvenementController extends Controller
{
    public function index()
    {
        // 1. Récupération des événements culturels (inchangé)
        $evenementsCulturels = EvenementCulturel::where('etat', '!=', 'Terminé')
                                                ->orderBy('date_evenement', 'asc')
                                                ->get();

        // 2. Récupération de TOUS les matchs insérés, triés par date.
        // Le filtre 'is_active' est retiré pour que l'administrateur voie TOUT.
        $allMatchesGrouped = InterclasseMatch::orderBy('date_heure_match', 'asc')
                                   ->get()
                                   ->groupBy('niveau_cycle');

        // 3. Définition des cycles à afficher.
        // CES CLÉS DOIVENT ÊTRE UTILISÉES LORS DE L'INSERTION DANS LA BDD !
        $cycles = [
            'Primaire'          => $allMatchesGrouped->get('Primaire', collect()),
            '6 Première Cycle'  => $allMatchesGrouped->get('6 Première Cycle', collect()), 
            '4 Secondaire'      => $allMatchesGrouped->get('4 Secondaire', collect()),      
        ];
        
        // Retirer les cycles qui n'ont aucun match (parfait pour l'affichage)
        $cycles = array_filter($cycles, function($matchList) {
            return $matchList->isNotEmpty();
        });


        return view('evenements.index', compact('evenementsCulturels', 'cycles'));
    }
}