@extends('layouts.app')

@section('content')
<div class="px-8 py-10">
    <!-- Header Premium -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase flex items-center gap-3">
                Inventario <span class="text-indigo-600">Premium</span> 🖥️
            </h1>
            <p class="text-slate-500 font-medium tracking-wide mt-1 uppercase text-xs">Control total de activos, hardware y equipamiento tecnológico.</p>
        </div>
        <a href="{{ route('admin.inventory.create') }}" 
            class="bg-slate-950 hover:bg-slate-800 text-white px-8 py-4 rounded-xl font-black italic uppercase tracking-widest text-xs transition-all shadow-xl hover:shadow-indigo-100 flex items-center gap-2">
            <span class="text-lg">+</span> Nuevo Elemento
        </a>
    </div>

    <!-- Estadísticas Rápidas (Alto Contraste) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-3xl border-2 border-slate-200 shadow-sm transition-all hover:border-indigo-200">
            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2 italic">Total Equipos</p>
            <p class="text-5xl font-black text-slate-900 tracking-tighter italic leading-none">{{ $items->count() }}</p>
        </div>
        <div class="bg-white p-8 rounded-3xl border-2 border-slate-200 shadow-sm transition-all hover:border-indigo-200">
            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mb-2 italic">En Uso</p>
            <p class="text-5xl font-black text-slate-900 tracking-tighter italic leading-none text-indigo-600">{{ $items->whereNotNull('user_id')->count() }}</p>
        </div>
        <div class="bg-indigo-600 p-8 rounded-3xl border-2 border-indigo-700 shadow-lg transition-all hover:bg-indigo-700">
            <p class="text-[0.65rem] font-bold text-indigo-200 uppercase tracking-widest mb-2 italic">Disponibles</p>
            <p class="text-5xl font-black text-white tracking-tighter italic leading-none">{{ $items->whereNull('user_id')->count() }}</p>
        </div>
    </div>

    <!-- Tabla de Datos Completa con Contraste Reforzado -->
    <div class="bg-white rounded-[2.5rem] border-2 border-slate-200 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b-2 border-slate-200">
                        <th class="px-8 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic">Código / Tag</th>
                        <th class="px-6 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic">Equipo / Marca</th>
                        <th class="px-6 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic">S/N - Serie</th>
                        <th class="px-6 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic">Ubicación</th>
                        <th class="px-6 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Estado</th>
                        <th class="px-6 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic">Usuario</th>
                        <th class="px-8 py-6 text-[0.7rem] font-black text-slate-500 uppercase tracking-widest italic text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y-2 divide-slate-100">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <!-- Código -->
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-indigo-600 tracking-tighter italic uppercase">#{{ $item->asset_tag }}</span>
                                <span class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-wide">{{ $item->type }}</span>
                            </div>
                        </td>
                        <!-- Equipo -->
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-800 tracking-tight uppercase italic">{{ $item->brand }}</span>
                                <span class="text-xs font-medium text-slate-500">{{ $item->model }}</span>
                            </div>
                        </td>
                        <!-- Serial -->
                        <td class="px-6 py-6">
                            <span class="text-xs font-mono font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                {{ $item->serial_number }}
                            </span>
                        </td>
                        <!-- Ubicación -->
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                <span class="text-xs font-bold text-slate-600 uppercase tracking-tight">{{ $item->location }}</span>
                            </div>
                        </td>
                        <!-- Estado -->
                        <td class="px-6 py-6 text-center">
                            @php
                                $statusColor = match($item->status) {
                                    'Operativo' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'En Reparación' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'De Baja' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    default => 'bg-slate-100 text-slate-600 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-4 py-1 rounded-full text-[0.6rem] font-black uppercase tracking-widest border-2 {{ $statusColor }} italic">
                                ● {{ $item->status }}
                            </span>
                        </td>
                        <!-- Usuario -->
                        <td class="px-6 py-6">
                            @if($item->user)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-[0.6rem] border-2 border-indigo-200">
                                        {{ substr($item->user->name, 0, 2) }}
                                    </div>
                                    <span class="text-xs font-black text-slate-700 tracking-tight uppercase italic">{{ $item->user->name }}</span>
                                </div>
                            @else
                                <span class="text-[0.6rem] font-bold text-slate-300 uppercase tracking-widest italic">Sin Asignar</span>
                            @endif
                        </td>
                        <!-- Acción -->
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.inventory.edit', $item->id) }}" 
                                    class="text-slate-400 hover:text-indigo-600 transition-colors p-2 hover:bg-indigo-50 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar Activo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors p-2 hover:bg-rose-50 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center">
                            <p class="text-slate-300 font-black uppercase tracking-widest italic text-sm">No se encontraron activos en el sistema</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Efecto de cristal para la tabla al hacer scroll */
    .overflow-x-auto::-webkit-scrollbar { height: 8px; }
    .overflow-x-auto::-webkit-scrollbar-track { background: transparent; }
    .overflow-x-auto::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; border: 2px solid white; }
</style>
@endsection
