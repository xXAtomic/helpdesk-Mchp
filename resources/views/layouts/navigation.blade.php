<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ auth()->user()->is_admin ? __('DASHBOARD ADMIN') : __('INICIO') }}
                    </x-nav-link>
                    @if(auth()->user()->is_admin)
                        <x-nav-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')">
                            {{ __('CONTROL TICKETS') }}
                        </x-nav-link>
                        <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.index')">
                            {{ __('INVENTARIO') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('user.tickets.index')" :active="request()->routeIs('user.tickets.*')">
                            {{ __('MIS TICKETS') }}
                        </x-nav-link>
                        <x-nav-link :href="route('knowledge.index')" :active="request()->routeIs('knowledge.index')">
                            {{ __('FAQ (PREGUNTAS)') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 transition">
                            <div>{{ Auth::user()->name }} @if(Auth::user()->is_admin) (ADMIN) @endif</div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}"> @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
