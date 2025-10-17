<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enfant; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Crée une nouvelle instance de contrôleur.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche le tableau de bord.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $userId = Auth::id();
        
        // IMPORTANT : Charger la variable $enfants pour la vue home et la modale
        $enfants = Enfant::where('user_id', $userId)->get();

        return view('home', [
            'enfants' => $enfants,
        ]);
    }

    /**
     * Méthode pour afficher les matricules (Utilisée par la route /matricule si elle existe).
     *
     * NOTE: Cette méthode est là UNIQUEMENT pour corriger l'erreur de route. 
     * Si vous utilisez @include, vous n'avez pas besoin d'une vue séparée.
     */
    public function showMatricules(Request $request)
    {
        $userId = Auth::id();
        $enfants = Enfant::where('user_id', $userId)->get();

        // Puisque cette fonction n'est pas censée renvoyer une page complète, 
        // nous redirigeons vers /home (la page qui affiche la modale).
        return redirect()->route('home')->with(['enfants' => $enfants]);
    }
}