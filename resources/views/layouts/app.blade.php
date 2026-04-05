<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TI Help Desk') }}</title>
    
    <!-- Fuente Inter (Estilo SaaS Premium) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- --- DEPENDENCIAS PREMIUM --- -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f3f4f6; overflow: hidden; }
        .main-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* SIDEBAR MINIMALISTA PRO (64px) */
        .sidebar { 
            width: 64px; background: #0f172a; display: flex; flex-direction: column; 
            align-items: center; padding: 0; border-right: 1px solid rgba(255,255,255,0.05); 
            transition: 0.3s; z-index: 50; 
        }
        
        .sidebar-brand {
            padding: 1.5rem 0; display: flex; justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 1.5rem;
        }

        .nav-icon { 
            width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; 
            color: #94a3b8; margin-bottom: 1rem; cursor: pointer; text-decoration: none; font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
        }
        
        .nav-icon:hover { 
            background: rgba(255,255,255,0.1); color: white; transform: scale(1.1);
        }
        
        .nav-icon.active { 
            background: #2563eb; color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); 
        }

        /* ÁREA DE CONTENIDO */
        .content-area { flex: 1; display: flex; flex-direction: column; background: #f8fafc; overflow-y: auto; position: relative; }

        /* SCROLLBAR PERSONALIZADA */
        .content-area::-webkit-scrollbar { width: 6px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <!-- BARRA LATERAL MINIMALISTA -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="transition-transform hover:scale-110 active:scale-95 duration-300">
                    @if(file_exists(public_path('img/logo.png')))
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/10">
                    @elseif(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/10">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xl border border-white/20">
                            G
                        </div>
                    @endif
                </a>
            </div>

            <nav style="display: flex; flex-direction: column; align-items: center; width: 100%; flex: 1;">
                
                @php
                    $roleId = auth()->user()->role_id ?? 3;
                @endphp

                <!-- 📊 DASHBOARD -->
                @if($roleId == 1)
                    <a href="{{ route('admin.dashboard') }}" class="nav-icon {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">📊</a>
                @elseif($roleId == 2)
                    <a href="{{ route('boss.dashboard') }}" class="nav-icon {{ request()->routeIs('boss.dashboard') ? 'active' : '' }}" title="Mi Dashboard">📈</a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-icon {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Mi Dashboard">🏠</a>
                @endif

                <!-- 🎟️ TICKETS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.tickets.index') }}" class="nav-icon {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}" title="Gestión Tickets">🎟️</a>
                @else
                    <a href="{{ route('user.tickets.index') }}" class="nav-icon {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}" title="Mis Tickets">🎟️</a>
                @endif

                <!-- 🖥️ INVENTARIO -->
                @if($roleId == 1)
                    <a href="{{ route('admin.inventory.index') }}" class="nav-icon {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" title="Inventario">🖥️</a>
                @endif

                <!-- 📚 MANUALES -->
                <a href="{{ route('knowledge.index') }}" class="nav-icon {{ request()->routeIs('*knowledge*') ? 'active' : '' }}" title="Manuales">📚</a>

                <!-- 👥 USUARIOS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.users.index') }}" class="nav-icon {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Usuarios">👥</a>
                @endif

            </nav>

            <!-- SALIR -->
            <div style="margin-top: auto; padding-bottom: 2rem; width: 100%; display: flex; justify-content: center;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-icon" style="background: none; border: none; cursor: pointer;" title="Cerrar Sesión">🚪</button>
                </form>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="content-area">
            @if(isset($header))
                <header class="bg-white border-b border-gray-200 py-4 px-8 flex justify-between items-center shadow-sm">
                    <h1 class="text-xl font-bold text-gray-800">{{ $header }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold px-2 py-1 bg-gray-100 text-gray-600 rounded-lg">
                            {{ auth()->user()->role->name ?? 'Usuario' }}
                        </span>
                        <span class="text-sm font-medium text-gray-500">{{ auth()->user()->name }}</span>
                    </div>
                </header>
            @endif

            <div class="p-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
