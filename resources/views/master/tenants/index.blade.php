<x-app-layout>
    <x-slot name="header">
        {{ __('Gerenciar Revendas') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de Sucesso --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-900">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('master.tenants.create') }}" class="px-4 py-2 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Nova Revenda
                        </a>
                    </div>

                    <div class="w-full overflow-hidden"> 
                        <table class="w-full divide-y divide-gray-200 table-fixed">
                            <thead class="bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-auto">
                                        Revenda / Revendedor
                                    </th>
                                    
                                    <th scope="col" class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-3/12">
                                        Email / Contato
                                    </th>
                                    
                                    <th scope="col" class="px-2 py-3 text-center text-xs font-bold text-white uppercase tracking-wider w-20">
                                        Status
                                    </th>
                                    
                                    <th scope="col" class="px-2 py-3 text-right text-xs font-bold text-white uppercase tracking-wider w-[70px] sm:w-[100px]">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($tenants as $tenant)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-3 py-4 align-middle">
                                        <div class="flex items-center">
                                            <div class="hidden sm:flex flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full items-center justify-center text-gray-700 font-bold text-sm mr-3">
                                                {{ substr($tenant->name, 0, 2) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $tenant->name }}
                                                </div>
                                                <div class="text-[10px] text-gray-500 truncate uppercase">
                                                    Resp: {{ $tenant->seller_name }}
                                                </div>
                                                <div class="text-xs text-gray-400 truncate">
                                                    CNPJ/CPF: {{ $tenant->document }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-nowrap align-middle">
                                        <div class="text-sm text-gray-900 truncate">{{ $tenant->email }}</div>
                                        <div class="text-sm text-gray-500 truncate">{{ $tenant->phone }}</div>
                                    </td>

                                    <td class="px-1 py-4 text-center align-middle">
                                        <span class="inline-flex px-2 py-1 text-[10px] font-bold leading-4 rounded-full bg-green-100 text-green-800">
                                            Ativo
                                        </span>
                                    </td>

                                    <td class="px-1 py-4 text-right align-middle">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('master.tenants.edit', $tenant->id) }}" class="text-blue-600 hover:text-blue-900" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-8 text-center text-gray-500 italic">
                                        Nenhuma revenda cadastrada.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">
                            {{ $tenants->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>