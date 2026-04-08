@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">
    <!-- Header Estratégico -->
    <div class="mb-12 flex justify-between items-end">
        <div>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-600 text-[0.6rem] font-black uppercase tracking-[0.2em] rounded-md italic mb-4 inline-block">Update Record</span>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                Editar <span class="text-indigo-600">Activo</span>
            </h1>
            <p class="text-slate-500 font-medium tracking-tight mt-3 text-sm italic border-l-4 border-indigo-500 pl-4">Modificando: {{ $item->asset_tag }} ({{ $item->brand }} {{ $item->model }})</p>
        </div>
        <div class="hidden md:block text-right">
             <span class="text-[0.6rem] font-black text-slate-300 uppercase tracking-widest block mb-1">Last Update</span>
             <span class="text-xs font-bold text-slate-400 uppercase italic">{{ $item->updated_at->format('d M, Y H:i') }}</span>
        </div>
    </div>

    <!-- Formulario de Alto Impacto -->
    <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Columna de Datos Técnicos (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 transition-all hover:shadow-indigo-100/30">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Información del Dispositivo</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Tag de Activo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Asset Tag (ID Único)</label>
                            <input type="text" name="asset_tag" value="{{ $item->asset_tag }}" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all">
                        </div>

                        <!-- Tipo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Categoría</label>
                            <select name="type" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all">
                                <option value="Laptop" {{ $item->type == 'Laptop' ? 'selected' : '' }}>💻 Laptop</option>
                                <option value="Desktop" {{ $item->type == 'Desktop' ? 'selected' : '' }}>🖥️ Desktop</option>
                                <option value="Monitor" {{ $item->type == 'Monitor' ? 'selected' : '' }}>📺 Monitor</option>
                                <option value="Impresora" {{ $item->type == 'Impresora' ? 'selected' : '' }}>🖨️ Impresora</option>
                                <option value="Smartphone" {{ $item->type == 'Smartphone' ? 'selected' : '' }}>📱 Smartphone</option>
                                <option value="Servidor" {{ $item->type == 'Servidor' ? 'selected' : '' }}>🗄️ Servidor</option>
                                <option value="Otro" {{ $item->type == 'Otro' ? 'selected' : '' }}>📦 Otro</option>
                            </select>
                        </div>

                        <!-- Marca -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Marca / Fabricante</label>
                            <input type="text" name="brand" value="{{ $item->brand }}" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all">
                        </div>

                        <!-- Modelo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Modelo Específidco</label>
                            <input type="text" name="model" value="{{ $item->model }}" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all">
                        </div>

                        <!-- Serial -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Número de Serie (S/N)</label>
                            <input type="text" name="serial_number" value="{{ $item->serial_number }}" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-mono font-bold focus:border-indigo-500 focus:bg-white transition-all">
                        </div>

                        <!-- Entidad Legal -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-indigo-600 uppercase tracking-widest ml-1">Entidad Perteneciente</label>
                            <select name="entity" required
                                class="w-full px-6 py-5 bg-indigo-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all appearance-none">
                                <option value="IASD" {{ $item->entity == 'IASD' ? 'selected' : '' }}>⛪ IASD - Iglesia Adventista</option>
                                <option value="FESDG" {{ $item->entity == 'FESDG' ? 'selected' : '' }}>🎓 FESDG - Fundación Sanders</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-950 p-10 rounded-[2.5rem] shadow-2xl shadow-indigo-200 text-white relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="w-24 h-24 bg-white/10 rounded-3xl flex items-center justify-center text-4xl shadow-inner border border-white/10 shrink-0">
                            {{ match($item->type) { 'Laptop' => '💻', 'Desktop' => '🖥️', 'Monitor' => '📺', 'Impresora' => '🖨️', 'Smartphone' => '📱', 'Servidor' => '🗄️', default => '📦' } }}
                        </div>
                        <div>
                            <h3 class="text-xl font-black italic uppercase tracking-tighter mb-1">Modo Edición Activo</h3>
                            <p class="text-indigo-200/60 text-xs font-bold uppercase tracking-widest leading-relaxed italic">
                                Cualquier cambio realizado afectará los reportes de inventario y la asignación del usuario inmediatamente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral: Estado y Asignación (1/3) -->
            <div class="space-y-8">
                <!-- Estado Operativo -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Estatus Actual</h2>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 {{ $item->status == 'Operativo' ? 'border-emerald-200 bg-emerald-50' : 'border-slate-50 bg-slate-50' }} cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 transition-all group">
                            <input type="radio" name="status" value="Operativo" {{ $item->status == 'Operativo' ? 'checked' : '' }} class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <div class="flex flex-col">
                                <span class="text-[0.7rem] font-black text-slate-900 uppercase italic">Operativo</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest">Listo para usar</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 {{ $item->status == 'En Reparación' ? 'border-amber-200 bg-amber-50' : 'border-slate-50 bg-slate-50' }} cursor-pointer hover:bg-amber-50 hover:border-amber-200 transition-all group">
                            <input type="radio" name="status" value="En Reparación" {{ $item->status == 'En Reparación' ? 'checked' : '' }} class="w-5 h-5 text-amber-600 border-slate-300 focus:ring-amber-500">
                            <div class="flex flex-col">
                                <span class="text-[0.7rem] font-black text-slate-900 uppercase italic">Reparación</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest">Mantenimiento</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 {{ $item->status == 'De Baja' ? 'border-rose-200 bg-rose-50' : 'border-slate-50 bg-slate-50' }} cursor-pointer hover:bg-rose-50 hover:border-rose-200 transition-all group">
                            <input type="radio" name="status" value="De Baja" {{ $item->status == 'De Baja' ? 'checked' : '' }} class="w-5 h-5 text-rose-600 border-slate-300 focus:ring-rose-500">
                            <div class="flex flex-col">
                                <span class="text-[0.7rem] font-black text-slate-900 uppercase italic">De Baja</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest">Fuera de servicio</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Ubicación Física</label>
                            <input type="text" name="location" value="{{ $item->location }}" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all italic">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-indigo-600 uppercase tracking-widest ml-1">Costo de Adquisición ($)</label>
                            <input type="number" step="0.01" name="purchase_cost" value="{{ $item->purchase_cost }}" required
                                class="w-full px-6 py-5 bg-indigo-50 border-2 border-transparent rounded-2xl text-slate-900 font-black focus:border-indigo-500 focus:bg-white transition-all text-xl italic shadow-inner">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Fecha de Compra</label>
                            <input type="date" name="purchased_at" value="{{ $item->purchased_at ? $item->purchased_at->format('Y-m-d') : '' }}"
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all uppercase italic">
                        </div>

                    </div>
                </div>

                <!-- Mantenimiento Preventivo ✨ -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                        <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Mantenimiento</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Último Mantenimiento</label>
                            <input type="date" name="last_maintenance_at" value="{{ $item->last_maintenance_at ? $item->last_maintenance_at->format('Y-m-d') : '' }}"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all italic">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Próximo Mantenimiento</label>
                            <input type="date" name="next_maintenance_at" value="{{ $item->next_maintenance_at ? $item->next_maintenance_at->format('Y-m-d') : '' }}"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all italic">
                        </div>
                    </div>
                </div>

                <!-- Asignación -->
                <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-200 text-white relative overflow-hidden">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full scale-150"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-2 h-6 bg-white rounded-full"></div>
                            <h2 class="text-sm font-black uppercase italic tracking-widest">Asignación</h2>
                        </div>
                        
                        <div class="space-y-4">
                            <p class="text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Persona Responsable</p>
                            <select name="user_id"
                                class="w-full px-5 py-4 bg-white/10 border-none rounded-xl text-white font-bold focus:ring-2 focus:ring-white transition-all appearance-none cursor-pointer">
                                <option value="" class="text-slate-900">SIN ASIGNAR (DISPONIBLE)</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ $item->user_id == $user->id ? 'selected' : '' }} class="text-slate-900">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-10 flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-white text-indigo-600 font-black py-5 rounded-2xl hover:bg-slate-50 transition-all shadow-xl uppercase tracking-widest italic text-xs">
                                Guardar Cambios
                            </button>
                        </div>
                        <a href="{{ route('admin.inventory.index') }}" 
                           class="block text-center mt-6 text-white/50 hover:text-white font-bold uppercase tracking-widest text-[0.6rem] transition-colors italic">
                            ← Cancelar y Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- SECCIÓN DE HISTORIAL / AUDITORÍA ✨ -->
    <div class="mt-20 bg-slate-950 p-10 md:p-14 rounded-[3.5rem] shadow-2xl relative overflow-hidden border border-white/5">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 mb-16">
            <div>
                <span class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.3em] italic mb-3 inline-block">Asset Lifecycle & Audit</span>
                <h2 class="text-4xl font-black text-white italic tracking-tighter uppercase leading-none">Historial de <span class="text-indigo-400">Transacciones</span></h2>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2 border-l border-white/20 pl-4 italic">Registro inmutable de trazabilidad técnica para el equipo TI</p>
            </div>
            <div class="flex items-center gap-3 bg-white/5 px-8 py-5 rounded-3xl border border-white/5 shadow-inner">
                <div class="w-3 h-3 bg-emerald-400 rounded-full animate-pulse shadow-[0_0_15px_rgba(52,211,153,0.5)]"></div>
                <span class="text-[0.65rem] font-black text-slate-300 uppercase tracking-widest italic">Sistema Sincronizado</span>
            </div>
        </div>

        <div class="space-y-8 relative">
            <!-- Línea de tiempo vertical decorativa -->
            <div class="absolute left-10 md:left-14 top-10 bottom-10 w-[1px] bg-gradient-to-b from-indigo-500/0 via-indigo-500/20 to-indigo-500/0 hidden md:block"></div>

            @forelse($item->logs as $log)
                <div class="group bg-white/5 hover:bg-white/10 p-8 md:p-12 rounded-[2.5rem] border border-white/5 transition-all space-y-8 relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ match($log->action) { 'CREATE' => 'bg-emerald-500', 'UPDATE' => 'bg-amber-500', default => 'bg-indigo-500' } }} opacity-50"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-white/5">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl shrink-0 {{ match($log->action) { 'CREATE' => 'bg-emerald-500/20 text-emerald-400', 'UPDATE' => 'bg-amber-500/20 text-amber-400', default => 'bg-indigo-500/20 text-indigo-400' } }}">
                                {{ match($log->action) { 'CREATE' => '✨', 'UPDATE' => '🔄', 'ASSIGN' => '👤', default => '📋' } }}
                            </div>
                            <div>
                                <h4 class="text-white font-black text-base italic uppercase tracking-tighter">{{ $log->details }}</h4>
                                <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest italic mt-1">Operador: <span class="text-indigo-400">{{ $log->user->name }}</span></p>
                            </div>
                        </div>
                        <div class="bg-slate-900 border border-white/10 px-6 py-3 rounded-2xl flex flex-col items-center shrink-0">
                            <span class="text-[0.5rem] font-black text-slate-500 uppercase tracking-widest mb-1">Gravity Timestamp</span>
                            <span class="text-[0.7rem] font-black text-slate-300 uppercase tracking-widest italic">{{ $log->created_at->format('d M, Y • H:i:s') }}</span>
                        </div>
                    </div>

                    @if($log->action == 'UPDATE')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                        <div class="bg-rose-500/5 p-6 rounded-3xl border border-rose-500/10 hover:border-rose-500/20 transition-all">
                            <p class="text-[0.6rem] font-black text-rose-500/60 uppercase tracking-[0.2em] mb-4 italic flex items-center gap-2">
                                <span class="w-2 h-2 bg-rose-500 rounded-full"></span> VALOR REEMPLAZADO
                            </p>
                            <div class="space-y-3">
                                @php $hasOld = false; @endphp
                                @if(is_array($log->old_data))
                                @foreach($log->old_data as $key => $value)
                                    @if(isset($log->new_data[$key]) && $log->new_data[$key] != $value && in_array($key, ['asset_tag', 'brand', 'model', 'serial_number', 'status', 'location', 'user_id', 'purchase_cost']))
                                        @php $hasOld = true; @endphp
                                        <div class="flex items-center justify-between border-b border-white/5 pb-2 last:border-0 last:pb-0">
                                            <span class="text-[0.6rem] text-slate-600 font-black uppercase italic">{{ str_replace('_', ' ', $key) }}:</span>
                                            <span class="text-[0.7rem] text-slate-400 font-bold line-through ml-4 italic">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                @endforeach
                                @endif
                                @if(!$hasOld) <p class="text-[0.62rem] text-slate-700 italic">Sin cambios críticos.</p> @endif
                            </div>
                        </div>

                        <div class="bg-emerald-500/5 p-6 rounded-3xl border border-emerald-500/10 hover:border-emerald-500/20 transition-all shadow-[0_0_30px_rgba(52,211,153,0.03)]">
                            <p class="text-[0.6rem] font-black text-emerald-400 uppercase tracking-[0.2em] mb-4 italic flex items-center gap-2">
                                <span class="w-2 h-2 bg-emerald-400 rounded-full shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span> NUEVA CONFIGURACIÓN
                            </p>
                            <div class="space-y-3">
                                @php $hasNew = false; @endphp
                                @if(is_array($log->new_data))
                                @foreach($log->new_data as $key => $value)
                                    @if(isset($log->old_data[$key]) && $log->old_data[$key] != $value && in_array($key, ['asset_tag', 'brand', 'model', 'serial_number', 'status', 'location', 'user_id', 'purchase_cost']))
                                        @php $hasNew = true; @endphp
                                        <div class="flex items-center justify-between border-b border-white/5 pb-2 last:border-0 last:pb-0">
                                            <span class="text-[0.6rem] text-indigo-400 font-black uppercase italic">{{ str_replace('_', ' ', $key) }}:</span>
                                            <span class="text-[0.75rem] text-white font-black ml-4 italic">{{ $value ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                @endforeach
                                @endif
                                @if(!$hasNew) <p class="text-[0.62rem] text-slate-700 italic">Sin cambios en la estructura.</p> @endif
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="bg-indigo-500/5 p-8 rounded-3xl border border-indigo-500/10 flex items-center gap-6">
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-xl">📄</div>
                            <div>
                                <p class="text-[0.65rem] text-slate-300 font-black uppercase italic tracking-widest">Snapshot del Activo</p>
                                <p class="text-[0.55rem] text-slate-500 font-bold uppercase tracking-widest mt-1 italic">Registro inicial almacenado correctamente.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-24 bg-white/5 rounded-[3rem] border border-dashed border-white/10 relative group hover:border-indigo-500/30 transition-all">
                    <div class="absolute inset-0 bg-indigo-500/5 blur-3xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="text-6xl block mb-8 transition-transform group-hover:scale-125 group-hover:rotate-12 duration-700">📜</span>
                    <h3 class="text-white font-black text-lg uppercase italic tracking-tighter mb-2">Libro de Auditoría Vacío</h3>
                    <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.2em] italic leading-loose max-w-sm mx-auto">Cualquier modificación técnica futura en este activo será grabada de forma inmutable en este módulo.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
