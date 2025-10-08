<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Matiere;
use Illuminate\Support\Facades\DB;

class MatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Désactiver la vérification des clés étrangères (pour TRUNCATE)
        if (config('database.default') !== 'sqlite') {
            Schema::disableForeignKeyConstraints();
        }
        
        // 2. Vider la table 'matieres' pour un nouvel ensemencement propre
        Matiere::truncate();
        
        // 3. Définition des matières (AJOUT DE CONDUITE)
        $matieres = [
            // Matières principales
            ['nom' => 'Mathématiques', 'coefficient' => 4],
            ['nom' => 'Français', 'coefficient' => 2],
            ['nom' => 'Anglais', 'coefficient' => 2],
            ['nom' => 'Physique-Chimie', 'coefficient' => 4],
            ['nom' => 'Histoire-Géographie', 'coefficient' => 2],
            ['nom' => 'SVT', 'coefficient' => 4],
            ['nom' => 'Informatique', 'coefficient' => 1],
            ['nom' => 'Philosophie', 'coefficient' => 2],
            ['nom' => 'EPS', 'coefficient' => 1],

            // Matière spéciale pour la fiche de CONDUITE
            // 🚨 Il est essentiel que cette matière soit là pour les fiches de conduite
            ['nom' => 'CONDUITE', 'coefficient' => 1], 
        ];

        // 4. Insertion des données
        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
        }

        // 5. Réactiver la vérification des clés étrangères
        if (config('database.default') !== 'sqlite') {
            Schema::enableForeignKeyConstraints();
        }
    }
}