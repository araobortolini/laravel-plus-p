<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTenantStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Se o usuário pertence a uma revenda e ela não está ativa
        if (Auth::check() && Auth::user()->tenant && !Auth::user()->tenant->is_active) {
            // Bloqueia qualquer tentativa de Criar, Editar ou Deletar (POST, PUT, PATCH, DELETE)
            if (!$request->isMethod('get')) {
                return back()->with('error', 'Esta revenda está bloqueada. Não é possível realizar alterações.');
            }
        }

        return $next($request);
    }
}