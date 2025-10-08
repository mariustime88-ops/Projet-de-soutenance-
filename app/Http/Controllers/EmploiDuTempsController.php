<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    /**
     * Affiche la page de sélection de la classe pour l'emploi du temps.
     */
    public function index()
    {
        // --- Liste des classes CORRIGÉE et COMPLÈTE ---
        $classes = [
            'Primaire' => ['CI', 'CP', 'CE1', 'CE2', 'CM1', 'CM2'],
            'Secondaire' => [
                '6ème', '5ème', '4ème', 
                '3ème (MC)', '3ème (ML)',
                
                // Niveaux 2nde
                '2nde A', '2nde B', '2nde C', '2nde D', '2nde G1', '2nde G2',
                
                // Niveaux 1ère
                '1ère A', '1ère B', '1ère C', '1ère D', '1ère G1', '1ère G2',
                
                // Niveaux Terminale
                'Terminal A', 'Terminal B', 'Terminal C', 'Terminal D', 'Terminal G1', 'Terminal G2',
            ]
        ];

        return view('emploi_du_temps.index', compact('classes'));
    }

    /**
     * Gère la requête AJAX ou POST pour afficher l'emploi du temps d'une classe spécifique.
     */
    public function show(Request $request)
    {
        $classe = $request->input('classe');
        
        // Simuler la récupération de l'emploi du temps pour la classe sélectionnée
        $emploiDuTemps = $this->getEmploiDuTempsData($classe);

        // Renvoyer le HTML du tableau via AJAX
        if ($request->ajax()) {
            return view('emploi_du_temps.tableau', compact('emploiDuTemps', 'classe'))->render();
        }

        // Sinon, rediriger (cas non-AJAX)
        return redirect()->route('emploi_du_temps.index')->with('classe_selectionnee', $classe);
    }


    /**
     * Fonction utilitaire pour simuler la récupération de données d'EDT.
     * Logique simplifiée : À remplacer par une requête à la base de données.
     * @param string $classe
     * @return array
     */
    private function getEmploiDuTempsData($classe)
    {
        // Extraction du niveau (ex: Terminal) et de la filière (ex: C)
        $parts = explode(' ', $classe);
        $niveau = $parts[0] ?? $classe; // Terminal, 1ère, 6ème, etc.
        $filiere = $parts[1] ?? ''; // A, B, C, G1, (MC), etc.

        // Logique de simulation basée sur les filières
        if (in_array($filiere, ['C', 'D'])) {
            // Filières scientifiques/techniques (Maths, PC)
            return [
                'Lundi' => [
                    ['heure' => '07h30 - 09h30', 'matiere' => 'Mathématiques Avancées', 'salle' => $classe],
                    ['heure' => '10h00 - 12h00', 'matiere' => 'Physique-Chimie', 'salle' => 'Labo ' . $filiere],
                ],
                'Mardi' => [
                    ['heure' => '08h00 - 10h00', 'matiere' => 'SVT / Technologie', 'salle' => $classe],
                ],
            ];
        } elseif (in_array($filiere, ['A', 'B'])) {
            // Filières littéraires (Philo, Histoire, Français)
            return [
                'Lundi' => [
                    ['heure' => '07h30 - 09h30', 'matiere' => 'Philosophie', 'salle' => $classe],
                    ['heure' => '10h00 - 12h00', 'matiere' => 'Français (Dissertation)', 'salle' => $classe],
                ],
                'Mardi' => [
                    ['heure' => '08h00 - 10h00', 'matiere' => 'Histoire-Géographie', 'salle' => $classe],
                ],
            ];
        } elseif (in_array($filiere, ['G1', 'G2'])) {
            // Filières tertiaires/techniques (Compta, Droit, Éco)
            return [
                'Lundi' => [
                    ['heure' => '08h00 - 10h00', 'matiere' => 'Comptabilité / Gestion', 'salle' => $classe . ' - B'],
                    ['heure' => '10h00 - 12h00', 'matiere' => 'Droit ou Économie', 'salle' => $classe . ' - B'],
                ],
                'Mardi' => [
                    ['heure' => '08h00 - 10h00', 'matiere' => 'Mathématiques', 'salle' => $classe . ' - B'],
                ],
            ];
        } elseif ($classe === 'CM2') {
            // Primaire
            return [
                'Lundi' => [
                    ['heure' => '07h30 - 09h00', 'matiere' => 'Calcul & Problèmes', 'salle' => 'Classe CM2'],
                    ['heure' => '09h00 - 10h30', 'matiere' => 'Lecture & Grammaire', 'salle' => 'Classe CM2'],
                ],
                'Mardi' => [
                    ['heure' => '07h30 - 09h00', 'matiere' => 'Histoire-Géographie', 'salle' => 'Classe CM2'],
                ],
            ];
        } else {
            // Cas par défaut (6ème, 5ème, 4ème, 3ème, CI, CP, etc.)
            return [
                'Lundi' => [
                    ['heure' => '08h00 - 12h30', 'matiere' => 'Programme Standard Général', 'salle' => $classe],
                ],
                'Mardi' => [
                    ['heure' => '08h00 - 12h30', 'matiere' => 'Programme Standard Général', 'salle' => $classe],
                ],
            ];
        }
    }
}