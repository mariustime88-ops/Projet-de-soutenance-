<?php

namespace App\Http\Controllers;

use App\Models\Enfant;
use App\Models\Matiere;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Affiche la liste des enfants du parent pour la sélection.
     */
    public function index()
{
    // Récupère uniquement les enfants de l'utilisateur connecté
    $enfants = Auth::user()->enfants;
    
    // --- LIGNE DE DÉBOGAGE ---

    return view('notes.index', compact('enfants'));
}

    /**
     * Affiche les notes et les moyennes d'un enfant spécifique.
     */
   
// app/Http/Controllers/NoteController.php

   // app/Http/Controllers/NoteController.php

// app/Http/Controllers/NoteController.php

    // Assurez-vous d'avoir les imports Auth, Enfant, Matiere, Note.

    /**
     * Affiche les notes et les moyennes d'un enfant spécifique.
     */
     public function show($enfantId)
    {
        $enfant = Enfant::where('user_id', Auth::id())->findOrFail($enfantId);
        $anneeScolaire = '2024/2025';

        $matieres = Matiere::orderBy('nom')->get(); 
        
        $notesExistantes = Note::where('enfant_id', $enfant->id)
                               ->where('annee_scolaire', $anneeScolaire)
                               ->get()
                               ->keyBy('matiere_id');
        
        // Initialisation des totaux généraux
        $totalPointsS1 = 0;
        $totalPointsS2 = 0;
        $totalCoeffS1 = 0;
        $totalCoeffS2 = 0;
        $resultats = []; // Contient toutes les matières normales

        // ----------------------------------------------------
        // 1. GESTION DE LA CONDUITE (COEFFICIENT 1, MAX 18)
        // ----------------------------------------------------
        $noteConduite = null;
        $coeffConduite = 1;

        if ($enfant->note_conduite !== null) {
            // Utiliser la note stockée dans la DB pour S1 et S2 (pour l'exemple, nous l'appliquons aux deux)
            $noteConduiteS1 = (float) $enfant->note_conduite;
            $noteConduiteS2 = (float) $enfant->note_conduite; // On duplique pour la moyenne annuelle

            // Ajout de la conduite aux totaux généraux pour S1 et S2
            $totalPointsS1 += $noteConduiteS1 * $coeffConduite;
            $totalCoeffS1 += $coeffConduite;
            
            $totalPointsS2 += $noteConduiteS2 * $coeffConduite;
            $totalCoeffS2 += $coeffConduite;

            // Préparation des données spécifiques de conduite
            $noteConduite = [
                'nom' => 'Conduite',
                'coeff' => $coeffConduite,
                'notes' => [
                    'S1' => $noteConduiteS1,
                    'S2' => $noteConduiteS2,
                ],
                // La moyenne annuelle est égale à la note si elle est la même pour S1 et S2
                'moyenne_annuelle' => number_format($noteConduiteS1, 2), 
                'statut' => $enfant->statut_conduite, // Statut pour la couleur dans la vue
            ];
        }
        // ----------------------------------------------------
        // FIN GESTION DE LA CONDUITE
        // ----------------------------------------------------


        // 2. BOUCLE SUR LES MATIÈRES NORMALES
        foreach ($matieres as $matiere) {
            $coeff = (float) $matiere->coefficient;
            $noteRecord = $notesExistantes->get($matiere->id);

            $noteS1 = $noteRecord && is_numeric($noteRecord->note_s1) ? (float) $noteRecord->note_s1 : null;
            $noteS2 = $noteRecord && is_numeric($noteRecord->note_s2) ? (float) $noteRecord->note_s2 : null;

            // Calcul de la Moyenne Annuelle de la Matière
            $moyenneAnnuelle = null;
            if (is_numeric($noteS1) && is_numeric($noteS2)) {
                $moyenneAnnuelle = number_format(($noteS1 + $noteS2) / 2, 2);
            }

            // Calcul des totaux pondérés pour les moyennes générales (MATIÈRES)
            if (is_numeric($noteS1)) {
                $totalPointsS1 += $noteS1 * $coeff;
                $totalCoeffS1 += $coeff;
            }
            if (is_numeric($noteS2)) {
                $totalPointsS2 += $noteS2 * $coeff;
                $totalCoeffS2 += $coeff;
            }
            
            $resultats[$matiere->id] = [
                'nom' => $matiere->nom,
                'coeff' => $coeff,
                'notes' => [
                    'S1' => $noteS1,
                    'S2' => $noteS2,
                ],
                'moyenne_annuelle' => $moyenneAnnuelle,
            ];
        }

        // 3. Calcul des Moyennes Générales (Incluant la Conduite)
        $moyenneSemestre1 = ($totalCoeffS1 > 0) ? number_format($totalPointsS1 / $totalCoeffS1, 2) : 'N/A';
        $moyenneSemestre2 = ($totalCoeffS2 > 0) ? number_format($totalPointsS2 / $totalCoeffS2, 2) : 'N/A';
        
        $totalCoeffAnnuel = $totalCoeffS1 + $totalCoeffS2; // Somme des coefficients notés (S1 + S2)
        $totalPointsAnnuel = $totalPointsS1 + $totalPointsS2;
        
        $moyenneAnnuelleGenerale = 'N/A';
        if ($totalCoeffAnnuel > 0) {
             // La moyenne annuelle générale (globale, conduite incluse)
             $moyenneAnnuelleGenerale = number_format($totalPointsAnnuel / $totalCoeffAnnuel, 2);
        }

        return view('notes.show', compact(
            'enfant', 
            'resultats', 
            'noteConduite', // NOUVEAU : On envoie la note de conduite séparément
            'moyenneSemestre1', 
            'moyenneSemestre2', 
            'moyenneAnnuelleGenerale'
        ));
    }
}