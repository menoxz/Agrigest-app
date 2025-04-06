<?php

use App\Http\Controllers\ImprevuController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypeCultureController;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\TypeInterventionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('type-culture', TypeCultureController::class);
    Route::resource('type-intervention', TypeInterventionController::class);
    Route::resource('parcelle', ParcelleController::class);
    Route::resource('intervention', InterventionController::class);
    Route::resource('imprevu', ImprevuController::class);

});



require __DIR__.'/auth.php';
