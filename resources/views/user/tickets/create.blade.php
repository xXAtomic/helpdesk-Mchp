@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA PROFESIONAL -->
    <div class="mb-12 border-b border-gray-100 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Nueva Solicitud</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-2">Detalla tu requerimiento para una asistencia rápida</p>
        </div>
        <a href="{{ route('user.tickets.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-indigo-600 transition uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Cancelar
        </a>
    </div>

    <!-- FORMULARIO SaaS -->
    <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden">
        <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <!-- SECCIÓN 1: ASUNTO -->
            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Título de la Solicitud</label>
                <div class="relative">
                    <input type="text" name="title" id="ticket-title" required autocomplete="off"
                           class="w-full px-6 py-6 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-[1rem] focus:bg-white focus:border-indigo-500 transition-all outline-none placeholder:text-gray-300"
                           placeholder="Ej: Falla en conexión a servidor..">
                    
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 flex items-center gap-2 pointer-events-none opacity-20">
                         <span class="text-[0.5rem] font-black uppercase tracking-widest text-slate-400">Powered by GravityBrain</span>
                         <span class="text-xs">🧠</span>
                    </div>
                </div>
            </div>

            <!-- GRAVITYBRAIN SUGGESTIONS PANEL (INTEGRADO) -->
            <div id="gravity-brain-panel" class="hidden transition-all duration-500">
                <div class="bg-slate-900 p-8 rounded-[2rem] border-l-[10px] border-indigo-500 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-500/20 flex items-center justify-center border border-white/10">
                                <span class="text-xl">🧠</span>
                            </div>
                            <div>
                                <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic">Recomendaciones de GravityBrain</p>
                                <p class="text-[0.55rem] text-slate-500 font-bold uppercase tracking-widest mt-1">Hemos encontrado soluciones que podrían ahorrarte tiempo:</p>
                            </div>
                        </div>
                        <div id="suggestions-container" class="space-y-3">
                            <!-- Sugerencias inyectadas por JS -->
                        </div>
                        <p class="text-[0.5rem] text-slate-600 font-bold mt-6 text-center uppercase tracking-[0.3em] border-t border-white/5 pt-4">Si ninguna solución te ayuda, continúa con tu reporte</p>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: DATOS TÉCNICOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Categoría del Problema</label>
                    <select name="category_id" required 
                            class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Urgencia Requerida</label>
                    <select name="priority_id" required 
                            class="w-full px-6 py-5 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none">
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- SECCIÓN 3: DESCRIPCIÓN -->
            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] ml-2">Descripción Detallada</label>
                <textarea name="description" rows="6" required 
                          class="w-full px-8 py-6 rounded-[2rem] bg-gray-50 border-2 border-transparent text-slate-900 font-medium text-[0.95rem] focus:bg-white focus:border-indigo-500 transition-all outline-none placeholder:text-gray-300"
                          placeholder="Describe paso a paso lo que está ocurriendo.."></textarea>
            </div>

            <!-- SECCIÓN 4: ADJUNTOS -->
            <div class="bg-gray-50 p-10 rounded-[2.5rem] border-2 border-dashed border-gray-100 text-center transition-all hover:bg-white hover:border-indigo-200 group">
                <input type="file" name="attachments[]" id="file-upload" multiple class="hidden">
                <label for="file-upload" class="cursor-pointer flex flex-col items-center">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-5 group-hover:scale-110 transition-transform group-hover:bg-indigo-600 group-hover:text-white border">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <span id="file-text" class="text-[0.65rem] font-black text-slate-600 uppercase tracking-widest bg-white px-8 py-3 rounded-xl border-2 shadow-sm transition-all group-hover:border-indigo-600 italic">Adjuntar archivos de respaldo</span>
                    <p class="text-[0.55rem] text-slate-300 font-bold mt-4 uppercase tracking-widest italic">Capturas de pantalla o logs técnicos (Máx 10MB)</p>
                </label>
            </div>

            <div class="pt-8">
                <button type="submit" 
                        class="w-full bg-indigo-600 text-white font-black py-8 rounded-2xl text-[0.8rem] uppercase tracking-[0.25em] shadow-2xl shadow-indigo-500/30 hover:bg-slate-950 transition-all transform hover:-translate-y-1 active:scale-[0.98] border-b-4 border-indigo-900 italic">
                    Publicar solicitud en plataforma
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Información Moderno (Gravity Style) -->
<div id="knowledgeModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity"></div>
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all border border-slate-100 flex flex-col max-h-[90vh]">
                <button onclick="closeKnowledgeModal()" class="absolute right-8 top-8 text-slate-300 hover:text-slate-900 transition-all p-2 bg-slate-50 rounded-2xl hover:rotate-90 z-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div class="overflow-y-auto p-10 sm:p-12">
                    <div class="flex items-center gap-5 mb-10">
                        <div id="modalIcon" class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center text-4xl shadow-inner border border-slate-100 shrink-0">📖</div>
                        <div>
                            <span id="modalCategory" class="px-3 py-1 bg-indigo-50 text-[0.6rem] font-black text-indigo-600 uppercase tracking-[0.2em] italic mb-2 inline-block rounded-lg uppercase">SOLUCIÓN SUGERIDA</span>
                            <h2 id="modalTitle" class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">Título</h2>
                        </div>
                    </div>

                    <div class="border-l-4 border-indigo-500 pl-6 py-2 mb-10">
                        <p id="modalDescription" class="text-slate-600 font-medium leading-relaxed italic whitespace-pre-line text-base"></p>
                    </div>

                    <div id="modalFileSection" class="mt-10 p-8 bg-slate-50 rounded-3xl border border-slate-100 hidden">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Manual Completo (PDF/Imagen)</p>
                                <p id="modalFileName" class="text-sm font-bold text-slate-950 truncate max-w-[200px]">documento.pdf</p>
                            </div>
                            <a id="modalFileLink" href="#" target="_blank" class="bg-indigo-600 hover:bg-slate-900 text-white font-black px-6 py-3 rounded-xl transition-all shadow-lg text-[0.65rem] uppercase tracking-widest italic flex items-center gap-2 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Descargar
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-indigo-900 text-center flex flex-col items-center">
                    <p class="text-[0.65rem] font-black text-indigo-200 uppercase tracking-widest italic mb-4">¿Esta solución resolvió tu duda?</p>
                    <div class="flex gap-4">
                         <button onclick="closeKnowledgeModal()" class="px-8 py-3 bg-white/10 hover:bg-white text-indigo-100 hover:text-indigo-950 rounded-xl font-black text-[0.6rem] uppercase tracking-widest transition-all">No, enviaré el ticket</button>
                         <button id="solve-button" class="px-8 py-3 bg-indigo-500 hover:bg-white text-white hover:text-indigo-950 rounded-xl font-black text-[0.6rem] uppercase tracking-widest transition-all shadow-lg">Sí, cancelar ticket ✨</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // INDICADOR DE ARCHIVOS
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileText = document.getElementById('file-text');
        const count = e.target.files.length;
        fileText.innerHTML = count > 0 ? `✅ ${count} ARCHIVOS CARGADOS` : 'ADJUNTAR ARCHIVOS DE RESPALDO';
    });

    let searchTimer;
    const titleInput = document.getElementById('ticket-title');
    const brainPanel = document.getElementById('gravity-brain-panel');
    const container = document.getElementById('suggestions-container');
    const solveBtn = document.getElementById('solve-button');
    let currentArticleId = null;

    function escapeJS(str) {
        if (!str) return '';
        return str
            .replace(/\\/g, '\\\\')
            .replace(/'/g, "\\'")
            .replace(/"/g, '\\"')
            .replace(/\n/g, '\\n')
            .replace(/\r/g, '\\r');
    }

    function deflectTicket(articleId, method) {
        const title = titleInput.value;
        fetch('{{ route('gravity.brain.deflect') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                title: title,
                article_id: articleId,
                method: method
            })
        }).then(() => {
            alert('¡Genial! Nos alegra haberte ayudado. Esta acción ahorra tiempo valioso al equipo técnico.');
            window.location.href = '{{ route('dashboard') }}';
        });
    }

    solveBtn.onclick = function() {
        deflectTicket(currentArticleId, 'ARTICLE');
    };

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
                                    class="w-full p-6 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/5 transition-all group text-left">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center text-2xl group-hover:bg-indigo-600 transition-all">${article.icon || '📖'}</div>
                                        <div>
                                            <h4 class="text-white font-black text-sm uppercase italic tracking-tight">${article.title}</h4>
                                            <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-1">Manual de Autogestión • ${article.category || 'TI'}</p>
                                        </div>
                                    </div>
                                    <span class="text-[0.55rem] font-black text-indigo-400 bg-indigo-400/10 px-4 py-2 rounded-xl group-hover:bg-indigo-500 group-hover:text-white transition-all uppercase tracking-widest border border-indigo-400/20 shadow-lg">Ver Solución</span>
                                </div>
                            </button>
                        `).join('');
                    } else {
                        brainPanel.classList.add('hidden');
                    }
                });
        }, 500);
    });

    // FUNCIONES DEL MODAL
    function openKnowledgeModal(title, content, category, icon, fileUrl, fileName, id) {
        currentArticleId = id;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDescription').textContent = content;
        document.getElementById('modalCategory').textContent = category || 'RECOMENDACIÓN';
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
        if (event.target.classList.contains('fixed') && event.target.id === 'knowledgeModal') {
            closeKnowledgeModal();
        }
    }
</script>
@endsection
