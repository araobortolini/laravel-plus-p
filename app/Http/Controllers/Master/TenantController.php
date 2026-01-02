<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tenant; // Importante: Importar o Model
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        // Busca as revendas (10 por página) ordenadas pela mais nova
        $tenants = Tenant::latest()->paginate(10);
        
        // Envia para a tela (View)
        return view('master.tenants.index', compact('tenants'));
    }

    public function create()
    {
        // Abre o formulário de cadastro (faremos em breve)
        return view('master.tenants.create');
    }

    public function store(Request $request)
    {
        // Lógica para salvar (faremos em breve)
    }
}