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
        Schema::create('recus', function (Blueprint $table) {
            $table->id();
            // Clé étrangère vers l'utilisateur (le parent)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            // Colonne pour l'enfant (Nous utiliserons ceci plus tard pour le filtre)
            $table->foreignId('enfant_id')->nullable()->constrained()->onDelete('cascade'); 
            // La tranche de paiement (ex: "Tranche 1", "Scolarité complète")
            $table->string('tranche'); 
            // Nom original du fichier uploadé (ex: "recu_brice_T1.pdf")
            $table->string('nom_fichier'); 
            // Chemin relatif dans le stockage (ex: "recus/1665487800_recu_brice.pdf")
            $table->string('chemin'); 
            
            $table->timestamps();
             });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};
