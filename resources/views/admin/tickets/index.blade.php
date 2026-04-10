@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA TÁCTICA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Gestión Global de Incidentes</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Helpdesk Ops • Terminal Administrativa
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.tickets.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Crear Ticket
            </a>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS (GLASS CARDS) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Pendientes</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $stats['open'] ?? '...' }} <span class="text-indigo-600">Casos</span></p>
            <div class="absolute -right-2 -bottom-2 opacity-5 text-4xl text-white group-hover:scale-110 transition-transform"><i class="fas fa-clock"></i></div>
        </div>

        <div class="bg-emerald-500/5 backdrop-blur-xl border border-emerald-500/10 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group hover:border-emerald-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-emerald-400 uppercase tracking-widest mb-1 italic">Cerrados</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $stats['closed'] ?? '...' }} <span class="text-emerald-900">Final.</span></p>
            <div class="absolute -right-2 -bottom-2 opacity-5 text-4xl text-emerald-400 group-hover:scale-110 transition-transform"><i class="fas fa-check-double"></i></div>
        </div>

        <div class="bg-blue-500/5 backdrop-blur-xl border border-blue-500/10 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group">
            <h4 class="text-[0.6rem] font-black text-blue-400 uppercase tracking-widest mb-1 italic">SLA Promedio</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $stats['avg_time'] ?? '2.4' }} <span class="text-blue-900">Hrs</span></p>
            <div class="absolute -right-2 -bottom-2 opacity-5 text-4xl text-blue-400 group-hover:scale-110 transition-transform"><i class="fas fa-bolt"></i></div>
        </div>

        <div class="bg-slate-950 border border-white/5 p-6 rounded-[2rem] shadow-2xl relative overflow-hidden group">
            <h4 class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Protocolos Totales</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $stats['total'] ?? $tickets->total() }} <span class="text-slate-800 text-sm">Hist.</span></p>
            <div class="absolute -right-2 -bottom-2 opacity-5 text-4xl text-white group-hover:scale-110 transition-transform"><i class="fas fa-database"></i></div>
        </div>
    </div>

    <!-- LISTADO INDUSTRIAL PREMIUM -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950/40 border-b border-white/5">
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Referencia</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Asunto / Solicitante</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Estado Operativo</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Vencimiento (SLA)</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-right">Actualizado</th>
                            <th class="px-8 py-6"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 italic">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-white/[0.03] transition-all group duration-300">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="text-[0.7rem] font-black text-indigo-400 bg-slate-900 px-3 py-1.5 rounded-xl border border-white/5 italic uppercase shadow-xl group-hover:border-indigo-500/50 transition-all">
                                        #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-white mb-1 uppercase tracking-tight group-hover:text-indigo-400 transition-colors">{{ $ticket->title }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[0.6rem] font-black text-slate-500 uppercase">{{ $ticket->user->name ?? 'Sistema' }}</span>
                                        <span class="w-1 h-1 bg-slate-800 rounded-full"></span>
                                        <span class="text-[0.6rem] font-black text-indigo-500 uppercase tracking-widest">{{ optional($ticket->category)->name ?? 'GENERAL' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[0.55rem] font-black uppercase tracking-widest italic border shadow-lg"
                                          style="background-color: <?= optional($ticket->status)->color ?>15; color: <?= optional($ticket->status)->color ?>; border-color: <?= optional($ticket->status)->color ?>30;">
                                        ● {{ $ticket->status->name ?? 'ABIERTO' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    @if($ticket->due_at)
                                        @php $remaining = $ticket->sla_remaining; @endphp
                                        <div class="flex flex-col">
                                            <span class="text-[0.65rem] font-black {{ $remaining == 'VENCIDO' ? 'text-rose-600 animate-pulse' : (Str::contains($remaining, 'horas') && !Str::contains($remaining, 'día') ? 'text-amber-500' : 'text-slate-300') }} uppercase italic leading-none">
                                                {{ $remaining }}
                                            </span>
                                            <span class="text-[0.5rem] font-black text-slate-600 uppercase tracking-tighter mt-1">
                                                Límite: {{ $ticket->due_at->format('d/m H:i') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-[0.6rem] font-black text-slate-800 tracking-[0.2em]">PROTOCOL_FREE</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <span class="text-[0.65rem] font-black text-slate-500 uppercase tracking-widest">{{ $ticket->updated_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="opacity-0 group-hover:opacity-100 transition-all">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" 
                                           class="inline-flex items-center gap-2 bg-slate-900 text-indigo-400 px-5 py-2.5 rounded-xl border border-white/5 hover:bg-indigo-600 hover:text-white transition-all font-black text-[0.6rem] uppercase tracking-widest italic shadow-2xl">
                                            GESTIONAR <i class="fas fa-chevron-right text-[8px]"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="px-8 py-6 border-t border-white/5 bg-slate-950/40">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="py-32 text-center">
                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-[2rem] bg-slate-950 text-slate-800 border border-white/5">
                    <i class="fas fa-check text-2xl opacity-20"></i>
                </div>
                <h3 class="text-sm font-black text-white uppercase italic tracking-[0.3em]">Protocolo de Paz</h3>
                <p class="text-[0.6rem] text-slate-600 max-w-xs mx-auto mt-3 uppercase font-black leading-relaxed italic tracking-widest">No hay tickets pendientes en la terminal operativa.</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Estilización Paginación Table Dark */
    .pagination { @apply flex gap-3 justify-center; }
    .page-item { @apply rounded-xl overflow-hidden border border-white/5; }
    .page-link { @apply bg-slate-950 text-slate-600 border-none px-6 py-3 font-black italic uppercase tracking-widest text-[0.6rem] transition-all; }
    .page-item.active .page-link { @apply bg-indigo-600 text-white shadow-lg; }
    .page-item:not(.active) .page-link:hover { @apply bg-slate-900 text-white; }
</style>
@endsection
