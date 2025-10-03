<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EnfantController;
use App\Http\Controllers\TDController;
use App\Http\Controllers\AuthorizationController;
// Assurez-vous d'avoir ceci en haut du fichier
use App\Http\Controllers\RecommandationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\RecuController; 
use App\Http\Controllers\NoteController;
// ... autres routes
 use App\Http\Controllers\CompositionController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route qui va à la vue d'inscription des enfants
// Elle est protégée pour que seuls les utilisateurs connectés puissent y accéder
Route::middleware(['auth'])->group(function () {
    Route::get('/enfants/create', [EnfantController::class, 'create'])->name('enfants.create');
    Route::post('/enfants/store', [EnfantController::class, 'store'])->name('enfants.store');
    Route::get('/enfants', [EnfantController::class, 'index'])->name('enfants.index');
    Route::get('/enfants/{enfant}/edit', [EnfantController::class, 'edit'])->name('enfants.edit');
    Route::put('/enfants/{enfant}', [EnfantController::class, 'update'])->name('enfants.update');
    Route::delete('/enfants/{enfant}', [EnfantController::class, 'destroy'])->name('enfants.destroy');


// Dans le groupe middleware(['auth'])->group(function () { ...
    
    // Ancien : Route::get('/conduite/{enfantId}', [App\Http\Controllers\ConduiteController::class, 'show'])->name('conduite.show');

    // NOUVEAU : 1. Page de sélection des enfants
    Route::get('/conduite', [App\Http\Controllers\ConduiteController::class, 'index'])->name('conduite.index');

    // NOUVEAU : 2. Affichage de la fiche de conduite
    Route::get('/conduite/{enfantId}', [App\Http\Controllers\ConduiteController::class, 'show'])->name('conduite.show');

   
// ... (vos autres routes) ...

// Route pour la page de composition
Route::get('/composition', [CompositionController::class, 'index'])->name('composition.index');
// ...

    // Route pour afficher les reçus de l'utilisateur
    Route::get('/recus', [App\Http\Controllers\RecuController::class, 'index'])->name('recus.index');
    
    // NOUVELLE ROUTE : Télécharger TOUS les reçus de l'utilisateur en ZIP
    Route::get('/recus/download-all', [RecuController::class, 'downloadAllUserRecus'])->name('recus.download.all');

    // Route pour le téléchargement d'un seul reçu (doit rester dans le groupe auth pour la sécurité)
    Route::get('/recus/{recu}/download', [RecuController::class, 'download'])->name('recus.download');
    
});
    
// Route pour la mise à jour de la photo d'un enfant
Route::put('/enfants/{enfant}/update-photo', [EnfantController::class, 'updatePhoto'])->name('enfants.updatePhoto');
// ... (vos autres routes)



Route::delete('/enfants/{enfant}', [EnfantController::class, 'destroy'])->name('enfants.destroy');
Route::get('/enfants/{enfant}', [EnfantController::class, 'show'])->name('enfants.show');
Route::get('/td-enfants', [TDController::class, 'index'])->name('td.index');

// Ajoutez cette route pour le bouton "Recommandation"
Route::get('/recommandation', [RecommandationController::class, 'index'])->name('recommandation.index');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');


// Routes protégées pour les utilisateurs connectés
Route::middleware(['auth'])->group(function () {
    // ... toutes vos routes existantes ...
    
    // NOUVELLES ROUTES DES NOTES 
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index'); // Liste des enfants
    Route::get('/notes/{enfant}', [NoteController::class, 'show'])->name('notes.show'); // Affichage des notes
    
    // ... autres routes existantes ...
});



Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement.index');


Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
// Ajoutez cette ligne pour la nouvelle route
Route::get('/autorisation', [AuthorizationController::class, 'index'])->name('autorisation.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
