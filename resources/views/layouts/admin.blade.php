<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TI Help Desk | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Inter', sans-serif; text-transform: uppercase; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-72 bg-[#020617] text-white flex flex-col shadow-2xl relative overflow-hidden">
        <div class="h-24 flex items-center justify-center font-black text-2xl tracking-tighter italic border-b border-white/5">
            MCHP<span class="text-blue-500 ml-1">SOPORTE</span>
        </div>
        <nav class="flex-1 px-6 py-10 space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-blue-600 text-white font-black text-xs shadow-lg shadow-blue-500/20 tracking-widest">
                🏠 DASHBOARD
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 hover:text-white hover:bg-white/5 font-black text-xs transition tracking-widest">
                🎟️ GESTIÓN TICKETS
            </a>
            <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 hover:text-white hover:bg-white/5 font-black text-xs transition tracking-widest">
                🖥️ INVENTARIO (EQUIPOS)
            </a>
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 hover:text-white hover:bg-white/5 font-black text-xs transition tracking-widest">
                👥 USUARIOS
            </a>
        </nav>
        <div class="p-8 border-t border-white/5 bg-white/2">
            <p class="text-[0.6rem] font-black text-gray-500 mb-1 tracking-widest">SESIóN INICIADA</p>
            <p class="font-black text-sm truncate mb-4 italic">{{ auth()->user()->name ?? 'Administrador' }}</p>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full bg-red-500/10 text-red-500 border border-red-500/20 py-3 rounded-xl font-black text-[0.65rem] hover:bg-red-500 hover:text-white transition tracking-widest">
                    CERRAR SESIóN 🚀
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="h-20 bg-white border-b border-gray-100 flex items-center px-10 justify-between">
            <h1 class="text-sm font-black text-gray-400 tracking-widest uppercase">Panel de Control General</h1>
            <div class="flex items-center gap-4">
                <span class="bg-blue-50 text-blue-600 text-[0.6rem] font-black px-3 py-1.5 rounded-lg border border-blue-100 tracking-widest">RANGO: TI ADMINISTRADOR</span>
            </div>
        </header>

        <div class="p-10">
            @if (session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-600 px-6 py-4 rounded-2xl font-black text-xs tracking-widest" role="alert">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
