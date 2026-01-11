<x-app-layout>
    <x-slot name="header">
        {{-- Cabeçalho Escuro estilo Master --}}
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Cadastrar Nova Loja (Revenda)') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card Branco com Borda Superior Escura --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    {{-- Aponta para a rota da Revenda --}}
                    <form method="POST" action="{{ route('tenant.stores.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            
                            {{-- Nome da Loja --}}
                            <div>
                                <x-input-label for="name" :value="__('Nome da Loja')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- E-mail de Contato/Login --}}
                            <div>
                                <x-input-label for="email" :value="__('E-mail de Acesso')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Segmento (Campo exclusivo da Revenda) --}}
                            <div>
                                <x-input-label for="segment_id" :value="__('Segmento de Atuação')" />
                                <select id="segment_id" name="segment_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Selecione um segmento...</option>
                                    @foreach($segments as $segment)
                                        <option value="{{ $segment->id }}" {{ old('segment_id') == $segment->id ? 'selected' : '' }}>
                                            {{ $segment->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('segment_id')" class="mt-2" />
                            </div>

                            {{-- DIVISOR VISUAL PARA DADOS DE ACESSO --}}
                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Segurança') }}</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Senha --}}
                                    <div>
                                        <x-input-label for="password" :value="__('Senha de Acesso')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    {{-- Confirmação de Senha --}}
                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 italic">Estas credenciais serão usadas pelo lojista para acessar o sistema.</p>
                            </div>
                        </div>

                        {{-- Botões de Ação --}}
                        <div class="flex items-center justify-end py-6 gap-8">
                            <a href="{{ route('tenant.stores.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase tracking-widest no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700 py-3 px-8 shadow-sm">
                                {{ __('CRIAR LOJA') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>