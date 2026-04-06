@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- CABECERA DE BÚSQUEDA MINIMALISTA -->
    <div class="mb-16 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight italic uppercase mb-4">Biblioteca TI</h1>
        <p class="text-sm font-medium text-slate-400 uppercase tracking-widest max-w-md mx-auto">Manuales operativos y soluciones de autogestión para toda la organización.</p>
    </div>

    <!-- BUSCADOR TIPO NOTION -->
    <div class="mb-16 max-w-2xl mx-auto bg-white p-2 rounded-2xl border border-gray-100 shadow-xl shadow-slate-200/50 flex">
        <div class="p-4 text-slate-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" placeholder="¿Qué solución técnica estás buscando hoy?.." 
               class="flex-1 px-4 py-4 border-none outline-none text-slate-600 font-bold placeholder:text-slate-300 bg-transparent text-sm">
    </div>

    <!-- GRID DE MANUALES PROFESIONAL -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($articles as $article)
            <div class="group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 border group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fas fa-file-alt text-sm"></i>
                        </div>
                        <span class="text-[0.6rem] font-black text-gray-300 uppercase tracking-widest">{{ $article->updated_at->format('M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3 group-hover:text-indigo-600 transition-colors uppercase italic">{{ $article->title }}</h3>
                    <p class="text-[0.75rem] font-medium text-slate-500 leading-relaxed mb-8 opacity-80">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                </div>
                
                <a href="{{ route('knowledge.show', $article->id) }}" class="relative z-10 inline-flex items-center gap-2 text-[0.65rem] font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-all">
                    LEER MANUAL COMPLETO <i class="fas fa-arrow-right text-[0.5rem]"></i>
                </a>
            </div>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.65rem]">No se han publicado manuales todavía. ✨</p>
        </div>
    @endif
</div>
@endsection
