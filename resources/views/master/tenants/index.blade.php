<x-app-layout>
    <x-slot name="header">
        {{ __('Gerenciar Revendas') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-4 sm:p-6 text-gray-900">
                    
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('master.tenants.create') }}" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Nova Revenda
                        </a>
                    </div>

                    <div class="w-full overflow-hidden"> 
                        <table class="w-full divide-y divide-gray-200 table-fixed">
                            <thead class="bg-blue-600">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-auto">
                                        Revenda
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
                                {{-- INÍCIO DO LOOP --}}
                                <tr class="hover:bg-blue-50 transition-colors">
                                    
                                    <td class="px-3 py-4 align-middle">
                                        <div class="flex items-center">
                                            <div class="hidden sm:flex flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full items-center justify-center text-blue-700 font-bold text-sm mr-3">
                                                L1
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-bold text-gray-900 truncate">
                                                    Loja Exemplo 01
                                                </div>
                                                <div class="text-xs text-gray-500 truncate">
                                                    CNPJ: 00.000.000/0001-00
                                                </div>
                                                
                                                <div class="lg:hidden mt-1 text-xs text-gray-400 flex flex-col">
                                                    <span class="truncate">contato@lojaexemplo.com</span>
                                                    <span class="truncate">(27) 99999-9999</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="hidden lg:table-cell px-3 py-4 whitespace-nowrap align-middle">
                                        <div class="text-sm text-gray-900 truncate">contato@lojaexemplo.com</div>
                                        <div class="text-sm text-gray-500 truncate">(27) 99999-9999</div>
                                    </td>

                                    <td class="px-1 py-4 text-center align-middle">
                                        <span class="inline-flex px-2 py-1 text-[10px] sm:text-xs font-bold leading-4 rounded-full bg-green-100 text-green-800">
                                            Ativo
                                        </span>
                                    </td>

                                    <td class="px-1 py-4 text-right align-middle">
                                        <div class="flex justify-end items-center gap-2">
                                            
                                            <a href="#" class="text-blue-600 hover:text-blue-900 font-bold p-1" title="Editar">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>

                                            <button class="text-red-600 hover:text-red-900 font-bold p-1" title="Excluir">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                {{-- FIM DO LOOP --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>