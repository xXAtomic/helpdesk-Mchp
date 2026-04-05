<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard General</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Botón Mis Tickets -->
                <a href="{{ route('user.tickets.index') }}" class="p-6 bg-blue-600 text-white rounded-2xl shadow-lg hover:scale-105 transition-all flex flex-col items-center">
                    <span class="text-4xl">🎫</span>
                    <span class="mt-2 font-bold uppercase">Mis Tickets</span>
                </a>
                <!-- Botón Inventario -->
                <a href="{{ route('inventory.index') }}" class="p-6 bg-emerald-600 text-white rounded-2xl shadow-lg hover:scale-105 transition-all flex flex-col items-center">
                    <span class="text-4xl">📦</span>
                    <span class="mt-2 font-bold uppercase">Inventario</span>
                </a>
                <!-- Botón Base de Conocimiento -->
                <a href="{{ route('knowledge.index') }}" class="p-6 bg-amber-500 text-white rounded-2xl shadow-lg hover:scale-105 transition-all flex flex-col items-center">
                    <span class="text-4xl">📚</span>
                    <span class="mt-2 font-bold uppercase">Conocimientos</span>
                </a>
                <!-- Botón Admin -->
                <a href="{{ route('admin.dashboard') }}" class="p-6 bg-purple-600 text-white rounded-2xl shadow-lg hover:scale-105 transition-all flex flex-col items-center">
                    <span class="text-4xl">⚙️</span>
                    <span class="mt-2 font-bold uppercase">Panel Admin</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
