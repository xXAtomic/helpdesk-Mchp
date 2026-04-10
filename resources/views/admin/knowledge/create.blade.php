@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE CREACIÓN DE CONOCIMIENTO -->
    <div class="mb-16 border-b border-white/5 pb-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Codificación de <span class="text-indigo-500">Nueva Directiva</span> Neural
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic">
                <i class="fas fa-brain text-indigo-400"></i>
                Generación de Manual Operativo • Gravity Brain
            </p>
        </div>
        <a href="{{ route('admin.knowledge.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Abortar Edición
        </a>
    </div>

    <!-- PANEL DE ESCRITURA (GLASSMORPHISM) -->
    <div class="max-w-5xl mx-auto bg-slate-900/40 backdrop-blur-xl p-10 md:p-14 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
        
        <form action="{{ route('admin.knowledge.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12 relative z-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Título Master -->
                <div class="md:col-span-2 space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-indigo-400 transition-colors">Título del Protocolo / Manual</label>
                    <input type="text" name="title" required
                        class="w-full px-8 py-6 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[1.1rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase tracking-tighter"
                        placeholder="EJ: CONFIGURACIÓN SEGURA DE ACCESO REMOTO">
                </div>

                <!-- Categoría Táctica -->
                <div class="space-y-4">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Tipo de Protocolo</label>
                    <div class="relative">
                        <select name="category" required
                            class="w-full px-8 py-5 bg-slate-950 border border-white/5 rounded-2xl text-white font-black text-[0.75rem] focus:border-indigo-500 transition-all outline-none appearance-none italic uppercase tracking-widest custom-select">
                            <option value="Manual">📖 Manual Operativo Central</option>
                            <option value="Recomendación">💡 Recomendación / Tip TI</option>
                            <option value="Guía">📂 Directiva Técnica</option>
                        </select>
                        <i class="fas fa-layer-group absolute right-8 top-1/2 -translate-y-1/2 text-slate-800"></i>
                    </div>
                </div>

                <!-- Icono de Ficha -->
                <div class="space-y-4 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Iconografía de Ficha</label>
                    <div class="relative">
                        <input type="text" name="icon"
                            class="w-full px-8 py-5 bg-slate-950 border border-white/5 rounded-2xl text-indigo-400 font-black text-[1rem] focus:border-indigo-500 transition-all outline-none text-center"
                            placeholder="EJ: 🛡️, 🧹, 📡" value="📖">
                    </div>
                </div>
            </div>

            <!-- Editor de Contenido Deep Dark -->
            <div class="space-y-4 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Cuerpo del Protocolo (Instrucciones Técnicas)</label>
                <textarea name="content" rows="12" required
                    class="w-full px-10 py-10 bg-slate-950 border border-white/5 rounded-[2.5rem] text-slate-300 font-black text-[0.9rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 leading-relaxed italic uppercase tracking-tighter shadow-inner"
                    placeholder="INTRODUZCA LAS INSTRUCCIONES PASO A PASO PARA EL USUARIO FINAL..."></textarea>
            </div>

            <!-- File Upload Táctico -->
            <div class="space-y-4">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic leading-none">Sincronizar Documentación PDF/Media</label>
                <label for="knowledge-file" class="relative group border-2 border-dashed border-white/5 rounded-[3rem] p-12 hover:border-indigo-500/40 transition-all bg-slate-950/50 flex flex-col items-center cursor-pointer overflow-hidden">
                    <input type="file" name="file" id="knowledge-file" class="hidden">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-2xl group-hover:scale-150 transition-all"></div>
                    <div class="w-16 h-16 bg-slate-900 rounded-2xl border border-white/5 shadow-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all relative z-10">
                       <i class="fas fa-cloud-upload-alt text-2xl"></i>
                    </div>
                    <span id="file-label" class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.3em] transition-all group-hover:text-white italic relative z-10">Vincular Archivo Maestro</span>
                    <p class="text-[0.55rem] text-slate-700 mt-6 uppercase tracking-[0.4em] italic relative z-10 border-t border-white/5 pt-4">Click para explorar terminal local</p>
                </label>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-10 flex flex-col sm:flex-row gap-6">
                <button type="submit"
                    class="flex-1 bg-white text-slate-950 hover:bg-indigo-600 hover:text-white font-black py-8 rounded-[2rem] transition-all shadow-3xl uppercase tracking-[0.4em] italic text-[0.8rem] flex items-center justify-center gap-6 group">
                    Publicar en Red Neural
                    <i class="fas fa-broadcast-tower text-[10px] group-hover:animate-pulse"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('knowledge-file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || "Vincular Archivo Maestro";
        const label = document.getElementById('file-label');
        label.textContent = fileName.toUpperCase();
        label.classList.add('text-indigo-400');
    });
</script>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
