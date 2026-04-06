@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- CABECERA DE BIENVENIDA MINIMALISTA -->
    <div class="mb-16 border-b border-gray-100 pb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-none italic uppercase">Panel Administrativo</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.3em] mt-3">Gestión TI • Misión Chilena del Pacífico</p>
        </div>
        <div class="text-right">
            <span class="text-[0.6rem] font-black text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg uppercase tracking-widest italic tracking-tight italic uppercase">Admin Mode: {{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1">Tickets Abiertos</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase font-black tracking-widest">{{ \App\Models\Ticket::whereHas('status', function($q){ $q->where('is_closed', false); })->count() }}</p>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1">Equipos en Inventario</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase font-black tracking-widest">{{ \App\Models\Asset::count() }}</p>
        </div>
        <div class="bg-indigo-950 p-8 rounded-2xl shadow-xl shadow-indigo-200">
            <p class="text-[0.6rem] font-black text-indigo-300 uppercase tracking-widest mb-1">Cerrados hoy</p>
            <p class="text-3xl font-black text-white tracking-tighter italic uppercase font-black tracking-widest">{{ \App\Models\Ticket::whereHas('status', function($q){ $q->where('is_closed', true); })->where('updated_at', '>=', now()->startOfDay())->count() }}</p>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1">Usuarios Totales</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase font-black tracking-widest">{{ \App\Models\User::count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- CARD: ADMINISTRAR SISTEMA -->
        <div class="group bg-white p-10 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
            <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-8">
                    <i class="fas fa-tools"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight italic mb-3">Gestión de Incidentes</h3>
                <p class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest leading-relaxed mb-10">Centraliza, asigna y da seguimiento a todos los tickets de la organización de forma eficiente.</p>
                <a href="{{ route('admin.tickets.index') }}" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-600 transition-colors shadow-xl">
                    Ver Mesa de Ayuda
                </a>
            </div>
        </div>

        <!-- CARD: CONFIGURAR EXPERIENCIA -->
        <div class="group bg-slate-950 p-10 rounded-2xl shadow-2xl overflow-hidden relative border border-white/5">
            <div class="absolute -left-6 -bottom-6 w-16 h-16 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl border border-white/10 mb-8">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-3">Recursos & Usuarios</h3>
                <p class="text-[0.7rem] font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-10">Configura departamentos, gestiona permisos de usuarios y actualiza el inventario tecnológico.</p>
                <a href="{{ route('admin.users.index') }}" class="inline-block bg-white text-slate-950 px-10 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-400 transition-colors">
                    Ficha Técnica
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
