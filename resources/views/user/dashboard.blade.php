@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Panel de Control</h1>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mt-1">Misión Chilena del Pacífico • Gestión de Recursos TI</p>
        </div>
        <div class="mt-6 md:mt-0 flex gap-4">
            <span class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest italic">
                SISTEMA GRAVITY v2.0
            </span>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS (ESTILO MY-TICKETS) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic">TICKETS ACTIVOS</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase">{{ auth()->user()->tickets()->where('status_id', '!=', 3)->count() }} SOLICITUDES</p>
        </div>
        <div class="bg-indigo-50 p-8 rounded-xl border border-indigo-100">
            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">RESUELTOS HOY</p>
            <p class="text-3xl font-black text-indigo-900 tracking-tighter italic uppercase font-black uppercase tracking-widest">{{ auth()->user()->tickets()->where('status_id', 3)->where('updated_at', '>=', now()->startOfDay())->count() }} CERRADOS</p>
        </div>
        <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic">EQUIPOS ASIGNADOS</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase font-black uppercase tracking-widest">{{ auth()->user()->inventories() ? auth()->user()->inventories()->count() : 0 }} DISPOSITIVOS</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- ACCIONES PRINCIPALES (TARJETAS GRANDES LIMPIAS) -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- CARD: NUEVO TICKET -->
            <div class="group bg-white p-12 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-[3] transition-transform duration-700 opacity-50"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-8">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight italic mb-3">Nueva Solicitud</h3>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-widest leading-relaxed mb-12">Reporta problemas técnicos o solicita asistencia inmediata al equipo TI de la organización.</p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest hover:bg-indigo-600 transition-colors shadow-lg">
                        Crear Ticket Ahora →
                    </a>
                </div>
            </div>

            <!-- TABLA DE ACTIVIDAD RECIENTE (ESTILO MY-TICKETS) -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-[0.65rem] font-black text-gray-500 uppercase tracking-widest">Últimos Registros</h3>
                    <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-bold text-indigo-600 hover:text-indigo-900 uppercase italic">Ver todo el historial</a>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @forelse(auth()->user()->tickets()->latest()->take(3)->get() as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-900">{{ $ticket->title }}</p>
                                    <p class="text-[0.65rem] font-medium text-slate-400 uppercase tracking-widest">{{ $ticket->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="inline-flex px-3 py-1 rounded-full text-[0.55rem] font-black uppercase tracking-tight"
                                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }};">
                                        {{ optional($ticket->status)->name ?? 'PROCESANDO' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-8 py-10 text-center text-[0.65rem] font-bold text-slate-300 uppercase tracking-widest">No hay actividad reciente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- COLUMNA LATERAL: DOCUMENTACIÓN -->
        <div class="space-y-8">
            <div class="bg-slate-950 p-10 rounded-xl shadow-2xl overflow-hidden relative">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl border border-white/10 mb-8">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-3">Guías Técnicas</h3>
                    <p class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-10">Documentación oficial para autogestión de equipos y software operativo.</p>
                    <a href="{{ route('knowledge.index') }}" class="inline-block w-full bg-white text-slate-950 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-400 transition-colors">
                        Explorar Manuales
                    </a>
                </div>
            </div>

            <!-- MI EQUIPO MINI -->
            <div class="bg-gray-50 p-8 rounded-xl border border-gray-100">
                <h5 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-8 border-b border-gray-200 pb-4 italic italic uppercase tracking-widest">Equipamiento Asignado</h5>
                <div class="space-y-6">
                    @forelse(auth()->user()->inventories()->take(2)->get() as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center text-lg">💡</div>
                            <div>
                                <p class="text-[0.65rem] font-bold text-slate-900 uppercase tracking-tight">{{ $item->model }}</p>
                                <p class="text-[0.55rem] font-medium text-slate-400 uppercase italic">{{ $item->serial_number }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[0.6rem] font-bold text-slate-300 uppercase italic text-center py-4">No hay equipos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
