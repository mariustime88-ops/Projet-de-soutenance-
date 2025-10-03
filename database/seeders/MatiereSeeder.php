<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Matiere; // Assurez-vous d'avoir bien importé le modèle Matiere
use Illuminate\Support\Facades\DB; // Optionnel si vous utilisez DB::table

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        // --- NOUVEAU CODE IMPORTANT ---
        // Désactive temporairement la vérification des clés étrangères (OBLIGATOIRE pour TRUNCATE)
        if (config('database.default') !== 'sqlite') {
            Schema::disableForeignKeyConstraints();
        }
        
        // Vider la table avant de la remplir pour éviter les doublons
        Matiere::truncate(); // Cette ligne fonctionnera maintenant
        
        // --- FIN DU NOUVEAU CODE ---


        // Définition des matières (votre tableau existant)
       // ...
        $matieres = [
            ['nom' => 'Mathématiques', 'coefficient' => 4],
            ['nom' => 'Français', 'coefficient' => 2],
            ['nom' => 'Anglais', 'coefficient' => 2], // <-- EST-CE QUE CELLE-CI EST LÀ ?
            ['nom' => 'Physique-Chimie', 'coefficient' => 4],
            ['nom' => 'Histoire-Géographie', 'coefficient' => 2],
            ['nom' => 'SVT', 'coefficient' => 4],
            ['nom' => 'EPS', 'coefficient' => 1], // <-- ET CELLE-CI ?
            ['nom' => 'Informatique', 'coefficient' => 1],
            ['nom' => 'Philosophie', 'coefficient' => 2],

        ];
// ...
        // Insertion des données dans la base de données
        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
        }

        // --- NOUVEAU CODE IMPORTANT ---
        // Réactive la vérification des clés étrangères
        if (config('database.default') !== 'sqlite') {
            Schema::enableForeignKeyConstraints();
        }
    }
}