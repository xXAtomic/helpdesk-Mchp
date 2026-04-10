@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA OPERATIVA -->
    <div class="mb-12 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Registro de Incidente Operativo</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,1)]"></span>
                Protocolo de Apertura • Entrada de Datos
            </p>
        </div>
        <a href="{{ route('user.tickets.index') }}" class="text-[0.65rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.3em] flex items-center gap-4 bg-slate-900 px-6 py-3 rounded-2xl border border-white/5 italic">
            <i class="fas fa-times-circle"></i>
            Abortar Operación
        </a>
    </div>

    <!-- PANEL DE REGISTRO (GLASSMORPHISM) -->
    <div class="max-w-4xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl"></div>
        
        <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10">
            @csrf
            
            <!-- ASUNTO: CAMPO TÁCTICO -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Identificador de la Solicitud</label>
                <div class="relative">
                    <input type="text" name="title" id="ticket-title" required autocomplete="off"
                           class="w-full px-8 py-7 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[1.1rem] tracking-tight focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 transition-all outline-none placeholder:text-slate-800 italic"
                           placeholder="RESUMEN BREVE DEL INCIDENTE...">
                    
                    <div class="absolute right-8 top-1/2 -translate-y-1/2 flex items-center gap-3 pointer-events-none opacity-20 group-focus-within:opacity-50 transition-all">
                         <span class="text-[0.5rem] font-black uppercase tracking-widest text-slate-400">NEURAL ENGINE ACTIVE</span>
                         <i class="fas fa-brain text-indigo-500 text-sm"></i>
                    </div>
                </div>
            </div>

            <!-- GRAVITYBRAIN: PANEL IA UNIFICADO -->
            <div id="gravity-brain-panel" class="hidden transition-all duration-700 animate-in fade-in slide-in-from-top-4">
                <div class="bg-indigo-600/10 p-10 rounded-[2.5rem] border border-indigo-500/20 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-5 mb-8 border-b border-indigo-500/10 pb-6">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/50">
                                <i class="fas fa-robot text-xl"></i>
                            </div>
                            <div>
                                <p class="text-[0.7rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic leading-none">Análisis de GravityBrain™</p>
                                <p class="text-[0.55rem] text-slate-500 font-bold uppercase tracking-widest mt-2">Hemos detectado soluciones potenciales en nuestra base de datos:</p>
                            </div>
                        </div>
                        <div id="suggestions-container" class="space-y-4">
                            <!-- Inyección dinámica -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATOS TÉCNICOS: SELECTS OSCUROS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Categoría de Servicio</label>
                    <div class="relative">
                        <select name="category_id" required 
                                class="w-full px-8 py-5 rounded-2xl bg-slate-950 border border-white/5 text-slate-300 font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase tracking-widest italic custom-select">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" class="bg-slate-950">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-800 text-xs pointer-events-none"></i>
                    </div>
                </div>
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Nivel de Prioridad TI</label>
                    <div class="relative">
                        <select name="priority_id" required 
                                class="w-full px-8 py-5 rounded-2xl bg-slate-950 border border-white/5 text-slate-300 font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none uppercase tracking-widest italic custom-select">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}" class="bg-slate-950">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-800 text-xs pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- DESCRIPCIÓN: TEXTAREA PROFUNDO -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Bitácora de Detalles</label>
                <textarea name="description" rows="8" required 
                          class="w-full px-8 py-8 rounded-[2.5rem] bg-slate-950 border border-white/5 text-slate-300 font-medium text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 leading-relaxed italic"
                          placeholder="PROPORCIONE UNA DESCRIPCIÓN PASO A PASO DEL INCIDENTE..."></textarea>
            </div>

            <!-- ADJUNTOS: ZONA DE CARGA NEÓN -->
            <div class="bg-slate-950/50 p-12 rounded-[3rem] border-2 border-dashed border-white/5 text-center transition-all hover:bg-slate-950 hover:border-indigo-500/40 group relative overflow-hidden">
                <input type="file" name="attachments[]" id="file-upload" multiple class="hidden">
                <label for="file-upload" class="cursor-pointer flex flex-col items-center relative z-10">
                    <div class="w-16 h-16 bg-slate-900 rounded-2xl shadow-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all group-hover:bg-indigo-600 group-hover:text-white border border-white/5">
                        <i class="fas fa-cloud-upload-alt text-xl"></i>
                    </div>
                    <span id="file-text" class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.3em] bg-slate-900 px-10 py-4 rounded-xl border border-white/5 shadow-2xl transition-all group-hover:text-white group-hover:border-indigo-500 italic">Anexar Evidencia Técnica</span>
                    <p class="text-[0.55rem] text-slate-700 font-bold mt-6 uppercase tracking-[0.4em] italic leading-none">Formatos Permitidos: Imagen / PDF (Máx 10MB)</p>
                </label>
            </div>

            <!-- BOTÓN DE ACCIÓN FINAL -->
            <div class="pt-10">
                <button type="submit" 
                        class="w-full bg-white text-slate-950 font-black py-8 rounded-[2rem] text-[0.85rem] uppercase tracking-[0.4em] shadow-[0_0_30px_rgba(255,255,255,0.1)] hover:bg-indigo-600 hover:text-white transition-all transform hover:-translate-y-1 active:scale-[0.98] italic flex items-center justify-center gap-4 group">
                    REGISTRAR EN TERMINAL
                    <i class="fas fa-paper-plane text-xs group-hover:translate-x-2 group-hover:-translate-y-2 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DE SOLUCIÓN PREDETERMINADA (DARK) -->
<div id="knowledgeModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto px-4 py-8">
        <div class="flex min-h-full items-center justify-center">
            <div class="relative bg-slate-900 border border-white/10 rounded-[3rem] shadow-3xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                
                <button onclick="closeKnowledgeModal()" class="absolute right-8 top-8 text-slate-500 hover:text-white transition-all p-3 bg-white/5 rounded-2xl hover:rotate-90 z-20">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <div class="overflow-y-auto p-12 bg-slate-900/50">
                    <div class="flex items-center gap-6 mb-12">
                        <div id="modalIcon" class="w-20 h-20 bg-slate-950 rounded-3xl flex items-center justify-center text-4xl shadow-2xl border border-white/10 shrink-0">📖</div>
                        <div>
                            <span id="modalCategory" class="px-4 py-1.5 bg-indigo-500/10 text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic mb-3 inline-block rounded-xl border border-indigo-500/20">Protocolo Sugerido</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-white tracking-tighter italic uppercase leading-none">Título</h2>
                        </div>
                    </div>

                    <div class="border-l-4 border-indigo-600 pl-8 py-3 mb-12">
                        <p id="modalDescription" class="text-slate-300 font-black text-sm uppercase italic tracking-tighter leading-relaxed whitespace-pre-line"></p>
                    </div>

                    <div id="modalFileSection" class="mt-12 p-8 bg-slate-950 rounded-[2.5rem] border border-white/5 hidden group">
                        <div class="flex items-center justify-between gap-6">
                            <div>
                                <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Manual Técnico Vinculado</p>
                                <p id="modalFileName" class="text-[0.7rem] font-bold text-white uppercase italic truncate max-w-[200px]">ARCHIVO.PDF</p>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank" class="bg-white text-slate-950 font-black px-8 py-4 rounded-xl transition-all shadow-2xl text-[0.6rem] uppercase tracking-widest italic flex items-center gap-3 hover:translate-x-2">
                                <i class="fas fa-download"></i>
                                Descargar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer del Modal con Acciones de Deflección -->
                <div class="p-10 bg-slate-950 border-t border-white/5 text-center flex flex-col items-center">
                    <p class="text-[0.65rem] font-black text-slate-600 uppercase tracking-widest italic mb-6">¿Se ha solucionado el incidente con esta información?</p>
                    <div class="flex gap-4">
                         <button onclick="closeKnowledgeModal()" class="px-10 py-4 bg-white/5 hover:bg-rose-600/20 text-slate-400 hover:text-rose-500 rounded-xl font-black text-[0.6rem] uppercase tracking-widest transition-all border border-white/5">No, necesito soporte</button>
                         <button id="solve-button" class="px-10 py-4 bg-emerald-600 hover:bg-white text-white hover:text-slate-950 rounded-xl font-black text-[0.6rem] uppercase tracking-widest transition-all shadow-[0_0_20px_rgba(16,185,129,0.3)]">Sí, solución confirmada ✨</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // INDICADOR DINÁMICO DE ARCHIVOS
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileText = document.getElementById('file-text');
        const count = e.target.files.length;
        fileText.innerHTML = count > 0 ? `<i class="fas fa-check-circle mr-2"></i> ${count} ARCHIVOS SINCRONIZADOS` : 'Anexar Evidencia Técnica';
        if(count > 0) fileText.classList.add('border-emerald-500', 'text-emerald-500');
    });

    let searchTimer;
    const titleInput = document.getElementById('ticket-title');
    const brainPanel = document.getElementById('gravity-brain-panel');
    const container = document.getElementById('suggestions-container');
    const solveBtn = document.getElementById('solve-button');
    let currentArticleId = null;

    function escapeJS(str) {
        if (!str) return '';
        return str.replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\n/g, '\\n').replace(/\r/g, '\\r');
    }

    function deflectTicket(articleId, method) {
        fetch('{{ route('gravity.brain.deflect') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ title: titleInput.value, article_id: articleId, method: method })
        }).then(() => {
            alert('¡SOLUCIÓN REGISTRADA! Nos alegra haberte ayudado. Esta acción optimiza el tiempo de respuesta global del sistema.');
            window.location.href = '{{ route('dashboard') }}';
        });
    }

    solveBtn.onclick = function() { deflectTicket(currentArticleId, 'ARTICLE'); };

    titleInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        const query = this.value;

        if (query.length < 4) {
            brainPanel.classList.add('hidden');
            return;
        }

        searchTimer = setTimeout(() => {
            fetch(`/gravity-brain/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        brainPanel.classList.remove('hidden');
                        container.innerHTML = data.map(article => `
                            <button type="button" onclick="openKnowledgeModal('${escapeJS(article.title)}', '${escapeJS(article.content)}', '${escapeJS(article.category)}', '${escapeJS(article.icon || '')}', '${article.file_path ? '/storage/'+article.file_path : ''}', '${escapeJS(article.file_name || '')}', ${article.id})"
                                    class="w-full p-8 bg-slate-950/60 hover:bg-slate-950/90 rounded-[2rem] border border-white/5 transition-all group text-left relative overflow-hidden shadow-2xl">
                                <div class="flex items-center justify-between relative z-10">
                                    <div class="flex items-center gap-6">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-3xl group-hover:bg-indigo-600 transition-all border border-white/5 shadow-inner">${article.icon || '📖'}</div>
                                        <div>
                                            <h4 class="text-white font-black text-[0.8rem] uppercase italic tracking-tight group-hover:text-indigo-400 transition-colors">${article.title}</h4>
                                            <p class="text-[0.6rem] text-slate-600 font-bold uppercase tracking-[0.2em] mt-1 italic leading-none">${article.category || 'TI'} • PROTOCOLO DE AUTOGESTIÓN</p>
                                        </div>
                                    </div>
                                    <span class="text-[0.55rem] font-black text-indigo-400 bg-indigo-500/10 px-5 py-2.5 rounded-xl group-hover:bg-white group-hover:text-slate-950 transition-all uppercase tracking-widest border border-indigo-500/30 italic shadow-lg">Ver Solución</span>
                                </div>
                            </button>
                        `).join('');
                    } else {
                        brainPanel.classList.add('hidden');
                    }
                });
        }, 600);
    });

    function openKnowledgeModal(title, content, category, icon, fileUrl, fileName, id) {
        currentArticleId = id;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDescription').textContent = content;
        document.getElementById('modalCategory').textContent = category || 'RECOMENDACIÓN NEURAL';
        document.getElementById('modalIcon').textContent = icon || '📖';
        const fileSection = document.getElementById('modalFileSection');
        if (fileUrl && fileUrl !== '') {
            fileSection.classList.remove('hidden');
            document.getElementById('modalFileLink').href = fileUrl;
            document.getElementById('modalFileName').textContent = fileName;
        } else { fileSection.classList.add('hidden'); }
        document.getElementById('knowledgeModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeKnowledgeModal() {
        document.getElementById('knowledgeModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>

<style>
    .custom-select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 1.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 3.5rem; }
</style>
@endsection
