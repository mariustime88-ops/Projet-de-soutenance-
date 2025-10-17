<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recu; 
use Illuminate\Support\Facades\DB; // Ajouté pour les requêtes DB

class Enfant extends Model
{
    use HasFactory;

    // Note maximale pour la conduite
    const NOTE_MAX_CONDUITE = 18.0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'age',
        'sexe',
        'classe',
        'lieu_naissance',
        'date_naissance',
        'photo_url',
        'allergies',
        'info_medicales',
        'adresse',
        'contact_urgence_nom',
        'contact_urgence_numero',
        'photo_path',
        'etat_sante',
        'note_conduite', // Stocke la note calculée
        'heures_colle',  // Entrée pour le calcul
        'matricule',     // **<-- AJOUTÉ : Le matricule unique**
    ];
    
    // Ajout des mutators pour le calcul automatique et la génération du matricule
    protected static function booted()
    {
        static::saving(function ($enfant) {
            // 1. Mise à jour de la note de conduite avant l'enregistrement (comme avant)
            $enfant->note_conduite = $enfant->getNoteFinaleCalculeeAttribute();
        });

        // 2. Génération du matricule uniquement lors de la CRÉATION
        static::creating(function ($enfant) {
            // S'assure qu'un matricule est généré seulement s'il n'existe pas déjà
            if (empty($enfant->matricule)) {
                $enfant->matricule = $enfant->generateMatricule();
            }
        });
    }

    /**
     * Génère un matricule unique basé sur l'année, le sexe, la classe et un numéro séquentiel.
     * Le format sera YYYY-SEXE-CLASSE-NNNN
     * Exemple : 2023-F-CE1-0015
     *
     * @return string
     */
    protected function generateMatricule(): string
    {
        $annee = date('Y');
        $sexe_code = strtoupper(substr($this->sexe, 0, 1)); // F ou M
        $classe_code = strtoupper(str_replace([' ', '-', '.'], '', $this->classe)); // Ex: CE1, CP, TLEC

        // Partie 1: Déterminer le compteur séquentiel pour l'année en cours
        // Trouve le dernier matricule pour l'année
        $latestEnfant = Enfant::where('matricule', 'like', $annee . '-%')
                              ->orderBy('matricule', 'desc')
                              ->first();

        $sequentialNumber = 1;

        if ($latestEnfant) {
            // Exemple : '2025-M-CP-0010'
            $parts = explode('-', $latestEnfant->matricule);
            // Assurez-vous que le dernier élément existe et est un nombre
            if (count($parts) > 3 && is_numeric(end($parts))) {
                $lastNumber = end($parts);
                $sequentialNumber = intval($lastNumber) + 1;
            }
        }

        // Partie 2: Formatage final (NNNN sur 4 chiffres)
        $sequentialString = str_pad($sequentialNumber, 4, '0', STR_PAD_LEFT);

        return "{$annee}-{$sexe_code}-{$classe_code}-{$sequentialString}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Calcule la déduction de points selon la règle: 1 point / 2 heures de colle.
     * @return float
     */
    public function getDeductionPointsAttribute(): float
    {
        // CORRECTION : Applique la règle 2h = -1 point
        return ($this->heures_colle ?? 0) / 2.0; 
    }

    /**
     * Calcule la note de conduite réelle basée sur 18 moins la déduction.
     * C'est cette valeur qui sera utilisée pour stocker et afficher.
     * @return float
     */
    public function getNoteFinaleCalculeeAttribute(): float
    {
        $note = self::NOTE_MAX_CONDUITE - $this->deduction_points;
        return max(0.0, $note);
    }


    /**
     * Méthode existante, renommée pour être plus claire.
     */
    public function getNoteFinaleConduiteAttribute()
    {
        // On retourne la note stockée (qui est mise à jour via le booted/saving)
        return $this->note_conduite !== null ? max(0, $this->note_conduite) : null;
    }

    /**
     * Détermine le statut de l'enfant (Exclus, Sous Surveillance, ou Normal).
     */
    public function getStatutConduiteAttribute()
    {
        // On utilise la note stockée, ou la note calculée si note_conduite est null
        $note = $this->note_conduite ?? $this->note_finale_calculee;

        if ($this->note_conduite === null && ($this->heures_colle === null || $this->heures_colle === 0)) {
            return [
                'texte' => 'Non évalué',
                'couleur' => 'secondary' // Gris
            ];
        }

        if ($note < 10) {
            return [
                'texte' => 'Exclusion Définitive 🚫',
                'couleur' => 'danger' // Rouge
            ];
        } elseif ($note >= 10 && $note < 12) {
            return [
                'texte' => 'Sous Surveillance !',
                'couleur' => 'warning' // Jaune
            ];
        } else {
            return [
                'texte' => 'Conduite Satisfaisante 👍',
                'couleur' => 'success' // Vert
            ];
        }
    }
        public function recus()
    {
        // Un enfant peut avoir plusieurs reçus (pour différentes tranches)
        return $this->hasMany(Recu::class);
    }
    

}