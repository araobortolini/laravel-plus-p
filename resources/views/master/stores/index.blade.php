<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Gerenciar Lojas Diretas') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        openModal: false, 
        openDeleteModal: false, 
        selectedStore: {},
        deleteCode: '',
        userInput: '',
        generateCode() {
            this.deleteCode = Math.floor(1000 + Math.random() * 9000).toString();
            this.userInput = '';
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('master.stores.create') }}" class="px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Nova Loja
                        </a>
                    </div>

                    <div class="w-full overflow-hidden"> 
                        <table class="w-full divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Loja / Responsável
                                    </th>
                                    <th scope="col" class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-3/12">
                                        Documento / Email
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-20">
                                        Status
                                    </th>
                                    <th scope="col" class="px-2 py-3 text-right text-xs font-bold text-white uppercase tracking-wider w-[120px]">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($stores as $store)
                                <tr class="hover:bg-gray-50 transition-colors cursor-pointer" 
                                    @click="selectedStore = {{ json_encode($store) }}; openModal = true">
                                    <td class="px-3 py-4 align-middle">
                                        <div class="flex items-center">
                                            <div class="hidden sm:flex flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full items-center justify-center text-gray-700 font-bold text-sm mr-3 uppercase border border-gray-200">
                                                {{ substr($store->name, 0, 2) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-bold text-gray-900 truncate">{{ $store->name }}</div>
                                                <div class="text-[10px] text-gray-500 truncate uppercase italic">Vínculo: Direta (Master)</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-nowrap align-middle">
                                        <div class="text-sm text-gray-900 truncate">{{ $store->document ?? '---' }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ $store->email }}</div>
                                    </td>

                                    <td class="px-1 py-4 text-center align-middle">
                                        <span class="inline-flex px-2 py-1 text-[10px] font-bold leading-4 rounded-full bg-green-100 text-green-800 uppercase border border-green-200">
                                            Ativo
                                        </span>
                                    </td>

                                    <td class="px-1 py-4 text-right align-middle">
                                        <div class="flex justify-end items-center gap-3" @click.stop>
                                            {{-- Botão Impersonation (Login como Lojista) --}}
                                            <a href="{{ route('master.login-as', $store->email) }}" 
                                               class="text-amber-500 hover:text-amber-700 transition-colors" 
                                               title="Acessar painel da loja">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('master.stores.edit', $store->id) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>

                                            <button @click="selectedStore = {{ json_encode($store) }}; generateCode(); openDeleteModal = true" class="text-red-600 hover:text-red-900" title="Excluir">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-8 text-center text-gray-500 italic uppercase text-[10px] tracking-widest bg-gray-50">Nenhuma loja direta cadastrada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DE INFORMAÇÕES --}}
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openModal = false"></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full border-t-4 border-gray-900">
                    <div class="bg-gray-900 px-4 py-3 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white uppercase tracking-widest">Informações da Loja</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-white">&times;</button>
                    </div>
                    <div class="p-6 space-y-6 text-left">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Nome da Loja</label>
                            <p class="text-lg font-bold text-gray-900" x-text="selectedStore.name"></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Documento</label>
                                <p class="text-sm text-gray-700 font-medium" x-text="selectedStore.document ?? '---'"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter">WhatsApp</label>
                                <p class="text-sm text-gray-700 font-medium" x-text="selectedStore.phone ?? '---'"></p>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-tighter">E-mail de Login</label>
                            <p class="text-sm text-gray-700 font-medium" x-text="selectedStore.email"></p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 flex justify-end items-center border-t border-gray-100">
                        <button @click="openModal = false" class="px-6 py-2 bg-gray-900 text-white text-[10px] font-bold rounded uppercase tracking-widest hover:bg-gray-700 transition shadow-md">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DE EXCLUSÃO SEGURA --}}
        <div x-show="openDeleteModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div class="fixed inset-0 bg-black bg-opacity-60 transition-opacity" @click="openDeleteModal = false"></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full border-t-4 border-red-600">
                    <div class="p-6">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 uppercase tracking-widest text-center">Excluir Loja Direta?</h3>
                        <p class="text-sm text-gray-500 mt-2 italic text-center">A loja <span class="font-bold text-gray-900" x-text="selectedStore.name"></span> e todos os seus acessos serão removidos.</p>
                        <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-[10px] font-bold text-gray-500 uppercase mb-2 text-center">Digite o código para confirmar:</p>
                            <div class="text-2xl font-black text-gray-900 tracking-widest mb-3 select-none text-center" x-text="deleteCode"></div>
                            <input type="text" x-model="userInput" maxlength="4" placeholder="----" class="w-full text-center text-lg font-bold border-gray-300 rounded-md focus:ring-red-500 focus:border-red-500 shadow-sm transition-all">
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse gap-2">
                        {{-- Correção técnica: Rota concatenada corretamente via AlpineJS --}}
                        <form :action="'{{ route('master.stores.index') }}/' + selectedStore.id" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" :disabled="userInput !== deleteCode"
                                    :class="userInput === deleteCode ? 'bg-red-600 hover:bg-red-700 shadow-md' : 'bg-gray-300 cursor-not-allowed'"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent px-4 py-2 text-xs font-bold text-white uppercase transition-all sm:w-auto">
                                Confirmar Exclusão
                            </button>
                        </form>
                        <button @click="openDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-bold text-gray-700 uppercase hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>