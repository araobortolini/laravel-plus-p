<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\TenantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rota do Dashboard Padrão (usuários comuns)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de Perfil (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// inicio do bloco rotas_master ...
// --- ÁREA RESTRITA DO SUPER ADMIN (MASTER) ---
Route::middleware(['auth', 'verified', 'is_master'])->prefix('master')->name('master.')->group(function () {
    
    // Dashboard do Master
    Route::get('/dashboard', function () {
        return view('master.dashboard');
    })->name('dashboard');

    // Gerenciamento de Revendas
    Route::resource('tenants', TenantController::class);
});
// do bloco rotas_master.

require __DIR__.'/auth.php';