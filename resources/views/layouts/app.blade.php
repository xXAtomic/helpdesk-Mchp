<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TI Help Desk | Portal de Soporte</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind via CDN for manual preview if not compiled -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    <!-- Navbar Superior -->
    <nav class="bg-blue-600 border-b border-blue-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="shrink-0 flex items-center">
                        <span class="font-bold text-2xl tracking-tight text-white">
                            Soporte<span class="text-blue-200">TI</span>
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm font-medium">Hola, {{ auth()->user()->name ?? 'Usuario Final' }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="text-blue-100 hover:text-white bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium transition">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sub Navbar de Acciones Rápidas -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex space-x-6">
            <a href="{{ route('user.tickets.index') ?? '#' }}" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-transparent hover:border-blue-600 pb-1 transition">
                Mis Tickets
            </a>
            <a href="{{ route('user.tickets.create') ?? '#' }}" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-transparent hover:border-blue-600 pb-1 transition">
                📝 Crear Nuevo Ticket
            </a>
            <a href="{{ route('user.knowledge.index') }}" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-transparent hover:border-blue-600 pb-1 transition">
                📚 Base de Conocimientos
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative shadow-sm" role="alert">
                <span class="block sm:inline font-medium">✅ {{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-gray-300 py-6 text-center text-sm">
        <p>&copy; {{ date('Y') }} Plataforma de Soporte TI. Basado en Laravel y Tailwind.</p>
    </footer>
=======
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TICKETS | HELP DESK</title>
    <!-- Fuente Inter (Super limpia para SaaS) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; font-family: 'Inter', sans-serif; background-color: #f3f4f6; overflow: hidden; }
        .main-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* BARRA IZQUIERDA NEGRA (ICONOS) */
        .sidebar { width: 64px; background: #111827; display: flex; flex-direction: column; align-items: center; padding: 0; border-right: 1px solid rgba(255,255,255,0.05); transition: 0.3s; }
        
        .nav-icon { 
            width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; 
            color: #9ca3af; margin-bottom: 1.2rem; cursor: pointer; text-decoration: none; font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
        }
        
        .nav-icon:hover { 
            background: rgba(255,255,255,0.1); color: white; transform: translateX(3px) scale(1.1);
        }
        
        .nav-icon.active { 
            background: #2563eb; color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); 
        }

        /* ÁREA DE CONTENIDO (GRIS/BLANCO) */
        .content-area { flex: 1; display: flex; flex-direction: column; background: white; overflow-y: auto; position: relative; }

        /* BOTONES INTERACTIVOS (PREMIUM) */
        .btn-primary { 
            background: #2563eb; color: white; border: 1px solid #1d4ed8; padding: 0.65rem 1.4rem; 
            border-radius: 10px; font-weight: 700; font-size: 0.82rem; cursor: pointer; 
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            display: inline-flex; align-items: center; gap: 0.5rem; text-transform: none;
        }

        .btn-primary:hover { 
            background: #1d4ed8; transform: translateY(-2px); 
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -2px rgba(37, 99, 235, 0.05);
        }

        .btn-primary:active { 
            transform: translateY(0px) scale(0.96); 
        }

        .btn-filter { 
            background: white; color: #4b5563; border: 1px solid #e5e7eb; padding: 0.65rem 1.4rem; 
            border-radius: 10px; font-weight: 700; font-size: 0.82rem; cursor: pointer; 
            transition: all 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem;
        }

        .btn-filter:hover { 
            background: #f9fafb; border-color: #d1d5db; color: #111827; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-filter:active {
            background: #f3f4f6; transform: scale(0.98);
        }

        /* TABLAS MODERNAS */
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9fafb; padding: 0.8rem 1.5rem; border-bottom: 1px solid #f1f5f9; font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.1em; text-align: left; }
        td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f9fafb; color: #111827; font-size: 0.88rem; }

        /* PILLS / BADGES */
        .badge { padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 750; border: 1px solid transparent; }
        .badge-open { background: #eff6ff; color: #2563eb; border-color: #dbeafe; }
        .badge-closed { background: #111827; color: white; }
        .badge-solved { background: #f0fdf4; color: #166534; border-color: #dcfce7; }

        /* AVATARS */
        .avatar { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 800; color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 2px solid white; }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <!-- BARRA ICONOS (NEGRA) -->
        <div class="sidebar">
            <!-- LOGOTIPO COMPACTO -->
            <div style="padding: 1.2rem 0; width: 100%; display: flex; justify-content: center; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 2rem;">
                <img src="{{ asset('images/logo.png') }}" style="width: 42px; height: 42px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.4));" alt="LOGO">
            </div>

            <!-- NAVEGACIÓN -->
            <nav style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <a href="{{ route('admin.dashboard') }}" class="nav-icon {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">📊</a>
                <a href="{{ route('admin.tickets.index') }}" class="nav-icon {{ request()->routeIs('admin.tickets.index') ? 'active' : '' }}" title="Tickets">🎟️</a>
                <a href="{{ route('inventory.index') }}" class="nav-icon {{ request()->routeIs('inventory.index') ? 'active' : '' }}" title="Inventario">📦</a>
                <a href="{{ route('admin.knowledge.index') }}" class="nav-icon {{ request()->routeIs('admin.knowledge.index') ? 'active' : '' }}" title="FAQ">❓</a>
                <a href="{{ route('admin.users.index') }}" class="nav-icon {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" title="Usuarios">👥</a>
            </nav>

            <!-- SALIR AL FONDO -->
            <div style="margin-top: auto; padding-bottom: 2rem; width: 100%; display: flex; justify-content: center;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-icon" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; margin: 0;" title="Salir">🚪</button>
                </form>
            </div>
        </div>

        <!-- CONTENIDO DINÁMICO (Crucial: NO BORRAR) -->
        <main class="content-area">
            {{ $slot }}
        </main>
    </div>
>>>>>>> origin/servidor-maraton-ayer

</body>
</html>
