@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER PREMIUM 🚀 -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Gestión de Insumos y Suministros</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Control de Almacén TI
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.supplies.create') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-black italic uppercase tracking-widest text-[0.7rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Nuevo Registro
            </a>
        </div>
    </div>

    <!-- DASHBOARD DE MÉTRICAS RÁPIDAS 📊 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Valor Total -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-3xl shadow-xl relative overflow-hidden group hover:border-emerald-500/30 transition-all">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-money-bill-wave text-6xl text-white"></i>
            </div>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1 italic">Valor en Inventario</p>
            <h3 class="text-3xl font-black text-white italic tracking-tighter hover:text-emerald-400 transition-colors">
                $ {{ number_format($totalValue, 0, ',', '.') }}
            </h3>
            <div class="mt-4 flex items-center text-[8px] text-emerald-500 font-black uppercase tracking-widest italic">
                <i class="fas fa-chart-line mr-2"></i> Actualizado hoy
            </div>
        </div>

        <!-- Total Unidades -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-3xl shadow-xl relative overflow-hidden group hover:border-blue-500/30 transition-all">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-boxes text-6xl text-white"></i>
            </div>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1 italic">Unidades Totales</p>
            <h3 class="text-3xl font-black text-white italic tracking-tighter hover:text-blue-400 transition-colors">
                {{ number_format($totalItems, 0, ',', '.') }} un.
            </h3>
            <div class="mt-4 flex items-center text-[8px] text-blue-500 font-black uppercase tracking-widest italic">
                <i class="fas fa-warehouse mr-2"></i> Stock Físico Global
            </div>
        </div>

        <!-- Alertas Stock -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-3xl shadow-xl relative overflow-hidden group hover:border-rose-500/30 transition-all">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-exclamation-triangle text-6xl text-white"></i>
            </div>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1 italic">Alertas de Stock</p>
            <h3 class="text-3xl font-black {{ $lowStock > 0 ? 'text-rose-500' : 'text-white' }} italic tracking-tighter">
                {{ $lowStock }} Críticos
            </h3>
            <div class="mt-4 flex items-center text-[8px] {{ $lowStock > 0 ? 'text-rose-500 animate-pulse' : 'text-slate-500' }} font-black uppercase tracking-widest italic text-rose-500">
                <i class="fas fa-bell mr-2"></i> Requieren Atención
            </div>
        </div>

        <!-- Categorías -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-3xl shadow-xl relative overflow-hidden group hover:border-indigo-500/30 transition-all">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i class="fas fa-tags text-6xl text-white"></i>
            </div>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1 italic">Categorías Únicas</p>
            <h3 class="text-3xl font-black text-white italic tracking-tighter hover:text-indigo-400 transition-colors">
                {{ $uniqueTypes }} Clases
            </h3>
            <div class="mt-4 flex items-center text-[8px] text-indigo-500 font-black uppercase tracking-widest italic">
                <i class="fas fa-layer-group mr-2"></i> Diversidad de Insumos
            </div>
        </div>
    </div>

    <!-- LISTADO DE INSUMOS (GRID) ✨ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($supplies as $supply)
            <div class="bg-slate-900/40 border border-white/5 p-8 rounded-[2.5rem] shadow-2xl hover:bg-slate-900/60 transition-all group relative overflow-hidden hover:border-white/10">
                
                @if($supply->isLowStock())
                    <div class="absolute top-0 right-0 p-4">
                        <span class="px-3 py-1 bg-rose-500 text-[8px] text-white font-black uppercase rounded-full shadow-lg shadow-rose-500/20 italic animate-bounce">
                            ⚠️ Stock Bajo
                        </span>
                    </div>
                @endif

                <div class="flex items-start justify-between mb-8">
                    <div class="w-14 h-14 bg-gradient-to-tr from-slate-800 to-slate-700 rounded-2xl flex items-center justify-center text-2xl text-indigo-400 shadow-inner group-hover:text-white group-hover:from-indigo-600 group-hover:to-blue-500 transition-all">
                        @switch($supply->type)
                            @case('TONER') <i class="fas fa-print"></i> @break
                            @case('PERIPHERAL') <i class="fas fa-mouse"></i> @break
                            @case('CABLE') <i class="fas fa-plug"></i> @break
                            @default <i class="fas fa-box"></i>
                        @endswitch
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1 italic">Stock Actual</span>
                        <h4 class="text-3xl font-black {{ $supply->isLowStock() ? 'text-rose-500' : 'text-white' }} italic tracking-tighter">
                            {{ $supply->stock }}
                        </h4>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-black text-white uppercase tracking-tighter italic leading-none truncate group-hover:text-indigo-400 transition-colors">
                        {{ $supply->name }}
                    </h3>
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-2 flex items-center gap-2 italic">
                        <span class="w-1 h-3 bg-indigo-500 rounded-full"></span>
                        MARCA: {{ $supply->brand ?? 'S/MARCA' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-8">
                    <div class="bg-white/5 p-3 rounded-2xl border border-white/5">
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Ubicación</p>
                        <p class="text-[10px] font-bold text-slate-200 truncate">{{ $supply->location ?? 'BODEGA TI' }}</p>
                    </div>
                    <div class="bg-white/5 p-3 rounded-2xl border border-white/5">
                        <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Valor Un.</p>
                        <p class="text-[10px] font-bold text-emerald-400 italic font-mono">$ {{ number_format($supply->unit_cost ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-white/5">
                    <a href="{{ route('admin.supplies.show', $supply) }}" class="flex-1 bg-white text-slate-900 text-center py-4 rounded-2xl font-black uppercase tracking-widest text-[0.65rem] transition-all hover:bg-slate-200 italic shadow-xl shadow-white/5">
                        <i class="fas fa-tasks mr-2"></i> Gestionar
                    </a>
                    <a href="{{ route('admin.supplies.edit', $supply) }}" class="w-12 h-12 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                        <i class="fas fa-pen text-xs"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PAGINACIÓN PREMIUM -->
    <div class="mt-16">
        {{ $supplies->links() }}
    </div>
</div>

<style>
    /* Estilización de la paginación de Laravel para encajar con el tema oscuro */
    .pagination { display: flex; gap: 0.5rem; }
    .page-item { border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1); }
    .page-link { background-color: #0f172a; color: #94a3b8; border: none; padding: 0.5rem 1rem; font-weight: 900; font-style: italic; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.7rem; transition: background-color 0.3s, color 0.3s; }
    .page-item.active .page-link { background-color: #4f46e5; color: white; }
    .page-link:hover { background-color: #1e293b; color: white; }
</style>

@endsection
