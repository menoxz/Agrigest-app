<?php

use App\Http\Controllers\ImprevuController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeCultureController;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\TypeInterventionController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\GlobalStatistiquesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatistiqueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Routes admin protégées
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('/parcelles', [AdminController::class, 'parcelles'])->name('parcelles');
    Route::get('/parcelles/create', [AdminController::class, 'createParcelle'])->name('parcelles.create');
    Route::post('/parcelles', [AdminController::class, 'storeParcelle'])->name('parcelles.store');
    Route::get('/interventions', [AdminController::class, 'interventions'])->name('interventions');
    Route::get('/interventions/create', [AdminController::class, 'createIntervention'])->name('interventions.create');
    Route::post('/interventions', [AdminController::class, 'storeIntervention'])->name('interventions.store');
    Route::get('/imprevus', [AdminController::class, 'imprevus'])->name('imprevus');
    Route::get('/imprevus/create', [AdminController::class, 'createImprevu'])->name('imprevus.create');
    Route::post('/imprevus', [AdminController::class, 'storeImprevu'])->name('imprevus.store');
});

// Routes pour les agriculteurs
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('type-culture', TypeCultureController::class);
    Route::resource('type-intervention', TypeInterventionController::class);
    Route::resource('parcelle', ParcelleController::class);
    Route::resource('intervention', InterventionController::class);
    Route::resource('imprevu', ImprevuController::class);

    // Route pour le rapport des interventions
    Route::get('/rapport/parcelle/{parcelle}', [RapportController::class, 'rapportInterventions'])
    ->name('rapport.parcelle')
    ->middleware('auth');
    // Route pour afficher les statistiques globales des parcelles
    Route::get('/statistiques/globales', [StatistiqueController::class, 'afficherStatistique'])->name('statistiques.globales.detail');
});

require __DIR__.'/auth.php';
