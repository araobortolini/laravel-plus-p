<div x-data="{ open: false }" class="flex flex-col md:flex-row">

    <nav class="md:hidden bg-[#172554] border-b border-blue-800 w-full">
        <div class="flex items-center justify-between h-16 px-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl">
                    PlusPDV
                </a>
            </div>

            <button @click="open = ! open" class="text-blue-200 hover:text-white focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden bg-[#1e3a8a]">
            <div class="pt-2 pb-3 space-y-1">
                @if(Auth::user()->is_master)
                    <x-responsive-nav-link :href="route('master.dashboard')" :active="request()->routeIs('master.dashboard')" class="text-white">
                        Dashboard Master
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('master.tenants.index')" :active="request()->routeIs('master.tenants.*')" class="text-white">
                        Revendas
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                        Visão Geral
                    </x-responsive-nav-link>
                @endif
            </div>
            
            <div class="pt-4 pb-1 border-t border-blue-800 px-4">
                <div class="text-white font-bold">{{ Auth::user()->name }}</div>
                <div class="text-sm text-blue-200">{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-sm text-blue-200 hover:text-white">Sair</button>
                </form>
            </div>
        </div>
    </nav>

    <aside class="hidden md:flex flex-col w-64 min-h-screen bg-[#172554] border-r border-blue-900">
        
        <div class="flex items-center justify-center h-16 bg-[#172554] border-b border-blue-900 shadow-sm">
            <h1 class="text-2xl font-bold text-white tracking-wider">PlusPDV</h1>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-2 space-y-1">
            
            @if(Auth::user()->is_master)
                <div class="mb-6">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Administração</p>
                    
                    <a href="{{ route('master.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors mb-1
                       {{ request()->routeIs('master.dashboard') ? 'bg-white text-[#172554]' : 'text-white hover:bg-blue-900' }}">
                        Dashboard Master
                    </a>

                    <a href="{{ route('master.tenants.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors mb-1
                       {{ request()->routeIs('master.tenants.*') ? 'bg-white text-[#172554]' : 'text-white hover:bg-blue-900' }}">
                        Revendas
                    </a>
                </div>
            @endif

            @if(!Auth::user()->is_master)
                <div class="mb-6">
                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Gestão Loja</p>
                    <a href="/dashboard" 
                       class="flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors mb-1
                       {{ request()->routeIs('dashboard') ? 'bg-white text-[#172554]' : 'text-white hover:bg-blue-900' }}">
                        Visão Geral
                    </a>
                </div>
            @endif

        </div>
    </aside>

</div>