<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\EnfantController;
use App\Http\Controllers\Admin\UserController; // <-- NOUVEAU
// Contrôleurs Utilisateurs / Parents
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TDController;
use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\RecommandationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\RecuController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CompositionController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\MatriculeController;
use App\Http\Controllers\ParametresController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\EnfantController as ParentEnfantController; // Alias pour le contrôleur Parent
use App\Http\Controllers\ConduiteController;
use App\Http\Controllers\Admin\MatiereController; // <<< AJOUTEZ CETTE LIGNE
// Contrôleurs Administrateurs
use App\Http\Controllers\Admin\EnfantController as AdminEnfantController; // Alias pour le contrôleur Admin
use App\Http\Controllers\Admin\NooteController; // <<< AJOUTEZ CETTE LIGNE
use App\Http\Controllers\Admin\RecuuController;
use App\Http\Controllers\Parent\RecuParentController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes Authentification
Auth::routes();


// =========================================================================
// 1. ROUTES PUBLIQUES
// =========================================================================

Route::get('/', function () {
    return view('welcome');
});


// =========================================================================
// 2. ROUTES PARENTS/UTILISATEURS (Protégées par 'auth')
// =========================================================================

Route::middleware(['auth'])->group(function () {

    // Page d'accueil principale
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route de test pour la modale matricule (si nécessaire)
    Route::get('/matricule', [HomeController::class, 'showMatricules'])->name('partials.matricule_modal');
    
    // ------------------------------------
    // Gestion des Enfants par le Parent (CRUD)
    // ------------------------------------
    Route::get('/enfants/create', [ParentEnfantController::class, 'create'])->name('enfants.create');
    Route::post('/enfants/store', [ParentEnfantController::class, 'store'])->name('enfants.store');
    Route::get('/enfants', [ParentEnfantController::class, 'index'])->name('enfants.index');
    Route::get('/enfants/{enfant}', [ParentEnfantController::class, 'show'])->name('enfants.show');
    Route::get('/enfants/{enfant}/edit', [ParentEnfantController::class, 'edit'])->name('enfants.edit');
    Route::put('/enfants/{enfant}', [ParentEnfantController::class, 'update'])->name('enfants.update');
    Route::delete('/enfants/{enfant}', [ParentEnfantController::class, 'destroy'])->name('enfants.destroy');
    Route::put('/enfants/{enfant}/update-photo', [ParentEnfantController::class, 'updatePhoto'])->name('enfants.updatePhoto');


    // ------------------------------------
    // Consultation
    // ------------------------------------
    
    // Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/{enfant}', [NoteController::class, 'show'])->name('notes.show');

    // Emploi du temps
    Route::get('/emploi-du-temps', [EmploiDuTempsController::class, 'index'])->name('emploi_du_temps.index');
    Route::get('/emploi-du-temps/show', [EmploiDuTempsController::class, 'show'])->name('emploi_du_temps.show');

    // Conduite
    Route::get('/conduite', [ConduiteController::class, 'index'])->name('conduite.index');
    Route::get('/conduite/{enfantId}', [ConduiteController::class, 'show'])->name('conduite.show');

    // Réception de Reçus
    Route::get('/recus', [RecuController::class, 'index'])->name('recus.index');
    Route::get('/recus/{id}/download', [RecuController::class, 'download'])->name('recus.download.single');
    Route::get('/recus/download-all', [RecuController::class, 'downloadAllUserRecus'])->name('recus.download.all');
    
    // Paiement / Frais
    Route::get('/paiement', [PaiementController::class, 'index'])->name('paiement.index');
    Route::get('/examens/frais', [ExamenController::class, 'frais'])->name('examens.frais');
    
    // Matricule (utilisé si une route est absolument nécessaire)
    Route::get('/matricules', [MatriculeController::class, 'index'])->name('matricules.index');


    // ------------------------------------
    // Autres Pages et Paramètres
    // ------------------------------------
    Route::get('/parametres', [ParametresController::class, 'index'])->name('parametres.index');
    Route::post('/parametres/update-password', [ParametresController::class, 'updatePassword'])->name('parametres.update.password');

    Route::get('/composition', [CompositionController::class, 'index'])->name('composition.index');
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
    Route::get('/examens', [ExamenController::class, 'index'])->name('examens.index');
    Route::get('/examens/candidats', [ExamenController::class, 'candidats'])->name('examens.candidats');
    Route::get('/td-enfants', [TDController::class, 'index'])->name('td.index');
    Route::get('/recommandation', [RecommandationController::class, 'index'])->name('recommandation.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/autorisation', [AuthorizationController::class, 'index'])->name('autorisation.index');

}); // <--- FIN du groupe middleware(['auth']) pour les Parents


// =========================================================================
// 3. ROUTES ADMINISTRATEUR (CORRECTION DE L'ERREUR D'ACCOLADE)
// =========================================================================

// =========================================================================
// 3. ROUTES ADMINISTRATEUR (Protégées par 'auth' et 'admin' middleware)
// =========================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Tableau de bord
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Gestion des Enfants/Élèves (CRUD)
    Route::resource('enfants', AdminEnfantController::class); // Utilise l'ALIAS AdminEnfantController

    // Gestion des Utilisateurs (Parents)
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
   // 5. Gestion des Reçus (Recuus)
    // Nous excluons 'show', 'edit', 'update' car c'est un CRUD de fichiers simple
    Route::resource('recuus', RecuuController::class)->except(['show', 'edit', 'update']);
    
    // Route de téléchargement spécifique
    Route::get('recuus/{recuu}/download', [RecuuController::class, 'download'])->name('recuus.download');
}); // <--- FIN du groupe middleware(['auth', 'admin'])
// =========================================================================
// 4. ROUTES QUI ÉTAIENT EN DEHORS
// =========================================================================

// Ces routes étaient hors de tous les groupes, je les laisse ici si elles ne nécessitent pas 'auth'
// Route::put('/enfants/{enfant}/update-photo', [EnfantController::class, 'updatePhoto'])->name('enfants.updatePhoto'); 
// NOTE: Cette route est maintenant dans le groupe 'auth' avec l'alias ParentEnfantController.
// Routes Admin pour la gestion des reçus


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ... Routes existantes (dashboard, enfants) ...

    // 3. Gestion des Matières <<< NOUVELLE LIGNE
    Route::resource('matieres', MatiereController::class);
    
    // 4. Gestion des Notes (prête à être utilisée une fois les matières créées)
    // Route::resource('notes', App\Http\Controllers\Admin\NoteController::class);

    // ...
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard'); // <<< POINTANT VERS LA NOUVELLE VUE
    })->name('dashboard'); // <<< NOM DE ROUTE À UTILISER : admin.dashboard
    
    // Page d'index des reçus (URL: /recus)
    Route::get('/recus', [RecuParentController::class, 'index'])->name('recus.index');
    
    // Route de téléchargement individuel sécurisé (Route::get('/recus/1/download') )
    Route::get('/recus/{recu}/download', [RecuParentController::class, 'downloadSingle'])->name('recus.download.single');
    
    // Route de téléchargement de tous les reçus (ZIP)
    Route::get('/recus/download/all', [RecuParentController::class, 'downloadAll'])->name('recus.download.all');

});




Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ... Routes existantes (dashboard, enfants, matieres) ...

    // 4. Gestion des Notes <<< NOUVELLE LIGNE
    Route::resource('notes', NooteController::class);

    // ...
});

