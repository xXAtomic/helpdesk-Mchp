@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Biblioteca Técnica</h1>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-widest mt-1">Manuales operativos y soluciones de autogestión</p>
        </div>
        <div class="mt-6 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest italic">
                ACCESO PÚBLICO TI
            </span>
        </div>
    </div>

    <!-- BUSCADOR TIPO NOTION (ADN MY-TICKETS) -->
    <div class="mb-16 max-w-2xl mx-auto bg-white p-2 rounded-xl border border-gray-100 shadow-xl shadow-slate-200/50 flex transition-all focus-within:shadow-indigo-100 focus-within:border-indigo-200">
        <div class="p-4 text-slate-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" placeholder="¿Qué solución técnica estás buscando hoy?.." 
               class="flex-1 px-4 py-4 border-none outline-none text-slate-600 font-bold placeholder:text-slate-300 bg-transparent text-sm italic tracking-tight">
    </div>

    <!-- GRID DE MANUALES (ESTILO MY-TICKETS) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <div class="group bg-white p-8 rounded-xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 border group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fas fa-file-alt text-sm text-[0.65rem]"></i>
                        </div>
                        <span class="text-[0.6rem] font-bold text-gray-300 uppercase tracking-widest">{{ $article->updated_at->format('M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight mb-3 group-hover:text-indigo-600 transition-colors uppercase italic">{{ $article->title }}</h3>
                    <p class="text-[0.65rem] font-bold text-slate-400 leading-relaxed uppercase tracking-widest italic mb-10 opacity-80">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                </div>
                
                <a href="{{ route('knowledge.show', $article->id) }}" class="relative z-10 inline-flex items-center gap-2 text-[0.6rem] font-black text-slate-900 border-b border-transparent hover:border-indigo-600 uppercase tracking-widest transition-all">
                    LEER MANUAL →
                </a>
            </div>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.6rem] italic italic uppercase tracking-widest">No se han publicado manuales todavía. ✨</p>
        </div>
    @endif
</div>
@endsection
