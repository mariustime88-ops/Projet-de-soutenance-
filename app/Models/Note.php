<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'enfant_id',
        'matiere_id',
        'valeur',
        'semestre',
    ];

    /**
     * Relation : Une note appartient à un enfant.
     */
    public function enfant()
    {
        return $this->belongsTo(Enfant::class);
    }

    /**
     * Relation : Une note appartient à une matière.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
