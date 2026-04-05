@extends('layouts.admin')

@section('content')
<div class="py-2">
    <!-- CABECERA Y MÉTRICAS RÁPIDAS -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <h2 class="text-2xl font-black text-gray-900 italic tracking-tighter uppercase">GESTIóN DE INCIDENTES 🎟️</h2>
            <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest leading-none">Monitoriza y da respuesta a todas las solicitudes de soporte técnico.</p>
        </div>
    </div>

    <!-- TARJETAS DE ESTADO -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2">Abiertos hoy 🎟️</p>
            <p class="text-3xl font-black text-blue-600">{{ $stats['open'] ?? $tickets->where('closed_at', null)->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2">Resueltos ✅</p>
            <p class="text-3xl font-black text-gray-900">{{ $stats['closed'] ?? $tickets->whereNotNull('closed_at')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2">T. Respuesta ⏱️</p>
            <p class="text-3xl font-black text-gray-900">{{ $stats['avg_time'] ?? '--' }}</p>
        </div>
        <div class="bg-[#020617] p-6 rounded-3xl shadow-xl">
            <p class="text-[0.6rem] font-black text-gray-500 uppercase tracking-widest mb-2">Total Histórico</p>
            <p class="text-3xl font-black text-white">{{ $stats['total'] ?? $tickets->count() }}</p>
        </div>
    </div>

    <!-- TABLA DE TICKETS (ESTILO SAAS) -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Ticket / Usuario</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Asunto</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Prioridad</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50/80 transition duration-200">
                        <td class="px-8 py-6">
                            <div class="font-black text-blue-600 text-sm italic tracking-tighter">#{{ $ticket->ticket_number ?? 'TCK-'.$ticket->id }}</div>
                            <div class="text-[0.65rem] font-bold text-gray-400 mt-1 uppercase">{{ $ticket->user->name ?? 'SISTEMA' }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="font-black text-gray-900 text-sm uppercase max-w-xs truncate">{{ $ticket->title }}</div>
                            <div class="text-[0.6rem] text-gray-400 font-bold mt-1 uppercase tracking-widest">{{ $ticket->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-black text-[0.65rem] uppercase tracking-widest" style="color: {{ optional($ticket->priority)->color ?? '#94a3b8' }}">
                                {{ optional($ticket->priority)->name ?? 'BAJA' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[0.6rem] font-black uppercase tracking-widest border"
                                  style="background-color: {{ optional($ticket->status)->color }}10; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                                ● {{ optional($ticket->status)->name ?? 'ABIERTO' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="inline-block bg-[#020617] text-white px-6 py-3 rounded-xl font-black text-[0.65rem] tracking-widest hover:bg-blue-600 transition shadow-lg shadow-black/5 uppercase">
                                GESTIONAR →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <p class="text-gray-300 font-black text-sm uppercase italic tracking-widest">No hay tickets pendientes hoy ✨</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINACIÓN -->
    @if(method_exists($tickets, 'links'))
    <div class="mt-8">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
