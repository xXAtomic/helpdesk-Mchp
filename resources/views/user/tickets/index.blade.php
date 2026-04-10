@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA TÁCTICA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Status de Soporte e Incidentes</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Console • Mis Solicitudes
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('user.tickets.create') }}" 
               class="bg-indigo-600 hover:bg-white hover:text-slate-950 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Nuevo Ticket
            </a>
        </div>
    </div>

    <!-- WIDGETS DE ESTADO RÁPIDO -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2rem] border border-white/5 shadow-2xl group hover:border-amber-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic leading-none">Cola de Espera</h4>
            <div class="flex items-end justify-between">
                <p class="text-3xl font-black text-amber-400 tracking-tighter uppercase italic leading-none">
                    {{ $stats['pending'] }} <span class="text-slate-600 text-sm">Tickets</span>
                </p>
                <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500 border border-amber-500/20">
                    <i class="fas fa-hourglass-half text-xs"></i>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2rem] border border-indigo-500/20 shadow-2xl group hover:border-indigo-500 transition-all overflow-hidden relative">
            <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl"></div>
            <h4 class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-4 italic leading-none">En Operación</h4>
            <div class="flex items-end justify-between relative z-10">
                <p class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                    {{ $stats['resolving'] }} <span class="text-indigo-900 text-sm">Activos</span>
                </p>
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-microchip text-xs"></i>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2rem] border border-white/5 shadow-2xl group hover:border-emerald-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic leading-none">Resueltos Hoy</h4>
            <div class="flex items-end justify-between">
                <p class="text-3xl font-black text-emerald-500 tracking-tighter uppercase italic leading-none">
                    {{ $stats['closed_today'] }} <span class="text-slate-600 text-sm">Cerrados</span>
                </p>
                <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500 border border-emerald-500/20">
                    <i class="fas fa-check-circle text-xs"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CONSOLA DE LISTADO -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden mb-10">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950/40 border-b border-white/5">
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Referencia ID</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Asunto del Incidente</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Estado del Nodo</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-right">Sincronización</th>
                            <th class="px-8 py-6"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 italic">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-white/[0.03] transition-all group duration-300">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="text-[0.7rem] font-black text-slate-400 bg-slate-950 px-3 py-1.5 rounded-xl border border-white/5 uppercase tracking-widest shadow-inner group-hover:text-white transition-colors">
                                        #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-black text-white uppercase tracking-tight group-hover:text-indigo-400 transition-colors">{{ $ticket->title }}</div>
                                    <div class="text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.2em] mt-1">{{ optional($ticket->category)->name ?? 'PROTOCOLO GENERAL' }}</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @php
                                        $statusBase = optional($ticket->status)->color ?? '#64748b';
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[0.55rem] font-black uppercase tracking-widest border border-white/5 shadow-lg group-hover:scale-110 transition-transform"
                                          style="background-color: {{ $statusBase }}15; color: {{ $statusBase }}; border-color: {{ $statusBase }}30;">
                                        <span class="w-1.5 h-1.5 rounded-full mr-2 shadow-[0_0_8px_currentColor] animate-pulse" style="background-color: currentColor;"></span>
                                        {{ optional($ticket->status)->name ?? 'ABIERTO' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <span class="text-[0.7rem] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">{{ $ticket->updated_at->format('d M / Y') }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('user.tickets.show', $ticket) }}" class="bg-indigo-600 hover:bg-white hover:text-slate-950 text-white px-6 py-2.5 rounded-xl font-black text-[0.6rem] uppercase tracking-widest transition-all shadow-xl shadow-indigo-500/10 italic inline-block grayscale group-hover:grayscale-0">
                                        REVISAR NODO
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($tickets->hasPages())
                <div class="px-8 py-6 border-t border-white/5 bg-slate-950/20">
                    {{ $tickets->links() }}
                </div>
            @endif
        @else
            <div class="py-32 text-center bg-slate-900/10">
                <div class="mb-8 inline-flex items-center justify-center w-24 h-24 rounded-[2rem] bg-slate-950 text-slate-800 border-2 border-dashed border-white/5 shadow-inner">
                    <i class="fas fa-inbox text-4xl opacity-20"></i>
                </div>
                <h3 class="text-xl font-black text-white uppercase italic tracking-tighter">Sin Incidentes Activos</h3>
                <p class="text-[0.7rem] font-black text-slate-600 uppercase tracking-widest mt-4 italic max-w-sm mx-auto leading-relaxed">Todos los protocolos están operando dentro de los parámetros normales. Tu flujo de trabajo está libre de reportes pendientes.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 20px; }
    
    .pagination { @apply flex gap-2; }
    .page-item { @apply rounded-xl overflow-hidden border border-white/5; }
    .page-link { @apply bg-slate-950/50 text-slate-500 border-none px-5 py-3 font-black italic uppercase tracking-widest text-[0.65rem] transition-all; }
    .page-item.active .page-link { @apply bg-indigo-600 text-white shadow-lg shadow-indigo-500/20; }
    .page-link:hover { @apply bg-slate-800 text-white; }
</style>
@endsection
