@extends('layouts.app')

@section('content')
<div class="px-8 py-10 max-w-7xl mx-auto">
    
    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-slate-100 pb-10 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-600 text-white text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-md italic shadow-lg shadow-indigo-200">Management ID: #{{ $supply->id }}</span>
                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-md italic">{{ $supply->type }}</span>
            </div>
            <h1 class="text-5xl font-black text-slate-950 tracking-tighter italic uppercase leading-none truncate max-w-2xl">
                {{ $supply->name }}
            </h1>
            <p class="text-slate-500 font-bold tracking-tight mt-4 text-[0.7rem] uppercase italic leading-relaxed">
                Control de disponibilidad y trazabilidad de activos consumibles. Marca: {{ $supply->brand ?? 'S/M' }}
            </p>
        </div>
        
        <div class="flex gap-4">
            <a href="{{ route('admin.supplies.index') }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-[0.65rem] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 hover:border-indigo-600 transition-all italic">Volver</a>
            <a href="{{ route('admin.supplies.edit', $supply) }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl text-[0.65rem] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-600 hover:border-indigo-600 transition-all italic">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- COLUMNA IZQUIERDA: ACCIONES Y STOCK -->
        <div class="lg:col-span-1 space-y-12">
            
            <!-- TARJETA DE STOCK ACTUAL -->
            <div class="bg-slate-950 rounded-[3rem] p-10 shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-600/10 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10 text-center">
                    <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.3em] italic mb-6">Unidades Disponibles</p>
                    <h2 class="text-8xl font-black text-white tracking-tighter italic">{{ $supply->stock }}</h2>
                    <div class="mt-8 flex items-center justify-center gap-2">
                        @if($supply->isLowStock())
                            <span class="px-4 py-2 bg-rose-500/20 text-rose-400 text-[0.6rem] font-black rounded-xl uppercase tracking-widest border border-rose-500/20 animate-pulse">Stock Crítico</span>
                        @else
                            <span class="px-4 py-2 bg-emerald-500/20 text-emerald-400 text-[0.6rem] font-black rounded-xl uppercase tracking-widest border border-emerald-500/20">Operativo</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FORMULARIO DE ENTREGA (DISPATCH) -->
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-950 uppercase italic tracking-tighter mb-8 flex items-center gap-3">
                    <span class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-lg italic text-indigo-600">D</span>
                    Registrar Entrega
                </h3>
                <form action="{{ route('admin.supplies.dispatch', $supply) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Asignar a Usuario</label>
                        <select name="user_id" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-950 font-bold text-sm focus:border-indigo-500 outline-none">
                            <option value="">Seleccionar..</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Cantidad</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $supply->stock }}" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-950 font-bold text-sm focus:border-indigo-500 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Tipo</label>
                            <select name="action" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-950 font-bold text-sm focus:border-indigo-500 outline-none">
                                <option value="CONSUMPTION">Consumo (Tóner)</option>
                                <option value="LOAN">Préstamo (Mouse)</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Etiqueta de Equipo (Opcional)</label>
                        <input type="text" name="equipment_tag" placeholder="Ej: PC-ADMIN-01" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-950 font-bold text-sm focus:border-indigo-500 outline-none">
                    </div>

                    <button type="submit" class="w-full bg-slate-950 hover:bg-indigo-600 text-white font-black py-5 rounded-2xl text-[0.7rem] uppercase tracking-widest transition-all italic shadow-2xl">
                        Ejecutar Transacción
                    </button>
                </form>
            </div>

            <!-- BOTÓN REABASTECIMIENTO -->
            <button onclick="document.getElementById('restockModal').classList.toggle('hidden')" class="w-full bg-white border-2 border-slate-100 hover:border-emerald-500 hover:bg-emerald-50 text-slate-400 hover:text-emerald-700 font-black py-5 rounded-2xl text-[0.7rem] uppercase tracking-widest transition-all italic flex items-center justify-center gap-3">
                <i class="fas fa-plus"></i> Reabastecer Stock
            </button>

        </div>

        <!-- COLUMNA DERECHA: HISTORIAL TÁCTICO -->
        <div class="lg:col-span-2 space-y-12">
            
            <div class="bg-white rounded-[3.5rem] border border-slate-100 p-12 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h3 class="text-2xl font-black text-slate-950 uppercase italic tracking-tighter">Historial de Movimientos</h3>
                        <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Registro auditable de ingresos y egresos</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-50">
                                <th class="py-6 text-[0.6rem] font-black text-slate-300 uppercase tracking-[0.2em] italic">Fecha</th>
                                <th class="py-6 text-[0.6rem] font-black text-slate-300 uppercase tracking-[0.2em] italic">Evento</th>
                                <th class="py-6 text-[0.6rem] font-black text-slate-300 uppercase tracking-[0.2em] italic">Cantidad</th>
                                <th class="py-6 text-[0.6rem] font-black text-slate-300 uppercase tracking-[0.2em] italic">Usuario / Admin</th>
                                <th class="py-6 text-[0.6rem] font-black text-slate-300 uppercase tracking-[0.2em] italic">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($supply->logs as $log)
                                <tr class="group hover:bg-slate-50/50 transition-all">
                                    <td class="py-8">
                                        <p class="text-[0.75rem] font-black text-slate-900 italic">{{ $log->created_at->format('d/m/Y') }}</p>
                                        <p class="text-[0.55rem] text-slate-400 font-bold uppercase tracking-widest">{{ $log->created_at->format('H:i') }} hrs</p>
                                    </td>
                                    <td class="py-8">
                                        <div class="flex items-center gap-3">
                                            @switch($log->action)
                                                @case('RESTOCK')
                                                    <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs"><i class="fas fa-arrow-up"></i></span>
                                                    <p class="text-[0.65rem] font-black text-slate-900 uppercase italic">Ingreso de Stock</p>
                                                    @break
                                                @case('CONSUMPTION')
                                                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs"><i class="fas fa-arrow-down"></i></span>
                                                    <p class="text-[0.65rem] font-black text-slate-900 uppercase italic">Consumo Directo</p>
                                                    @break
                                                @case('LOAN')
                                                    <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs"><i class="fas fa-hand-holding"></i></span>
                                                    <p class="text-[0.65rem] font-black text-slate-900 uppercase italic">Préstamo Activo</p>
                                                    @break
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="py-8">
                                        <p class="text-xl font-black {{ $log->action === 'RESTOCK' ? 'text-emerald-600' : 'text-slate-900' }} tracking-tighter italic">
                                            {{ $log->action === 'RESTOCK' ? '+' : '-' }}{{ $log->quantity }}
                                        </p>
                                    </td>
                                    <td class="py-8">
                                        @if($log->user)
                                            <p class="text-[0.75rem] font-black text-slate-900 uppercase tracking-tighter">{{ $log->user->name }}</p>
                                            <p class="text-[0.55rem] text-slate-400 font-bold uppercase tracking-widest">Receptor</p>
                                        @else
                                            <p class="text-[0.75rem] font-black text-slate-900 uppercase tracking-tighter">{{ $log->admin->name }}</p>
                                            <p class="text-[0.55rem] text-slate-400 font-bold uppercase tracking-widest">Administrador</p>
                                        @endif
                                    </td>
                                    <td class="py-8">
                                        @if($log->status === 'PENDING_RETURN')
                                            <form action="{{ route('admin.supplies.return', $log) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white px-4 py-2 rounded-xl text-[0.55rem] font-black uppercase tracking-widest italic border border-rose-100 shadow-sm transition-all flex items-center gap-2">
                                                    <i class="fas fa-undo text-[0.5rem]"></i> Devolver
                                                </button>
                                            </form>
                                        @elseif($log->status === 'RETURNED')
                                            <span class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-xl text-[0.55rem] font-black uppercase tracking-widest italic border border-emerald-100 shadow-sm">Reintegrado</span>
                                        @else
                                            <span class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl text-[0.55rem] font-black uppercase tracking-widest italic border border-indigo-100 shadow-sm">Completado</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Restock (Oculto por defecto) -->
<div id="restockModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-md">
    <div class="bg-white rounded-[3rem] p-12 max-w-md w-full shadow-2xl relative">
        <button onclick="document.getElementById('restockModal').classList.add('hidden')" class="absolute right-8 top-8 text-slate-300 hover:text-slate-950 transition-all text-2xl">×</button>
        <h3 class="text-3xl font-black text-slate-950 uppercase italic tracking-tighter mb-8">Reabastecer</h3>
        <form action="{{ route('admin.supplies.restock', $supply) }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Cantidad a Ingresar</label>
                <input type="number" name="quantity" value="1" min="1" required class="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-950 font-black text-xl text-center focus:border-emerald-500 outline-none">
            </div>
            <div class="space-y-2">
                <label class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest ml-2">Notas de Compra / Proveedor</label>
                <textarea name="notes" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent text-slate-900 text-sm outline-none" rows="3"></textarea>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-slate-950 text-white font-black py-6 rounded-2xl text-[0.7rem] uppercase tracking-widest transition-all italic shadow-2xl shadow-emerald-200">
                Confirmar Ingreso de Mercancía
            </button>
        </form>
    </div>
</div>
@endsection
