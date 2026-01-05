<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            {{ __('Configurações: Segmentos de Negócio') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-6">
                <a href="{{ route('master.settings.segments.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 shadow-md">
                    + Novo Segmento
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#111827]">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nome do Segmento</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Motor Base (Comportamento)</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($segments as $segment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 uppercase">
                                    {{ $segment->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 uppercase font-mono">
                                    <span class="bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                        {{ str_replace('_', ' ', $segment->behavior_base) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('master.settings.segments.toggle', $segment) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-tighter transition-all {{ $segment->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                            {{ $segment->is_active ? 'Ativo' : 'Inativo' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('master.settings.segments.edit', $segment) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                    Nenhum segmento cadastrado para a evolução do sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>