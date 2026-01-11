<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Store;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // 1. Redireciona o MASTER
        // Verifica se é master explicitamente ou se não possui tenant_id (padrão do admin no seeder)
        if ($user && ($user->is_master || is_null($user->tenant_id))) {
            return redirect()->intended(route('master.dashboard'));
        }

        // 2. Redireciona o LOJISTA (Store)
        // Verificamos se o e-mail do usuário logado existe na tabela de lojas
        $isStore = Store::where('email', $user->email)->exists();
        
        if ($isStore) {
            return redirect()->intended(route('store.dashboard'));
        }

        // 3. Redireciona a REVENDA (Tenant)
        // Caso não seja master nem loja, ele cai no dashboard da revenda
        return redirect()->intended(route('tenant.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}