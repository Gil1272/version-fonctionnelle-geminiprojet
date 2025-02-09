<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('handleLogin');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// 🛑 Protéger les routes réservées aux administrateurs
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::prefix('projets')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projets.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('projets.create');
        Route::post('/create', [ProjectController::class, 'store'])->name('projets.store');
        Route::get('/edit/{projet}', [ProjectController::class, 'edit'])->name('projets.edit');
        Route::delete('/delete/{projet}', [ProjectController::class, 'destroy'])->name('projets.destroy');

    });

    Route::prefix('employes')->group(function () {
        Route::get('/', [EmployeController::class, 'index'])->name('employes.index');
        Route::get('/create', [EmployeController::class, 'create'])->name('employes.create');
        Route::post('/create', [EmployeController::class, 'store'])->name('employes.store');
        Route::get('/edit/{employe}', [EmployeController::class, 'edit'])->name('employes.edit');
        Route::put('/edit/{employe}', [EmployeController::class, 'update'])->name('employes.update');

        Route::delete('/delete/{employe}', [EmployeController::class, 'destroy'])->name('employes.destroy');
    });

    Route::prefix('taches')->group(function () {
        Route::get('/', [TacheController::class, 'index'])->name('taches.index');
        Route::get('/create', [TacheController::class, 'create'])->name('taches.create');
        Route::post('/create', [TacheController::class, 'store'])->name('taches.store');
        Route::get('/edit/{employe}', [TacheController::class, 'edit'])->name('taches.edit');
    });

});
