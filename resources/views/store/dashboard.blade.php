<x-app-layout>
    <x-slot name="header">
        {{-- Cabeçalho Escuro no padrão do sistema --}}
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight uppercase">
                {{ __('Painel da Loja') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card 1: Status --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-600 p-6">
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Status da Loja</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2 italic">Bem-vindo, {{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-400 mt-1">Loja ativa e operante</p>
                </div>

                {{-- Card 2: Operação (PDV) --}}
                {{-- Nota: Futuramente você colocará a rota route('store.pdv.index') aqui --}}
                <a href="#" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900 p-6 hover:bg-gray-50 transition transform hover:-translate-y-1">
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Operação</h3>
                    <div class="flex items-center mt-2">
                        <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <p class="text-xl font-bold text-indigo-600 uppercase tracking-tighter">Acessar PDV</p>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Iniciar vendas e caixa</p>
                </a>

                {{-- Card 3: Estoque --}}
                {{-- Nota: Futuramente você colocará a rota route('store.products.index') aqui --}}
                <a href="#" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900 p-6 hover:bg-gray-50 transition transform hover:-translate-y-1">
                    <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest">Estoque</h3>
                    <div class="flex items-center mt-2">
                        <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p class="text-xl font-bold text-indigo-600 uppercase tracking-tighter">Produtos</p>
                    </div>
                    <p class="text-sm text-gray-400 mt-2">Cadastrar e gerenciar itens</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>