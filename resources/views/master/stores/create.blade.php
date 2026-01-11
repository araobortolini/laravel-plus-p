<x-app-layout>
    <x-slot name="header">
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Cadastrar Nova Loja Direta') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    <form method="POST" action="{{ route('master.stores.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nome do Responsável --}}
                            <div>
                                <x-input-label for="owner_name" :value="__('Nome do Responsável')" />
                                <x-text-input id="owner_name" class="block mt-1 w-full" type="text" name="owner_name" :value="old('owner_name')" required autofocus />
                                <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                            </div>

                            {{-- Nome da Loja --}}
                            <div>
                                <x-input-label for="name" :value="__('Nome da Loja')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- CPF/CNPJ --}}
                            <div>
                                <x-input-label for="document" :value="__('CPF/CNPJ')" />
                                <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document')" required />
                                <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            </div>

                            {{-- E-mail de Contato --}}
                            <div>
                                <x-input-label for="email" :value="__('E-mail de Contato')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Telefone (WhatsApp) --}}
                            <div>
                                <x-input-label for="phone" :value="__('Telefone (WhatsApp)')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            {{-- DIVISOR VISUAL PARA DADOS DE ACESSO --}}
                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Credenciais de Acesso à Loja') }}</h3>
                                
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
                                <p class="mt-2 text-sm text-gray-500 italic">O lojista usará este e-mail e senha para acessar o PDV.</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end py-6 gap-8">
                            <a href="{{ route('master.stores.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase tracking-widest no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700 py-3 px-8 shadow-sm">
                                {{ __('SALVAR LOJA DIRETA') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>