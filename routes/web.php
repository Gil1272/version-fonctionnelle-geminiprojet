<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

// Redirection de la racine vers login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::middleware('guest:web,employe')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('handleLogin');
});

// Routes accessibles après login (pour les deux guards)
Route::middleware(['auth:web,employe'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes publiques pour l'index des projets et tâches
    Route::get('/projets', [ProjectController::class, 'index'])->name('projets.index');
    Route::get('/taches', [TacheController::class, 'index'])->name('taches.index');

    // Routes protégées pour les administrateurs
    Route::middleware('admin')->group(function () {
        // Routes pour les projets
        Route::prefix('projets')->group(function () {
            Route::get('/create', [ProjectController::class, 'create'])->name('projets.create');
            Route::post('/create', [ProjectController::class, 'store'])->name('projets.store');
            Route::get('/edit/{projet}', [ProjectController::class, 'edit'])->name('projets.edit');
            Route::delete('/delete/{projet}', [ProjectController::class, 'destroy'])->name('projets.destroy');
        });

        // Routes pour les employés
        Route::prefix('employes')->group(function () {
            Route::get('/', [EmployeController::class, 'index'])->name('employes.index');
            Route::get('/create', [EmployeController::class, 'create'])->name('employes.create');
            Route::post('/create', [EmployeController::class, 'store'])->name('employes.store');
            Route::get('/edit/{employe}', [EmployeController::class, 'edit'])->name('employes.edit');
            Route::put('/edit/{employe}', [EmployeController::class, 'update'])->name('employes.update');
            Route::delete('/delete/{employe}', [EmployeController::class, 'destroy'])->name('employes.destroy');
        });

        // Routes pour les tâches
        Route::prefix('taches')->group(function () {
            Route::get('/create', [TacheController::class, 'create'])->name('taches.create');
            Route::post('/create', [TacheController::class, 'store'])->name('taches.store');
            Route::get('/edit/{employe}', [TacheController::class, 'edit'])->name('taches.edit');
        });
    });
});
