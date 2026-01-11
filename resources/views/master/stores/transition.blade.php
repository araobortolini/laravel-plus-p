<x-app-layout>
    <x-slot name="header">
        <div class="bg-red-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8 shadow-inner">
            <h2 class="font-semibold text-xl text-white leading-tight uppercase tracking-widest">
                {{ __('Lojas em Transição') }}
            </h2>
            <p class="text-red-200 text-xs mt-1 italic">Lojas que perderam o vínculo com revendedores e aguardam custódia ou ação do Master.</p>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'excluidas', activeRevenda: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex space-x-4 mb-8">
                <button 
                    @click="tab = 'excluidas'" 
                    :class="tab === 'excluidas' ? 'bg-red-700 text-white shadow-lg scale-105' : 'bg-white text-gray-500 hover:bg-gray-50'"
                    class="px-8 py-4 rounded-xl font-black text-sm uppercase tracking-widest transition-all border border-gray-200 flex items-center">
                    <span class="mr-2">🗑️</span> Revendas Excluídas
                </button>
                <button 
                    @click="tab = 'bloqueadas'" 
                    :class="tab === 'bloqueadas' ? 'bg-orange-600 text-white shadow-lg scale-105' : 'bg-white text-gray-500 hover:bg-gray-50'"
                    class="px-8 py-4 rounded-xl font-black text-sm uppercase tracking-widest transition-all border border-gray-200 flex items-center">
                    <span class="mr-2">🚫</span> Revendas Bloqueadas
                </button>
            </div>

            <div x-show="tab === 'excluidas'" x-transition>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($deletedTenants as $reseller)
                        <div class="bg-white rounded-xl shadow-md border-l-4 border-red-500 overflow-hidden hover:shadow-xl transition-shadow cursor-pointer" @click="activeRevenda = '{{ $reseller->id }}'">
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-black text-gray-900 uppercase leading-none">{{ $reseller->name }}</h3>
                                        <p class="text-[10px] text-red-500 font-bold mt-1 uppercase">Excluída em: {{ $reseller->deleted_at->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="bg-red-100 text-red-700 text-[10px] px-2 py-1 rounded-full font-bold">
                                        {{ $reseller->stores_count }} LOJAS ÓRFÃS
                                    </span>
                                </div>

                                <div class="flex flex-col space-y-2">
                                    <button class="w-full py-2 bg-gray-900 text-white text-[10px] font-bold uppercase rounded hover:bg-gray-800 transition">
                                        Ver Lojas da Revenda
                                    </button>
                                    <div class="grid grid-cols-2 gap-2">
                                        <form action="{{ route('master.tenants.restore', $reseller->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-2 bg-green-100 text-green-700 text-[9px] font-bold uppercase rounded hover:bg-green-200">Reabilitar</button>
                                        </form>
                                        <button @click.stop="confirmPermanentDelete('{{ $reseller->id }}')" class="w-full py-2 bg-red-100 text-red-700 text-[9px] font-bold uppercase rounded hover:bg-red-200">Excluir Permanente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 bg-white rounded-xl text-center border-2 border-dashed border-gray-200 text-gray-400 italic">
                            Nenhuma revenda excluída com lojas pendentes.
                        </div>
                    @endforelse
                </div>
            </div>

            <div x-show="tab === 'bloqueadas'" x-transition x-cloak>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-orange-500">
                    <div class="p-6">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Revenda / Loja</th>
                                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status Revenda</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($blockedStores as $store)
                                    <tr class="hover:bg-orange-50 transition-colors">
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $store->name }}</div>
                                            <div class="text-[10px] text-orange-600 font-medium uppercase">Origem: {{ $store->tenant->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-[9px] font-bold rounded-full uppercase italic">Bloqueada</span>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <a href="{{ route('master.login-as', $store->email) }}" class="inline-flex p-2 bg-gray-100 text-gray-600 rounded hover:bg-gray-200" title="Acessar Painel">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div x-show="activeRevenda" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="activeRevenda = null"></div>
                    <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        <div class="px-4 py-3 bg-gray-900 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-white uppercase tracking-widest">Lojas Órfãs da Revenda</h3>
                            <button @click="activeRevenda = null" class="text-gray-400 hover:text-white font-bold text-2xl">&times;</button>
                        </div>
                        <div class="p-6">
                            <table class="w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="text-[10px] font-bold text-gray-400 uppercase">
                                        <th class="text-left pb-3">Loja</th>
                                        <th class="text-center pb-3">E-mail</th>
                                        <th class="text-right pb-3">Ação</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($stores as $store)
                                        <template x-if="activeRevenda == '{{ $store->tenant_id }}'">
                                            <tr>
                                                <td class="py-3 text-sm font-bold">{{ $store->name }}</td>
                                                <td class="py-3 text-sm text-center text-gray-500">{{ $store->email }}</td>
                                                <td class="py-3 text-right">
                                                    <form action="{{ route('master.stores.migrate', $store->id) }}" method="POST">
                                                        @csrf
                                                        <button class="bg-green-600 text-white px-3 py-1 rounded text-[9px] font-black uppercase tracking-tighter hover:bg-green-700">Resgatar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </template>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                <p class="text-sm text-blue-700 font-medium">
                    <strong>Manual de Transição:</strong><br>
                    Revendas excluídas mantêm suas lojas em estado "Órfão". Você pode **Reabilitar** a revenda para restaurar o acesso dela, ou **Resgatar** lojas individuais para que virem Lojas Diretas do Master.
                </p>
            </div>
        </div>
    </div>

    <script>
        function confirmPermanentDelete(id) {
            if (confirm('ATENÇÃO CRÍTICA: Isso excluirá permanentemente a revenda e todos os registros vinculados. Esta ação NÃO PODE ser desfeita. Deseja continuar?')) {
                let form = document.createElement('form');
                form.action = `/master/tenants/${id}/force-delete`;
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>