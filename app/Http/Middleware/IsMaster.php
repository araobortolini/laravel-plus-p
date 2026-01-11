<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Se não estiver logado, manda pro login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Se estiver logado mas NÃO for Master, proíbe o acesso
        // Ajustado: Considera Master se is_master for true OU se o tenant_id for null
        $user = Auth::user();
        if (!$user->is_master && !is_null($user->tenant_id)) {
            abort(403, 'ACESSO NEGADO: Esta área é restrita ao Super Admin.');
        }

        // 3. Se passou pelos testes, permite o acesso
        return $next($request);
    }
}