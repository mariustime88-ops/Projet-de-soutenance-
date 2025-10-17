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
        Schema::create('enfants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('age');
            $table->string('sexe');
            $table->string('classe');
            $table->string('lieu_naissance');
            $table->date('date_naissance');
            $table->string('photo_url')->nullable();
            $table->string('allergies')->nullable();
            $table->text('info_medicales')->nullable();
            $table->string('adresse');
            $table->string('contact_urgence_nom');
            $table->string('contact_urgence_numero');
              $table->string('matricule', 20)->nullable()->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfants');
    }
};