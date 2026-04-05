@extends('layouts.admin') <!-- Usamos admin layout por ahora pero ajustaremos menú -->

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">📊 Dashboard de Gestión TI</h2>
        <span class="px-4 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold border border-indigo-200">
            Vista de Jefe
        </span>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Abiertos -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500 uppercase">Tickets Abiertos</p>
            <h3 class="text-3xl font-bold text-blue-600 mt-1">{{ $openTickets }}</h3>
        </div>

        <!-- Cerrados -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500 uppercase">Tickets Cerrados</p>
            <h3 class="text-3xl font-bold text-green-600 mt-1">{{ $closedTickets }}</h3>
        </div>

        <!-- En Proceso -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500 uppercase">En Proceso</p>
            <h3 class="text-3xl font-bold text-purple-600 mt-1">{{ $inProcessTickets }}</h3>
        </div>

        <!-- Equipos -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500 uppercase">Equipos Registrados</p>
            <h3 class="text-3xl font-bold text-orange-600 mt-1">{{ $totalAssets }}</h3>
        </div>

        <!-- Tiempo Respuesta -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-indigo-500 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500 uppercase">Tiempo Resol.</p>
            <h3 class="text-3xl font-bold text-indigo-600 mt-1">{{ $avgResponseTime }}</h3>
        </div>
    </div>

    <!-- Metrics and Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tickets por Categoría -->
        <div class="bg-white p-8 rounded-2xl shadow-sm">
            <h4 class="text-lg font-bold text-gray-800 mb-6">Distribución por Categoría</h4>
            <div class="space-y-4">
                @foreach($ticketsByCategory as $cat)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">{{ $cat->name }}</span>
                        <span class="text-gray-500">{{ $cat->total }}</span>
                    </div>
                    @php 
                        $totalAll = $ticketsByCategory->sum('total');
                        $percentage = $totalAll > 0 ? ($cat->total / $totalAll) * 100 : 0;
                    @endphp
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-2xl shadow-lg text-white">
            <h4 class="text-xl font-bold mb-4">Resumen Semanal</h4>
            <p class="opacity-90 leading-relaxed mb-6">
                El inventario actual cuenta con **{{ $totalAssets }}** activos operativos.
                El tiempo promedio de respuesta se mantiene en **{{ $avgResponseTime }}**, cumpliendo con los estándares de calidad de TI.
            </p>
            <div class="bg-white/10 p-4 rounded-xl backdrop-blur-md">
                <p class="text-xs font-semibold uppercase tracking-wider opacity-75">Nota de Privacidad</p>
                <p class="text-sm">Esta vista solo muestra métricas generales agregadas. No se exponen datos personales ni descripciones sensibles.</p>
            </div>
        </div>
    </div>
</div>
@endsection
