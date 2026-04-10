@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE CATALOGACIÓN -->
    <div class="mb-16 flex flex-col md:flex-row justify-between items-start md:items-end gap-10 border-b border-white/5 pb-10">
        <div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none">
                Sincronización de <span class="text-indigo-500">Nuevo Activo</span> patrimonial
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.6em] mt-4 flex items-center gap-3 italic leading-none">
                <i class="fas fa-barcode text-indigo-400"></i>
                Terminal de Registro Patrimonial • Gravity Inventory
            </p>
        </div>
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-slate-900 rounded-2xl border border-white/5 flex items-center justify-center text-slate-700 text-2xl font-black italic shadow-2xl">
                <i class="fas fa-microchip"></i>
            </div>
        </div>
    </div>

    <!-- FORMULARIO TÉCNICO -->
    <form action="{{ route('admin.inventory.store') }}" method="POST" class="max-w-7xl mx-auto">
        @csrf
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
            
            <!-- COLUMNA PRINCIPAL: ESPECIFICACIONES TÉCNICAS (2/3) -->
            <div class="xl:col-span-2 space-y-12">
                <div class="bg-slate-900/40 backdrop-blur-xl p-10 md:p-12 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-600/10 transition-all"></div>
                    
                    <div class="flex items-center gap-4 mb-12 relative z-10">
                        <div class="w-1.5 h-8 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></div>
                        <h2 class="text-[0.8rem] font-black text-white uppercase italic tracking-[0.3em]">Especificaciones del Hardware</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
                        <!-- Asset Tag -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within/in:text-indigo-400">Identificador Patrimonial (Tag)</label>
                            <input type="text" name="asset_tag" required
                                class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[1rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase tracking-tighter"
                                placeholder="MCHP-LP-000">
                        </div>

                        <!-- Tipo -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Segmento de Equipo</label>
                            <div class="relative">
                                <select name="type" required
                                    class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.8rem] focus:border-indigo-500 transition-all outline-none appearance-none italic uppercase tracking-widest custom-select">
                                    <option value="Laptop">💻 Laptop</option>
                                    <option value="Desktop">🖥️ Desktop</option>
                                    <option value="Monitor">📺 Monitor</option>
                                    <option value="Impresora">🖨️ Impresora</option>
                                    <option value="Smartphone">📱 Smartphone</option>
                                    <option value="Servidor">🗄️ Servidor</option>
                                    <option value="Otro">📦 Otro Segmento</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-800"></i>
                            </div>
                        </div>

                        <!-- Marca -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within/in:text-indigo-400">Fabricante / OEM</label>
                            <input type="text" name="brand" required
                                class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                                placeholder="DELL, APPLE, LENOVO...">
                        </div>

                        <!-- Modelo -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within/in:text-indigo-400">Modelo del Sistema</label>
                            <input type="text" name="model" required
                                class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                                placeholder="PRECISION 3581 M2 14">
                        </div>

                        <!-- Serial -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within/in:text-indigo-400">Número de Serie (S/N)</label>
                            <input type="text" name="serial_number" required
                                class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-indigo-400 font-mono font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase"
                                placeholder="SCN-9988-7766-XXA">
                        </div>

                        <!-- Entidad -->
                        <div class="space-y-3 group/in">
                            <label class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic">Entidad de Asignación</label>
                            <div class="relative">
                                <select name="entity" required
                                    class="w-full px-8 py-6 bg-indigo-500/10 border border-indigo-500/30 rounded-2xl text-white font-black text-[0.8rem] focus:border-indigo-500 transition-all outline-none appearance-none italic uppercase tracking-widest custom-select">
                                    <option value="IASD" class="bg-indigo-950">⛪ IASD - Iglesia Adventista</option>
                                    <option value="FESDG" class="bg-indigo-950">🎓 FESDG - Fundación Sanders</option>
                                </select>
                                <i class="fas fa-shield-alt absolute right-6 top-1/2 -translate-y-1/2 text-indigo-400/50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 border-l-[10px] border-indigo-600 p-10 rounded-[2.5rem] shadow-2xl flex items-start gap-8 relative overflow-hidden group">
                    <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-32 h-32 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
                    <div class="w-14 h-14 bg-indigo-600/20 rounded-2xl flex items-center justify-center text-indigo-500 shrink-0 shadow-inner">
                        <i class="fas fa-info-circle text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-black text-[0.7rem] uppercase tracking-[0.3em] mb-2 italic">Directiva de Auditoría</h4>
                        <p class="text-slate-500 text-[0.85rem] font-bold leading-relaxed italic uppercase tracking-tight">
                            VALIDE QUE EL <span class="text-indigo-400">ASSET TAG</span> COINCIDA CON LA MARQUEZA FÍSICA PARA GARANTIZAR LA INTEGRIDAD DEL INVENTARIO.
                        </p>
                    </div>
                </div>
            </div>

            <!-- COLUMNA LATERAL: CICLO DE VIDA Y ASIGNACIÓN (1/3) -->
            <div class="space-y-12">
                <!-- Estatus Operativo -->
                <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3.5rem] border border-white/5 shadow-3xl space-y-10 group">
                    <div class="flex items-center gap-4">
                        <div class="w-1.5 h-8 bg-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>
                        <h2 class="text-[0.7rem] font-black text-white uppercase italic tracking-widest leading-none pt-1">Vector de Estado</h2>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center gap-5 p-6 rounded-2xl border border-white/5 bg-slate-950 cursor-pointer hover:bg-emerald-600/10 hover:border-emerald-500/40 transition-all group/opt">
                            <input type="radio" name="status" value="Operativo" checked class="w-5 h-5 text-emerald-600 border-white/10 bg-slate-900 focus:ring-emerald-500 ring-offset-slate-950">
                            <div class="flex flex-col">
                                <span class="text-[0.8rem] font-black text-white uppercase italic leading-none">Activo Operativo</span>
                                <span class="text-[0.55rem] font-black text-slate-500 uppercase tracking-widest mt-2">Disponible para Sincronización</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-5 p-6 rounded-2xl border border-white/5 bg-slate-950 cursor-pointer hover:bg-amber-600/10 hover:border-amber-500/40 transition-all group/opt">
                            <input type="radio" name="status" value="En Reparación" class="w-5 h-5 text-amber-600 border-white/10 bg-slate-900 focus:ring-amber-500 ring-offset-slate-950">
                            <div class="flex flex-col">
                                <span class="text-[0.8rem] font-black text-white uppercase italic leading-none">Mantenimiento</span>
                                <span class="text-[0.55rem] font-black text-slate-500 uppercase tracking-widest mt-2">Protocolo de Reparación</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-8 border-t border-white/5 space-y-8">
                        <div class="space-y-3">
                            <label class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Ubicación Terminal</label>
                            <input type="text" name="location" required
                                class="w-full px-6 py-5 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.8rem] focus:border-indigo-500 transition-all italic uppercase"
                                placeholder="ALMACÉN TI • OFICINA 402">
                        </div>
                        
                        <div class="space-y-3">
                            <label class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic">Inversión Institucional ($)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="purchase_cost" value="0.00" required
                                    class="w-full px-8 py-6 bg-slate-950 border border-indigo-500/20 rounded-3xl text-white font-black focus:border-indigo-500 transition-all text-xl italic shadow-2xl tracking-tighter">
                                <i class="fas fa-dollar-sign absolute right-8 top-1/2 -translate-y-1/2 text-indigo-500/50"></i>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest italic leading-none px-1">Adquisición</label>
                                <input type="date" name="purchased_at"
                                    class="w-full px-4 py-4 bg-slate-950 border border-white/5 rounded-xl text-white font-black text-[0.7rem] focus:border-indigo-500 transition-all italic">
                            </div>
                            <div class="space-y-3">
                                <label class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest italic leading-none px-1">Próx. Revisión</label>
                                <input type="date" name="next_maintenance_at"
                                    value="{{ now()->addMonths(6)->format('Y-m-d') }}"
                                    class="w-full px-4 py-4 bg-slate-950 border border-indigo-500/10 rounded-xl text-indigo-400 font-black text-[0.7rem] focus:border-indigo-500 transition-all italic">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloque de Acción Final -->
                <div class="bg-indigo-600 p-12 rounded-[3.5rem] shadow-3xl text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 w-40 h-40 bg-white/10 rounded-full scale-110 group-hover:scale-150 transition-all duration-1000"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-1.5 h-8 bg-white rounded-full"></div>
                            <h2 class="text-[0.8rem] font-black text-white uppercase italic tracking-[0.3em] leading-none pt-1">Responsable</h2>
                        </div>
                        
                        <div class="space-y-4 mb-12">
                            <select name="user_id" id="user_id"
                                class="w-full px-6 py-5 bg-white/10 border border-white/20 rounded-2xl text-white font-black text-[0.75rem] focus:ring-2 focus:ring-white transition-all appearance-none uppercase italic tracking-tighter">
                                <option value="" class="bg-indigo-950">SIN ASIGNAR (STORAGE)</option>
                                @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                    <option value="{{ $user->id }}" class="bg-indigo-950">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-white text-indigo-600 font-black py-8 rounded-[2rem] hover:bg-slate-900 hover:text-white transition-all shadow-3xl uppercase tracking-[0.4em] italic text-[0.75rem]">
                            Confirmar Sincronización
                        </button>
                        
                        <a href="{{ route('admin.inventory.index') }}" 
                           class="block text-center mt-10 text-white/40 hover:text-white font-black uppercase tracking-[0.2em] text-[0.6rem] transition-colors italic">
                            <i class="fas fa-arrow-left mr-2"></i> Abortar y volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
