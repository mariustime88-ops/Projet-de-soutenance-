<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TdProgramme; // 🚨 Importez le modèle

class TDController extends Controller
{
    /**
     * Affiche la liste des TD (Travaux Dirigés) par niveau et filière depuis la base.
     */
    public function index()
    {
        // Récupération de tous les TD actifs, ordonnés par classe pour un meilleur affichage
        $allTds = TdProgramme::where('is_active', true)
                              ->orderBy('classe_niveau')
                              ->orderBy('filiere')
                              ->get();

        // 1. Groupement des TD pour le cycle Primaire (filiere est NULL)
        $tdsPrimaire = $allTds->filter(function($td) {
            return $td->filiere === null;
        })->values();

        // 2. Groupement des TD pour le cycle Secondaire (filiere n'est pas NULL)
        $tdsSecondaire = $allTds->filter(function($td) {
            return $td->filiere !== null;
        })->values();
        
        // Les vues recevront les objets du Modèle TdProgramme
        return view('td.index', compact('tdsPrimaire', 'tdsSecondaire'));
    }
}