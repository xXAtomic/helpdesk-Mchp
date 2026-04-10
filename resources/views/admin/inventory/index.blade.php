@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER ESTRATÉGICO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 border-b border-white/5 pb-8 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Control de Hardware e Inventario TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Gravity Inventory Systems • {{ now()->format('M Y') }}
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <button class="bg-slate-900 border border-white/10 text-slate-400 px-5 py-3 rounded-2xl font-black uppercase tracking-widest text-[0.6rem] hover:text-white hover:border-white/20 transition-all flex items-center gap-3 shadow-2xl italic">
                <i class="fas fa-download"></i> EXPORTAR DATA
            </button>
            <a href="{{ route('admin.inventory.create') }}" 
                class="bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Nuevo Activo
            </a>
        </div>
    </div>

    <!-- DASHBOARD DE ESTADO (GLASSMORPHISM) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group hover:border-white/20 transition-all">
            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Patrimonio Global</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $items->count() }} <span class="text-slate-600">Items</span></p>
            <div class="mt-4 w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                <div class="bg-white h-full shadow-[0_0_10px_#fff]" style="width: 100%"></div>
            </div>
        </div>

        <!-- En Uso -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group hover:border-indigo-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Desplegados</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $items->whereNotNull('user_id')->count() }} <span class="text-indigo-900">Asig.</span></p>
            <div class="mt-4 w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                <div class="bg-indigo-500 h-full shadow-[0_0_10px_#6366f1]" style="width: {{ $items->count() > 0 ? ($items->whereNotNull('user_id')->count() / $items->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        <!-- Stock Libre -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group hover:border-emerald-500/30 transition-all">
            <h4 class="text-[0.6rem] font-black text-emerald-400 uppercase tracking-widest mb-1 italic">Disponibles</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $items->whereNull('user_id')->where('status', 'Operativo')->count() }} <span class="text-emerald-900 text-sm">Libres</span></p>
            <div class="mt-4 w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full shadow-[0_0_10px_#10b981]" style="width: {{ $items->count() > 0 ? ($items->whereNull('user_id')->where('status', 'Operativo')->count() / $items->count()) * 100 : 0 }}%"></div>
            </div>
        </div>

        <!-- Críticos -->
        <div class="bg-rose-500/5 backdrop-blur-xl border border-rose-500/20 p-6 rounded-[2rem] shadow-xl relative overflow-hidden group hover:border-rose-500/40 transition-all">
            <h4 class="text-[0.6rem] font-black text-rose-500 uppercase tracking-widest mb-1 italic">Estado Crítico</h4>
            <p class="text-3xl font-black text-white tracking-tighter italic">{{ $items->whereIn('status', ['En Reparación', 'De Baja'])->count() }} <span class="text-rose-900 text-sm">Offline</span></p>
            <div class="mt-4 w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                <div class="bg-rose-600 h-full shadow-[0_0_10px_#e11d48]" style="width: {{ $items->count() > 0 ? ($items->whereIn('status', ['En Reparación', 'De Baja'])->count() / $items->count()) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    @php $vencidos = $items->filter(fn($i) => $i->health_status == 'Mantenimiento Vencido')->count(); @endphp
    @if($vencidos > 0)
    <div class="bg-rose-600/10 border border-rose-500/20 p-5 rounded-2xl mb-8 flex items-center justify-between animate-pulse">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-rose-600 text-white rounded-xl flex items-center justify-center shadow-lg shadow-rose-600/20">
                <i class="fas fa-briefcase-medical"></i>
            </div>
            <div>
                <h4 class="text-[0.6rem] font-black text-rose-500 uppercase tracking-widest italic">ALERTA DE SALUD TÉCNICA</h4>
                <p class="text-sm font-black text-white uppercase italic tracking-tight">{{ $vencidos }} Equipos requieren mantenimiento <span class="text-rose-400">urgente</span></p>
            </div>
        </div>
        <i class="fas fa-exclamation-triangle text-rose-600 mr-4 opacity-40"></i>
    </div>
    @endif

    <!-- BARRA DE FILTROS DARK -->
    <form action="{{ route('admin.inventory.index') }}" method="GET" class="bg-slate-900/40 backdrop-blur-xl p-4 rounded-3xl border border-white/5 mb-8 flex flex-col md:flex-row gap-4 items-center">
        <div class="flex-1 w-full relative group">
            <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-indigo-400 transition-colors"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="BUSCAR ETIQUETA, MARCA O SERIE..." 
                   class="w-full pl-14 pr-6 py-4 bg-slate-950 border border-white/5 rounded-2xl text-[0.7rem] font-black text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/20 transition-all placeholder:text-slate-700 uppercase tracking-widest italic shadow-inner">
        </div>
        
        <div class="flex items-center gap-3 w-full md:w-auto">
            <select name="type" onchange="this.form.submit()" class="bg-slate-950 border border-white/5 px-6 py-4 rounded-2xl text-[0.65rem] font-black uppercase tracking-widest text-slate-400 focus:outline-none focus:border-indigo-500 italic cursor-pointer shadow-inner">
                <option value="">TODOS LOS TIPOS</option>
                <option value="Laptop" {{ request('type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                <option value="Desktop" {{ request('type') == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                <option value="Monitor" {{ request('type') == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                <option value="Smartphone" {{ request('type') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                <option value="Impresora" {{ request('type') == 'Impresora' ? 'selected' : '' }}>Impresora</option>
            </select>
            
            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.inventory.index') }}" class="w-12 h-12 bg-rose-500/20 text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all border border-rose-500/20" title="Limpiar Filtros">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </div>
    </form>

    <!-- LISTADO DE ACTIVOS PREMIUM -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/40 border-b border-white/5">
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">ID / Etiqueta</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Entidad</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Dispositivo</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">N° Serie</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Ubicación</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Salud TI</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Estado</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Usuario Asignado</th>
                        <th class="px-8 py-6"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/5 italic">
                    @forelse($items as $item)
                    <tr class="hover:bg-white/[0.03] transition-all group duration-300">
                        <td class="px-8 py-6">
                            <span class="text-[0.7rem] font-black text-white bg-slate-900 px-3 py-1.5 rounded-xl border border-white/5 italic uppercase shadow-xl group-hover:border-indigo-500/50 transition-all">
                                {{ $item->asset_tag }}
                            </span>
                        </td>
                        
                        <td class="px-8 py-6 text-center">
                            @if($item->entity)
                                <span class="text-[0.6rem] font-black {{ $item->entity == 'IASD' ? 'bg-amber-500 text-slate-950' : 'bg-blue-600 text-white' }} px-3 py-1 rounded-lg uppercase tracking-widest shadow-lg">
                                    {{ $item->entity }}
                                </span>
                            @else
                                <span class="text-slate-800">-</span>
                            @endif
                        </td>
                        
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-white uppercase italic tracking-tight group-hover:text-indigo-400 transition-colors">{{ $item->brand }}</span>
                                <span class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mt-1">{{ $item->model }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-[0.65rem] font-mono font-black text-slate-400 tracking-tight italic">{{ $item->serial_number }}</span>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-map-marker-alt text-slate-700 text-[10px]"></i>
                                <span class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest italic">{{ $item->location }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            @php
                                $hColor = $item->health_color ?? 'slate';
                                $hStatus = $item->health_status ?? 'Desconocido';
                            @endphp
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="px-3 py-1.5 rounded-xl text-[0.55rem] font-black uppercase tracking-widest border italic"
                                      style="{{ 'background-color: rgba(var(--health-'.$hColor.'), 0.1); color: var(--health-text-'.$hColor.'); border-color: rgba(var(--health-'.$hColor.'), 0.2);' }}">
                                    {{ $hStatus }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            @php
                                $statusStyle = match($item->status) {
                                    'Operativo' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'En Reparación' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'De Baja' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    default => 'bg-slate-800 text-slate-500 border-white/5'
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[0.55rem] font-black uppercase tracking-widest border {{ $statusStyle }} shadow-sm">
                                ● {{ $item->status }}
                            </span>
                        </td>


                        <td class="px-8 py-6">
                            @if($item->user)
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-600/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20 text-xs font-black shadow-lg">
                                        {{ substr($item->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-[0.7rem] font-black text-slate-200 uppercase tracking-tight italic group-hover:text-white transition-colors">{{ $item->user->name }}</span>
                                </div>
                            @else
                                <span class="text-[0.6rem] font-black text-slate-700 uppercase tracking-widest italic">BASE ALMACÉN</span>
                            @endif
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="opacity-0 group-hover:opacity-100 transition-all flex justify-end items-center gap-6">
                                <a href="{{ route('admin.inventory.show', $item->id) }}" class="w-9 h-9 bg-white/5 rounded-xl flex items-center justify-center text-white border border-white/5 hover:bg-indigo-600 hover:border-indigo-500 shadow-xl transition-all" title="Ver Detalle">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="w-9 h-9 bg-white/5 rounded-xl flex items-center justify-center text-slate-400 border border-white/5 hover:bg-slate-800 hover:text-white shadow-xl transition-all" title="Editar Activo">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-box-open text-slate-800 text-6xl mb-6 opacity-20"></i>
                                <p class="text-slate-600 font-black uppercase tracking-[0.5em] italic text-[0.65rem]">Protocolo de Vacío: Sin activos en base de datos</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINACIÓN -->
    <div class="mt-12">
        {{ $items->links() }}
    </div>
</div>

<style>
    /* Estilización Paginación */
    .pagination { display: flex; gap: 0.5rem; }
    .page-item { border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.05); }
    .page-link { background: rgba(15, 23, 42, 0.5); color: #64748b; border: none; padding: 0.75rem 1.25rem; font-weight: 900; font-style: italic; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.65rem; transition: all 0.3s; }
    .page-item.active .page-link { background: #4f46e5; color: white; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.2); }
    .page-link:hover { background: #1e293b; color: white; }

    /* Variables de Salud TI para evitar clases dinámicas conflictivas */
    :root {
        --health-emerald: 16, 185, 129; --health-text-emerald: #10b981;
        --health-amber: 245, 158, 11; --health-text-amber: #f59e0b;
        --health-rose: 225, 29, 72; --health-text-rose: #e11d48;
        --health-slate: 71, 85, 105; --health-text-slate: #94a3b8;
    }
</style>

@endsection
