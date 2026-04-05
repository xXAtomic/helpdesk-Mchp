<!DOCTYPE html>
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

</body>
</html>
