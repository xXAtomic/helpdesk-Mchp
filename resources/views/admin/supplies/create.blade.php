@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE LOGÍSTICA TÉCNICA -->
    <div class="mb-16 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Gestión de <span class="text-indigo-500">Suministros</span> de Soporte
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic leading-none">
                <i class="fas fa-boxes text-indigo-400"></i>
                Registro de Stock Crítico • Terminal de Bodega
            </p>
        </div>
        <a href="{{ route('admin.supplies.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Volver a Inventario
        </a>
    </div>

    <!-- PANEL DE REGISTRO DE BODEGA -->
    <div class="max-w-4xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
        <form action="{{ route('admin.supplies.store') }}" method="POST" class="space-y-12 relative z-10">
            @csrf
            
            <!-- SECCIÓN 1: IDENTIFICACIÓN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Denominación del Ítem</label>
                    <input type="text" name="name" required 
                           class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                           placeholder="EJ: TÓNER HP 85A NEGRO">
                </div>
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Fabricante / OEM</label>
                    <input type="text" name="brand" 
                           class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                           placeholder="EJ: HEWLETT PACKARD">
                </div>
            </div>

            <!-- SECCIÓN 2: CATEGORIZACIÓN Y CUANTIFICACIÓN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Segmento de Almacén</label>
                    <div class="relative">
                        <select name="type" required 
                                class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase tracking-widest italic custom-select">
                            <option value="TONER">🖨️ Consumible de Impresión</option>
                            <option value="PERIPHERAL">🖱️ Periférico Externo</option>
                            <option value="CABLE">🔌 Cableado y Energía</option>
                            <option value="STORAGE">💾 Unidad de Datos</option>
                            <option value="OTHER">📦 Otros Accesorios</option>
                        </select>
                        <i class="fas fa-layer-group absolute right-8 top-1/2 -translate-y-1/2 text-slate-800"></i>
                    </div>
                </div>
                
                <div class="flex gap-6">
                    <div class="flex-1 space-y-4">
                        <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Stock Inicial</label>
                        <input type="number" name="stock" value="0" min="0" required 
                               class="w-full px-6 py-6 rounded-2xl bg-slate-950 border border-white/5 text-indigo-400 font-black text-center text-2xl shadow-inner focus:border-indigo-500 transition-all outline-none italic tracking-tighter">
                    </div>
                    <div class="flex-1 space-y-4">
                        <label class="block text-[0.6rem] font-black text-rose-500/60 uppercase tracking-[0.4em] ml-2 italic">Umbral Crítico</label>
                        <input type="number" name="min_stock" value="1" min="0" required 
                               class="w-full px-6 py-6 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 font-black text-center text-2xl shadow-[0_0_20px_rgba(225,29,72,0.1)] focus:border-rose-500 transition-all outline-none italic tracking-tighter">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: LOGÍSTICA Y COSTOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-all">Ubicación Física Terminal</label>
                    <input type="text" name="location" 
                           class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.8rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                           placeholder="ESTANTE X • CAJA Y">
                </div>
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-all">Valor Unitario Institucional ($)</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="unit_cost" value="0.00" required 
                               class="w-full px-8 py-6 rounded-2xl bg-indigo-500/5 border border-indigo-500/20 text-indigo-400 font-black text-2xl focus:border-indigo-500 transition-all outline-none italic tracking-tighter shadow-2xl">
                        <i class="fas fa-tags absolute right-8 top-1/2 -translate-y-1/2 text-indigo-500/50"></i>
                    </div>
                </div>
            </div>

            <!-- BOTÓN DE SINCRONIZACIÓN -->
            <div class="pt-10">
                <button type="submit" 
                        class="w-full bg-white text-slate-950 font-black py-8 rounded-[2rem] text-[0.85rem] uppercase tracking-[0.4em] shadow-3xl hover:bg-indigo-600 hover:text-white transition-all transform hover:-translate-y-1 active:scale-95 italic flex items-center justify-center gap-6 group">
                    SINCRONIZAR CON BODEGA CENTRAL
                    <i class="fas fa-clipboard-check text-xs group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
