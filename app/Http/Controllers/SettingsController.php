<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }
    public function update(Request $request)
{
    // Traitez les données ici (langue, notifications...)
    // Par exemple, vous pouvez enregistrer les données dans la base de données de l'utilisateur.

    return redirect()->back()->with('success', 'Préférences enregistrées avec succès!');
}
}
