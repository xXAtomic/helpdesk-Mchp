@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <a href="{{ route('admin.compliance.show', $document->id) }}" class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-slate-900 transition-all flex items-center gap-2 italic mb-6">
            <i class="fas fa-arrow-left"></i> Volver al reporte
        </a>
        <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Editar Documento</h1>
        <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-3 italic">Actualización de Normativa: {{ $document->title }}</p>
    </div>

    <form action="{{ route('admin.compliance.update', $document->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-2xl space-y-8">
            <div>
                <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Título del Documento</label>
                <input type="text" name="title" required value="{{ $document->title }}"
                       class="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white transition-all outline-none text-sm font-bold text-slate-900 italic">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Versión</label>
                    <input type="text" name="version" value="{{ $document->version }}"
                           class="w-full px-8 py-5 rounded-2xl bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white transition-all outline-none text-sm font-bold text-slate-900 italic">
                </div>
                <div class="flex items-center gap-8 pt-8">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="requires_asset" value="1" {{ $document->requires_asset ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                        </div>
                        <span class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest group-hover:text-indigo-600 transition-all italic">Vínculo a Activo</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" {{ $document->is_active ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-emerald-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                        </div>
                        <span class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest group-hover:text-emerald-500 transition-all italic">Activo</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-4 italic">Contenido Legal</label>
                <textarea name="content" rows="15" required
                          class="w-full px-8 py-6 rounded-3xl bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white transition-all outline-none text-sm font-medium text-slate-700 leading-relaxed italic">{{ $document->content }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.compliance.index') }}" class="px-10 py-5 rounded-2xl text-[0.65rem] font-black uppercase text-slate-400 hover:text-slate-900 transition-all italic">Cancelar</a>
            <button type="submit" class="bg-indigo-600 text-white px-14 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-slate-950 transition-all shadow-xl italic">
                Actualizar Normativa Gravity
            </button>
        </div>
    </form>
</div>
@endsection
