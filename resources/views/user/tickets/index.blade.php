@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Mis Solicitudes</h1>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mt-1">Gestión y seguimiento de incidentes técnicos</p>
        </div>
        <div class="mt-6 md:mt-0">
            <a href="{{ route('user.tickets.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-[0.7rem] text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nuevo Ticket
            </a>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pendientes</p>
            <p class="text-2xl font-bold text-gray-900 tracking-tighter uppercase italic">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1">En Resolución</p>
            <p class="text-2xl font-bold text-indigo-900 tracking-tighter uppercase italic">{{ $stats['resolving'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-emerald-500 uppercase tracking-widest mb-1">Cerrados hoy</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tighter uppercase italic">{{ $stats['closed_today'] }}</p>
        </div>
    </div>

    <!-- LISTADO INDUSTRIAL -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Referencia</th>
                            <th class="px-6 py-4 text-left text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Asunto / Categoría</th>
                            <th class="px-6 py-4 text-center text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                            <th class="px-6 py-4 text-right text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Actualizado</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-[0.7rem] font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 mb-0.5">{{ $ticket->title }}</div>
                                    <div class="text-[0.65rem] font-medium text-gray-400 uppercase tracking-tight">{{ optional($ticket->category)->name ?? 'GENERAL' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-tight"
                                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border: 1px solid {{ optional($ticket->status)->color }}30;">
                                        {{ optional($ticket->status)->name ?? 'ABIERTO' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-[0.7rem] font-medium text-gray-500 uppercase">{{ $ticket->updated_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('user.tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-[0.65rem] uppercase tracking-widest">Ver Detalles</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="py-20 text-center">
                <div class="mb-4 inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">No hay tickets activos</h3>
                <p class="text-sm text-gray-500 max-w-xs mx-auto mt-2">Todo está funcionando correctamente. Si necesitas ayuda, pulsa el botón de Nuevo Ticket.</p>
            </div>
        @endif
    </div>
</div>
@endsection
