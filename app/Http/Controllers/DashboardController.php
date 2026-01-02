<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redireciona o usuário para o dashboard correto com base no seu nível de acesso.
     */
    public function index()
    {
        if (Auth::user()->is_master) {
            return redirect()->route('master.dashboard');
        }

        return redirect()->route('tenant.dashboard');
    }
}