@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE BIBLIOTECA PREMIUM -->
    <div class="mb-16 text-center border-b border-white/5 pb-12">
        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Repositorio Digital y Guías de Autogestión</h1>
        <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center justify-center gap-2 italic">
            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,1)]"></span>
            Gravity Knowledge Base • Protocolos de Solución
        </p>
    </div>

    <!-- BUSCADOR NEURAL (GLASSMORPHISM) -->
    <div class="mb-20 max-w-2xl mx-auto relative group">
        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur opacity-20 group-focus-within:opacity-50 transition-all duration-700"></div>
        <div class="relative bg-slate-900/60 backdrop-blur-2xl p-2 rounded-2xl border border-white/10 flex shadow-2xl">
            <div class="p-4 text-indigo-400">
                <i class="fas fa-search text-xl"></i>
            </div>
            <input type="text" placeholder="¿QUÉ SOLUCIÓN TÉCNICA NECESITAS HOY?..." 
                   class="flex-1 bg-transparent border-none outline-none text-white font-black placeholder:text-slate-700 text-[0.7rem] italic tracking-widest uppercase py-2 pr-6">
        </div>
    </div>

    <!-- GRID DE MÓDULOS OPERATIVOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($articles as $article)
            @php $p = $article->file_path ? asset('storage/' . $article->file_path) : ''; @endphp
            <div onclick="openKnowledgeModal('{{ addslashes($article->title) }}', '{{ addslashes($article->content) }}', '{{ $article->category }}', '{{ $article->icon }}', '{{ $p }}', '{{ addslashes($article->file_name) }}')"
                 class="group bg-slate-900/40 backdrop-blur-xl p-10 rounded-[2.5rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 transition-all duration-500 flex flex-col justify-between overflow-hidden relative cursor-pointer">
                
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-600/5 rounded-full blur-2xl group-hover:bg-indigo-600/10 transition-all"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 bg-slate-950 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/5 group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-700 shadow-2xl">
                            {{ $article->icon ?? '📖' }}
                        </div>
                        <span class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest italic tracking-tighter">{{ $article->updated_at->format('M Y') }}</span>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white tracking-tighter mb-4 group-hover:text-indigo-400 transition-colors uppercase italic leading-none">{{ $article->title }}</h3>
                    
                    <div class="h-1 w-12 bg-white/5 mb-6 group-hover:w-full group-hover:bg-indigo-500 transition-all duration-500"></div>
                    
                    <p class="text-[0.7rem] font-black text-slate-500 leading-relaxed uppercase tracking-widest italic mb-12 opacity-80 group-hover:text-slate-400 transition-colors">
                        {{ Str::limit(strip_tags($article->content), 120) }}
                    </p>
                </div>
                
                <div class="relative z-10 inline-flex items-center gap-3 text-[0.65rem] font-black text-slate-600 group-hover:text-indigo-400 uppercase tracking-widest transition-all italic">
                    ACCEDER AL PROTOCOLO <span class="group-hover:translate-x-2 transition-transform">→</span>
                </div>
            </div>
        @endforeach
    </div>

    @if($articles->isEmpty())
        <div class="py-32 text-center bg-slate-900/10 rounded-[3rem] border-2 border-dashed border-white/5">
            <i class="fas fa-layer-group text-slate-900 text-6xl mb-6 opacity-20"></i>
            <p class="text-[0.7rem] font-black text-slate-700 uppercase tracking-widest italic">Sector de Conocimiento Vacío: Sin activos publicados de momento.</p>
        </div>
    @endif
</div>

<!-- MODAL DE LECTURA PREMIUM (DARK) -->
<div id="knowledgeModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl transition-opacity" onclick="closeKnowledgeModal()"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto px-4 sm:px-0">
        <div class="flex min-h-full items-center justify-center">
            <div class="relative bg-slate-900 border border-white/10 rounded-[3rem] shadow-3xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                
                <!-- Header del Modal -->
                <div class="bg-slate-950 p-10 border-b border-white/5 relative overflow-hidden shrink-0">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
                    
                    <button onclick="closeKnowledgeModal()" class="absolute right-8 top-8 text-slate-500 hover:text-white transition-all p-3 bg-white/5 rounded-2xl hover:rotate-90 hover:bg-rose-600/20">
                        <i class="fas fa-times text-xl"></i>
                    </button>

                    <div class="flex items-center gap-6 relative z-10">
                        <div id="modalIcon" class="w-20 h-20 bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-5xl shadow-2xl border border-white/5 shrink-0">📖</div>
                        <div>
                            <span id="modalCategory" class="px-4 py-1.5 bg-indigo-500/10 border border-indigo-500/20 text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic mb-3 inline-block rounded-xl shadow-lg">BIBLIOTECA TI</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-white tracking-tighter italic uppercase leading-tight">DETALLE DEL MANUAL</h2>
                        </div>
                    </div>
                </div>

                <!-- Contenido del Modal -->
                <div class="overflow-y-auto custom-scrollbar p-10 sm:p-12 bg-slate-900/50">
                    <div class="border-l-4 border-indigo-600 pl-8 py-2 mb-12">
                        <p id="modalDescription" class="text-slate-200 font-black uppercase italic tracking-tighter leading-relaxed text-sm whitespace-pre-line"></p>
                    </div>

                    <div id="modalFileSection" class="mt-12 p-8 bg-slate-950 rounded-[2.5rem] border border-white/5 hidden relative overflow-hidden group">
                        <div class="absolute inset-0 bg-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6 relative z-10">
                            <div>
                                <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Archivo Sincronizado</p>
                                <p id="modalFileName" class="text-[0.75rem] font-bold text-white uppercase italic truncate max-w-[250px]">DOCUMENTO_TECNICO.PDF</p>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank" class="w-full sm:w-auto bg-white text-slate-950 hover:bg-indigo-600 hover:text-white px-8 py-4 rounded-2xl font-black transition-all shadow-2xl text-[0.65rem] uppercase tracking-widest italic flex items-center justify-center gap-3">
                                <i class="fas fa-cloud-download-alt text-lg"></i>
                                DESCARGAR RECURSO
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="p-8 bg-slate-950 border-t border-white/5 text-center shrink-0">
                    <p class="text-[0.55rem] font-black text-slate-800 uppercase tracking-[0.6em] italic leading-none">
                        Gravity Knowledge Node &copy; {{ date('Y') }} • Data Archival Protocol
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 20px; }
</style>

<script>
function openKnowledgeModal(title, content, category, icon, fileUrl, fileName) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = content;
    document.getElementById('modalCategory').textContent = category || 'RECURSO TI';
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
</script>
@endsection
