@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tickets Abiertos</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $openTickets ?? 0 }}</div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Mis Tickets Asignados</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $myTickets ?? 0 }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Equipos en Inventario</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAssets ?? 0 }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="font-bold text-gray-800">Acciones Rápidas</h3>
    </div>
    <div class="p-6">
        <p class="text-gray-600 mb-4">Bienvenido al sistema. Puedes gestionar el Help Desk usando el panel lateral.</p>
        <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Ver Listado de Tickets
        </a>
    </div>
</div>
@endsection
