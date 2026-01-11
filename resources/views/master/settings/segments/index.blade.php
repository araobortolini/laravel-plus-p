<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            {{ __('Configurações: Segmentos de Negócio') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ openModal: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-6">
                <button @click="openModal = true" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150 shadow-md cursor-pointer">
                    + Novo Segmento
                </button>
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

        <div x-show="openModal" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="fixed inset-0 bg-gray-900 opacity-75" @click="openModal = false"></div>

            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full relative z-10"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="bg-gray-900 px-4 py-3 border-b border-gray-700 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-bold text-white uppercase tracking-wider">Cadastrar Novo Segmento</h3>
                        <button @click="openModal = false" class="text-gray-400 hover:text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('master.settings.segments.store') }}" method="POST" class="p-6">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="name" :value="__('Nome do Segmento')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus placeholder="Ex: Hamburgueria, Loja de Roupas..." />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="behavior_base" :value="__('Motor Base (Comportamento)')" />
                                <select id="behavior_base" name="behavior_base" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecione o motor...</option>
                                    @foreach($behaviors as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1 italic">Define a lógica de operação do sistema para este nicho.</p>
                                <x-input-error :messages="$errors->get('behavior_base')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                            <button type="button" @click="openModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Salvar Segmento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>