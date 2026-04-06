@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- NAVEGACIÓN Y CABECERA -->
    <div class="mb-12">
        <a href="{{ route('knowledge.index') }}" class="inline-flex items-center gap-2 text-[0.65rem] font-black text-slate-400 hover:text-indigo-600 transition uppercase tracking-widest mb-10">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Regresar a la Biblioteca
        </a>

        <div class="flex items-center gap-4 mb-6">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[0.65rem] font-black uppercase tracking-widest rounded-lg border border-indigo-100">
                GUÍA TÉCNICA OFICIAL
            </span>
            <span class="text-[0.65rem] font-bold text-slate-300 uppercase tracking-widest italic">Actualizado {{ $article->updated_at->diffForHumans() }}</span>
        </div>
        
        <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter italic uppercase mb-8 leading-tight">
            {{ $article->title }}
        </h1>
    </div>

    <!-- CONTENIDO DEL MANUAL -->
    <div class="bg-white p-12 rounded-[2rem] border border-gray-100 shadow-2xl relative overflow-hidden min-h-[400px]">
        <div class="absolute right-0 top-0 w-32 h-32 bg-gray-50 rounded-full translate-x-12 -translate-y-12"></div>
        
        <div class="relative z-10 prose prose-indigo max-w-none">
            <div class="text-slate-600 font-medium text-lg leading-relaxed whitespace-pre-wrap mb-12">
                {!! $article->content !!}
            </div>

            @if($article->file_path)
                <div class="mt-8 pt-8 border-t border-slate-100">
                    <div class="flex flex-col sm:flex-row items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100 gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Documentación Adjunta:</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $article->file_name }}</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $article->file_path) }}" target="_blank" class="w-full sm:w-auto bg-indigo-600 hover:bg-slate-900 text-white font-black px-8 py-3 rounded-xl transition-all shadow-lg hover:shadow-indigo-200 uppercase tracking-widest italic text-[0.65rem]">
                            Descargar Ahora
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- PIE DE MANUAL: ÚTIL? -->
    <div class="mt-16 bg-slate-900 p-10 rounded-3xl text-center relative overflow-hidden">
        <div class="absolute left-0 bottom-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-cyan-500"></div>
        <h4 class="text-xl font-bold text-white mb-4 uppercase italic tracking-tight">¿Te sirvió esta información?</h4>
        <p class="text-[0.65rem] font-medium text-slate-400 uppercase tracking-widest mb-10">Si el problema persiste, inicia una solicitud formal con Soporte TI.</p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="{{ route('user.tickets.create') }}" class="bg-white text-slate-900 px-10 py-4 rounded-xl font-black text-[0.7rem] uppercase tracking-[0.2em] hover:bg-indigo-500 hover:text-white transition-all shadow-xl">
                Crear Nuevo Ticket
            </a>
            <button onclick="window.print()" class="text-slate-500 font-bold text-[0.6rem] uppercase tracking-widest hover:text-white transition-colors">
                <i class="fas fa-print mr-2"></i> Imprimir Guía
            </button>
        </div>
    </div>
</div>
@endsection
