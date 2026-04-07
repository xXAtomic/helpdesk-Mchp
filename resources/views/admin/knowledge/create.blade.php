@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <!-- Header Minimalista -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase mb-2">
            Nueva <span class="text-indigo-600">Recomendación</span>
        </h1>
        <p class="text-slate-500 font-medium tracking-wide">Publicar nuevo manual o recomendación en la base de conocimiento.</p>
    </div>

    <!-- Formulario Pro-SaaS -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <form action="{{ route('admin.knowledge.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Título -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Título de la Recomendación</label>
                    <input type="text" name="title" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300"
                        placeholder="Ej: Cómo configurar el correo institucional">
                </div>

                <!-- Categoría -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Tipo de Contenido</label>
                    <select name="category" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="Manual">📖 Manual Operativo</option>
                        <option value="Recomendación">💡 Recomendación / Tip</option>
                        <option value="Guía">📂 Guía Técnica</option>
                    </select>
                </div>

                <!-- Icono -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Icono (Emoji)</label>
                    <input type="text" name="icon"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300"
                        placeholder="Ej: 🛡️, 🧹, 📡" value="📖">
                </div>
            </div>

            <!-- Contenido -->
            <div class="space-y-2">
                <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Contenido / Instrucciones</label>
                <textarea name="content" rows="8" required
                    class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-medium focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300"
                    placeholder="Escribe aquí el detalle de la recomendación..."></textarea>
            </div>

            <!-- Carga de Archivo -->
            <div class="space-y-2">
                <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Adjuntar Manual (PDF/Imagen)</label>
                <label for="knowledge-file" class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-10 hover:border-indigo-400 transition-all bg-slate-50 flex flex-col items-center cursor-pointer">
                    <input type="file" name="file" id="knowledge-file" class="hidden">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform text-indigo-600">
                       <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <span id="file-label" class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest transition-all">Seleccionar Archivo</span>
                    <p class="text-[0.55rem] text-slate-400 mt-2 uppercase tracking-tighter italic">Click para buscar en tu equipo</p>
                </label>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-6 flex gap-4">
                <button type="submit"
                    class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-black py-5 rounded-xl transition-all shadow-lg hover:shadow-slate-200 uppercase tracking-widest italic">
                    Publicar Recomendación
                </button>
                <a href="{{ route('admin.knowledge.index') }}"
                    class="px-8 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold py-5 rounded-xl transition-all uppercase tracking-widest flex items-center">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('knowledge-file').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || "Seleccionar Archivo";
        document.getElementById('file-label').textContent = fileName;
    });
</script>
@endsection
