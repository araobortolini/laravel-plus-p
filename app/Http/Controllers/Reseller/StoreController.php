<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\BusinessSegment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where('tenant_id', Auth::user()->tenant_id)->get();
        return view('tenant.stores.index', compact('stores'));
    }

    public function create()
    {
        $segments = BusinessSegment::where('is_active', true)->get();
        return view('tenant.stores.create', compact('segments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'segment_id' => 'required|exists:business_segments,id',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            Store::create([
                'name' => $request->name,
                'email' => $request->email,
                'segment_id' => $request->segment_id,
                'tenant_id' => Auth::user()->tenant_id, 
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tenant_id' => Auth::user()->tenant_id,
                'is_master' => false,
            ]);

            DB::commit();
            return redirect()->route('tenant.stores.index')->with('success', 'Loja criada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao salvar: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Store $store)
    {
        if ($store->tenant_id !== Auth::user()->tenant_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $segments = BusinessSegment::where('is_active', true)->get();
        return view('tenant.stores.edit', compact('store', 'segments'));
    }

    /**
     * ATUALIZADO: Agora processa a alteração de senha se preenchida.
     */
    public function update(Request $request, Store $store)
    {
        if ($store->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'segment_id' => 'required|exists:business_segments,id',
            'password' => 'nullable|min:8|confirmed', // Senha opcional
        ]);

        try {
            DB::beginTransaction();

            // 1. Atualiza os dados da loja
            $store->update([
                'name' => $request->name,
                'segment_id' => $request->segment_id,
            ]);

            // 2. Se a senha foi digitada, atualiza o usuário vinculado pelo email
            if ($request->filled('password')) {
                $user = User::where('email', $store->email)->first();
                if ($user) {
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('tenant.stores.index')->with('success', 'Loja atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao atualizar: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Store $store)
    {
        if ($store->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $store->delete();
        return redirect()->route('tenant.stores.index')->with('success', 'Loja removida com sucesso!');
    }
}