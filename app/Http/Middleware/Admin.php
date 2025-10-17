<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Gère une requête entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            // S'il n'est pas connecté, le renvoie à la page de connexion
            return redirect('/login');
        }

        // 2. Vérifie si l'utilisateur connecté est un administrateur (is_admin = 1)
        if (Auth::user()->is_admin) {
            // S'il est admin, lui permet de continuer
            return $next($request);
        }

        // 3. S'il est connecté mais n'est PAS un admin (il est un parent/utilisateur standard),
        // le redirige vers sa propre page d'accueil.
        return redirect('/home')->with('error', 'Accès refusé. Vous n\'êtes pas autorisé à accéder à la zone d\'administration.');
    }
}
