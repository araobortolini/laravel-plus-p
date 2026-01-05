<nav x-data="{ open: false }" class="bg-gray-900 md:w-64 md:h-screen md:sticky md:top-0 md:flex-shrink-0 flex flex-col z-50">
    
    <div class="md:hidden flex items-center justify-between px-4 h-16 bg-gray-900 text-white border-b border-gray-700 flex-shrink-0">
        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}">
                <span class="font-bold text-lg tracking-wider text-white">
                    {{ Auth::user()->is_master ? 'MASTER' : 'REVENDA' }}
                </span>
            </a>
        </div>
        
        <div class="flex items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 hover:text-white focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
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
    </div>

    <div :class="{'translate-x-0': open, '-translate-x-full': ! open}" 
         class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto border-r border-gray-700 shadow-[6px_0_20px_rgba(0,0,0,0.8)] relative flex flex-col h-full">
        
        <div class="hidden md:flex items-center justify-center h-16 border-b border-gray-800 px-4 flex-shrink-0">
            <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl tracking-wider uppercase">
                {{ Auth::user()->is_master ? 'MASTER PANEL' : 'PAINEL REVENDA' }}
            </a>
        </div>

        <div class="flex-1 flex flex-col mt-4 space-y-2 px-2 overflow-y-auto custom-scrollbar">
            
            {{-- Link Dashboard --}}
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            {{-- Links Exclusivos do Master --}}
            @if(Auth::user()->is_master)
                <a href="{{ route('master.tenants.index') }}" class="flex items-center px-4 py-2 rounded-md transition-colors {{ request()->routeIs('master.tenants.*') ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Revendas
                </a>

                {{-- [NOVO] Menu Configurações com Dropdown --}}
                <div x-data="{ open: {{ request()->routeIs('master.settings.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 rounded-md transition-colors bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Configurações
                        </span>
                        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" x-cloak class="mt-2 ml-4 space-y-1 border-l-2 border-gray-700 pl-4">
                        <a href="{{ route('master.settings.segments.index') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('master.settings.segments.*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                            Segmentos
                        </a>
                    </div>
                </div>
            @endif

            {{-- Link Lojas: Aparece SOMENTE para a Revenda --}}
            @if(!Auth::user()->is_master)
                <a href="{{ route('tenant.stores.index') }}" class="flex items-center px-4 py-2 rounded-md transition-colors {{ request()->routeIs('tenant.stores.*') ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Lojas
                </a>
            @endif

            {{-- Link de Retorno Dourado: Só aparece se estiver simulando --}}
            @if(session()->has('impersonator_id'))
                <div class="pt-4 mt-4 border-t border-gray-800">
                    <a href="{{ route('master.leave-impersonation') }}" class="flex items-center px-4 py-3 rounded-md font-bold text-[11px] uppercase tracking-widest transition-all bg-[#D4AF37] hover:bg-[#B8860B] text-gray-900 border border-[#C5A028] shadow-[0_4px_15px_rgba(212,175,55,0.3)]">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Voltar para Master
                    </a>
                </div>
            @endif

        </div>
    </div>

    <div x-show="open" 
         @click="open = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden transition-opacity"
         style="display: none;">
    </div>
</nav>