<x-app-layout>
    <x-slot name="header">
        {{-- Cabeçalho Escuro no padrão do Master/Revenda --}}
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight uppercase">
                {{ __('Editar Loja') }}: {{ $store->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card Branco com Borda Superior Escura --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    {{-- Rota de Update com o ID da loja --}}
                    <form method="POST" action="{{ route('tenant.stores.update', $store) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Nome da Loja --}}
                            <div>
                                <x-input-label for="name" :value="__('Nome da Loja')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $store->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- E-mail de Contato (Desabilitado por segurança) --}}
                            <div>
                                <x-input-label for="email" :value="__('E-mail de Acesso')" />
                                <x-text-input id="email" class="block mt-1 w-full bg-gray-50 text-gray-500" type="email" name="email" :value="$store->email" disabled />
                                <p class="text-xs text-gray-400 mt-1 italic">O e-mail de acesso não pode ser alterado para garantir a integridade do login.</p>
                            </div>

                            {{-- Segmento --}}
                            <div>
                                <x-input-label for="segment_id" :value="__('Segmento de Atuação')" />
                                <select id="segment_id" name="segment_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach($segments as $segment)
                                        <option value="{{ $segment->id }}" {{ (old('segment_id', $store->segment_id) == $segment->id) ? 'selected' : '' }}>
                                            {{ $segment->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('segment_id')" class="mt-2" />
                            </div>

                            {{-- SEÇÃO DE SENHA (SUBSTITUINDO A DICA) --}}
                            <div class="border-t border-gray-100 pt-6 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Segurança e Acesso') }}</h3>
                                <p class="text-sm text-gray-500 mb-4 italic">Deixe os campos abaixo em branco caso **não** deseje alterar a senha atual da loja.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Nova Senha --}}
                                    <div>
                                        <x-input-label for="password" :value="__('Nova Senha de Acesso')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    {{-- Confirmação --}}
                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botões de Ação --}}
                        <div class="flex items-center justify-end py-6 gap-8 border-t border-gray-100 mt-8">
                            <a href="{{ route('tenant.stores.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase tracking-widest no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700 py-3 px-8 shadow-sm">
                                {{ __('ATUALIZAR DADOS') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>