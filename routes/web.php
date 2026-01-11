<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\TenantController;
use App\Http\Controllers\Master\BusinessSegmentController;
use App\Http\Controllers\Master\StoreController as MasterStoreController;
use App\Http\Controllers\Reseller\StoreController as ResellerStoreController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rota para sair da simulação e voltar ao Master
Route::get('/leave-impersonation', [TenantController::class, 'leaveImpersonation'])->name('master.leave-impersonation');

/**
 * [UNIFICADO] Redirecionamento inteligente
 */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rotas de Perfil (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ÁREA RESTRITA DO SUPER ADMIN (MASTER) ---
Route::middleware(['auth', 'verified', 'is_master'])->prefix('master')->name('master.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('master.dashboard');
    })->name('dashboard');

    // ==============================================================================
    // BLOCO DE PRIORIDADE: Rotas Específicas de Revendas (Soft Deletes / Ações)
    // ==============================================================================
    // Estas rotas PRECISAM vir antes do Route::resource('tenants') para não serem ignoradas.
    // Usamos {id} para bater com o método do Controller que espera um ID numérico.
    Route::post('/tenants/{id}/restore', [TenantController::class, 'restore'])->name('tenants.restore');
    Route::delete('/tenants/{id}/force-delete', [TenantController::class, 'forceDelete'])->name('tenants.force-delete');
    
    // Rota para Bloquear/Desbloquear Revenda (Toggle)
    Route::post('/tenants/{tenant}/toggle', [TenantController::class, 'toggleStatus'])->name('tenants.toggle');
    
    // Resource Padrão (CRUD) - Deve ficar abaixo das rotas específicas
    Route::resource('tenants', TenantController::class);

    // ==============================================================================
    // ROTAS DE GESTÃO DE TRANSIÇÃO (LOJAS ÓRFÃS)
    // ==============================================================================
    Route::get('/stores/transition', [MasterStoreController::class, 'transitionIndex'])->name('stores.transition');
    Route::post('/stores/{store}/migrate', [MasterStoreController::class, 'migrate'])->name('stores.migrate');

    // Resource de Lojas do Master
    Route::resource('stores', MasterStoreController::class);

    // ==============================================================================
    // CONFIGURAÇÕES GERAIS
    // ==============================================================================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('segments/{segment}/toggle', [BusinessSegmentController::class, 'toggleStatus'])->name('segments.toggle');
        Route::resource('segments', BusinessSegmentController::class);
    });

    // Login Simulado
    Route::get('/login-as/{user}', [TenantController::class, 'loginAs'])->name('login-as');
});

// --- ÁREA DO REVENDEDOR (PAINEL REVENDA) ---
Route::middleware(['auth', 'verified', 'tenant.active'])->prefix('tenant')->name('tenant.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->name('dashboard');

    Route::resource('stores', ResellerStoreController::class);
});

// --- ÁREA DO LOJISTA (PAINEL DA LOJA / PDV) ---
Route::middleware(['auth', 'verified'])->prefix('store')->name('store.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('store.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';