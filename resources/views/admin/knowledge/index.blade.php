@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- ACCIONES DE CABECERA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Repositorio de Inteligencia TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                GravityBrain • Centralized Knowledge
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.knowledge.create') }}" 
               class="bg-indigo-600 hover:bg-white hover:text-slate-950 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                Nueva Entrada
            </a>
        </div>
    </div>

    <!-- LAYOUT DE DOS COLUMNAS -->
    <div class="flex flex-col lg:flex-row gap-10">
        
        <!-- COLUMNA PRINCIPAL: MANUALES (2/3) -->
        <div class="lg:w-2/3">
            <div class="mb-8 flex items-center gap-4">
                <div class="w-1 h-6 bg-indigo-500 rounded-full shadow-[0_0_8px_#6366f1]"></div>
                <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">Manuales Operativos</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($manuals as $article)
                    <div onclick="openKnowledgeModal('{{ addslashes($article->title) }}', '{{ addslashes($article->content) }}', '{{ $article->category }}', '{{ $article->icon }}', '{{ $article->file_path ? asset('storage/' . $article->file_path) : '' }}', '{{ addslashes($article->file_name) }}')"
                         class="group bg-slate-900/40 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 transition-all duration-500 flex flex-col justify-between overflow-hidden relative cursor-pointer">
                        
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-950 rounded-2xl flex items-center justify-center text-2xl border border-white/5 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-xl">
                                        {{ $article->icon ?? '📖' }}
                                    </div>
                                    <span class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">{{ $article->updated_at->format('d M, Y') }}</span>
                                </div>
                                <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-all" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.knowledge.edit', $article->id) }}" class="text-slate-500 hover:text-white transition-colors">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.knowledge.destroy', $article->id) }}" method="POST" onsubmit="return confirm('¿Eyectar este manual?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-500 hover:text-rose-500">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-white tracking-tighter mb-4 group-hover:text-indigo-400 transition-colors uppercase italic leading-tight">{{ $article->title }}</h3>
                            <p class="text-[0.7rem] font-black text-slate-500 leading-relaxed mb-8 uppercase italic tracking-wide">
                                {{ Str::limit(strip_tags($article->content), 90) }}
                            </p>
                            
                            <div class="flex items-center gap-3 text-[0.65rem] font-black text-indigo-400 uppercase tracking-widest italic group-hover:gap-5 transition-all">
                                ACCEDER AL PROTOCOLO
                                <i class="fas fa-arrow-right text-[8px]"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($manuals->isEmpty())
                    <div class="col-span-full py-24 text-center bg-slate-900/40 rounded-[3rem] border border-dashed border-white/5">
                        <i class="fas fa-file-signature text-slate-800 text-4xl mb-4 opacity-30"></i>
                        <p class="text-slate-600 font-black uppercase tracking-[0.3em] italic text-[0.65rem]">Protocolo Vacío: Sin documentación activa.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- SIDEBAR: RECOMENDACIONES (1/3) -->
        <div class="lg:w-1/3">
            <div class="mb-8 flex items-center gap-4">
                <div class="w-1 h-6 bg-amber-500 rounded-full shadow-[0_0_8px_#f59e0b]"></div>
                <h2 class="text-xl font-black text-white uppercase italic tracking-tighter">Tips de Mantenimiento</h2>
            </div>

            <div class="space-y-6">
                @foreach($tips as $tip)
                    <div onclick="openKnowledgeModal('{{ addslashes($tip->title) }}', '{{ addslashes($tip->content) }}', '{{ $tip->category }}', '{{ $tip->icon }}', '{{ $tip->file_path ? asset('storage/' . $tip->file_path) : '' }}', '{{ addslashes($tip->file_name) }}')"
                         class="bg-indigo-600/5 backdrop-blur-xl p-8 rounded-[2.5rem] border border-indigo-500/10 relative overflow-hidden group cursor-pointer hover:bg-indigo-600/10 hover:border-indigo-500/30 transition-all shadow-2xl">
                        
                        <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/5 rounded-full scale-110 group-hover:scale-150 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl shadow-inner text-white backdrop-blur-md">
                                    {{ $tip->icon ?? '💡' }}
                                </div>
                                <div class="flex gap-4 opacity-0 group-hover:opacity-100 transition-all" onclick="event.stopPropagation()">
                                    <a href="{{ route('admin.knowledge.edit', $tip->id) }}" class="text-white/20 hover:text-white transition-colors">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.knowledge.destroy', $tip->id) }}" method="POST" onsubmit="return confirm('¿Eyectar este Tip?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white/20 hover:text-rose-500 transition-colors">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <h4 class="text-indigo-400 font-black text-[0.65rem] uppercase tracking-widest mb-2 italic">Recomendación Técnica</h4>
                            <p class="text-lg font-black text-white leading-tight mb-4 uppercase italic tracking-tighter">{{ $tip->title }}</p>
                            <p class="text-slate-500 text-[0.7rem] font-black leading-relaxed italic border-l border-indigo-500/20 pl-4 uppercase tracking-wide">
                                {{ Str::limit($tip->content, 120) }}
                            </p>
                        </div>
                    </div>
                @endforeach

                @if($tips->isEmpty())
                     <div class="py-16 px-8 text-center bg-slate-900/40 border border-dashed border-white/5 rounded-[3rem]">
                        <i class="fas fa-lightbulb text-slate-800 text-3xl mb-4 opacity-20"></i>
                        <p class="text-slate-600 font-black uppercase tracking-widest text-[0.6rem] italic">SISTEMA EN ESPERA</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de Información Moderno (DARK GLASS) -->
<div id="knowledgeModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-6 sm:p-12">
            <div class="relative bg-slate-900/80 backdrop-blur-2xl rounded-[3rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all border border-white/10 flex flex-col max-h-[90vh]">
                
                <button onclick="closeKnowledgeModal()" class="absolute right-8 top-8 text-slate-500 hover:text-white transition-all w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center hover:rotate-90 z-20">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <div class="overflow-y-auto p-12 custom-scrollbar">
                    <div class="flex items-center gap-6 mb-12">
                        <div id="modalIcon" class="w-24 h-24 bg-slate-950 rounded-[2rem] flex items-center justify-center text-5xl shadow-2xl border border-white/5 shrink-0">📖</div>
                        <div>
                            <span id="modalCategory" class="px-4 py-1.5 bg-indigo-500/10 text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.3em] italic mb-3 inline-block rounded-xl border border-indigo-500/20">Protocolo Operativo</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-white tracking-tighter italic uppercase leading-none">Título del Manual</h2>
                        </div>
                    </div>

                    <div class="border-l-2 border-indigo-500/30 pl-8 py-2 mb-12">
                        <p id="modalDescription" class="text-slate-400 font-black leading-relaxed italic whitespace-pre-line text-sm uppercase tracking-wide"></p>
                    </div>

                    <div id="modalFileSection" class="mt-12 p-8 bg-slate-950 rounded-[2rem] border border-white/5 hidden shadow-inner">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-white text-xl">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div>
                                    <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Adjunto del Sistema</p>
                                    <p id="modalFileName" class="text-[0.7rem] font-black text-white truncate max-w-[200px] uppercase italic">documento.pdf</p>
                                </div>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank" class="bg-white text-slate-950 hover:bg-indigo-500 hover:text-white font-black px-8 py-4 rounded-2xl transition-all shadow-2xl text-[0.65rem] uppercase tracking-widest italic flex items-center gap-3 shrink-0">
                                <i class="fas fa-download"></i>
                                DESCARGAR
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-slate-950/60 border-t border-white/5 text-center">
                    <p class="text-[0.6rem] font-black text-slate-700 uppercase tracking-[0.6em] italic">Knowledge Core v4.0 • Atomic Dev 🚀</p>
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

window.onclick = function(event) {
    const modal = document.getElementById('knowledgeModal');
    if (event.target == modal.children[0] || event.target.classList.contains('min-h-full')) {
        closeKnowledgeModal();
    }
}
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(99, 102, 241, 0.2); }
</style>
@endsection
