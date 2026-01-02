<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tenant; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Adicionado para gerenciar o login

class TenantController extends Controller
{
    public function index()
    {
        // Alterado para carregar o relacionamento 'user' necessário para o loginAs
        $tenants = Tenant::with('user')->latest()->paginate(10);
        return view('master.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('master.tenants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'document'    => 'required|string|max:255',
            'email'       => 'required|email|unique:tenants,email|unique:users,email',
            'phone'       => 'required|string|max:255',
            'password'    => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $tenant = Tenant::create([
                'seller_name' => $validated['seller_name'],
                'name'        => $validated['name'],
                'document'    => $validated['document'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
            ]);

            User::create([
                'name'      => $validated['seller_name'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'tenant_id' => $tenant->id,
            ]);

            DB::commit();
            return redirect()->route('master.tenants.index')->with('success', 'Revenda cadastrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Erro ao salvar: ' . $e->getMessage()]);
        }
    }

    public function destroy(Tenant $tenant)
    {
        try {
            DB::beginTransaction();

            // Desativa o usuário vinculado para impedir login
            if($tenant->user) {
                $tenant->user->delete(); 
            }

            // A exclusão do Tenant é "Soft", as Lojas permanecem no banco para migração futura
            $tenant->delete();

            DB::commit();
            return redirect()->route('master.tenants.index')->with('success', 'Revenda excluída. Clientes preservados para migração.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Falha na exclusão.');
        }
    }

    // --- NOVOS MÉTODOS PARA ACESSO RÁPIDO (IMPERSONATE) ---

    public function loginAs(User $user)
    {
        // Armazena o ID do Master atual na sessão antes de trocar de conta
        session(['impersonator_id' => Auth::id()]);

        // Faz o login como o usuário da revenda
        Auth::login($user);

        // [ATUALIZADO] Removido o ->with('success') para não exibir o campo verde ao entrar
        return redirect()->route('tenant.dashboard');
    }

    public function leaveImpersonation()
    {
        // Recupera o ID do Master da sessão
        $masterId = session('impersonator_id');

        if ($masterId) {
            $master = User::find($masterId);
            
            // Faz login de volta na conta Master
            Auth::login($master);
            
            // Limpa a marcação de simulação da sessão
            session()->forget('impersonator_id');

            // Mantido o success aqui para confirmar que você saiu da conta da revenda com segurança
            return redirect()->route('master.tenants.index')->with('success', 'Você voltou para o Painel Master.');
        }

        return redirect('/');
    }
}