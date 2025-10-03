<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('enfants', function (Blueprint $table) {
            // REMPLACER ->after('annee_scolaire') par ->after('classe') ou une autre colonne EXISTANTE.
            // J'utilise 'classe' comme exemple, vérifiez que cette colonne existe.
            $table->decimal('note_conduite', 4, 2)->nullable()->after('classe'); 
            
            // J'enlève le second `after` pour simplifier, il se placera juste après `note_conduite`
            $table->unsignedInteger('heures_colle')->default(0); 
        });
    }

    public function down(): void
    {
        Schema::table('enfants', function (Blueprint $table) {
            $table->dropColumn('note_conduite');
            $table->dropColumn('heures_colle');
        });
    }
};