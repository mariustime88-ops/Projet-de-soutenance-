<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evenement_culturel', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description_theme');
            $table->date('date_evenement');
            $table->string('programme_details'); // Liste des activités (pour la vue)
            $table->string('etat', 50)->default('Planifié');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evenement_culturel');
    }
};