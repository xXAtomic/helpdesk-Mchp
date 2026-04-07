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

    <!-- LAYOUT DE DOS COLUMNAS -->
    <div class="flex flex-col lg:flex-row gap-10">
        
        <!-- COLUMNA PRINCIPAL: MANUALES (2/3) -->
        <div class="lg:w-2/3">
            <div class="mb-6 flex items-center gap-3">
                <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Manuales Operativos</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($manuals as $article)
                    <div onclick="openKnowledgeModal('{{ addslashes($article->title) }}', '{{ addslashes($article->content) }}', '{{ $article->category }}', '{{ $article->icon }}', '{{ $article->file_path ? asset('storage/' . $article->file_path) : '' }}', '{{ addslashes($article->file_name) }}')"
                         class="group bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-500/20 transition-all duration-500 flex flex-col justify-between overflow-hidden relative cursor-pointer">
                        <div class="absolute -right-6 -top-6 w-16 h-16 bg-gray-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-400 border group-hover:bg-indigo-600 group-hover:text-white transition-colors text-xl">
                                        {{ $article->icon ?? '📖' }}
                                    </div>
                                    <span class="text-[0.6rem] font-black text-gray-300 uppercase tracking-widest">{{ $article->updated_at->format('d M, Y') }}</span>
                                </div>
                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.knowledge.edit', $article->id) }}" class="p-2 text-slate-400 hover:text-indigo-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.knowledge.destroy', $article->id) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-3 group-hover:text-indigo-600 transition-colors uppercase italic leading-tight">{{ $article->title }}</h3>
                            <p class="text-[0.7rem] font-medium text-slate-400 leading-relaxed mb-6">
                                {{ Str::limit(strip_tags($article->content), 80) }}
                            </p>
                            
                            <div class="flex items-center gap-2 text-[0.6rem] font-black text-indigo-500 uppercase tracking-widest italic group-hover:gap-4 transition-all">
                                Leer Manual completo
                                <span>→</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($manuals->isEmpty())
                    <div class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.6rem]">Sin manuales operativos todavía.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- SIDEBAR: RECOMENDACIONES (1/3) -->
        <div class="lg:w-1/3">
            <div class="mb-6 flex items-center gap-3">
                <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Tips de la Semana</h2>
            </div>

            <div class="space-y-6">
                @foreach($tips as $tip)
                    <div onclick="openKnowledgeModal('{{ addslashes($tip->title) }}', '{{ addslashes($tip->content) }}', '{{ $tip->category }}', '{{ $tip->icon }}', '{{ $tip->file_path ? asset('storage/' . $tip->file_path) : '' }}', '{{ addslashes($tip->file_name) }}')"
                         class="bg-gradient-to-br from-slate-900 to-indigo-950 p-6 rounded-2xl shadow-xl border border-white/5 relative overflow-hidden group cursor-pointer">
                        <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/5 rounded-full scale-150 group-hover:scale-[2] transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-xl shadow-inner text-white">
                                    {{ $tip->icon ?? '💡' }}
                                </div>
                                <div class="flex gap-1" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.knowledge.edit', $tip->id) }}" class="text-white/30 hover:text-white transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 113.536 3.536L12 20.122l-3.586-3.586L20.586 7.414z"></path></svg>
                                    </a>
                                </div>
                            </div>
                            <h4 class="text-indigo-400 font-black text-[0.65rem] uppercase tracking-widest mb-1 italic">Recomendación TI</h4>
                            <p class="text-white font-bold leading-snug mb-2">{{ $tip->title }}</p>
                            <p class="text-slate-400 text-[0.7rem] font-medium leading-relaxed italic border-l-2 border-indigo-500/30 pl-3">
                                {{ Str::limit($tip->content, 100) }}
                            </p>
                        </div>
                    </div>
                @endforeach

                @if($tips->isEmpty())
                     <div class="py-12 px-6 text-center border-2 border-dashed border-slate-200 rounded-3xl">
                        <div class="text-3xl mb-3 opacity-30">✨</div>
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-[0.6rem]">No hay recomendaciones publicadas.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
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
                            <span id="modalCategory" class="px-3 py-1 bg-indigo-50 text-[0.6rem] font-black text-indigo-600 uppercase tracking-[0.2em] italic mb-2 inline-block rounded-lg">Manual Operativo</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">Título del Manual</h2>
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
    document.getElementById('modalCategory').textContent = category;
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
