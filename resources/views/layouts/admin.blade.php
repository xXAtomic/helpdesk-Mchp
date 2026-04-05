<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TI Help Desk | Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center font-bold text-xl tracking-widest border-b border-gray-800">
            GLPI<span class="text-blue-500">TICK</span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded bg-gray-800 hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('admin.tickets.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Tickets</a>
<<<<<<< HEAD
            <a href="{{ route('admin.assets.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Inventario (Equipos)</a>
            <a href="{{ route('admin.knowledge.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Base de Conocimientos</a>
=======
            <a href="#" class="block px-4 py-2 text-gray-400 hover:bg-gray-700 pointer-events-none">Inventario (Proximamente)</a>
            <a href="#" class="block px-4 py-2 text-gray-400 hover:bg-gray-700 pointer-events-none">Base de Conocimientos</a>
>>>>>>> origin/servidor-maraton-ayer
        </nav>
        <div class="p-4 border-t border-gray-800">
            <p class="text-sm">Logueado como:</p>
            <p class="font-bold truncate">{{ auth()->user()->name ?? 'Admin Dummy' }}</p>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full text-left text-sm text-red-500 hover:text-red-400 py-2">Salida</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="h-16 bg-white shadow flex items-center px-6 justify-between">
            <h1 class="text-xl font-semibold text-gray-800">Panel Administrativo</h1>
            <div>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">Técnico/Admin</span>
            </div>
        </header>

        <div class="p-6">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
