@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA PROFESIONAL -->
    <div class="mb-12 border-b border-gray-100 pb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase italic">Registrar Incidente</h1>
            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest mt-2 italic">Apertura Manual de Ticket por Soporte TI</p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-indigo-600 transition uppercase tracking-widest flex items-center gap-2 italic">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al listado
        </a>
    </div>

    <!-- FORMULARIO SaaS ADMIN -->
    <div class="bg-white p-10 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
        <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10 relative z-10">
            @csrf
            
            <!-- SECCIÓN 0: USUARIO SOLICITANTE -->
            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] italic">Usuario / Solicitante</label>
                <select name="user_id" required 
                        class="w-full px-6 py-5 rounded-xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-[0.9rem] focus:bg-white focus:border-indigo-500 transition-all outline-none italic">
                    <option value="">-- SELECCIONE EL USUARIO --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }}) @if($user->department) - {{ $user->department->name }} @endif</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-xs text-red-500 font-bold mt-1 uppercase">{{ $message }}</p>
                @enderror
            </div>

            <!-- SECCIÓN 1: ASUNTO -->
            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] italic">Título del Incidente</label>
                <input type="text" name="title" id="ticket-title" required value="{{ old('title') }}"
                       class="w-full px-6 py-5 rounded-xl bg-gray-50 border-2 border-transparent text-slate-900 font-bold text-[0.9rem] focus:bg-white focus:border-indigo-500 transition-all outline-none placeholder:text-gray-300 italic"
                       placeholder="Ej: Falla en conexión a servidor de base de datos..">
            </div>

            <!-- GRAVITYBRAIN SUGGESTIONS PANEL -->
            <div id="gravity-brain-panel" class="hidden">
                <div class="bg-indigo-950 p-8 rounded-2xl border-l-8 border-indigo-500 shadow-xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
                            <span class="text-lg">🧠</span>
                        </div>
                        <p class="text-[0.6rem] font-black text-indigo-300 uppercase tracking-widest">GravityBrain: Sugerencias Encontradas</p>
                    </div>
                    <div id="suggestions-container" class="space-y-4">
                        <!-- Sugerencias aquí -->
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: DATOS TÉCNICOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] italic">Categoría</label>
                    <select name="category_id" required 
                            class="w-full px-6 py-5 rounded-xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none italic">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-4">
                    <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] italic">Prioridad de Atención</label>
                    <select name="priority_id" required 
                            class="w-full px-6 py-5 rounded-xl bg-gray-50 border-2 border-transparent text-slate-700 font-bold text-sm focus:border-indigo-500 transition-all outline-none italic">
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- SECCIÓN 3: DESCRIPCIÓN -->
            <div class="space-y-4">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.25em] italic">Descripción del Problema</label>
                <textarea name="description" rows="6" required 
                          class="w-full px-8 py-6 rounded-2xl bg-gray-50 border-2 border-transparent text-slate-900 font-medium text-[0.95rem] focus:bg-white focus:border-indigo-500 transition-all outline-none placeholder:text-gray-300 italic"
                          placeholder="Describe el incidente reportado por el usuario..">{{ old('description') }}</textarea>
            </div>

            <!-- SECCIÓN 4: ADJUNTOS -->
            <div class="bg-indigo-50/50 p-8 rounded-2xl border border-dashed border-indigo-200 text-center">
                <input type="file" name="attachments[]" id="file-upload" multiple class="hidden">
                <label for="file-upload" class="cursor-pointer group flex flex-col items-center">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <span id="file-text" class="text-[0.65rem] font-black text-slate-500 uppercase tracking-widest bg-white px-6 py-2 rounded-lg border shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-all italic">Anexar Evidencia Técnica</span>
                    <p class="text-[0.6rem] text-slate-300 font-bold mt-4 uppercase tracking-tighter italic">JPG, PNG, PDF, DOC, XLS (Máx 10MB)</p>
                </label>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row gap-4 justify-end">
                <a href="{{ route('admin.tickets.index') }}" class="px-12 py-6 rounded-xl bg-slate-100 text-slate-500 font-black text-[0.7rem] uppercase tracking-widest hover:bg-slate-200 transition-all text-center italic">
                    Descartar
                </a>
                <button type="submit" 
                        class="px-16 py-6 rounded-xl bg-slate-950 text-white font-black text-[0.7rem] uppercase tracking-widest shadow-2xl shadow-slate-500/20 hover:bg-indigo-600 transition-all transform hover:-translate-y-1 active:scale-95 italic">
                    Registrar en el Sistema
                </button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPTS PARA GRAVITYBRAIN Y UI -->
<script>
    // INDICADOR DE ARCHIVOS
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileText = document.getElementById('file-text');
        const count = e.target.files.length;
        fileText.innerHTML = count > 0 ? `✅ ${count} ARCHIVOS CARGADOS` : 'ANEXAR EVIDENCIA TÉCNICA';
    });

    // GRAVITYBRAIN SEARCH
    let searchTimer;
    const titleInput = document.getElementById('ticket-title');
    const brainPanel = document.getElementById('gravity-brain-panel');
    const container = document.getElementById('suggestions-container');

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
                            <a href="/knowledge/${article.id}" target="_blank" class="block p-5 bg-white/5 hover:bg-white/10 rounded-xl border border-white/5 transition-all group">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-white font-bold text-sm uppercase italic tracking-tight">${article.title}</h4>
                                    <span class="text-[0.55rem] font-bold text-indigo-400 bg-indigo-400/10 px-2 py-1 rounded">LEER SOLUCIÓN</span>
                                </div>
                            </a>
                        `).join('');
                    } else {
                        brainPanel.classList.add('hidden');
                    }
                });
        }, 500);
    });
</script>
@endsection
