<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            {{ __('Novo Segmento de Negócio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="p-8">
                    <form method="POST" action="{{ route('master.settings.segments.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nome do Segmento (Ex: Pizzaria, Oficina...)')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Digite o nome amigável..." />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="behavior_base" :value="__('Motor Lógico (Comportamento)')" />
                            <select id="behavior_base" name="behavior_base" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-gray-700 font-medium">
                                <option value="" disabled selected>Selecione o comportamento base...</option>
                                @foreach($behaviors as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-500 italic">
                                * Isso define como o PDV e as funções principais da loja se comportarão.
                            </p>
                            <x-input-error :messages="$errors->get('behavior_base')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('master.settings.segments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="bg-gray-900 hover:bg-gray-700">
                                {{ __('Cadastrar Segmento') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>