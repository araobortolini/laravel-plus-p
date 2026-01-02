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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se o usuário está autenticado
        // 2. Verifica se o campo 'is_master' no banco de dados é verdadeiro
        if (!Auth::check() || !Auth::user()->is_master) {
            
            // Se não for Master, redireciona para o dashboard da revenda
            // Certifique-se de que a rota 'tenant.dashboard' esteja criada no seu web.php
            return redirect()->route('tenant.dashboard')->with('error', 'Acesso restrito apenas para administradores Master.');
        }

        return $next($request);
    }
}