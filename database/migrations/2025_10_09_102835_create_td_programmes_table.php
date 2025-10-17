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
        Schema::create('td_programmes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('matiere', 100);
            $table->string('classe_niveau', 50); // Ex: 'CI & CP', 'Tle'
            $table->string('filiere')->nullable(); // Ex: 'C, D', 'MC & ML' (NULL pour le primaire)
            $table->string('jour', 20)->default('Samedi');
            $table->string('heure', 50); // Ex: '08h00 - 13h00'
            $table->date('date_td')->nullable(); // Optionnel : pour des dates précises
            $table->boolean('is_active')->default(true); // Pour désactiver un TD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_programmes');
    }
};