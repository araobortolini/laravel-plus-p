<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Título dinâmico para a aba do navegador --}}
        <title>{{ Auth::user()->is_master ? 'Master Panel' : 'Painel Revenda' }} - {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- TRAVA GLOBAL DE INTERFACE: Impede cliques em botões de ação se o painel estiver bloqueado --}}
        @if(Auth::user()->tenant && !Auth::user()->tenant->is_active)
            <style>
                /* Esconde botões de criação e submissão em todo o sistema */
                form button[type="submit"]:not(.logout-btn), 
                a[href*="create"], 
                button[id*="create"],
                .btn-primary {
                    display: none !important;
                }

                /* Desabilita visualmente inputs e seletores */
                input, select, textarea {
                    pointer-events: none !important;
                    background-color: #f3f4f6 !important;
                    opacity: 0.7;
                }
            </style>
        @endif
    </head>
    <body class="font-sans antialiased bg-gray-100">
        
        <div class="min-h-screen flex flex-col md:flex-row">
            
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-h-screen w-full">
                
                <header class="hidden md:flex items-center justify-between bg-gray-900 shadow h-16 px-6 border-b border-gray-800">
                    
                    {{-- A correção segura: usamos o seletor descendente para forçar branco apenas nos textos deste bloco --}}
                    <div class="font-semibold text-xl leading-tight text-white [&_h2]:text-white [&_div]:text-white">
                        @if (isset($header))
                            {{ $header }}
                        @endif
                    </div>

                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-900 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                    <div class="font-bold">{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Perfil') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Sair') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    
                    {{-- AVISO GLOBAL DE PAINEL BLOQUEADO --}}
                    @if(Auth::user()->tenant && !Auth::user()->tenant->is_active)
                        <div class="bg-orange-600 text-white py-3 px-6 shadow-lg flex items-center justify-between sticky top-0 z-50 border-b border-orange-700">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest">Painel Bloqueado / Modo de Leitura</p>
                                    <p class="text-[10px] opacity-90 uppercase font-bold">Ações de escrita e alteração estão desabilitadas.</p>
                                </div>
                            </div>
                            <button class="bg-white text-orange-700 px-4 py-1.5 rounded-md text-[10px] font-black uppercase hover:bg-orange-50 transition shadow-sm">
                                Saiba Mais
                            </button>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="max-w-7xl mx-auto mb-6">
                            @if (session('success'))
                                <div class="rounded-md bg-green-50 p-4 border-l-4 border-green-400 mb-4 shadow-sm">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="rounded-md bg-red-50 p-4 border-l-4 border-red-400 mb-4 shadow-sm">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">Encontramos alguns problemas:</h3>
                                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>