<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié ET si le champ is_admin est vrai
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Si l'utilisateur n'est pas admin, il est redirigé (par exemple vers la page d'accueil)
        return redirect('/home')->with('error', 'Accès non autorisé à l\'administration.');
    }
}