@extends('layouts.app')

@section('content')
<div class="px-8 py-10 max-w-7xl mx-auto">
    
    <!-- HEADER NIVEL CIENCIA FICCIÓN 🚀 -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-slate-100 pb-10 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-600 text-white text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-md italic shadow-lg shadow-indigo-200">Inventory Hub</span>
                @if($lowStock > 0)
                    <span class="px-3 py-1 bg-rose-500 text-white text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-md italic animate-pulse shadow-lg shadow-rose-200">Stock Crítico: {{ $lowStock }}</span>
                @endif
            </div>
            <h1 class="text-5xl font-black text-slate-950 tracking-tighter italic uppercase leading-none">
                Gestión de <span class="text-indigo-600">Insumos</span>
            </h1>
            <p class="text-slate-500 font-bold tracking-tight mt-4 text-[0.7rem] uppercase italic leading-relaxed max-w-lg">
                Control táctico de periféricos, consumibles y repuestos críticos para la continuidad operativa de la misión.
            </p>
        </div>
        
        <a href="{{ route('admin.supplies.create') }}" class="bg-slate-950 hover:bg-indigo-700 text-white px-10 py-5 rounded-[2rem] font-black italic uppercase tracking-widest text-[0.75rem] transition-all shadow-2xl hover:shadow-indigo-200 flex items-center gap-4 group">
            <div class="w-8 h-8 bg-white/10 rounded-xl flex items-center justify-center group-hover:rotate-90 transition-transform">
                <i class="fas fa-plus text-indigo-400"></i>
            </div>
            Registrar Nuevo Insumo
        </a>
    </div>

    <!-- LISTADO DE INSUMOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($supplies as $supply)
            <div class="bg-white rounded-[3rem] border border-slate-100 p-8 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all group relative overflow-hidden">
                @if($supply->isLowStock())
                    <div class="absolute top-0 right-0 p-4">
                        <div class="bg-rose-500 text-white p-2 rounded-2xl shadow-lg animate-bounce">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                @endif

                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-inner border border-slate-100">
                        @switch($supply->type)
                            @case('TONER') <i class="fas fa-print"></i> @break
                            @case('PERIPHERAL') <i class="fas fa-mouse"></i> @break
                            @case('CABLE') <i class="fas fa-plug"></i> @break
                            @default <i class="fas fa-box"></i>
                        @endswitch
                    </div>
                    <div class="text-right">
                        <span class="text-[0.6rem] font-black text-slate-300 uppercase tracking-widest block mb-1 italic">Stock Actual</span>
                        <h3 class="text-4xl font-black {{ $supply->isLowStock() ? 'text-rose-600' : 'text-slate-950' }} tracking-tighter">{{ $supply->stock }}</h3>
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-xl font-black text-slate-900 uppercase tracking-tighter italic leading-none truncate group-hover:text-indigo-600 transition-colors">{{ $supply->name }}</h4>
                    <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mt-2">MARCA: {{ $supply->brand ?? 'N/A' }} • {{ $supply->type }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Ubicación</p>
                        <p class="text-[0.7rem] font-bold text-slate-900 truncate">{{ $supply->location ?? 'Bodega TI' }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Min. Alert</p>
                        <p class="text-[0.7rem] font-bold text-slate-900">{{ $supply->min_stock }} Unidades</p>
                    </div>
                </div>

                <div class="flex gap-3 pt-6 border-t border-slate-50">
                    <a href="{{ route('admin.supplies.show', $supply) }}" class="flex-1 bg-slate-950 hover:bg-indigo-600 text-white text-center py-4 rounded-2xl font-black uppercase tracking-widest text-[0.65rem] transition-all shadow-xl shadow-slate-100 italic flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i> Gestionar
                    </a>
                    <a href="{{ route('admin.supplies.edit', $supply) }}" class="w-14 h-14 bg-white border-2 border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-600 transition-all">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $supplies->links() }}
    </div>
</div>
@endsection
