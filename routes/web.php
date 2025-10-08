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
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\ExamenFraisController;

use App\Http\Controllers\ParametresController;


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
// Page d'accueil des reçus (Liste pour le parent)
    Route::get('/recus', [RecuController::class, 'index'])->name('recus.index');
    
    // Téléchargement d'un reçu individuel
    Route::get('/recus/{id}/download', [RecuController::class, 'download'])->name('recus.download.single');
    
    // Téléchargement de tous les reçus en ZIP
    Route::get('/recus/download-all', [RecuController::class, 'downloadAllUserRecus'])->name('recus.download.all');

    // [ADMIN] Formulaire d'upload des reçus
    Route::get('/recus/upload', [RecuController::class, 'create'])->name('recus.upload.create');
    Route::post('/recus/upload', [RecuController::class, 'store'])->name('recus.upload.store');

// Dans le groupe middleware(['auth'])->group(function () { ...
    
    // Ancien : Route::get('/conduite/{enfantId}', [App\Http\Controllers\ConduiteController::class, 'show'])->name('conduite.show');

    // NOUVEAU : 1. Page de sélection des enfants
    Route::get('/conduite', [App\Http\Controllers\ConduiteController::class, 'index'])->name('conduite.index');

    // NOUVEAU : 2. Affichage de la fiche de conduite
    Route::get('/conduite/{enfantId}', [App\Http\Controllers\ConduiteController::class, 'show'])->name('conduite.show');

   // ... (vos autres routes) ...

// Routes pour la page Paramètres
Route::get('/parametres', [ParametresController::class, 'index'])->name('parametres.index');
Route::post('/parametres/update-password', [ParametresController::class, 'updatePassword'])->name('parametres.update.password');


// ... (vos autres routes) ...

// Route pour la page de composition
Route::get('/composition', [CompositionController::class, 'index'])->name('composition.index');
// ...

});
    
// Route pour la mise à jour de la photo d'un enfant
Route::put('/enfants/{enfant}/update-photo', [EnfantController::class, 'updatePhoto'])->name('enfants.updatePhoto');
// ... (vos autres routes)


// ... (vos autres routes) ...

// Route pour la page Infos et Frais des Examens
Route::get('/frais-examens', [ExamenFraisController::class, 'index'])->name('examens.index');


Route::delete('/enfants/{enfant}', [EnfantController::class, 'destroy'])->name('enfants.destroy');
Route::get('/enfants/{enfant}', [EnfantController::class, 'show'])->name('enfants.show');
Route::get('/td-enfants', [TDController::class, 'index'])->name('td.index');

// Ajoutez cette route pour le bouton "Recommandation"
Route::get('/recommandation', [RecommandationController::class, 'index'])->name('recommandation.index');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');




// Route pour afficher la page de sélection de l'emploi du temps
Route::get('/emploi-du-temps', [EmploiDuTempsController::class, 'index'])->name('emploi_du_temps.index');

// Route pour charger le tableau de l'emploi du temps (souvent utilisé par AJAX)
Route::get('/emploi-du-temps/show', [EmploiDuTempsController::class, 'show'])->name('emploi_du_temps.show');

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
