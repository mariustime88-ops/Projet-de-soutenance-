<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvenementCulturel extends Model
{
    use HasFactory;
    
    protected $table = 'evenement_culturel';

    protected $fillable = [
        'titre', 
        'description_theme', 
        'date_evenement', 
        'programme_details', 
        'etat'
    ];

    protected $casts = [
        'date_evenement' => 'date',
    ];
}