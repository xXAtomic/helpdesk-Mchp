@extends('layouts.app')

@section('content')
    <div class="py-2">
        <!-- CABECERA DE BIENVENIDA -->
        <div class="mb-12">
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase underline decoration-blue-600 decoration-8 underline-offset-4">¡HOLA DE NUEVO, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-[0.65rem] font-bold text-slate-400 mt-4 uppercase tracking-[0.3em] leading-none opacity-80">¿QUÉ PROCEDIMIENTO TÉCNICO NECESITAS REALIZAR HOY?</p>
        </div>

        <!-- GRID DE ACCIONES PREMIUM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- CARD: INCIDENTE -->
            <div class="group relative bg-white p-12 rounded-[3.5rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-700"></div>
                
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-8 group-hover:rotate-12 transition-transform">
                    <span class="text-3xl">🚀</span>
                </div>
                
                <h3 class="text-2xl font-black text-slate-900 mb-2 italic tracking-tighter uppercase">NUEVO REQUERIMIENTO</h3>
                <p class="text-xs font-bold text-slate-400 mb-8 uppercase tracking-widest leading-relaxed">Abre un ticket estructurado para resolución por soporte técnico o finanzas.</p>
                
                <a href="{{ route('user.tickets.create') }}" class="inline-flex items-center gap-3 bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300">
                    CENTRO DE SOLICITUDES
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <!-- CARD: KNOWLEDGE -->
            <div class="group relative bg-slate-950 p-12 rounded-[3.5rem] shadow-2xl overflow-hidden hover:-translate-y-2 transition-all duration-500">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-transparent"></div>
                
                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-8">
                    <span class="text-3xl">📖</span>
                </div>
                
                <h3 class="text-2xl font-black text-white mb-2 italic tracking-tighter uppercase">BIBLIOTECA TÉCNICA</h3>
                <p class="text-xs font-bold text-slate-500 mb-8 uppercase tracking-widest leading-relaxed text-balance">Revisa los manuales operativos y soluciones de autogestión paso a paso.</p>
                
                <a href="{{ route('knowledge.index') }}" class="inline-flex items-center gap-3 bg-white text-slate-950 px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-amber-400 hover:text-slate-950 transition-all duration-300">
                    EXPLORAR MANUALES
                </a>
            </div>
        </div>
    </div>
@endsection
