@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- CABECERA DE BIENVENIDA MINIMALISTA -->
    <div class="mb-16 border-b border-gray-100 pb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none italic uppercase">Panel de Control</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mt-3">Misión Chilena del Pacífico • Gestión de Recursos TI</p>
        </div>
        <div class="text-right">
            <span class="text-[0.6rem] font-black text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg uppercase tracking-widest italic">Sesión de: {{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- COLUMNA PRINCIPAL DE ACCIONES -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- CARD: NUEVO TICKET -->
            <div class="group bg-white p-10 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-indigo-50 rounded-full group-hover:scale-[3] transition-transform duration-700 opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-8 group-hover:rotate-[360deg] transition-transform duration-700">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight italic mb-3">Nueva Solicitud</h3>
                    <p class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest leading-relaxed mb-10">Reporta problemas técnicos o solicita asistencia inmediata al equipo TI.</p>
                </div>
                
                <a href="{{ route('user.tickets.create') }}" class="relative z-10 w-full bg-slate-900 text-white py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-600 transition-colors shadow-xl">
                    Crear Ticket →
                </a>
            </div>

            <!-- CARD: MANUALES -->
            <div class="group bg-slate-950 p-10 rounded-2xl shadow-2xl flex flex-col justify-between overflow-hidden relative border border-white/5">
                <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full group-hover:scale-[4] transition-transform duration-1000"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl border border-white/10 mb-8 group-hover:scale-110 transition-transform">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-3">Guías Técnicas</h3>
                    <p class="text-[0.7rem] font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-10">Accede a nuestra base de conocimientos para resolver dudas frecuentes.</p>
                </div>
                
                <a href="{{ route('knowledge.index') }}" class="relative z-10 w-full bg-white text-slate-950 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-400 transition-colors">
                    Explorar Guías
                </a>
            </div>

        </div>

        <!-- COLUMNA LATERAL: ESTADO RÁPIDO -->
        <div class="space-y-8">
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h5 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-8 border-b border-gray-200 pb-4 italic">Estado de Mis Recursos</h5>
                
                <div class="space-y-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Total Solicitudes</p>
                            <p class="text-xl font-black text-slate-900 italic uppercase">
                                {{ auth()->user()->tickets()->count() }} TICKETS
                            </p>
                        </div>
                        <div class="bg-indigo-600/10 p-3 rounded-xl text-indigo-600">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Cerrados con Éxito</p>
                            <p class="text-xl font-black text-slate-900 italic uppercase">
                                {{ auth()->user()->tickets()->whereHas('status', function($q){ $q->where('is_closed', true); })->count() }} CERRADOS
                            </p>
                        </div>
                        <div class="bg-emerald-600/10 p-3 rounded-xl text-emerald-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200">
                        <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-black text-indigo-600 hover:text-slate-900 transition-all uppercase tracking-widest flex items-center gap-2 italic">
                            VER TODO EL LISTADO <i class="fas fa-arrow-right text-[0.5rem]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
