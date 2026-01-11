<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::whereNull('tenant_id')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('master.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('master.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_name' => 'required|string|max:255',
            'name'       => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:8|confirmed',
            'document'   => 'nullable|string|max:20',
            'phone'      => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $store = Store::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'document'  => $request->document,
                'phone'     => $request->phone,
                'tenant_id' => null, 
            ]);

            User::create([
                'name'      => $request->owner_name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'is_master' => false,
                'tenant_id' => null,
            ]);

            DB::commit();
            return redirect()->route('master.stores.index')->with('success', 'Loja direta criada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao criar loja: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Store $store)
    {
        return view('master.stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('master.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'document' => 'nullable|string|max:20',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $store->update($request->only(['name', 'document', 'phone']));

            if ($request->filled('password')) {
                $user = User::where('email', $store->email)->first();
                if ($user) {
                    $user->update([
                        'password' => Hash::make($request->password)
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('master.stores.index')
                ->with('success', 'Loja direta e acessos atualizados com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }

    public function destroy(Store $store)
    {
        try {
            DB::beginTransaction();
            User::where('email', $store->email)->delete();
            $store->delete();
            DB::commit();
            return redirect()->route('master.stores.index')
                ->with('success', 'Loja removida com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao remover loja.');
        }
    }

    // --- NOVOS MÉTODOS PARA GESTÃO DE TRANSIÇÃO (ATUALIZADOS) ---

    public function transitionIndex()
    {
        // 1. Revendas Excluídas (Soft Deleted) que possuem lojas
        $deletedTenants = Tenant::onlyTrashed()
            ->withCount('stores')
            ->orderBy('deleted_at', 'desc')
            ->get();

        // 2. Lojas Órfãs (para alimentar o modal de revendas excluídas)
        $stores = Store::whereHas('tenant', function ($query) {
            $query->onlyTrashed();
        })->get();

        // 3. Lojas de Revendas Bloqueadas (is_active = false)
        $blockedStores = Store::whereHas('tenant', function ($query) {
            $query->where('is_active', false);
        })->with('tenant')->get();

        return view('master.stores.transition', compact('deletedTenants', 'stores', 'blockedStores'));
    }

    public function migrate(Store $store)
    {
        try {
            $store->update(['tenant_id' => null]);

            return redirect()->route('master.stores.index')
                ->with('success', "A loja {$store->name} foi resgatada e agora é uma Loja Direta!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro na migração: ' . $e->getMessage());
        }
    }
}