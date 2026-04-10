@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA OPERATIVA PREMIUM -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Plataforma Operativa • Gestión de Recursos TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Central • Nodo de Usuario: {{ auth()->user()->name }}
            </p>
        </div>
        <div class="md:text-right">
            <span class="inline-block bg-slate-900 border border-white/5 px-6 py-3 rounded-2xl shadow-xl text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic leading-none">
                Gravity v2.0 • {{ now()->format('Y') }}
            </span>
        </div>
    </div>

    <!-- WIDGETS DE ESTADO (GLASSMORPHISM) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl group hover:border-indigo-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic leading-none">Tickets en Curso</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $ticketsCount ?? 0 }} <span class="text-slate-700 text-sm">Solicitudes</span>
            </p>
            <div class="mt-6 w-full h-1 bg-slate-950 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full shadow-[0_0_10px_#6366f1]" style="width: 70%"></div>
            </div>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl group hover:border-emerald-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic leading-none">Resueltos Hoy</h4>
            <p class="text-3xl font-black text-emerald-500 tracking-tighter italic uppercase leading-none">
                {{ $resolvedTodayCount ?? 0 }} <span class="text-slate-700 text-sm underline decoration-emerald-500/30">Cerrados</span>
            </p>
            <div class="mt-6 w-full h-1 bg-slate-950 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full shadow-[0_0_10px_#10b981]" style="width: 100%"></div>
            </div>
        </div>

        <button onclick="document.getElementById('mi-equipamiento').scrollIntoView({behavior: 'smooth'})" 
                class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl group hover:bg-slate-900 hover:border-white/20 transition-all text-left relative overflow-hidden">
            <div class="absolute -right-5 -top-5 w-20 h-20 bg-indigo-600/5 rounded-full blur-2xl group-hover:bg-indigo-500/10 transition-all"></div>
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic leading-none">Equipos bajo Cargo</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic uppercase leading-none flex items-center gap-3">
                {{ $assignedAssets->count() }} <span class="text-slate-700 text-sm">Hardware</span>
                <i class="fas fa-chevron-down text-indigo-500 text-xs animate-bounce"></i>
            </p>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-16">
        
        <!-- COLUMNA PRINCIPAL DE ACCIONES (2/3) -->
        <div class="lg:col-span-2 space-y-10">
            <!-- CARD: NUEVO TICKET (GLASSMORPHISM) -->
            <div class="group bg-slate-900/40 backdrop-blur-xl p-12 rounded-[3rem] border border-white/5 shadow-3xl hover:border-indigo-500/30 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-slate-950 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/5 shadow-2xl mb-10 group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-700">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-3xl font-black text-white uppercase tracking-tighter italic mb-4 leading-none">Nueva Solicitud</h3>
                    <p class="text-[0.7rem] font-black text-slate-500 uppercase tracking-widest leading-relaxed mb-12 italic">Reporta anomalías técnicas en tu equipo o solicita asistencia inmediata.</p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-block bg-white text-slate-950 px-12 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-2xl italic">
                        REGISTRAR INCIDENTE <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
            </div>

            <!-- TABLA DE ACTIVIDAD RECIENTE -->
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
                <div class="px-8 py-6 bg-slate-950/40 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Actividad en Tiempo Real</h3>
                    <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-black text-indigo-400 hover:text-white uppercase italic tracking-widest">Ver Todo →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-white/5 italic">
                            @forelse($latestTickets as $ticket)
                                <tr class="hover:bg-white/[0.03] transition-all group">
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-black text-white uppercase tracking-tight group-hover:text-indigo-400 transition-colors">{{ $ticket->title }}</p>
                                        <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest mt-1">{{ $ticket->created_at->diffForHumans() }}</p>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @php
                                            $statusColor = optional($ticket->status)->color ?? '#64748b';
                                        @endphp
                                        <span class="inline-flex px-4 py-1.5 rounded-xl text-[0.55rem] font-black uppercase tracking-widest border border-white/5"
                                              style="background-color: <?= $statusColor ?>15; color: <?= $statusColor ?>; border-color: <?= $statusColor ?>30;">
                                            {{ optional($ticket->status)->name ?? 'PROCESANDO' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-8 py-16 text-center text-[0.6rem] font-black text-slate-800 uppercase tracking-[0.4em] italic">Sin actividad registrada en la terminal</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- COLUMNA LATERAL: BIBLIOTECA Y COMPLIANCE (1/3) -->
        <div class="space-y-10">
            <!-- CARD BIBLIOTECA RÁPIDA -->
            <div class="bg-slate-950 p-10 rounded-[3rem] shadow-3xl border border-white/5 relative group overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/10 mb-10 group-hover:scale-110 group-hover:rotate-6 transition-all">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic mb-4 leading-none">Protocolos TI</h3>
                    <p class="text-[0.65rem] font-black text-slate-600 uppercase tracking-widest mb-10 italic leading-relaxed">Guías rápidas y manuales operativos para autogestión de recursos institucionales.</p>
                    <a href="{{ route('knowledge.index') }}" class="block w-full bg-white text-slate-950 py-5 rounded-2xl font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-600 hover:text-white transition-all italic shadow-2xl">
                        EXPLORAR MANUALES
                    </a>
                </div>
            </div>

            <!-- CARD COMPLIANCE STATUS -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-2xl relative group">
                <div class="flex items-center gap-4 mb-10 border-b border-white/5 pb-6">
                    <div class="w-2 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                    <h5 class="text-[0.65rem] font-black text-white uppercase italic tracking-widest">Estado de Identidad</h5>
                </div>
                <div class="space-y-6">
                    <a href="{{ route('user.compliance.index') }}" class="flex items-center justify-between p-6 bg-slate-950/60 rounded-[1.5rem] border border-white/5 hover:border-emerald-500/30 transition-all group/item">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-2xl border border-white/5 shadow-xl group-hover/item:scale-110 transition-transform">📄</div>
                            <div>
                                <p class="text-[0.7rem] font-black text-white uppercase italic leading-none">Compromisos</p>
                                <p class="text-[0.55rem] font-black {{ $pendingComplianceCount > 0 ? 'text-amber-500' : 'text-emerald-500' }} uppercase mt-1 italic tracking-widest">
                                    {{ $pendingComplianceCount > 0 ? $pendingComplianceCount . ' Pendientes' : 'Estatus: Al día' }}
                                </p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-800 text-[10px] group-hover/item:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                
                @if($pendingComplianceCount > 0)
                    <div class="mt-10">
                        <a href="{{ route('user.compliance.index') }}" class="block w-full text-center bg-rose-600 text-white py-5 rounded-2xl font-black text-[0.65rem] uppercase tracking-widest hover:bg-rose-500 transition-all shadow-xl italic animate-pulse">
                            FIRMAR PENDIENTES
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SECCIÓN: INVENTARIO DE HARDWARE ASIGNADO ✨ -->
    <div id="mi-equipamiento" class="space-y-10 pb-20 scroll-mt-20">
        <div class="flex items-center justify-between border-b border-white/5 pb-8">
            <div class="flex items-center gap-5">
                <div class="w-2 h-10 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></div>
                <div>
                    <h3 class="text-2xl font-black text-white uppercase italic tracking-tighter leading-none">Inventario de Responsabilidades</h3>
                    <p class="text-[0.65rem] font-black text-slate-600 uppercase tracking-[0.3em] mt-2 italic">Activos TI vinculados a su identidad digital</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($assignedAssets as $item)
                <div class="group bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-10">
                            <div class="w-16 h-16 bg-slate-950 rounded-2xl flex items-center justify-center text-white text-3xl border border-white/5 shadow-2xl group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-700">
                                @if($item->type == 'Laptop') <i class="fas fa-laptop"></i>
                                @elseif($item->type == 'Desktop') <i class="fas fa-desktop"></i>
                                @elseif($item->type == 'Monitor') <i class="fas fa-tv"></i>
                                @elseif($item->type == 'Impresora') <i class="fas fa-print"></i>
                                @elseif($item->type == 'Smartphone') <i class="fas fa-mobile-alt"></i>
                                @else <i class="fas fa-box"></i> @endif
                            </div>
                            <div class="text-right">
                                <span class="text-[0.65rem] font-black text-white bg-slate-950 px-3 py-1.5 rounded-xl border border-white/5 uppercase italic shadow-inner group-hover:border-indigo-500/50 transition-colors">
                                    {{ $item->asset_tag }}
                                </span>
                                <div class="mt-3 flex items-center justify-end gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->status == 'Operativo' ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                    <span class="text-[0.55rem] font-black text-slate-500 uppercase italic tracking-tighter">{{ $item->status }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-[0.65rem] font-black text-indigo-400 uppercase italic tracking-widest group-hover:text-white transition-colors">{{ $item->brand }}</h4>
                            <p class="text-xl font-black text-white uppercase italic leading-none truncate tracking-tighter">{{ $item->model }}</p>
                            <p class="text-[0.55rem] font-black text-slate-700 uppercase italic tracking-[0.2em] mt-4 pt-4 border-t border-white/5">{{ $item->entity ?? strtoupper(config('app.institution')) }}</p>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <span class="text-[0.55rem] font-mono font-black text-slate-600 uppercase tracking-tighter italic">S/N: {{ $item->serial_number }}</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-950 flex items-center justify-center text-slate-700 group-hover:text-indigo-400 border border-white/5 shadow-inner transition-all">
                                <i class="fas fa-microchip text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 bg-slate-900/10 rounded-[3rem] border-2 border-dashed border-white/5 text-center relative group overflow-hidden">
                     <i class="fas fa-box-open text-slate-900 text-6xl mb-6 opacity-20"></i>
                     <h3 class="text-white font-black text-xl uppercase italic tracking-tighter">Inventario Personal Vacío</h3>
                     <p class="text-[0.7rem] font-black text-slate-600 uppercase tracking-widest mt-4 italic max-w-sm mx-auto leading-relaxed">No se han detectado activos vinculados a su identidad. Contacte al nodo TI si esto es un error de sincronización.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- FOOTER DE PROTOCOLO -->
<div class="pb-12 text-center">
    <p class="text-[0.55rem] font-black text-slate-800 uppercase tracking-[1em] italic">
        Atomic Core • Global Identity Protocol • Gravity Dashboard
    </p>
</div>
@endsection
