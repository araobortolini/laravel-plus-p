<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white leading-tight">
            {{ __('Editar Segmento de Negócio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border-t-4 border-gray-900">
                <div class="p-6 sm:p-10 text-gray-900">
                    
                    <form method="POST" action="{{ route('master.settings.segments.update', $segment) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Nome do Segmento --}}
                            <div>
                                <x-input-label for="name" :value="__('Nome do Segmento')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $segment->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Motor Base (Comportamento) --}}
                            <div>
                                <x-input-label for="behavior_base" :value="__('Motor Base (Comportamento)')" />
                                <select id="behavior_base" name="behavior_base" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($behaviors as $key => $label)
                                        <option value="{{ $key }}" {{ old('behavior_base', $segment->behavior_base) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('behavior_base')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end py-6 gap-8">
                            <a href="{{ route('master.settings.segments.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-bold uppercase no-underline">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button class="bg-gray-900 hover:bg-gray-700">
                                {{ __('ATUALIZAR SEGMENTO') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>