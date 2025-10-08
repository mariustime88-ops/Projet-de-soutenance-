<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamenFraisController extends Controller
{
    /**
     * Affiche la page des informations et frais des examens.
     */
    public function index()
    {
        // --- Données d'Examen Simulé ---
        $examens = [
            'CM2' => [
                'nom_examen' => 'Certificat d\'Études Primaires (CEP)',
                'frais' => '10 000 XOF',
                'dossiers' => [
                    'Acte de naissance (copie légalisée)',
                    'Certificat de scolarité de l\'année en cours',
                    'Quittance de paiement des frais d\'examen',
                    '4 photos d\'identité récentes (format passeport)',
                ],
                'informations' => [
                    'Les épreuves se déroulent généralement en fin d\'année scolaire, entre juin et juillet.',
                    'Vérifiez la date limite de dépôt des dossiers auprès de l\'administration.',
                ]
            ],
            '3ème' => [
                'nom_examen' => 'Brevet d\'Études du Premier Cycle (BEPC)',
                'frais' => '15 000 XOF',
                'dossiers' => [
                    'Acte de naissance (copie légalisée)',
                    'Fiche d\'inscription dûment remplie et signée par le parent/tuteur',
                    'Certificat de nationalité (copie simple)',
                    'Reçu de versement des frais d\'examen',
                    '2 photos d\'identité',
                ],
                'informations' => [
                    'L\'examen du BEPC inclut une phase écrite et, pour certaines options, une épreuve orale ou pratique.',
                    'Les candidats sont invités à réviser les programmes des classes de 4ème et 3ème.',
                ]
            ],
            'Terminale' => [
                'nom_examen' => 'Baccalauréat (BAC)',
                'frais' => '25 000 XOF',
                'dossiers' => [
                    'Acte de naissance original ou copie légalisée',
                    'Attestation de succès au BEPC (original ou copie légalisée)',
                    'Certificat de scolarité du niveau Terminale',
                    'Quittance de paiement des frais d\'examen (y compris l\'assurance)',
                    'Rapport médical (pour certaines filières)',
                ],
                'informations' => [
                    'Le Baccalauréat est divisé en plusieurs filières (A, B, C, D, G1, G2). Les épreuves diffèrent selon la filière.',
                    'Le paiement des frais se fait en une seule tranche au début du second semestre.',
                    'Une préparation spécifique aux épreuves anticipées est souvent nécessaire.',
                ]
            ]
        ];

        return view('examens.index', compact('examens'));
    }
}