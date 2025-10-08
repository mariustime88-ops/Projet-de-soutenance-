<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ParametresController extends Controller
{
    /**
     * Affiche la page principale des paramètres.
     */
    public function index()
    {
        // Nous allons passer l'utilisateur authentifié pour afficher ses informations
        $user = auth()->user(); 
        
        return view('parametres.index', compact('user'));
    }

    /**
     * Gère la modification du mot de passe.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Vérification du mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Le mot de passe actuel est incorrect.',
            ]);
        }

        // Mise à jour du mot de passe
        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        return redirect()->route('parametres.index')->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
    
    // NOTE : Les fonctions pour changer le thème, la langue, etc., nécessiteraient 
    // l'utilisation de sessions ou de champs dans la table 'users' que nous allons simuler dans la vue.
}