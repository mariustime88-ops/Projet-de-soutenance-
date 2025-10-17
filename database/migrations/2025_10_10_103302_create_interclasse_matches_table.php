<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ATTENTION : La classe doit s'appeler CreateInterclasseMatchesTable,
// mais Laravel gère le nom exact basé sur le nom du fichier.

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interclasse_matches', function (Blueprint $table) {
            $table->id();
            $table->string('niveau_cycle'); // Ex: 'Primaire', '6 Première Cycle', '4 Secondaire'
            $table->string('equipe_a');
            $table->string('equipe_b');
            
            // Score et Résultat
            $table->string('score')->nullable(); // Ex: '8-2'. Nullable car à venir.
            $table->string('gagnant')->nullable(); // Nom de l'équipe gagnante (pour le classement)
            $table->text('details_resultat')->nullable();
            
            // Organisation du Tournoi
            $table->string('phase'); // Ex: 'Poule', 'Quart de Finale', 'Finale'
            $table->string('poule_nom')->nullable(); // Pour les matchs de poule, Ex: 'Poule A'

            // Planification
            $table->dateTime('date_heure_match');
            $table->string('lieu');
            
            // État (pour l'affichage en ligne)
            $table->boolean('is_active')->default(true); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interclasse_matches');
    }
};