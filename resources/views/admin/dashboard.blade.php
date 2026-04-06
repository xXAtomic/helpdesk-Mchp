@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Panel Administrativo</h1>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mt-1">Gestión Centralizada • Misión Chilena del Pacífico</p>
        </div>
        <div class="mt-6 md:mt-0 flex gap-4">
            <span class="inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-lg text-[0.6rem] font-black text-indigo-600 uppercase tracking-widest italic">
                ADMIN MODE ACTIVE
            </span>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS (ESTILO MY-TICKETS) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">Tickets Pendientes</p>
            <p class="text-2xl font-black text-slate-900 tracking-tighter italic uppercase text-center">{{ \App\Models\Ticket::whereHas('status', function($q){ $q->where('is_closed', false); })->count() }} ACTIVOS</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">Inventario Total</p>
            <p class="text-2xl font-black text-slate-900 tracking-tighter italic uppercase text-center">{{ \App\Models\Asset::count() }} EQUIPOS</p>
        </div>
        <div class="bg-indigo-950 p-6 rounded-xl shadow-xl shadow-indigo-200">
            <p class="text-[0.6rem] font-black text-indigo-300 uppercase tracking-widest mb-1 italic text-center">Finalizados Hoy</p>
            <p class="text-2xl font-black text-white tracking-tighter italic uppercase text-center">{{ \App\Models\Ticket::whereHas('status', function($q){ $q->where('is_closed', true); })->where('updated_at', '>=', now()->startOfDay())->count() }} CERRADOS</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">Usuarios Base</p>
            <p class="text-2xl font-black text-slate-900 tracking-tighter italic uppercase text-center">{{ \App\Models\User::count() }} REGISTROS</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- ACCIONES PRINCIPALES (TARJETAS GRANDES LIMPIAS) -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- CARD: INCIDENTES -->
            <div class="group bg-white p-12 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-8">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight italic mb-3">Gestión de Incidentes</h3>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-widest leading-relaxed mb-12">Centraliza, asigna y da seguimiento a todas las solicitudes técnicas de la organización de forma eficiente.</p>
                    <a href="{{ route('admin.tickets.index') }}" class="inline-block bg-slate-900 text-white px-12 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest hover:bg-emerald-600 transition-colors shadow-lg">
                        Mesa de Ayuda →
                    </a>
                </div>
            </div>

            <!-- TAREAS DE CONFIGURACIÓN (TIPO NOTION) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-slate-400 mb-6 border">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-tight italic mb-2">Roles & Usuarios</h4>
                    <p class="text-[0.65rem] font-medium text-slate-400 leading-relaxed uppercase tracking-widest mb-8 italic">Gestión de permisos y altas/bajas de personal operativo en el sistema.</p>
                    <a href="{{ route('admin.users.index') }}" class="text-[0.6rem] font-bold text-indigo-600 hover:text-slate-900 uppercase tracking-widest flex items-center gap-2">ADMINISTRAR PERSONAL <i class="fas fa-arrow-right text-[0.5rem]"></i></a>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-gray-50 rounded-lg flex items-center justify-center text-slate-400 mb-6 border">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-tight italic mb-2">Inventario TI</h4>
                    <p class="text-[0.65rem] font-medium text-slate-400 leading-relaxed uppercase tracking-widest mb-8 italic italic uppercase tracking-widest">Control y registro de equipos tecnológicos asignados a los departamentos.</p>
                    <a href="{{ route('admin.inventory.index') }}" class="text-[0.6rem] font-bold text-indigo-600 hover:text-slate-900 uppercase tracking-widest flex items-center gap-2">RECURSOS TÉCNICOS <i class="fas fa-arrow-right text-[0.5rem]"></i></a>
                </div>
            </div>

        </div>

        <!-- COLUMNA LATERAL: UTILIDADES ADMIN -->
        <div class="space-y-8">
            <div class="bg-slate-950 p-10 rounded-xl shadow-2xl overflow-hidden relative border border-white/5">
                <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl border border-white/10 mb-8">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-3">Seguridad & Guías</h3>
                    <p class="text-[0.7rem] font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-10">Administra la base de conocimientos y configura las políticas de acceso del servidor.</p>
                    <a href="{{ route('admin.knowledge.index') }}" class="inline-block w-full bg-white text-slate-950 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-400 transition-colors">
                        Ficha Técnica
                    </a>
                </div>
            </div>

            <!-- REGISTRO BREVE -->
            <div class="bg-gray-50 p-8 rounded-xl border border-gray-100">
                <h5 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-8 border-b border-gray-200 pb-4 italic uppercase tracking-widest">Métricas de Rendimiento</h5>
                <div class="space-y-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Tasa de Resolución</p>
                            <p class="text-xl font-black text-slate-900 italic uppercase italic">
                                {{ \App\Models\Ticket::count() > 0 ? round((\App\Models\Ticket::whereHas('status', function($q){ $q->where('is_closed', true); })->count() / \App\Models\Ticket::count()) * 100) : 0 }}% LOGRADO
                            </p>
                        </div>
                        <div class="bg-indigo-600/10 p-3 rounded-lg text-indigo-600">
                            <i class="fas fa-chart-line text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
