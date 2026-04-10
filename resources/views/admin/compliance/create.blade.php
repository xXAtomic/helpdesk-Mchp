@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE PROTOCOLOS LEGALES -->
    <div class="mb-16 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Redacción de <span class="text-indigo-500">Nueva Directiva</span> Legal
            </h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic">
                <i class="fas fa-file-contract text-indigo-400"></i>
                Terminal de Cumplimiento Normativo • Gravity Compliance
            </p>
        </div>
        <a href="{{ route('admin.compliance.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Abortar Protocolo
        </a>
    </div>

    <!-- PANEL DE REDACCIÓN (GLASSMORPHISM) -->
    <div class="max-w-5xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
        
        <form action="{{ route('admin.compliance.store') }}" method="POST" class="space-y-12 relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Título del Documento -->
                <div class="md:col-span-2 space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Título de la Directiva</label>
                    <input type="text" name="title" required placeholder="EJ: ACUERDO DE RESPONSABILIDAD DE EQUIPOS"
                           class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[1rem] focus:border-indigo-500 transition-all outline-none italic uppercase tracking-tighter">
                </div>

                <!-- Versión -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Versión Protocolo</label>
                    <input type="text" name="version" value="1.0" placeholder="1.0"
                           class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-indigo-400 font-black text-[1rem] focus:border-indigo-500 transition-all outline-none text-center">
                </div>
            </div>

            <!-- Switch Táctico de Activos -->
            <div class="flex items-center gap-6 p-8 bg-slate-950 rounded-[2rem] border border-white/5 group/sw">
                <div class="w-12 h-12 rounded-xl bg-slate-900 flex items-center justify-center text-slate-700 group-hover/sw:text-indigo-500 transition-colors">
                    <i class="fas fa-link text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-[0.65rem] font-black text-white uppercase italic tracking-widest leading-none">Vinculación Obligatoria</p>
                    <p class="text-[0.5rem] font-black text-slate-600 uppercase tracking-widest mt-2 italic leading-none">Solicitar ID de equipo al recolectar firma</p>
                </div>
                <label class="relative cursor-pointer">
                    <input type="checkbox" name="requires_asset" value="1" class="sr-only peer">
                    <div class="w-14 h-8 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all shadow-inner"></div>
                </label>
            </div>

            <!-- Cuerpo del Documento (Terminal de Escritura) -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400">Contenido Legal (Template Base)</label>
                <textarea name="content" rows="18" required placeholder="REDACTA AQUÍ LOS TÉRMINOS Y CONDICIONES DEL PROTOCOLO..."
                          class="w-full px-10 py-10 rounded-[2.5rem] bg-slate-950 border border-white/5 text-slate-400 font-medium text-[0.9rem] focus:border-indigo-500 transition-all outline-none leading-relaxed italic uppercase tracking-tighter shadow-inner"></textarea>
            </div>

            <div class="flex justify-end gap-8 pt-10">
                <a href="{{ route('admin.compliance.index') }}" class="px-10 py-6 rounded-2xl text-[0.6rem] font-black uppercase text-slate-600 hover:text-white transition-all italic tracking-[0.3em]">Ignorar Cambios</a>
                <button type="submit" class="bg-white text-slate-950 px-16 py-6 rounded-2xl font-black text-[0.7rem] uppercase tracking-[0.4em] hover:bg-indigo-600 hover:text-white transition-all shadow-3xl italic flex items-center gap-6 group">
                    REGISTRAR EN BÓVEDA
                    <i class="fas fa-shield-alt text-xs group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom selects y ajustes menores */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #020617; }
    ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #334155; }
</style>
@endsection
