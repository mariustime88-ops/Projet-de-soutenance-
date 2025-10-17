<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TdProgramme extends Model
{
    use HasFactory;

    // Assurez-vous que le nom de la table est bien défini
    protected $table = 'td_programmes'; 

    // Les champs que vous remplirez via phpMyAdmin
    protected $fillable = [
        'titre',
        'description',
        'matiere',
        'classe_niveau',
        'filiere',
        'jour',
        'heure',
        'date_td',
        'is_active',
    ];
}