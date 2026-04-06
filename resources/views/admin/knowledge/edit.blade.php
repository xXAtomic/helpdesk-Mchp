@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <!-- Header Minimalista -->
    <div class="mb-12">
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter italic uppercase mb-2">
            Editar <span class="text-indigo-600">Recomendación</span>
        </h1>
        <p class="text-slate-500 font-medium tracking-wide">Actualizar manual o recomendación en la base de conocimiento.</p>
    </div>

    <!-- Formulario Pro-SaaS -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <form action="{{ route('admin.knowledge.update', $manual->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Título -->
                <div class="space-y-2">
                    <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Título de la Recomendación</label>
                    <input type="text" name="title" required value="{{ old('title', $manual->title) }}"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Categoría -->
                    <div class="space-y-2">
                        <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Tipo de Contenido</label>
                        <select name="category" required
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="Manual" {{ $manual->category == 'Manual' ? 'selected' : '' }}>📖 Manual Operativo</option>
                            <option value="Recomendación" {{ $manual->category == 'Recomendación' ? 'selected' : '' }}>💡 Recomendación / Tip</option>
                            <option value="Guía" {{ $manual->category == 'Guía' ? 'selected' : '' }}>📂 Guía Técnica</option>
                        </select>
                    </div>

                    <!-- Icono -->
                    <div class="space-y-2">
                        <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Icono (Emoji)</label>
                        <input type="text" name="icon"
                            class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-semibold focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300"
                            value="{{ old('icon', $manual->icon) }}">
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="space-y-2">
                <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Contenido / Instrucciones</label>
                <textarea name="content" rows="8" required
                    class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl text-slate-900 font-medium focus:ring-2 focus:ring-indigo-500 transition-all placeholder:text-slate-300">{{ old('content', $manual->content) }}</textarea>
            </div>

            <!-- Carga de Archivo -->
            <div class="space-y-4">
                <label class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest ml-1">Reemplazar Manual (PDF/Imagen)</label>
                
                @if($manual->file_path)
                    <div class="flex items-center gap-3 p-4 bg-indigo-50 border border-indigo-100 rounded-xl mb-4">
                        <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Archivo Actual:</p>
                            <p class="text-sm font-bold text-indigo-950 truncate">{{ $manual->file_name }}</p>
                        </div>
                    </div>
                @endif

                <div class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-8 hover:border-indigo-400 transition-all bg-slate-50">
                    <input type="file" name="file" id="knowledge-file-edit" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform text-indigo-600">
                           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        </div>
                        <span id="file-label-edit" class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest transition-all italic">Seleccionar Nuevo Archivo</span>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="pt-6 flex gap-4">
                <button type="submit"
                    class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-black py-5 rounded-xl transition-all shadow-lg hover:shadow-slate-200 uppercase tracking-widest italic">
                    Actualizar Recomendación
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
    document.getElementById('knowledge-file-edit').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || "Seleccionar Archivo";
        document.getElementById('file-label-edit').textContent = fileName;
    });
</script>
@endsection
