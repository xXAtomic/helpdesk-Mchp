@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE GESTIÓN DE SUMINISTROS -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-8">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <span class="px-4 py-1.5 bg-indigo-600/10 text-indigo-400 text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-xl border border-indigo-500/20 italic shadow-2xl">
                    Asset Module: #{{ $supply->id }}
                </span>
                <span class="px-4 py-1.5 bg-slate-900 text-slate-500 text-[0.6rem] font-black uppercase tracking-[0.3em] rounded-xl border border-white/5 italic">
                    {{ $supply->type }}
                </span>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none truncate max-w-2xl">
                {{ $supply->name }}
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] mt-4 flex items-center gap-3 italic">
                <i class="fas fa-industry text-indigo-400"></i>
                Marca / Fabricante: <span class="text-white">{{ $supply->brand ?? 'PROTOCOLO OEM' }}</span>
            </p>
        </div>
        
        <div class="flex gap-4">
            <a href="{{ route('admin.supplies.index') }}" class="px-8 py-4 bg-slate-900 text-slate-500 hover:text-white transition-all rounded-2xl text-[0.6rem] font-black uppercase tracking-[0.3em] border border-white/5 italic flex items-center gap-3 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-2 transition-transform"></i>
                Terminal
            </a>
            <a href="{{ route('admin.supplies.edit', $supply) }}" class="px-8 py-4 bg-white text-slate-950 hover:bg-indigo-600 hover:text-white transition-all rounded-2xl text-[0.6rem] font-black uppercase tracking-[0.3em] italic flex items-center gap-3">
                <i class="fas fa-edit"></i>
                Editar Ficha
            </a>
        </div>
    </div>

    <!-- DASHBOARD DE SUMINISTRO -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- ESTADO DE DISPONIBILIDAD Y MOVIMIENTO -->
        <div class="lg:col-span-1 space-y-12">
            
            <!-- CONTADOR DE STOCK NEÓN -->
            <div class="bg-slate-900 border border-white/5 rounded-[3.5rem] p-12 shadow-3xl relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all duration-1000"></div>
                <div class="relative z-10 text-center">
                    <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] italic mb-8">Unidades Sincronizadas</p>
                    <h2 class="text-9xl font-black text-white tracking-widest italic drop-shadow-[0_0_30px_rgba(255,255,255,0.1)] group-hover:scale-110 transition-transform duration-700">{{ $supply->stock }}</h2>
                    <div class="mt-10 flex items-center justify-center">
                        @if($supply->isLowStock())
                            <span class="px-6 py-2 bg-rose-600/20 text-rose-500 text-[0.6rem] font-black rounded-2xl uppercase tracking-[0.3em] border border-rose-500/30 animate-pulse italic">Nivel Crítico de Almacén</span>
                        @else
                            <span class="px-6 py-2 bg-emerald-600/20 text-emerald-500 text-[0.6rem] font-black rounded-2xl uppercase tracking-[0.3em] border border-emerald-500/30 italic">Stock Operativo Normal</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- REGISTRO DE DESPACHO (FORMULARIO TÁCTICO) -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-3xl">
                <h3 class="text-[0.7rem] font-black text-white uppercase italic tracking-[0.4em] mb-10 flex items-center gap-4">
                    <i class="fas fa-shipping-fast text-indigo-500"></i>
                    Protocolo de Entrega
                </h3>
                <form action="{{ route('admin.supplies.dispatch', $supply) }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.4em] ml-2 italic leading-none">Endpoint Receptor (Usuario)</label>
                        <select name="user_id" required class="w-full px-6 py-5 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.7rem] focus:border-indigo-500 outline-none uppercase italic custom-select">
                            <option value="">SELECCIONAR...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.4em] ml-2 italic leading-none">Magnitud</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $supply->stock }}" required class="w-full px-6 py-5 rounded-2xl bg-slate-950 border border-white/5 text-indigo-400 font-black text-xl text-center outline-none italic tracking-tighter">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.4em] ml-2 italic leading-none">Tipo</label>
                            <select name="action" required class="w-full px-6 py-5 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.7rem] focus:border-indigo-500 outline-none uppercase italic custom-select">
                                <option value="CONSUMPTION">Consumo</option>
                                <option value="LOAN">Préstamo</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.4em] ml-2 italic leading-none">ID Equipo Destino (Opcional)</label>
                        <input type="text" name="equipment_tag" placeholder="EJ: PC-ADM-01" class="w-full px-6 py-5 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.7rem] outline-none uppercase italic tracking-widest">
                    </div>

                    <button type="submit" class="w-full bg-white text-slate-950 hover:bg-indigo-600 hover:text-white font-black py-6 rounded-2xl text-[0.7rem] uppercase tracking-[0.3em] transition-all italic shadow-3xl group">
                        Confirmar Transacción 🚀
                    </button>
                </form>
            </div>

            <button onclick="document.getElementById('restockModal').classList.toggle('hidden')" class="w-full bg-slate-950/50 hover:bg-emerald-600/10 text-slate-500 hover:text-emerald-500 font-black py-6 rounded-[2rem] text-[0.65rem] uppercase tracking-[0.4em] transition-all italic flex items-center justify-center gap-4 border border-white/5 shadow-2xl group">
                <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform"></i> Reabastecer Terminal
            </button>

        </div>

        <!-- HISTORIAL DE LOGÍSTICA TECTÓNICA -->
        <div class="lg:col-span-2 space-y-12">
            
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-[3.5rem] border border-white/5 p-10 md:p-12 shadow-3xl relative overflow-hidden group">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h3 class="text-[0.8rem] font-black text-white uppercase italic tracking-[0.5em] leading-none mb-3">Trazabilidad de Movimientos</h3>
                        <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.3em] italic">Bitácora de fluctuación de stock auditable</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="py-6 text-[0.55rem] font-black text-slate-700 uppercase tracking-[0.3em] italic">Temporal</th>
                                <th class="py-6 text-[0.55rem] font-black text-slate-700 uppercase tracking-[0.3em] italic text-center">Acción</th>
                                <th class="py-6 text-[0.55rem] font-black text-slate-700 uppercase tracking-[0.3em] italic text-center">Escala</th>
                                <th class="py-6 text-[0.55rem] font-black text-slate-700 uppercase tracking-[0.3em] italic">Agente Receptor</th>
                                <th class="py-6 text-[0.55rem] font-black text-slate-700 uppercase tracking-[0.3em] italic text-right">Estatus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($supply->logs as $log)
                                <tr class="group/tr hover:bg-white/5 transition-all">
                                    <td class="py-8">
                                        <p class="text-[0.8rem] font-black text-white italic leading-none">{{ $log->created_at->format('d M / Y') }}</p>
                                        <p class="text-[0.55rem] text-slate-600 font-black uppercase tracking-[0.2em] mt-2 italic">{{ $log->created_at->format('H:i') }} Z</p>
                                    </td>
                                    <td class="py-8">
                                        <div class="flex items-center justify-center gap-3">
                                            @switch($log->action)
                                                @case('RESTOCK')
                                                    <span class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs border border-emerald-500/20 shadow-lg shadow-emerald-500/10 animate-pulse"><i class="fas fa-level-up-alt"></i></span>
                                                    @break
                                                @case('CONSUMPTION')
                                                    <span class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center text-xs border border-indigo-500/20"><i class="fas fa-level-down-alt"></i></span>
                                                    @break
                                                @case('LOAN')
                                                    <span class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center text-xs border border-blue-500/20"><i class="fas fa-handshake"></i></span>
                                                    @break
                                            @endswitch
                                        </div>
                                    </td>
                                    <td class="py-8 text-center">
                                        <p class="text-xl font-black {{ $log->action === 'RESTOCK' ? 'text-emerald-500' : 'text-slate-400' }} tracking-tighter italic">
                                            {{ $log->action === 'RESTOCK' ? '+' : '-' }}{{ $log->quantity }}
                                        </p>
                                    </td>
                                    <td class="py-8">
                                        @if($log->user)
                                            <p class="text-[0.7rem] font-black text-white uppercase tracking-tighter leading-none italic group-hover/tr:text-indigo-400 transition-colors">{{ $log->user->name }}</p>
                                            <p class="text-[0.5rem] font-black text-slate-700 uppercase tracking-widest mt-1 italic">Entidad de Destino</p>
                                        @else
                                            <p class="text-[0.7rem] font-black text-white uppercase tracking-tighter leading-none italic">{{ $log->admin->name }}</p>
                                            <p class="text-[0.5rem] font-black text-slate-700 uppercase tracking-widest mt-1 italic">Operador Admin</p>
                                        @endif
                                    </td>
                                    <td class="py-8 text-right">
                                        @if($log->status === 'PENDING_RETURN')
                                            <form action="{{ route('admin.supplies.return', $log) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-rose-500 hover:bg-white text-white hover:text-slate-950 px-5 py-2 rounded-xl text-[0.5rem] font-black uppercase tracking-widest italic border border-rose-500/30 transition-all flex items-center gap-2 ml-auto shadow-2xl">
                                                    DEVOLVER
                                                </button>
                                            </form>
                                        @elseif($log->status === 'RETURNED')
                                            <span class="bg-emerald-500/10 text-emerald-500 px-4 py-2 rounded-xl text-[0.5rem] font-black uppercase tracking-widest italic border border-emerald-500/20 shadow-lg">REINTEGRADO</span>
                                        @else
                                            <span class="bg-indigo-500/10 text-slate-500 px-4 py-2 rounded-xl text-[0.5rem] font-black uppercase tracking-widest italic border border-white/5">COMPLETADO</span>
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

<!-- Modal Restock (Dark Glass) -->
<div id="restockModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/90 backdrop-blur-xl animate-in fade-in duration-300">
    <div class="bg-slate-900 border border-white/10 rounded-[3.5rem] p-12 max-w-md w-full shadow-3xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-600/5 rounded-full blur-3xl"></div>
        <button onclick="document.getElementById('restockModal').classList.add('hidden')" class="absolute right-10 top-10 text-slate-600 hover:text-white transition-all text-xl hover:rotate-90">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-10 flex items-center gap-4 group">
             <i class="fas fa-plus-circle text-emerald-500"></i>
             Reabastecer
        </h3>
        <form action="{{ route('admin.supplies.restock', $supply) }}" method="POST" class="space-y-8 relative z-10">
            @csrf
            <div class="space-y-3">
                <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Magnitud de Ingreso</label>
                <input type="number" name="quantity" value="1" min="1" required class="w-full px-8 py-6 rounded-[2rem] bg-slate-950 border border-white/5 text-emerald-500 font-black text-3xl text-center focus:border-emerald-600 outline-none italic tracking-tighter shadow-2xl">
            </div>
            <div class="space-y-3">
                <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Bitácora de Suministro</label>
                <textarea name="notes" placeholder="REFERENCIA DE COMPRA O FACTURACIÓN..." class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-slate-400 text-[0.7rem] outline-none italic uppercase font-black" rows="3"></textarea>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-white text-white hover:text-slate-950 font-black py-8 rounded-[2rem] text-[0.75rem] uppercase tracking-[0.4em] transition-all italic shadow-[0_0_30px_rgba(16,185,129,0.2)] group">
                CONFIRMAR SINCRONIZACIÓN DE STOCK
            </button>
        </form>
    </div>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
