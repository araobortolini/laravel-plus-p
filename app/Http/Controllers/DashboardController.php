<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class DashboardController extends Controller
{
    /**
     * Redireciona o usuário para o dashboard correto com base no seu nível de acesso.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. Administrador Master (Gestão Global)
        // Ajustado: Verifica is_master OU se o tenant_id é nulo
        if ($user->is_master || is_null($user->tenant_id)) {
            return redirect()->route('master.dashboard');
        }

        // 2. Lojista (Operacional)
        $isStore = Store::where('email', $user->email)->exists();
        
        if ($isStore) {
            return redirect()->route('store.dashboard');
        }

        // 3. Revendedor (Gestão de Carteira)
        if ($user->tenant_id !== null) {
            return redirect()->route('tenant.dashboard');
        }

        // Caso de segurança
        return redirect('/');
    }
}