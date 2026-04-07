@extends('layouts.app')

@section('content')
<div class="px-6 py-8 max-w-7xl mx-auto">
    
    <!-- HEADER ESTRATÉGICO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 border-b border-slate-100 pb-8 gap-6">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="px-2.5 py-0.5 bg-indigo-600 text-white text-[0.6rem] font-black uppercase tracking-widest rounded italic shadow-md shadow-indigo-100">Inventory</span>
                <span class="text-[0.65rem] font-black text-slate-300 uppercase tracking-widest">{{ now()->format('M Y') }}</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                Control de <span class="text-indigo-600">Hardware</span>
            </h1>
            <p class="text-slate-500 font-medium tracking-tight mt-2 text-xs uppercase italic">Inventario global de activos tecnológicos MChP.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <button class="bg-white border border-slate-200 text-slate-500 px-5 py-2.5 rounded-lg font-bold uppercase tracking-widest text-[0.6rem] hover:bg-slate-50 transition-all flex items-center gap-2 shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                CSV
            </button>
            <a href="{{ route('admin.inventory.create') }}" 
                class="bg-slate-950 hover:bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg hover:shadow-indigo-200 flex items-center gap-2 group">
                <span class="text-base group-hover:rotate-90 transition-transform">+</span> Nuevo Activo
            </a>
        </div>
    </div>

    <!-- DASHBOARD DE ESTADO (COMPACTO) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <h4 class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Total Activos</h4>
                <p class="text-2xl font-black text-slate-900 tracking-tighter italic">{{ $items->count() }}</p>
                <div class="mt-2 w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                    <div class="bg-slate-900 h-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <h4 class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">En Uso</h4>
                <p class="text-2xl font-black text-indigo-600 tracking-tighter italic">{{ $items->whereNotNull('user_id')->count() }}</p>
                <div class="mt-2 w-full h-1 bg-indigo-50 rounded-full overflow-hidden">
                    <div class="bg-indigo-600 h-full" style="width: {{ $items->count() > 0 ? ($items->whereNotNull('user_id')->count() / $items->count()) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <h4 class="text-[0.6rem] font-black text-emerald-400 uppercase tracking-widest mb-1 italic">Stock Libre</h4>
                <p class="text-2xl font-black text-emerald-600 tracking-tighter italic">{{ $items->whereNull('user_id')->where('status', 'Operativo')->count() }}</p>
                <div class="mt-2 w-full h-1 bg-emerald-50 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full" style="width: {{ $items->count() > 0 ? ($items->whereNull('user_id')->where('status', 'Operativo')->count() / $items->count()) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-rose-50 p-5 rounded-2xl border border-rose-100 relative overflow-hidden group">
            <div class="relative z-10">
                <h4 class="text-[0.6rem] font-black text-rose-400 uppercase tracking-widest mb-1 italic">Reparaciones</h4>
                <p class="text-2xl font-black text-rose-600 tracking-tighter italic">{{ $items->whereIn('status', ['En Reparación', 'De Baja'])->count() }}</p>
                <div class="mt-2 w-full h-1 bg-rose-200 rounded-full overflow-hidden">
                    <div class="bg-rose-600 h-full" style="width: {{ $items->count() > 0 ? ($items->whereIn('status', ['En Reparación', 'De Baja'])->count() / $items->count()) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- BARRA DE ACCIÓN (MÁS ESTÉTICA) -->
    <form action="{{ route('admin.inventory.index') }}" method="GET" class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm mb-8 flex flex-col md:flex-row gap-3 items-center">
        <div class="flex-1 w-full relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar etiqueta, marca o serie..." 
                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 uppercase tracking-wide">
        </div>
        
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select name="type" onchange="this.form.submit()" class="flex-1 md:w-40 px-4 py-3 bg-slate-50 border-none rounded-xl text-[0.65rem] font-black uppercase tracking-widest text-slate-500 focus:ring-2 focus:ring-indigo-100 italic cursor-pointer">
                <option value="">Tipo: Todos</option>
                <option value="Laptop" {{ request('type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                <option value="Desktop" {{ request('type') == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                <option value="Monitor" {{ request('type') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                <option value="Smartphone" {{ request('type') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                <option value="Impresora" {{ request('type') == 'Impresora' ? 'selected' : '' }}>Impresora</option>
            </select>
            <select name="status" onchange="this.form.submit()" class="flex-1 md:w-40 px-4 py-3 bg-slate-50 border-none rounded-xl text-[0.65rem] font-black uppercase tracking-widest text-slate-500 focus:ring-2 focus:ring-indigo-100 italic cursor-pointer">
                <option value="">Status: Todos</option>
                <option value="Operativo" {{ request('status') == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                <option value="En Reparación" {{ request('status') == 'En Reparación' ? 'selected' : '' }}>Reparación</option>
                <option value="De Baja" {{ request('status') == 'De Baja' ? 'selected' : '' }}>Baja</option>
            </select>
            
            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.inventory.index') }}" class="p-3 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 transition-all shadow-sm" title="Limpiar Filtros">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </div>
    </form>

    <!-- LISTADO DE ACTIVOS (COMPENSADO) -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">Id / Etiqueta</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">Dispositivo</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">N° Serie</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">Ubicación</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic text-center">Estado</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">Usuario</th>
                        <th class="px-6 py-4 text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/50 transition-all group duration-200">
                        <td class="px-6 py-4">
                            <span class="text-[0.7rem] font-bold text-indigo-500 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100 italic uppercase">
                                {{ $item->asset_tag }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-900 uppercase italic tracking-tight">{{ $item->brand }}</span>
                                <span class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $item->model }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-[0.65rem] font-mono font-bold text-slate-500 tracking-tight italic">{{ $item->serial_number }}</span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest italic">{{ $item->location }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @php
                                $statusStyle = match($item->status) {
                                    'Operativo' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'En Reparación' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'De Baja' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    default => 'bg-slate-50 text-slate-500 border-slate-100'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[0.55rem] font-black uppercase tracking-widest border italic {{ $statusStyle }}">
                                ● {{ $item->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($item->user)
                                <div class="flex items-center gap-2.5">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=6366f1&color=fff&bold=true" class="w-7 h-7 rounded-lg shadow-sm">
                                    <span class="text-[0.65rem] font-black text-slate-700 uppercase italic tracking-tight">{{ $item->user->name }}</span>
                                </div>
                            @else
                                <span class="text-[0.6rem] font-bold text-slate-300 uppercase tracking-widest italic">Disponible</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity flex justify-end items-center gap-4 text-xs">
                                <a href="{{ route('admin.inventory.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-black uppercase tracking-widest italic border-b border-transparent hover:border-indigo-600 transition-all">
                                    Ficha
                                </a>
                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="text-slate-600 hover:text-slate-900 font-black uppercase tracking-widest italic border-b border-transparent hover:border-slate-800 transition-all">
                                    Editar
                                </a>
                                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar Activo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-600 font-black uppercase tracking-widest italic border-b border-transparent hover:border-rose-600 transition-all">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center bg-slate-50/30">
                            <div class="flex flex-col items-center">
                                <p class="text-slate-400 font-black uppercase tracking-[0.2em] italic text-xs">Sin registros de inventario</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
