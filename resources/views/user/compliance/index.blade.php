@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE BÓVEDA DOCUMENTAL -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Certificaciones y Compromisos Legales</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Compliance Hub • Mis Documentos
            </p>
        </div>
    </div>

    <!-- 🚩 SECCIÓN: PENDIENTES DE ACCIÓN -->
    <div class="mb-20">
        <h2 class="text-[0.65rem] font-black text-rose-500 uppercase tracking-[0.5em] mb-10 flex items-center gap-4 italic group">
            <span class="w-12 h-[2px] bg-rose-600 shadow-[0_0_8px_#e11d48]"></span> 
            Protocolos Pendientes de Firma
        </h2>
        
        @if($pending->isEmpty())
            <div class="bg-indigo-600/5 backdrop-blur-xl p-16 rounded-[3.5rem] border border-white/5 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
                <div class="w-24 h-24 bg-slate-900 rounded-[2rem] flex items-center justify-center text-emerald-500 text-4xl mx-auto mb-8 border border-emerald-500/20 shadow-2xl">
                    <i class="fas fa-check-double shadow-lg"></i>
                </div>
                <h2 class="text-3xl font-black text-white uppercase italic tracking-tighter mb-4 leading-none">Estatus: Limpio</h2>
                <p class="text-[0.7rem] font-black text-slate-500 uppercase italic tracking-[0.2em]">No se han detectado compromisos legales pendientes por procesar.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($pending as $doc)
                    <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-2xl flex flex-col md:flex-row items-center justify-between gap-10 hover:border-rose-500/30 transition-all group relative overflow-hidden">
                        <div class="absolute -left-10 -top-10 w-32 h-32 bg-rose-600/5 rounded-full blur-2xl group-hover:bg-rose-600/10 transition-all"></div>
                        
                        <div class="relative z-10 flex items-center gap-8">
                            <div class="w-20 h-20 bg-slate-950 rounded-[1.5rem] flex items-center justify-center text-white text-3xl shadow-2xl border border-white/5 group-hover:bg-rose-600 group-hover:scale-110 transition-all duration-700">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <div>
                                <span class="px-4 py-1 bg-rose-600 text-white text-[0.55rem] font-black uppercase tracking-widest italic mb-3 inline-block rounded-lg shadow-lg shadow-rose-600/20">Acción Requerida</span>
                                <h3 class="text-2xl font-black text-white uppercase italic tracking-tighter leading-none group-hover:text-rose-400 transition-colors">{{ $doc->title }}</h3>
                            </div>
                        </div>
                        <a href="{{ route('user.compliance.show', $doc->id) }}" class="w-full md:w-auto bg-white text-slate-950 px-10 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-2xl italic flex items-center justify-center gap-4 group">
                            INICIAR PROTOCOLO DE FIRMA 
                            <i class="fas fa-signature text-xs group-hover:rotate-12"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ✅ SECCIÓN: HISTORIAL CERTIFICADO -->
    <div>
        <h2 class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.5em] mb-10 flex items-center gap-4 italic">
            <span class="w-12 h-[2px] bg-slate-800"></span> 
            Historial de Archivo Digital
        </h2>

        @if($signed->isEmpty())
            <div class="py-20 text-center bg-slate-900/20 rounded-[3rem] border-2 border-dashed border-white/5">
                <i class="fas fa-shield-alt text-slate-800 text-5xl mb-6 opacity-20"></i>
                <p class="text-[0.65rem] font-black text-slate-700 uppercase tracking-widest italic">Bóveda Vacía: Aún no has validado documentos legales en el sistema.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($signed as $sig)
                    <div class="bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl relative group overflow-hidden hover:border-emerald-500/20 transition-all">
                        <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-all"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-8">
                                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-400 text-[0.55rem] font-black uppercase tracking-widest rounded-xl italic border border-emerald-500/20 shadow-lg shadow-emerald-500/5">Certificado v.{{ $sig->document->version }}</span>
                                <span class="text-[0.55rem] font-black text-slate-600 italic uppercase tracking-tighter">{{ $sig->signed_at->format('d M, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-8 leading-tight group-hover:text-emerald-400 transition-colors">{{ $sig->document->title }}</h3>
                            
                            <div class="flex items-center justify-between pt-6 border-t border-white/5">
                                <div class="flex flex-col">
                                    <span class="text-[0.5rem] font-black text-slate-700 uppercase mb-1">Hash de Identidad</span>
                                    <span class="text-[0.55rem] font-mono text-slate-500 font-bold tracking-tight lowercase">{{ substr($sig->signature_token, 0, 15) }}...</span>
                                </div>
                                <a href="{{ route('user.compliance.show', $sig->document->id) }}" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-800 border border-white/5 transition-all shadow-xl" title="Revisar Digital">
                                    <i class="fas fa-file-alt text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- INFO PIE -->
    <div class="mt-20 text-center">
        <p class="text-[0.55rem] font-black text-slate-800 uppercase tracking-[0.8em] italic">
            Atomic Compliance Vault • Entorno de Seguridad v2.0
        </p>
    </div>
</div>
@endsection
