<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecommandationController extends Controller
{
    public function index()
    {
        $recommandations = [
            [
                'titre' => 'Le Guide du Parent Accompagnateur',
                'description' => 'Un livre essentiel pour aider les parents à soutenir la réussite scolaire de leurs enfants, avec des conseils pratiques et des méthodes éprouvées.',
                'image' => 'https://via.placeholder.com/300x200?text=Livre+Guide',
                'auteur' => 'Dr. Marie Dupont',
                'categorie' => 'Livres',
                'effet' => 'shadow-lg'
            ],
            [
                'titre' => 'Tutoriels Vidéo en Mathématiques',
                'description' => 'Une plateforme en ligne avec des vidéos claires et concises pour maîtriser les concepts clés des mathématiques, de la 3e à la Terminale.',
                'image' => 'https://via.placeholder.com/300x200?text=Tutoriels+Maths',
                'auteur' => 'MathsFaciles.com',
                'categorie' => 'Ressources en ligne',
                'effet' => 'shadow-lg'
            ],
            [
                'titre' => 'L\'Importance de la Lecture',
                'description' => 'Un article qui met en lumière les bienfaits de la lecture quotidienne pour le développement de la créativité et l\'amélioration des compétences en écriture.',
                'image' => 'https://via.placeholder.com/300x200?text=Article+Lecture',
                'auteur' => 'L\'Éducateur moderne',
                'categorie' => 'Articles',
                'effet' => 'shadow-lg'
            ],
        ];

        return view('recommandation.index', compact('recommandations'));
    }
}