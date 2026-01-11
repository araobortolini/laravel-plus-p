<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tenant; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function index()
    {
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
            'name'         => 'required|string|max:255',
            'document'     => 'required|string|max:255',
            'email'        => 'required|email|unique:tenants,email|unique:users,email',
            'phone'        => 'required|string|max:255',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $tenant = Tenant::create([
                'seller_name' => $validated['seller_name'],
                'name'         => $validated['name'],
                'document'     => $validated['document'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
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

    public function edit(Tenant $tenant)
    {
        $user = $tenant->user; 
        return view('master.tenants.edit', compact('tenant', 'user'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $user = $tenant->user;

        $validated = $request->validate([
            'seller_name' => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'document'     => 'required|string|max:255',
            'email'        => 'required|email|unique:tenants,email,'.$tenant->id.'|unique:users,email,'.$user->id,
            'phone'        => 'required|string|max:255',
            'password'     => 'nullable|string|min:8|confirmed', 
        ]);

        try {
            DB::beginTransaction();

            $tenant->update([
                'seller_name' => $validated['seller_name'],
                'name'         => $validated['name'],
                'document'     => $validated['document'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
            ]);

            $userData = [
                'name'  => $validated['seller_name'],
                'email' => $validated['email'],
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            DB::commit();
            return redirect()->route('master.tenants.index')->with('success', 'Dados da revenda atualizados!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Erro ao atualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy(Tenant $tenant)
    {
        try {
            DB::beginTransaction();

            if($tenant->user) {
                $tenant->user->delete(); 
            }

            $tenant->delete();

            DB::commit();
            return redirect()->route('master.tenants.index')->with('success', 'Revenda excluída.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Falha na exclusão.');
        }
    }

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update([
            'is_active' => !$tenant->is_active
        ]);

        $status = $tenant->is_active ? 'ativada' : 'bloqueada';
        return back()->with('success', "A revenda {$tenant->name} foi {$status} com sucesso!");
    }

    public function loginAs($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Você já está logado nesta conta.');
        }

        session(['impersonator_id' => Auth::id()]);
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Acesso simulado como: ' . $user->name);
    }

    public function leaveImpersonation()
    {
        $masterId = session('impersonator_id');

        if ($masterId) {
            $master = User::find($masterId);
            Auth::login($master);
            session()->forget('impersonator_id');
            
            return redirect()->route('master.tenants.index')->with('success', 'Você voltou para o Painel Master.');
        }

        return redirect('/');
    }

    // --- NOVOS MÉTODOS PARA REVENDAS EXCLUÍDAS (SOFT DELETES) ---

    /**
     * Reabilita uma revenda que foi excluída logicamente.
     */
    public function restore($id)
    {
        try {
            DB::beginTransaction();

            // Busca incluindo deletados para poder restaurar
            $tenant = Tenant::withTrashed()->findOrFail($id);
            $tenant->restore();

            // Restaura também o usuário principal da revenda
            $user = User::withTrashed()->where('email', $tenant->email)->first();
            if ($user) {
                $user->restore();
            }

            DB::commit();
            return redirect()->route('master.stores.transition')->with('success', "A revenda {$tenant->name} e seus acessos foram restaurados!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao restaurar revenda.');
        }
    }

    /**
     * Exclui permanentemente a revenda do banco de dados.
     */
    public function forceDelete($id)
    {
        try {
            DB::beginTransaction();

            $tenant = Tenant::withTrashed()->findOrFail($id);
            
            // Remove o usuário definitivamente
            $user = User::withTrashed()->where('email', $tenant->email)->first();
            if ($user) {
                $user->forceDelete();
            }

            // Exclui a revenda permanentemente
            $tenant->forceDelete();

            DB::commit();
            return redirect()->route('master.stores.transition')->with('success', 'Revenda removida permanentemente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro na exclusão permanente.');
        }
    }
}