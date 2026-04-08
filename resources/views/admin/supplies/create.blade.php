@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- HEADER NIVEL CIENCIA FICCIÓN 🚀 -->
    <div class="mb-12 border-b border-gray-100 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-950 tracking-tighter italic uppercase leading-none">
                Nuevo <span class="text-indigo-600">Insumo</span>
            </h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Registra stock de tóners, periféricos o cables técnicos</p>
        </div>
        <a href="{{ route('admin.supplies.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-indigo-600 transition uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al Listado
        </a>
    </div>

    <!-- FORMULARIO SaaS -->
    <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm relative overflow-hidden">
        <form action="{{ route('admin.supplies.store') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Nombre del Insumo</label>
                    <input type="text" name="name" required 
                           class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-sm focus:border-indigo-500 transition-all outline-none"
                           placeholder="Ej: Tóner HP 85A Negro">
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Marca / Fabricante</label>
                    <input type="text" name="brand" 
                           class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-sm focus:border-indigo-500 transition-all outline-none"
                           placeholder="Ej: Hewlett Packard">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Categoría Técnica</label>
                    <select name="type" required 
                            class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                        <option value="TONER">🖨️ Consumible de Impresión (Tóner/Tinta)</option>
                        <option value="PERIPHERAL">🖱️ Periférico (Mouse/Teclado/Parlantes)</option>
                        <option value="CABLE">🔌 Cables y Conectores</option>
                        <option value="STORAGE">💾 Almacenamiento (Discos/Memorias)</option>
                        <option value="OTHER">📦 Otros Accesorios</option>
                    </select>
                </div>
                <div class="space-y-4 text-center">
                    <div class="flex gap-4">
                        <div class="flex-1 space-y-4">
                            <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Stock Inicial</label>
                            <input type="number" name="stock" value="0" min="0" required 
                                   class="w-full px-6 py-5 rounded-2xl bg-slate-950 text-white font-black text-center text-xl shadow-xl shadow-slate-100 outline-none">
                        </div>
                        <div class="flex-1 space-y-4">
                            <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Alerta Min.</label>
                            <input type="number" name="min_stock" value="5" min="0" required 
                                   class="w-full px-6 py-5 rounded-2xl bg-rose-500 text-white font-black text-center text-xl shadow-xl shadow-rose-100 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Ubicación Física</label>
                <input type="text" name="location" 
                       class="w-full px-8 py-6 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-medium text-[0.95rem] focus:bg-white focus:border-indigo-500 transition-all outline-none placeholder:text-gray-300"
                       placeholder="Ej: Estante 3, Oficina de Informática..">
            </div>

            <div class="pt-8">
                <button type="submit" 
                        class="w-full bg-indigo-600 text-white font-black py-8 rounded-2xl text-[0.8rem] uppercase tracking-[0.25em] shadow-2xl shadow-indigo-500/30 hover:bg-slate-950 transition-all transform hover:-translate-y-1 active:scale-[0.98] border-b-4 border-indigo-900 italic">
                    Finalizar Registro de Insumo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
