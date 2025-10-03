<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // Supprimez toutes les autres instances de $this->call([...])
        // et n'utilisez que la structure suivante :
        $this->call([
             // UserSeeder::class, // Décommentez si vous voulez recréer des utilisateurs
             MatiereSeeder::class,      // Pour remplir la table des matières
             NoteTestSeeder::class,     // Pour insérer des notes de test 
             ]);
    }
    
}