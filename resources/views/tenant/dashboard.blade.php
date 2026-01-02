<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Alterado para text-white para garantir visibilidade no fundo escuro --}}
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Painel do Revendedor') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Grid de Cards de Indicadores --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                {{-- Card: Total de Lojas --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-blue-500 p-6">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Minhas Lojas</div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-3xl font-black text-gray-900">0</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>

                {{-- Card: Receita Mensal --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-green-500 p-6">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Receita Mensal</div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-3xl font-black text-gray-900 text-green-600">R$ 0,00</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Card: Lojas Inativas --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-red-500 p-6">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Lojas Inativas</div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-3xl font-black text-gray-900">0</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>

                {{-- Card: Ações Pendentes --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-orange-500 p-6">
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Ações Pendentes</div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-sm font-bold text-gray-400 italic">Tudo em dia</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

            </div>

            {{-- Seção de Atalhos Rápidos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 uppercase tracking-widest text-sm mb-4">Atalhos Rápidos</h3>
                    <div class="flex flex-wrap gap-4">
                        <a href="#" class="px-6 py-3 bg-gray-900 text-white rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-700 transition shadow-md">
                            + Cadastrar Nova Loja
                        </a>
                        <a href="#" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                            Ver Todas as Lojas
                        </a>
                        <a href="#" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-50 transition shadow-sm">
                            Relatório de Vendas
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>