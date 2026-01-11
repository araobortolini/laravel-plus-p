<x-app-layout>
    <x-slot name="header">
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight uppercase">
                {{ __('Editar Loja Direta') }}: {{ $store->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    <form method="POST" action="{{ route('master.stores.update', $store->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Nome da Loja --}}
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="name" :value="__('Nome da Loja')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $store->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- E-mail --}}
                            <div class="col-span-1 md:col-span-2">
                                <x-input-label for="email" :value="__('E-mail de Acesso')" />
                                <x-text-input id="email" class="block mt-1 w-full bg-gray-100 text-gray-500 cursor-not-allowed" type="email" name="email" :value="$store->email" readonly />
                                <p class="text-xs text-gray-500 mt-1 italic">O e-mail não pode ser alterado para garantir a integridade do acesso.</p>
                            </div>

                            {{-- Documento --}}
                            <div>
                                <x-input-label for="document" :value="__('Documento (CPF/CNPJ)')" />
                                <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document', $store->document)" />
                                <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            </div>

                            {{-- Telefone --}}
                            <div>
                                <x-input-label for="phone" :value="__('Telefone / WhatsApp')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $store->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <div class="col-span-1 md:col-span-2 mt-4 border-t border-gray-100 pt-6">
                                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4">Segurança / Alterar Senha</h3>
                                <p class="text-xs text-gray-500 mb-4 italic italic">Preencha os campos abaixo apenas se desejar alterar a senha de acesso desta loja.</p>
                            </div>

                            {{-- Nova Senha --}}
                            <div>
                                <x-input-label for="password" :value="__('Nova Senha')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            {{-- Confirmar Senha --}}
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="Repita a nova senha" />
                            </div>
                        </div>

                        {{-- Botões de Ação --}}
                        <div class="flex items-center justify-end py-6 gap-4 border-t border-gray-100 mt-8">
                            <a href="{{ route('master.stores.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase tracking-widest no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700 py-3 px-8 shadow-sm">
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>