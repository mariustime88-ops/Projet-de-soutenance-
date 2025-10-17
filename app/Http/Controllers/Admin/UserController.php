<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Affiche la liste de TOUS les utilisateurs (parents et autres admins).
     */
    public function index()
    {
        // Récupère les utilisateurs et les trie, met en évidence les admins.
        $users = User::orderBy('is_admin', 'desc')->orderBy('name')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire pour modifier un utilisateur.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour les informations d'un utilisateur.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // L'email doit être unique, sauf pour l'utilisateur actuel
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // is_admin doit être 0 (Parent) ou 1 (Admin)
            'is_admin' => ['required', Rule::in([0, 1])],
        ]);
        
        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur ' . $user->name . ' a été mis à jour.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(User $user)
    {
        // Mesure de sécurité: Interdire à l'utilisateur de se supprimer lui-même
        if (Auth::id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        // IMPORTANT: Gérer les relations. Si un utilisateur est supprimé, que deviennent ses enfants ?
        // Dans le modèle User, vous devriez avoir 'onDelete' => 'cascade' pour les relations 'hasMany' d'enfants.
        // Si ce n'est pas le cas, vous devez supprimer les enfants manuellement ici avant de supprimer l'utilisateur.
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'L\'utilisateur (Parent) a été supprimé avec succès.');
    }
}