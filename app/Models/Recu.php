<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enfant_id', // Nouveau champ
        'tranche', 
        'nom_fichier',
        'chemin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enfant() // Nouvelle relation vers l'enfant concerné
    {
        return $this->belongsTo(Enfant::class);
    }
}