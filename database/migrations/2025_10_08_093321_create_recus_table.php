<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('recus')) {
            Schema::create('recus', function (Blueprint $table) {
                $table->id();
                
                // Clé étrangère vers l'utilisateur (le parent) - D'après votre version originale
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
                
                // Clé étrangère vers l'enfant
                $table->foreignId('enfant_id')->nullable()->constrained('enfants')->onDelete('cascade'); 
                
                // La tranche/titre du paiement (sera rempli par le champ 'titre' du formulaire Admin)
                $table->string('tranche'); 
                
                // Nom original du fichier uploadé (sera rempli par le nom du fichier)
                $table->string('nom_fichier'); 
                
                // Chemin relatif dans le stockage (sera rempli par 'filePath' de l'upload)
                $table->string('chemin'); 
                
                // Si la colonne 'periode' est toujours requise, nous l'ajoutons ici :
                $table->string('periode')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};



