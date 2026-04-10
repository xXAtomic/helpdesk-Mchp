@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE GESTIÓN TÁCTICA -->
    <div class="mb-14 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Modificar <span class="text-indigo-500">Insumo</span>
            </h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic leading-none">
                <i class="fas fa-edit text-indigo-400"></i>
                Identificador Único: #{{ $supply->id }} • Terminal de Control
            </p>
        </div>
        <a href="{{ route('admin.supplies.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Abortar Edición
        </a>
    </div>

    <!-- PANEL DE EDICIÓN SaaS (GLASSMORPHISM) -->
    <div class="max-w-4xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
        
        <form action="{{ route('admin.supplies.update', $supply) }}" method="POST" class="space-y-12 relative z-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Nombre Máster -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Denominación del Recurso</label>
                    <input type="text" name="name" value="{{ $supply->name }}" required 
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase">
                </div>
                <!-- Marca / Fabricante -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Manufactura / Entidad Especializada</label>
                    <input type="text" name="brand" value="{{ $supply->brand }}" 
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Categoría Táctica -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Clasificación Técnica</label>
                    <div class="relative">
                        <select name="type" required 
                                class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase italic tracking-widest custom-select">
                            <option value="TONER" {{ $supply->type == 'TONER' ? 'selected' : '' }} class="bg-slate-950">🖨️ PRODUCTO DE IMPRESIÓN</option>
                            <option value="PERIPHERAL" {{ $supply->type == 'PERIPHERAL' ? 'selected' : '' }} class="bg-slate-950">🖱️ PERIFÉRICO TÉCNICO</option>
                            <option value="CABLE" {{ $supply->type == 'CABLE' ? 'selected' : '' }} class="bg-slate-950">🔌 INFRAESTRUCTURA CABLEADA</option>
                            <option value="STORAGE" {{ $supply->type == 'STORAGE' ? 'selected' : '' }} class="bg-slate-950">💾 ALMACENAMIENTO DE DATOS</option>
                            <option value="OTHER" {{ $supply->type == 'OTHER' ? 'selected' : '' }} class="bg-slate-950">📦 ACCESORIO MULTIPROPÓSITO</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-8 top-1/2 -translate-y-1/2 text-slate-800 pointer-events-none"></i>
                    </div>
                </div>
                <!-- Alerta de Stock Mínimo (Neon Alert) -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none transition-all group-focus-within:text-rose-400">Umbral de Alerta Crítica</label>
                    <div class="relative">
                        <input type="number" name="min_stock" value="{{ $supply->min_stock }}" min="0" required 
                            class="w-full px-8 py-6 rounded-[2rem] bg-rose-500/10 border border-rose-500/30 text-rose-500 font-black text-center text-2xl focus:bg-rose-500/20 focus:border-rose-500 transition-all outline-none">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-rose-500 rounded-full blur-xl opacity-20 animate-pulse"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Ubicación Física -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-all">Coordenadas de Almacenamiento</label>
                    <input type="text" name="location" value="{{ $supply->location }}" 
                        class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                        placeholder="EJ: BODEGA NIVEL 2">
                </div>
                <!-- Costo Unitario (La Correció del Error) -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-all">Valor Económico Unitario ($)</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="unit_cost" value="{{ $supply->unit_cost }}" required 
                            class="w-full px-8 py-6 rounded-2xl bg-indigo-500/10 border border-indigo-500/30 text-white font-black text-2xl focus:bg-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-center">
                        <div class="absolute -bottom-1 -left-1 w-6 h-6 bg-indigo-500 rounded-full blur-xl opacity-20"></div>
                    </div>
                </div>
            </div>

            <!-- EJECUCIÓN MAESTRO -->
            <div class="pt-10 flex flex-col sm:flex-row gap-6">
                <button type="submit" 
                        class="flex-1 bg-white text-slate-950 hover:bg-indigo-600 hover:text-white font-black py-8 rounded-[2rem] transition-all shadow-3xl uppercase tracking-[0.4em] italic text-[0.8rem] flex items-center justify-center gap-6 group">
                    ACTUALIZAR REGISTRO TÁCTICO
                    <i class="fas fa-save text-[10px] group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
