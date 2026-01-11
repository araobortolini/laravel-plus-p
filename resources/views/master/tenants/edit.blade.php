<x-app-layout>
    <x-slot name="header">
        <div class="bg-gray-900 -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:px-8">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Editar Revenda') }}: {{ $tenant->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Card no padrão Master (Branco com borda superior preta) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    <form method="POST" action="{{ route('master.tenants.update', $tenant) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nome do Responsável (Seller Name) --}}
                            <div>
                                <x-input-label for="seller_name" :value="__('Nome do Responsável')" />
                                <x-text-input id="seller_name" class="block mt-1 w-full" type="text" name="seller_name" :value="old('seller_name', $tenant->seller_name)" required autofocus />
                                <x-input-error :messages="$errors->get('seller_name')" class="mt-2" />
                            </div>

                            {{-- Nome da Empresa/Revenda --}}
                            <div>
                                <x-input-label for="name" :value="__('Nome da Revenda (Empresa)')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $tenant->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- CPF/CNPJ --}}
                                <div>
                                    <x-input-label for="document" :value="__('CPF/CNPJ')" />
                                    <x-text-input id="document" class="block mt-1 w-full" type="text" name="document" :value="old('document', $tenant->document)" required />
                                    <x-input-error :messages="$errors->get('document')" class="mt-2" />
                                </div>

                                {{-- Telefone --}}
                                <div>
                                    <x-input-label for="phone" :value="__('Telefone (WhatsApp)')" />
                                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $tenant->phone)" required />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>
                            </div>

                            {{-- E-mail de Acesso --}}
                            <div>
                                <x-input-label for="email" :value="__('E-mail de Contato/Acesso')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $tenant->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Seção de Alteração de Senha --}}
                            <div class="border-t border-gray-100 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Alterar Senha') }}</h3>
                                <p class="text-sm text-gray-500 mb-4 italic">Deixe os campos abaixo em branco caso não queira alterar a senha atual.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label for="password" :value="__('Nova Senha')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end py-6 gap-8">
                            <a href="{{ route('master.tenants.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase tracking-widest no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700 py-3 px-8 shadow-sm">
                                {{ __('ATUALIZAR REVENDA') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>