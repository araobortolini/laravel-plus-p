<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIsMaster
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Verifica se é Master (pelo campo boolean OU por ser um admin sem tenant_id)
        if ($user->is_master || is_null($user->tenant_id)) {
            return $next($request);
        }

        // Se não for Master, redireciona para o dashboard da revenda
        return redirect()->route('tenant.dashboard')->with('error', 'Acesso restrito apenas para administradores Master.');
    }
}