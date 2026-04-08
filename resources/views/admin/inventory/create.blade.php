@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-12 px-6">
    <!-- Header Estratégico -->
    <div class="mb-12 flex justify-between items-end">
        <div>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-600 text-[0.6rem] font-black uppercase tracking-[0.2em] rounded-md italic mb-4 inline-block">New Registration</span>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">
                Nuevo <span class="text-indigo-600">Activo</span>
            </h1>
            <p class="text-slate-500 font-medium tracking-tight mt-3 text-sm">Ingreso de equipamiento para el control patrimonial de la institución.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-16 h-16 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-300 text-2xl font-black italic">
                #
            </div>
        </div>
    </div>

    <!-- Formulario de Alto Impacto -->
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Columna de Datos Técnicos (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-6 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Información del Dispositivo</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Tag de Activo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Asset Tag (ID Único)</label>
                            <input type="text" name="asset_tag" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                placeholder="MCHP-LP-001">
                        </div>

                        <!-- Tipo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Categoría</label>
                            <select name="type" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all">
                                <option value="Laptop">💻 Laptop</option>
                                <option value="Desktop">🖥️ Desktop</option>
                                <option value="Monitor">📺 Monitor</option>
                                <option value="Impresora">🖨️ Impresora</option>
                                <option value="Smartphone">📱 Smartphone</option>
                                <option value="Servidor">🗄️ Servidor</option>
                                <option value="Otro">📦 Otro</option>
                            </select>
                        </div>

                        <!-- Marca -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Marca / Fabricante</label>
                            <input type="text" name="brand" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                placeholder="Dell, Apple, Lenovo...">
                        </div>

                        <!-- Modelo -->
                        <div class="space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Modelo Específidco</label>
                            <input type="text" name="model" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                placeholder="Ej: MacBook Pro M2 14">
                        </div>

                        <!-- Serial -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Número de Serie (S/N)</label>
                            <input type="text" name="serial_number" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-mono font-bold focus:border-indigo-500 focus:bg-white transition-all placeholder:text-slate-300"
                                placeholder="SCN-9988-7766-XXA">
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-50 p-8 rounded-[2.5rem] border border-indigo-100 flex items-start gap-5">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-indigo-900 font-black text-xs uppercase tracking-widest mb-1 italic">Dato Importante</h4>
                        <p class="text-indigo-700/70 text-sm font-medium leading-relaxed italic">
                            Asegúrate de que el **Asset Tag** coincida con la etiqueta física pegada en el dispositivo para una auditoría rápida.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Columna Lateral: Estado y Asignación (1/3) -->
            <div class="space-y-8">
                <!-- Estado Operativo -->
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        <h2 class="text-sm font-black text-slate-900 uppercase italic tracking-widest">Estatus</h2>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 transition-all group">
                            <input type="radio" name="status" value="Operativo" checked class="w-5 h-5 text-emerald-600 border-slate-300 focus:ring-emerald-500">
                            <div class="flex flex-col">
                                <span class="text-[0.7rem] font-black text-slate-900 uppercase italic">Operativo</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest">Listo para usar</span>
                            </div>
                        </label>

                        <label class="flex items-center gap-4 p-4 rounded-2xl border-2 border-slate-50 bg-slate-50 cursor-pointer hover:bg-amber-50 hover:border-amber-200 transition-all group">
                            <input type="radio" name="status" value="En Reparación" class="w-5 h-5 text-amber-600 border-slate-300 focus:ring-amber-500">
                            <div class="flex flex-col">
                                <span class="text-[0.7rem] font-black text-slate-900 uppercase italic">Reparación</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest">Mantenimiento</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div>
                            <label class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest ml-1">Ubicación Física</label>
                            <input type="text" name="location" required
                                class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-2xl text-slate-900 font-bold focus:border-indigo-500 focus:bg-white transition-all italic"
                                placeholder="Ej: Almacén TI">
                        </div>
                        
                        <div class="pt-6 border-t border-slate-100 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[0.65rem] font-black text-indigo-600 uppercase tracking-widest ml-1">Costo de Adquisición ($)</label>
                                <input type="number" step="0.01" name="purchase_cost" value="0.00" required
                                    class="w-full px-6 py-5 bg-indigo-50/50 border-2 border-transparent rounded-2xl text-slate-900 font-black focus:border-indigo-500 focus:bg-white transition-all text-xl italic shadow-inner">
                            </div>
                            
                            <div class="pt-6 border-t border-slate-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-1.5 h-4 bg-indigo-400 rounded-full"></div>
                                    <h2 class="text-[0.6rem] font-black text-slate-400 uppercase italic tracking-widest">Ciclo Preventivo</h2>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[0.65rem] font-black text-indigo-600 uppercase tracking-widest ml-1">Próxima Revisión Sugerida</label>
                                    <input type="date" name="next_maintenance_at"
                                        value="{{ now()->addMonths(6)->format('Y-m-d') }}"
                                        class="w-full px-6 py-5 bg-indigo-50/50 border-2 border-transparent rounded-2xl text-slate-900 font-black focus:border-indigo-500 focus:bg-white transition-all uppercase italic">
                                </div>
                            </div>
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
                                class="w-full px-5 py-4 bg-white/10 border-none rounded-xl text-white font-bold focus:ring-2 focus:ring-white transition-all appearance-none">
                                <option value="" class="text-slate-900">SIN ASIGNAR (DISPONIBLE)</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" class="text-slate-900">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-10 flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-white text-indigo-600 font-black py-5 rounded-2xl hover:bg-slate-50 transition-all shadow-xl uppercase tracking-widest italic text-xs">
                                Confirmar Registro
                            </button>
                        </div>
                        <a href="{{ route('admin.inventory.index') }}" 
                           class="block text-center mt-6 text-white/50 hover:text-white font-bold uppercase tracking-widest text-[0.6rem] transition-colors italic">
                            ← Volver al Inventario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
