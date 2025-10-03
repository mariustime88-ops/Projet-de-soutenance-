<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Enfant;
use Illuminate\Support\Facades\Hash;

class EnfantTestSeeder extends Seeder
{
    /**
     * Crée un utilisateur parent de test et un enfant pour ce parent.
     */
    public function run(): void
    {
        // 1. Création de l'utilisateur de test (si non existant)
        $user = User::firstOrCreate(
            ['email' => 'parent.test@ecole.com'],
            [
                'name' => 'Parent Test',
                'password' => Hash::make('password'), // Mot de passe: password
            ]
        );

        // 2. Création de l'enfant de test
        Enfant::firstOrCreate(
            ['nom' => 'Dupont', 'prenom' => 'Lucas'],
            [
                'user_id' => $user->id,
                'date_naissance' => '2015-05-10',
                'classe' => '5ème B',
                // Ajoutez les autres champs requis par votre table 'enfants' si nécessaire
                // (Ex: 'age' => 10, 'sexe' => 'M', 'lieu_naissance' => 'Paris', etc.)
            ]
        );

        $this->command->info('Utilisateur parent (parent.test@ecole.com / password) et Enfant de test (Lucas Dupont) créés.');
    }
}