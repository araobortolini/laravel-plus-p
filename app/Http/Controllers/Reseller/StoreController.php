<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Exibe a listagem de lojas da revenda logada.
     */
    public function index()
    {
        // Buscamos apenas as lojas que pertencem ao tenant_id do usuário atual
        $stores = Store::where('tenant_id', Auth::user()->tenant_id)->get();
        
        return view('tenant.stores.index', compact('stores'));
    }

    /**
     * Exibe o formulário de criação de nova loja.
     */
    public function create()
    {
        return view('tenant.stores.create');
    }

    /**
     * Salva uma nova loja no banco de dados.
     */
    public function store(Request $request)
    {
        // A lógica de salvar faremos no próximo passo
    }
}