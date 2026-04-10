@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA OPERATIVA CENTRAL -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Sistema de Gestión TI • Apertura de Incidente</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,1)]"></span>
                Protocolo de Asistencia Técnica • Admin Console
            </p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="text-[0.65rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.3em] flex items-center gap-4 bg-slate-900 px-6 py-3 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-xs"></i>
            Regresar al Centro de Control
        </a>
    </div>

    <!-- PANEL DE COMANDO (GLASSMORPHISM) -->
    <div class="max-w-4xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600/5 rounded-full blur-3xl"></div>
        
        <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10">
            @csrf
            
            <!-- SECCIÓN: IDENTIFICACIÓN DEL USUARIO -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Usuario Solicitante / Endpoint</label>
                <div class="relative">
                    <select name="user_id" required 
                            class="w-full px-8 py-6 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.85rem] focus:border-indigo-500 transition-all outline-none appearance-none tracking-widest italic uppercase">
                        <option value="" class="text-slate-700">-- SELECCIONAR IDENTIDAD --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} • {{ $user->email }} @if($user->department) • [{{ $user->department->name }}] @endif
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-8 top-1/2 -translate-y-1/2 text-slate-800 pointer-events-none"></i>
                </div>
                @error('user_id')
                    <p class="text-[0.6rem] text-rose-500 font-black mt-2 uppercase tracking-widest italic">⚠ {{ $message }}</p>
                @enderror
            </div>

            <!-- SECCIÓN: ASUNTO TÉCNICO -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Identificador del Incidente</label>
                <div class="relative">
                    <input type="text" name="title" id="ticket-title" required value="{{ old('title') }}"
                           class="w-full px-8 py-7 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[1.1rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase tracking-tighter"
                           placeholder="RESUMEN DEL FALLO O REQUERIMIENTO...">
                    
                    <div class="absolute right-8 top-1/2 -translate-y-1/2 flex items-center gap-3 opacity-20 pointer-events-none group-focus-within:opacity-60 transition-all">
                        <span class="text-[0.5rem] font-black text-indigo-400 uppercase tracking-widest">Neural Link Active</span>
                        <i class="fas fa-brain text-indigo-500"></i>
                    </div>
                </div>
            </div>

            <!-- GRAVITYBRAIN: PANEL IA -->
            <div id="gravity-brain-panel" class="hidden transition-all duration-700 animate-in fade-in slide-in-from-top-4">
                <div class="bg-indigo-600/10 p-10 rounded-[2.5rem] border border-indigo-500/20 shadow-2xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                                <i class="fas fa-robot"></i>
                            </div>
                            <p class="text-[0.7rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic leading-none">Análisis Automático de Soluciones</p>
                        </div>
                        <div id="suggestions-container" class="space-y-4">
                            <!-- Inyección JS -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATOS OPERATIVOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Segmento de Servicio</label>
                    <div class="relative">
                        <select name="category_id" required 
                                class="w-full px-8 py-5 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none tracking-widest italic uppercase">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-layer-group absolute right-8 top-1/2 -translate-y-1/2 text-slate-800"></i>
                    </div>
                </div>
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Protocolo de Prioridad</label>
                    <div class="relative">
                        <select name="priority_id" required 
                                class="w-full px-8 py-5 rounded-2xl bg-slate-950 border border-white/5 text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none tracking-widest italic uppercase">
                            @foreach($priorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-bolt absolute right-8 top-1/2 -translate-y-1/2 text-slate-800"></i>
                    </div>
                </div>
            </div>

            <!-- DESCRIPCIÓN DETALLADA -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic">Detalle Técnico / Bitácora</label>
                <textarea name="description" rows="8" required 
                          class="w-full px-8 py-8 rounded-[2.5rem] bg-slate-950 border border-white/5 text-slate-300 font-medium text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 leading-relaxed italic"
                          placeholder="DESCRIPCIÓN EXHAUSTIVA DEL REQUERIMIENTO..."></textarea>
            </div>

            <!-- ADJUNTOS -->
            <div class="bg-slate-950/50 p-12 rounded-[3rem] border-2 border-dashed border-white/5 text-center transition-all hover:border-indigo-500/40 relative group overflow-hidden">
                <input type="file" name="attachments[]" id="file-upload" multiple class="hidden">
                <label for="file-upload" class="cursor-pointer flex flex-col items-center">
                    <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-xl">
                        <i class="fas fa-paperclip text-xl"></i>
                    </div>
                    <span id="file-text" class="text-[0.65rem] font-black text-slate-400 uppercase tracking-widest bg-slate-900 px-8 py-3 rounded-xl border border-white/5 transition-all group-hover:text-white italic">Anexar Soporte Documental</span>
                </label>
            </div>

            <!-- ACCIONES -->
            <div class="pt-10 flex flex-col sm:flex-row gap-6 justify-end">
                <a href="{{ route('admin.tickets.index') }}" class="px-12 py-6 rounded-2xl bg-slate-950 text-slate-600 font-black text-[0.7rem] uppercase tracking-widest hover:text-white transition-all text-center italic border border-white/5">
                    Cancelar Apertura
                </a>
                <button type="submit" 
                        class="px-16 py-6 rounded-2xl bg-white text-slate-950 font-black text-[0.7rem] uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all transform hover:-translate-y-1 shadow-3xl italic flex items-center justify-center gap-4 group">
                    REGISTRAR INCIDENTE
                    <i class="fas fa-check-circle text-xs group-hover:scale-125 transition-transform"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileText = document.getElementById('file-text');
        const count = e.target.files.length;
        fileText.innerHTML = count > 0 ? `✅ ${count} ARCHIVOS CARGADOS` : 'Anexar Soporte Documental';
        if(count > 0) fileText.classList.add('border-indigo-500', 'text-indigo-400');
    });

    let searchTimer;
    const titleInput = document.getElementById('ticket-title');
    const brainPanel = document.getElementById('gravity-brain-panel');
    const container = document.getElementById('suggestions-container');

    titleInput.addEventListener('input', function() {
        clearTimeout(searchTimer);
        const query = this.value;
        if (query.length < 4) { brainPanel.classList.add('hidden'); return; }

        searchTimer = setTimeout(() => {
            fetch(`/gravity-brain/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        brainPanel.classList.remove('hidden');
                        container.innerHTML = data.map(article => `
                            <a href="/knowledge/${article.id}" target="_blank" class="block p-6 bg-slate-950/60 hover:bg-slate-950 rounded-2xl border border-white/5 transition-all group">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-white font-black text-sm uppercase italic tracking-tight group-hover:text-indigo-400 transition-colors">${article.title}</h4>
                                    <span class="text-[0.55rem] font-black text-indigo-400 border border-indigo-400/30 px-4 py-2 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all uppercase tracking-widest italic">Ver Ficha</span>
                                </div>
                            </a>
                        `).join('');
                    } else { brainPanel.classList.add('hidden'); }
                });
        }, 600);
    });
</script>
@endsection
