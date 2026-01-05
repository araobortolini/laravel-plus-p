<x-app-layout>
    {{-- Injetando o título na Top Bar (Barra Superior) --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            {{ __('Gerenciar Lojas') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-6">
                <a href="{{ route('tenant.stores.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 shadow-md">
                    + Nova Loja
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="p-0">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#111827]">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Loja / Detalhes
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                    Documento / Email
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($stores as $store)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold border border-gray-200 uppercase">
                                                {{ substr($store->name, 0, 2) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 uppercase tracking-tight">{{ $store->name }}</div>
                                                <div class="text-[10px] text-gray-400 font-mono italic">ID: {{ substr($store->id, 0, 8) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-700 font-medium">{{ $store->document ?? '---' }}</div>
                                        <div class="text-xs text-gray-400 lowercase">{{ $store->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full uppercase tracking-tighter {{ $store->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $store->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-3">
                                            <a href="{{ route('tenant.stores.edit', $store) }}" class="text-blue-500 hover:text-blue-700 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('tenant.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta loja?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <p class="text-gray-400 text-sm font-medium italic italic">Nenhuma loja cadastrada para esta revenda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>