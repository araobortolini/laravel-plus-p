<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tenant; 
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
        // Abre o formulário de cadastro
        return view('master.tenants.create');
    }

    public function store(Request $request)
    {
        // 1. Validação atualizada com os 5 campos que você criou
        // Note que o 'email' agora passará na validação pois a coluna já existe no banco
        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'document'    => 'required|string|max:255',
            'email'       => 'required|email|unique:tenants,email',
            'phone'       => 'required|string|max:255',
        ]);

        // 2. Criação da Revenda usando os dados validados
        // O Laravel cuidará de inserir o UUID se o Model estiver configurado
        Tenant::create($validated);

        // 3. Redirecionamento com mensagem de sucesso
        return redirect()
            ->route('master.tenants.index')
            ->with('success', 'Revenda cadastrada com sucesso!');
    }
}