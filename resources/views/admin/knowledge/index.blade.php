@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- ACCIONES DE CABECERA -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight italic uppercase mb-2">Biblioteca TI</h1>
            <p class="text-sm font-medium text-slate-400 uppercase tracking-widest">Gestión de manuales operativos y recomendaciones.</p>
        </div>
        <a href="{{ route('admin.knowledge.create') }}" 
           class="bg-indigo-600 hover:bg-slate-900 text-white font-black px-8 py-4 rounded-xl transition-all shadow-lg hover:shadow-indigo-200 uppercase tracking-widest italic text-[0.7rem] flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nueva Recomendación
        </a>
    </div>

    <!-- GRID DE MANUALES PROFESIONAL -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($manuals as $article)
            <div class="group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 border group-hover:bg-indigo-600 group-hover:text-white transition-colors text-xl">
                                {{ $article->icon ?? '📖' }}
                            </div>
                            <span class="text-[0.6rem] font-black text-gray-300 uppercase tracking-widest">{{ $article->updated_at->format('d M, Y') }}</span>
                        </div>
                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.knowledge.edit', $article->id) }}" class="p-2 text-slate-400 hover:text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('admin.knowledge.destroy', $article->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta recomendación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3 group-hover:text-indigo-600 transition-colors uppercase italic">{{ $article->title }}</h3>
                    <p class="text-[0.75rem] font-medium text-slate-500 leading-relaxed mb-6 opacity-80">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                    
                    @if($article->file_path)
                        <a href="{{ asset('storage/' . $article->file_path) }}" target="_blank" class="flex items-center gap-2 mb-6 p-3 bg-slate-50 rounded-xl border border-slate-100 group-hover:border-indigo-100 transition-colors">
                            <div class="text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-[0.65rem] font-bold text-slate-400 truncate uppercase tracking-tighter">{{ $article->file_name }}</span>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($manuals->isEmpty())
        <div class="py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.65rem]">No se han publicado manuales todavía. ✨</p>
        </div>
    @endif
</div>
@endsection
