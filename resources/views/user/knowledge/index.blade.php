@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6 lg:px-8">
    
    <!-- CABECERA DE BÚSQUEDA MINIMALISTA -->
    <div class="mb-16 text-center">
        <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none text-center">Biblioteca Digital y Guías de Autogestión TI</h1>
        <p class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.6em] mt-4 italic text-center">Recursos Técnicos de la Organización</p>
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
            <div onclick="openKnowledgeModal('{{ addslashes($article->title) }}', '{{ addslashes($article->content) }}', '{{ $article->category }}', '{{ $article->icon }}', '{{ $article->file_path ? asset('storage/' . $article->file_path) : '' }}', '{{ addslashes($article->file_name) }}')"
                 class="group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative cursor-pointer">
                <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 border group-hover:bg-indigo-600 group-hover:text-white transition-colors text-xl">
                            {{ $article->icon ?? '📖' }}
                        </div>
                        <span class="text-[0.6rem] font-black text-gray-300 uppercase tracking-widest">{{ $article->updated_at->format('M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3 group-hover:text-indigo-600 transition-colors uppercase italic leading-tight">{{ $article->title }}</h3>
                    <p class="text-[0.75rem] font-medium text-slate-500 leading-relaxed mb-8 opacity-80 italic">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                </div>
                
                <div class="relative z-10 inline-flex items-center gap-2 text-[0.65rem] font-black text-slate-400 group-hover:text-indigo-600 uppercase tracking-widest transition-all italic">
                    LEER MANUAL COMPLETO <span class="group-hover:translate-x-2 transition-transform">→</span>
                </div>
            </div>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.65rem]">No se han publicado manuales todavía. ✨</p>
        </div>
    @endif
</div>

<!-- Modal de Información Moderno -->
<div id="knowledgeModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <!-- Botón de Cerrar -->
                <button onclick="closeKnowledgeModal()" class="absolute right-8 top-8 text-slate-300 hover:text-slate-900 transition-all p-2 bg-slate-50 rounded-2xl hover:rotate-90 z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="overflow-y-auto p-10 sm:p-12">
                    <div class="flex items-center gap-5 mb-10">
                        <div id="modalIcon" class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-4xl shadow-inner border border-slate-100 shrink-0">📖</div>
                        <div>
                            <span id="modalCategory" class="px-3 py-1 bg-indigo-50 text-[0.6rem] font-black text-indigo-600 uppercase tracking-[0.2em] italic mb-2 inline-block rounded-lg">Biblioteca TI</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">Título</h2>
                        </div>
                    </div>

                    <div class="border-l-4 border-indigo-500 pl-6 py-2 mb-10">
                        <p id="modalDescription" class="text-slate-600 font-medium leading-relaxed italic whitespace-pre-line text-base"></p>
                    </div>

                    <div id="modalFileSection" class="mt-10 p-8 bg-slate-50 rounded-3xl border border-slate-100 hidden">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Recurso Adjunto</p>
                                <p id="modalFileName" class="text-sm font-bold text-slate-950 truncate max-w-[200px]">documento.pdf</p>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank" class="bg-indigo-600 hover:bg-slate-900 text-white font-black px-6 py-3 rounded-xl transition-all shadow-lg text-[0.65rem] uppercase tracking-widest italic flex items-center gap-2 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Descargar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-slate-50 border-t border-slate-100 text-center">
                    <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest italic">Base de Conocimiento TI MChP &copy; {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openKnowledgeModal(title, content, category, icon, fileUrl, fileName) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = content;
    document.getElementById('modalCategory').textContent = category || 'Biblioteca TI';
    document.getElementById('modalIcon').textContent = icon || '📖';
    
    const fileSection = document.getElementById('modalFileSection');
    if (fileUrl && fileUrl !== '') {
        fileSection.classList.remove('hidden');
        document.getElementById('modalFileLink').href = fileUrl;
        document.getElementById('modalFileName').textContent = fileName;
    } else {
        fileSection.classList.add('hidden');
    }

    const modal = document.getElementById('knowledgeModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeKnowledgeModal() {
    const modal = document.getElementById('knowledgeModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Cerrar al hacer click fuera del modal
window.onclick = function(event) {
    const modal = document.getElementById('knowledgeModal');
    if (event.target == modal.children[0] || event.target.classList.contains('min-h-full')) {
        closeKnowledgeModal();
    }
}
</script>
@endsection
