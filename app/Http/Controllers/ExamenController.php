<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamenController extends Controller
{
    /**
     * Affiche la page d'accueil des informations sur les examens.
     */
    public function index()
    {
        // Données complètes des frais d'examens
        // 🚨 CORRECTION : TOUS les statuts sont maintenant 'Doit être payé'
        $fraisExamens = [
            ['examen' => 'CM2 (CEPE)', 'montant' => 5000, 'statut' => 'Doit être payé'],
            ['examen' => '3ème (BEPC)', 'montant' => 15000, 'statut' => 'Doit être payé'],
            ['examen' => 'Tle (BAC)', 'montant' => 20000, 'statut' => 'Doit être payé'],
        ];

        // Liste des documents requis par niveau d'examen (inchangée)
        $documentsParExamen = [
            'CM2 (CEPE)' => [
                'Extrait de naissance récent',
                'Quittance des frais d\'inscription CEPE',
            ],
            '3ème (BEPC)' => [
                'Extrait de naissance récent',
                'Certificat de scolarité',
                'Quittance des frais d\'inscription BEPC',
            ],
            'Tle (BAC)' => [
                'Extrait de naissance récent',
                'Certificat de nationalité',
                'Quittance des frais d\'inscription BAC',
            ],
        ];

        return view('examens.index', compact('fraisExamens', 'documentsParExamen'));
    }

    /**
     * Affiche les détails concernant l'éligibilité et les documents des candidats.
     */
    public function candidats()
    {
        $documentsRequis = [
            'Extrait de naissance récent',
            'Certificat de scolarité 2024/2025',
            'Fiche d\'inscription remplie',
        ];
        
        return view('examens.candidats', compact('documentsRequis'));
    }

    /**
     * Affiche les informations sur les frais et le statut de paiement.
     */
    public function frais()
    {
        // 🚨 CORRECTION : Mise à jour des statuts ici aussi pour la cohérence
        $fraisExamens = [
            ['examen' => 'BEPC', 'montant' => 15000, 'statut' => 'Doit être payé', 'date_limite' => '2025-01-30'],
            ['examen' => 'BAC', 'montant' => 20000, 'statut' => 'Doit être payé', 'date_limite' => '2025-02-28'],
        ];
        
        return view('examens.frais', compact('fraisExamens'));
    }
}