@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE BIBLIOTECA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Repositorio Central de Conocimiento</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Knowledge Base • Protocolos de Autogestión
            </p>
        </div>
        <div class="md:text-right">
            <span class="inline-block bg-slate-900 border border-white/5 px-6 py-3 rounded-2xl shadow-xl text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">
                ACCESO LIBRE TI
            </span>
        </div>
    </div>

    <!-- BUSCADOR NEURAL SENSORIAL -->
    <div class="mb-20 max-w-3xl mx-auto relative group">
        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-[2.5rem] blur opacity-20 group-focus-within:opacity-40 transition-all duration-700"></div>
        <div class="relative bg-slate-900/40 backdrop-blur-2xl p-2 rounded-[2.2rem] border border-white/5 flex items-center shadow-2xl">
            <div class="p-5 text-indigo-400">
                <i class="fas fa-search text-xl"></i>
            </div>
            <input type="text" placeholder="¿QUÉ PROTOCOLO TÉCNICO NECESITAS CONSULTAR?..." 
                   class="flex-1 bg-transparent border-none outline-none text-white font-black placeholder:text-slate-700 text-[0.75rem] italic tracking-widest uppercase py-4 pr-10">
        </div>
    </div>

    <!-- GRID DE MÓDULOS DE CONOCIMIENTO -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($articles as $article)
            <div class="group bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-600/5 rounded-full blur-2xl group-hover:bg-indigo-600/10 transition-all"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 bg-slate-950 rounded-2xl flex items-center justify-center text-slate-500 border border-white/5 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-xl group-hover:scale-110 duration-700">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <span class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest italic">{{ $article->updated_at->format('M Y') }}</span>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white tracking-tighter mb-4 group-hover:text-indigo-400 transition-colors uppercase italic leading-none">{{ $article->title }}</h3>
                    
                    <div class="h-1 w-12 bg-white/5 mb-6 group-hover:w-full group-hover:bg-indigo-500 transition-all"></div>
                    
                    <p class="text-[0.7rem] font-black text-slate-500 leading-relaxed uppercase tracking-widest italic mb-12 opacity-80 group-hover:text-slate-400 transition-colors">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                </div>
                
                <a href="{{ route('knowledge.show', $article->id) }}" class="relative z-10 w-full bg-slate-950 hover:bg-white hover:text-slate-950 text-white py-4 rounded-xl font-black text-[0.65rem] uppercase tracking-widest text-center transition-all border border-white/5 shadow-xl italic flex items-center justify-center gap-3 decoration-0 group-hover:shadow-indigo-500/10">
                    LEER MANUAL TÉCNICO
                    <i class="fas fa-book-reader text-[8px]"></i>
                </a>
            </div>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="py-32 text-center bg-slate-900/10 rounded-[3rem] border-2 border-dashed border-white/5">
            <div class="w-20 h-20 bg-slate-950 rounded-[1.5rem] flex items-center justify-center text-slate-700 mx-auto mb-8 shadow-inner border border-white/5">
                <i class="fas fa-cloud-sun text-4xl opacity-20"></i>
            </div>
            <p class="text-slate-600 font-black uppercase tracking-[0.5em] text-[0.65rem] italic">Sincronizando Archivos: No hay manuales disponibles en este sector.</p>
        </div>
    @endif

    <!-- FOOTER PROTOCOL -->
    <div class="mt-20 flex justify-center border-t border-white/5 pt-10">
        <p class="text-[0.55rem] font-black text-slate-800 uppercase tracking-[1em] italic">
            Gravity Document Engine • Data Integrity Guaranteed
        </p>
    </div>
</div>
@endsection
