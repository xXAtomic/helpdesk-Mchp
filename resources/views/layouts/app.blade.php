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

    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f3f4f6; overflow: hidden; }
        .main-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* SIDEBAR PROFESIONAL (ANCHO) */
        .sidebar { 
            width: 260px; background: #0f172a; display: flex; flex-direction: column; 
            padding: 0; border-right: 1px solid rgba(255,255,255,0.05); transition: 0.3s; z-index: 50; 
        }
        
        .sidebar-brand {
            padding: 2rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;
            color: white; font-weight: 800; font-size: 1.4rem; font-style: italic;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-item { 
            display: flex; align-items: center; gap: 1rem; padding: 0.75rem 1.5rem;
            color: #94a3b8; cursor: pointer; text-decoration: none; font-size: 0.9rem; font-weight: 600;
            transition: all 0.2s ease; margin: 0.25rem 1rem; border-radius: 12px;
        }
        
        .nav-item:hover { 
            background: rgba(255,255,255,0.05); color: white;
        }
        
        .nav-item.active { 
            background: #2563eb; color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); 
        }

        .nav-icon-span { font-size: 1.2rem; }

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
        <!-- BARRA LATERAL RESTAURADA -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <span style="color: #3b82f6;">MCHP</span> SOPORTE
            </div>

            <nav style="display: flex; flex-direction: column; margin-top: 1.5rem; flex: 1;">
                
                @php
                    $roleId = auth()->user()->role_id ?? 3;
                @endphp

                <!-- 🏠 DASHBOARD -->
                @if($roleId == 1)
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon-span">📊</span> DASHBOARD
                    </a>
                @elseif($roleId == 2)
                    <a href="{{ route('boss.dashboard') }}" class="nav-item {{ request()->routeIs('boss.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon-span">📈</span> MI DASHBOARD
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span class="nav-icon-span">🏠</span> MI DASHBOARD
                    </a>
                @endif

                <!-- 🎟️ TICKETS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.tickets.index') }}" class="nav-item {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <span class="nav-icon-span">🎟️</span> GESTIÓN TICKETS
                    </a>
                @else
                    <a href="{{ route('user.tickets.index') }}" class="nav-item {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}">
                        <span class="nav-icon-span">🎟️</span> MIS TICKETS
                    </a>
                @endif

                <!-- 📦 INVENTARIO (Solo Admin) -->
                @if($roleId == 1)
                    <a href="{{ route('admin.inventory.index') }}" class="nav-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
                        <span class="nav-icon-span">🖥️</span> INVENTARIO (EQUIPOS)
                    </a>
                @endif

                <!-- 📚 CONOCIMIENTO -->
                <a href="{{ route('knowledge.index') }}" class="nav-item {{ request()->routeIs('*knowledge*') ? 'active' : '' }}">
                    <span class="nav-icon-span">📚</span> MANUALES
                </a>

                <!-- 👥 USUARIOS (Solo Admin) -->
                @if($roleId == 1)
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="nav-icon-span">👥</span> USUARIOS
                    </a>
                @endif

            </nav>

            <!-- SALIR -->
            <div style="padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item" style="background: none; border: none; cursor: pointer; width: calc(100% - 2rem); margin: 0; padding-left: 0.5rem;">
                        <span class="nav-icon-span">🚪</span> CERRAR SESIÓN
                    </button>
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

                {{ $slot }}
            </div>
        </main>
    </div>

</body>
</html>
