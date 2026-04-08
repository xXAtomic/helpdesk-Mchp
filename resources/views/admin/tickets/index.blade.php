@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA PRO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Panel Administrativo de Tickets</h1>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mt-1">Gestión Global de Incidentes de la Misión</p>
        </div>
        <div class="mt-6 md:mt-0 flex gap-4">
            <a href="{{ route('admin.tickets.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-slate-900 border border-transparent rounded-lg font-bold text-[0.7rem] text-white uppercase tracking-widest hover:bg-slate-800 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Crear Ticket
            </a>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS ADMIN -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Total Pendientes</p>
            <p class="text-2xl font-bold text-gray-900 tracking-tighter italic">{{ $stats['open'] ?? $tickets->count() }}</p>
        </div>
        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Cerrados</p>
            <p class="text-2xl font-bold text-indigo-900 tracking-tighter italic">{{ $stats['closed'] ?? 0 }}</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
            <p class="text-[0.6rem] font-black text-blue-400 uppercase tracking-widest mb-1 italic">Tiempo Promedio</p>
            <p class="text-2xl font-bold text-blue-900 tracking-tighter italic">{{ $stats['avg_time'] ?? '2.5h' }}</p>
        </div>
        <div class="bg-slate-50 p-6 rounded-xl border border-slate-200">
            <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Total Histórico</p>
            <p class="text-2xl font-bold text-slate-900 tracking-tighter italic">{{ $stats['total'] ?? $tickets->count() }}</p>
        </div>
    </div>

    <!-- LISTADO INDUSTRIAL PRO -->
    <div class="bg-white shadow-sm border border-gray-100 rounded-xl overflow-hidden">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-[0.65rem] font-black text-gray-400 uppercase tracking-widest italic">Referencia</th>
                            <th class="px-6 py-4 text-left text-[0.65rem] font-black text-gray-400 uppercase tracking-widest italic">Asunto / Solicitante</th>
                            <th class="px-6 py-4 text-center text-[0.65rem] font-black text-gray-400 uppercase tracking-widest italic">Estado</th>
                            <th class="px-6 py-4 text-left text-[0.65rem] font-black text-gray-400 uppercase tracking-widest italic">Vencimiento (SLA)</th>
                            <th class="px-6 py-4 text-right text-[0.65rem] font-black text-gray-400 uppercase tracking-widest italic">Actualizado</th>
                            <th class="px-6 py-4 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-[0.7rem] font-bold text-indigo-400 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100">
                                        #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-900 mb-0.5 uppercase tracking-tight italic">{{ $ticket->title }}</div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[0.6rem] font-black text-slate-400 uppercase">{{ $ticket->user->name ?? 'Invitado' }}</span>
                                        <span class="text-slate-300">•</span>
                                        <span class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest">{{ optional($ticket->category)->name ?? 'GENERAL' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[0.6rem] font-black uppercase tracking-tight italic border shadow-sm"
                                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                                        ● {{ $ticket->status->name ?? 'ABIERTO' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($ticket->due_at)
                                        @php $remaining = $ticket->sla_remaining; @endphp
                                        <div class="flex flex-col">
                                            <span class="text-[0.65rem] font-black {{ $remaining == 'VENCIDO' ? 'text-rose-600 animate-pulse' : (Str::contains($remaining, 'horas') && !Str::contains($remaining, 'día') ? 'text-amber-600' : 'text-slate-900') }} uppercase italic">
                                                {{ $remaining }}
                                            </span>
                                            <span class="text-[0.5rem] font-bold text-slate-400 uppercase tracking-tighter">
                                                {{ $ticket->due_at->format('d/m H:i') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-[0.6rem] font-bold text-slate-300">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-[0.7rem] font-medium text-slate-400 uppercase tracking-wide">{{ $ticket->updated_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 font-black text-[0.65rem] uppercase tracking-widest border-b-2 border-transparent hover:border-indigo-600 transition-all italic">
                                            Gestionar Caso
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(method_exists($tickets, 'links'))
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $tickets->links() }}
            </div>
            @endif
        @else
            <div class="py-20 text-center">
                <div class="mb-4 inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 uppercase italic tracking-widest">No hay tickets pendientes</h3>
                <p class="text-[0.7rem] text-slate-500 max-w-xs mx-auto mt-2 uppercase font-medium">Excelente trabajo. La bandeja de entrada está vacía.</p>
            </div>
        @endif
    </div>
</div>
@endsection
