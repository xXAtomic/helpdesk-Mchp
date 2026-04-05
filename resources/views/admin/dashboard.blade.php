@extends('layouts.app')

@section('content')

    <div class="py-6">
        <!-- 🏁 TARJETAS DE MÉTRICAS (GRID 4 COLUMNAS) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- CARD: TOTAL TICKETS -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                <div class="text-[0.65rem] font-black text-gray-400 uppercase tracking-wider mb-4">Tickets Totales</div>
                <div class="flex items-baseline gap-2">
                    <div class="text-3xl font-black text-gray-900">{{ $stats['total_tickets'] }}</div>
                    <div class="text-xs font-bold text-green-500">Global</div>
                </div>
            </div>

            <!-- CARD: TICKETS PENDIENTES -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                <div class="text-[0.65rem] font-black text-gray-400 uppercase tracking-wider mb-4">Tickets Abiertos</div>
                <div class="text-3xl font-black text-gray-900">{{ $stats['open_tickets'] }}</div>
            </div>

            <!-- CARD: EQUIPOS -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                <div class="text-[0.65rem] font-black text-gray-400 uppercase tracking-wider mb-4">Equipos Registrados</div>
                <div class="text-3xl font-black text-gray-900">{{ $stats['total_equipment'] }}</div>
            </div>

            <!-- CARD: USUARIOS -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition hover:shadow-md">
                <div class="text-[0.65rem] font-black text-gray-400 uppercase tracking-wider mb-4">Usuarios Activos</div>
                <div class="text-3xl font-black text-gray-900">{{ $stats['total_users'] }}</div>
            </div>
        </div>

        <!-- 🏢 SECCIÓN INFERIOR: TABLA DE ACTIVIDAD -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LISTADO DE TICKETS RECIENTES -->
            <div class="lg:col-span-2">
                <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                    Actividad de Tickets Reciente 📋
                </h3>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full">
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentTickets as $ticket)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-6">
                                    <div class="font-black text-gray-900 text-base">{{ $ticket->title }}</div>
                                    <div class="text-xs font-medium text-gray-400 mt-1">
                                        Por: {{ $ticket->user->name ?? 'Sistema' }} • {{ $ticket->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-[0.65rem] font-black text-blue-600 bg-blue-50 px-4 py-2 rounded-lg hover:bg-blue-600 hover:text-white transition uppercase">
                                        Detalles →
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="px-8 py-12 text-center text-gray-400 font-medium italic">
                                    No hay actividad de tickets reciente. ✨
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BARRA DE ACCIONES RÁPIDAS -->
            <div>
                <h3 class="text-lg font-black text-gray-900 mb-6">Acciones Rápidas ⚡</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.tickets.index') }}" class="w-full bg-blue-600 text-white px-6 py-4 rounded-xl font-black text-sm text-center shadow-lg hover:shadow-blue-200 transition">
                        🎟️ GESTIONAR TICKETS
                    </a>
                    <a href="{{ route('admin.inventory.index') }}" class="w-full bg-white border-2 border-gray-100 text-gray-900 px-6 py-4 rounded-xl font-black text-sm text-center hover:bg-gray-50 transition">
                        🖥️ VER INVENTARIO
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="w-full bg-white border-2 border-gray-100 text-gray-900 px-6 py-4 rounded-xl font-black text-sm text-center hover:bg-gray-50 transition">
                        👥 GESTIONAR USUARIOS
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
