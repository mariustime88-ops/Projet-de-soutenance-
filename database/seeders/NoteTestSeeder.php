<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Enfant;
use App\Models\Matiere;

class NoteTestSeeder extends Seeder
{
    /**
     * Insère des notes de test pour le premier enfant trouvé.
     */
   public function run(): void
    {
        $enfant = Enfant::first();
        if (!$enfant) {
            $this->command->warn('Aucun enfant trouvé. Veuillez créer un enfant (ex: avec EnfantTestSeeder ou via l\'interface).');
            return;
        }

        $matieres = Matiere::all();
        if ($matieres->isEmpty()) {
            $this->command->warn('Aucune matière trouvée. Veuillez exécuter MatiereSeeder en premier.');
            return;
        }

        $notesToInsert = [];

        foreach ($matieres as $matiere) {
            // Génération de notes aléatoires pour S1 et S2 (entre 8.00 et 18.00)
            $noteS1 = rand(80, 180) / 10; 
            $noteS2 = rand(80, 180) / 10;
            
            $notesToInsert[] = [
                'enfant_id' => $enfant->id,
                'matiere_id' => $matiere->id,
                'note_s1' => $noteS1,
                'note_s2' => $noteS2,
                'annee_scolaire' => '2024/2025',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Supprime les anciennes notes de l'enfant avant d'en insérer de nouvelles
        DB::table('notes')->where('enfant_id', $enfant->id)->delete();
        
        DB::table('notes')->insert($notesToInsert);

        $this->command->info('Notes de test S1 et S2 insérées pour l\'enfant: ' . $enfant->prenom . ' ' . $enfant->nom);
    }
}
