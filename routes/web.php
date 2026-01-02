<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Master\TenantController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rota para sair da simulação e voltar ao Master (Dourada)
Route::get('/leave-impersonation', [TenantController::class, 'leaveImpersonation'])->name('master.leave-impersonation');

// [UNIFICADO] Redirecionamento inteligente
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas de Perfil (Profile) - CORRIGIDO com Route::
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

    // Rota para entrar na conta da revenda
    Route::get('/login-as/{user}', [TenantController::class, 'loginAs'])->name('login-as');
});
// do bloco rotas_master.

// --- ÁREA DO REVENDEDOR (TENANT) ---
Route::middleware(['auth', 'verified'])->prefix('tenant')->name('tenant.')->group(function () {
    
    // Dashboard da Revenda
    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';