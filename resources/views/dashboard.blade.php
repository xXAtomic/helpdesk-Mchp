@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE BIENVENIDA PREMIUM -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Plataforma Operativa • Gestión TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Central • Nodo de Usuario: {{ auth()->user()->name }}
            </p>
        </div>
        <div class="md:text-right">
            <div class="inline-block bg-slate-900 border border-white/5 px-6 py-3 rounded-2xl shadow-xl">
                <h4 class="text-[0.55rem] font-black text-slate-500 uppercase tracking-widest italic mb-1">Último Acceso</h4>
                <p class="text-[0.65rem] font-black text-white uppercase italic leading-none">{{ now()->format('d M, Y | H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- COLUMNA PRINCIPAL DE ACCIONES TÁCTICAS (2/3) -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- CARD: NUEVO TICKET (GLASSMORPHISM) -->
            <div class="group bg-slate-900/40 backdrop-blur-xl p-10 rounded-[2.5rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-600/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-slate-950 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/5 shadow-2xl mb-10 group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-700">
                        <i class="fas fa-plus shadow-sm animate-pulse"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic mb-4 leading-none">Nueva Solicitud</h3>
                    <p class="text-[0.7rem] font-black text-slate-500 uppercase tracking-widest leading-relaxed mb-12 italic">Reporta anomalías técnicas o solicita asistencia de hardware de forma inmediata.</p>
                </div>
                
                <a href="{{ route('user.tickets.create') }}" class="relative z-10 w-full bg-indigo-600 hover:bg-white hover:text-slate-950 text-white py-5 rounded-2xl font-black text-[0.65rem] uppercase tracking-widest text-center transition-all shadow-xl shadow-indigo-500/10 italic flex items-center justify-center gap-3">
                    REGISTRAR INCIDENTE
                    <i class="fas fa-arrow-right text-[8px]"></i>
                </a>
            </div>

            <!-- CARD: MANUALES -->
            <div class="group bg-slate-950 p-10 rounded-[2.5rem] shadow-2xl flex flex-col justify-between overflow-hidden relative border border-white/5 hover:border-white/10 transition-all">
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-transform duration-1000"></div>
                
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/10 mb-10 group-hover:scale-110 group-hover:rotate-12 transition-all shadow-2xl">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic mb-4 leading-none">Protocolos TI</h3>
                    <p class="text-[0.7rem] font-black text-slate-600 uppercase tracking-widest leading-relaxed mb-12 italic">Consulta guías interactivas y manuales operativos para autogestión de recursos.</p>
                </div>
                
                <a href="{{ route('knowledge.index') }}" class="relative z-10 w-full bg-white text-slate-950 py-5 rounded-2xl font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-500 hover:text-white transition-all italic flex items-center justify-center gap-3 shadow-xl">
                    EXPLORAR REPOSITORIO
                    <i class="fas fa-external-link-alt text-[8px]"></i>
                </a>
            </div>

        </div>

        <!-- COLUMNA LATERAL: MÉTRICAS DE IDENTIDAD (1/3) -->
        <div class="space-y-8">
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[2.5rem] border border-white/5 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-1 bg-gradient-to-l from-indigo-500 to-transparent"></div>
                <h5 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] mb-12 border-b border-white/5 pb-6 italic">Estado de Conectividad</h5>
                
                <div class="space-y-12">
                    <div class="flex items-center justify-between group">
                        <div>
                            <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest mb-2 italic">Mis Solicitudes</p>
                            <p class="text-2xl font-black text-white italic uppercase tracking-tighter group-hover:text-indigo-400 transition-colors">
                                {{ auth()->user()->tickets()->count() }} TICKETS
                            </p>
                        </div>
                        <div class="bg-indigo-600/10 p-4 rounded-2xl text-indigo-400 border border-indigo-500/20 shadow-lg">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between group">
                        <div>
                            <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest mb-2 italic">Casos Resueltos</p>
                            <p class="text-2xl font-black text-emerald-500 italic uppercase tracking-tighter group-hover:text-white transition-colors">
                                {{ auth()->user()->tickets()->whereHas('status', function($q){ $q->where('name', 'Cerrado'); })->count() }} CERRADOS
                            </p>
                        </div>
                        <div class="bg-emerald-500/10 p-4 rounded-2xl text-emerald-500 border border-emerald-500/20 shadow-lg">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>

                    <div class="pt-10 border-t border-white/5">
                        <a href="{{ route('user.tickets.index') }}" class="text-[0.65rem] font-black text-indigo-400 hover:text-white hover:tracking-[0.2em] transition-all uppercase tracking-widest flex items-center gap-3 italic group">
                            VER HISTORIAL COMPLETO 
                            <i class="fas fa-chevron-right text-[8px] group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CARD COMPLIANCE RÁPIDO -->
            @php 
                $pendingSigns = auth()->user()->unsignedDocuments()->count();
            @endphp
            <div class="{{ $pendingSigns > 0 ? 'bg-rose-500/10 border-rose-500/30' : 'bg-slate-900/20 border-white/5' }} border p-8 rounded-[2rem] transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 {{ $pendingSigns > 0 ? 'bg-rose-600 animate-bounce' : 'bg-slate-800' }} rounded-xl flex items-center justify-center text-white">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <div>
                        <h4 class="text-[0.6rem] font-black text-white uppercase italic tracking-widest">Compromisos Legales</h4>
                        <p class="text-[0.7rem] font-black {{ $pendingSigns > 0 ? 'text-rose-400' : 'text-slate-500' }} uppercase italic">
                            {{ $pendingSigns }} Documentos Pendientes
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
