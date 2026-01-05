<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BusinessSegment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BusinessSegmentController extends Controller
{
    /**
     * Lista todos os segmentos cadastrados no Master Panel.
     */
    public function index()
    {
        $segments = BusinessSegment::orderBy('name', 'asc')->get();
        return view('master.settings.segments.index', compact('segments'));
    }

    /**
     * Exibe o formulário de criação com os 4 Motores Base.
     */
    public function create()
    {
        // Motores que definimos para a evolução do sistema
        $behaviors = [
            'food_service' => 'Food Service (Mesas/Comandas)',
            'retail'       => 'Varejo (Check-out Rápido)',
            'service'      => 'Serviços (Ordem de Serviço)',
            'industry'     => 'Indústria (Produção/Ficha Técnica)',
        ];

        return view('master.settings.segments.create', compact('behaviors'));
    }

    /**
     * Salva o novo segmento no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_segments,name',
            'behavior_base' => 'required|in:food_service,retail,service,industry',
        ]);

        BusinessSegment::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'behavior_base' => $request->behavior_base,
            'is_active' => true,
        ]);

        return redirect()->route('master.settings.segments.index')
            ->with('success', 'Segmento criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(BusinessSegment $segment)
    {
        $behaviors = [
            'food_service' => 'Food Service (Mesas/Comandas)',
            'retail'       => 'Varejo (Check-out Rápido)',
            'service'      => 'Serviços (Ordem de Serviço)',
            'industry'     => 'Indústria (Produção/Ficha Técnica)',
        ];

        return view('master.settings.segments.edit', compact('segment', 'behaviors'));
    }

    /**
     * Atualiza os dados do segmento.
     */
    public function update(Request $request, BusinessSegment $segment)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:business_segments,name,' . $segment->id,
            'behavior_base' => 'required|in:food_service,retail,service,industry',
        ]);

        $segment->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'behavior_base' => $request->behavior_base,
        ]);

        return redirect()->route('master.settings.segments.index')
            ->with('success', 'Segmento atualizado com sucesso!');
    }

    /**
     * Alterna o status entre Ativo e Inativo.
     */
    public function toggleStatus(BusinessSegment $segment)
    {
        $segment->update([
            'is_active' => !$segment->is_active
        ]);

        return back()->with('success', 'Status do segmento alterado com sucesso!');
    }

    /**
     * Remove o segmento (Opcional, com SoftDeletes).
     */
    public function destroy(BusinessSegment $segment)
    {
        $segment->delete();
        return redirect()->route('master.settings.segments.index')
            ->with('success', 'Segmento removido!');
    }
}