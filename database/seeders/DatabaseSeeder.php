<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Importez le modèle User
use App\Models\Enfant; // Importez le modèle Enfant

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exécute les seeders dans l'ordre de dépendance
        $this->call([
            // UserSeeder::class,     // Si vous avez un seeder pour l'utilisateur
            MatiereSeeder::class,       // Doit être exécuté avant les notes
            // EnfantSeeder::class,   // Si vous avez un seeder pour les enfants
            // NoteTestSeeder::class, // Pour insérer des notes de test après les matières
        ]);

        // 🚨 SI VOUS N'AVEZ PAS DE USER SEEDER, créez l'utilisateur parent manuellement pour vous reconnecter
        // User::factory()->create([
        //     'name' => 'TIME Marius Mahougnon',
        //     'email' => 'mariustime88@gmail.com',
        // ]);
    }
}