<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        // Les champs utilisés dans RecuuController::store() DOIVENT être ici
        'enfant_id', 
        'user_id',     // Clé étrangère vers le parent
        'tranche',     // Colonne pour le titre (Ex: Tranche 1)
        'periode',
        'nom_fichier', // Nom original
        'chemin',      // Chemin de stockage
    ];
    
    public function enfant()
    {
        return $this->belongsTo(Enfant::class);
    }
}
