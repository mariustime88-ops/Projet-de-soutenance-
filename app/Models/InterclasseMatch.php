<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterclasseMatch extends Model
{
    use HasFactory;

    protected $table = 'interclasse_matches';

    protected $fillable = [
        'niveau_cycle', 
        'equipe_a', 
        'equipe_b', 
        'score', 
        'gagnant', // Utilisé pour le classement
        'phase', 
        'poule_nom', // Utilisé pour le classement de poule
        'date_heure_match', 
        'lieu', 
        'details_resultat', 
        'is_active'
    ];
    
    protected $casts = [
        'date_heure_match' => 'datetime',
    ];
}