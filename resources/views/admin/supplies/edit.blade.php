@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- HEADER NIVEL CIENCIA FICCIÓN 🚀 -->
    <div class="mb-12 border-b border-gray-100 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-950 tracking-tighter italic uppercase leading-none">
                Editar <span class="text-indigo-600">Insumo</span>
            </h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">ID del Producto: #{{ $supply->id }}</p>
        </div>
        <a href="{{ route('admin.supplies.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-indigo-600 transition uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver
        </a>
    </div>

    <!-- FORMULARIO SaaS -->
    <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm relative overflow-hidden">
        <form action="{{ route('admin.supplies.update', $supply) }}" method="POST" class="space-y-10">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Nombre del Insumo</label>
                    <input type="text" name="name" value="{{ $supply->name }}" required 
                           class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Marca / Fabricante</label>
                    <input type="text" name="brand" value="{{ $supply->brand }}" 
                           class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Categoría Técnica</label>
                    <select name="type" required 
                            class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                        <option value="TONER" {{ $supply->type == 'TONER' ? 'selected' : '' }}>🖨️ Consumible de Impresión (Tóner/Tinta)</option>
                        <option value="PERIPHERAL" {{ $supply->type == 'PERIPHERAL' ? 'selected' : '' }}>🖱️ Periférico (Mouse/Teclado/Parlantes)</option>
                        <option value="CABLE" {{ $supply->type == 'CABLE' ? 'selected' : '' }}>🔌 Cables y Conectores</option>
                        <option value="STORAGE" {{ $supply->type == 'STORAGE' ? 'selected' : '' }}>💾 Almacenamiento (Discos/Memorias)</option>
                        <option value="OTHER" {{ $supply->type == 'OTHER' ? 'selected' : '' }}>📦 Otros Accesorios</option>
                    </select>
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Alerta de Stock Mínimo</label>
                    <input type="number" name="min_stock" value="{{ $supply->min_stock }}" min="0" required 
                           class="w-full px-6 py-5 rounded-2xl bg-rose-500 text-white font-black text-center text-xl shadow-xl shadow-rose-100 outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Ubicación Física</label>
                    <input type="text" name="location" value="{{ $supply->location }}" 
                           class="w-full px-8 py-6 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-medium text-[0.95rem] focus:bg-white focus:border-indigo-500 transition-all outline-none">
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Costo Unitario ($)</label>
                    <input type="number" step="0.01" name="unit_cost" value="{{ $supply->unit_cost }}" required 
                           class="w-full px-8 py-6 rounded-2xl bg-indigo-50 border-2 border-transparent text-indigo-900 font-black text-xl focus:bg-white focus:border-indigo-500 transition-all outline-none">
                </div>
            </div>

            <div class="pt-8">
                <button type="submit" 
                        class="w-full bg-slate-950 text-white font-black py-8 rounded-2xl text-[0.8rem] uppercase tracking-[0.25em] shadow-2xl transition-all transform hover:-translate-y-1 active:scale-[0.98] border-b-4 border-indigo-900 italic">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
