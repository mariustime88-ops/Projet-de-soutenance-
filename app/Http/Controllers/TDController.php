<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TDController extends Controller
{
    public function index()
    {
        $tds = [
            [
                'titre' => 'TD de Mathématiques - Probabilités',
                'description' => 'Un ensemble d\'exercices sur les probabilités et statistiques.',
                'classe' => 'Terminale',
                'date' => '25/09/2025'
            ],
            [
                'titre' => 'TD de Français - La dissertation',
                'description' => 'Sujets et méthodes pour la dissertation littéraire.',
                'classe' => 'Terminale',
                'date' => '27/09/2025'
            ],
            [
                'titre' => 'TD de Physique - Électricité',
                'description' => 'Problèmes sur les circuits électriques et les lois de l\'électrocinétique.',
                'classe' => 'Terminale',
                'date' => '28/09/2025'
            ],
            [
                'titre' => 'TD d\'Histoire - La Seconde Guerre Mondiale',
                'description' => 'Questions sur les causes, le déroulement et les conséquences du conflit.',
                'classe' => 'Troisième',
                'date' => '26/09/2025'
            ],
            [
                'titre' => 'TD de Sciences - Le cycle de l\'eau',
                'description' => 'Explications et exercices sur le cycle naturel de l\'eau.',
                'classe' => 'Troisième',
                'date' => '29/09/2025'
            ],
            [
                'titre' => 'TD d\'Anglais - L\'expression écrite',
                'description' => 'Exercices de rédaction et de grammaire pour améliorer l\'écriture.',
                'classe' => 'Troisième',
                'date' => '30/09/2025'
            ],
        ];

        $tdsTerminale = collect($tds)->where('classe', 'Terminale')->all();
        $tdsTroisieme = collect($tds)->where('classe', 'Troisième')->all();

        return view('td.index', compact('tdsTerminale', 'tdsTroisieme'));
    }
}