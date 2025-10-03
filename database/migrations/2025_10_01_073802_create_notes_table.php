<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécute les migrations (crée la table 'notes').
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('enfant_id')->constrained()->onDelete('cascade');
    $table->foreignId('matiere_id')->constrained()->onDelete('cascade');

    // Champs des notes (utilisés par le contrôleur)
    $table->decimal('note_s1', 4, 2)->nullable(); // Note du Semestre 1
    $table->decimal('note_s2', 4, 2)->nullable(); // Note du Semestre 2
    $table->string('annee_scolaire')->default('2024/2025');

    $table->timestamps();

    // Cette ligne garantit qu'il n'y a qu'une seule ligne de notes par enfant et par matière
    $table->unique(['enfant_id', 'matiere_id', 'annee_scolaire']); 
});
    }

    /**
     * Annule les migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};

