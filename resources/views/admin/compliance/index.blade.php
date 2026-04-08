@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Gravity Compliance</h1>
            <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-3 italic">Gestión de Responsabilidad y Documentación Legal</p>
        </div>
        <a href="{{ route('admin.compliance.create') }}" class="mt-8 md:mt-0 bg-indigo-600 text-white px-10 py-4 rounded-2xl text-[0.7rem] font-black uppercase tracking-widest hover:bg-slate-950 transition-all shadow-xl shadow-indigo-100 italic">
            Nuevo Documento +
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($documents as $doc)
            <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl transition-all group relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-slate-50 rounded-full group-hover:bg-indigo-50 transition-colors"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[0.5rem] font-black uppercase tracking-widest rounded-md italic">Versión {{ $doc->version }}</span>
                        @if($doc->requires_asset)
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[0.5rem] font-black uppercase tracking-widest rounded-md italic">Vínculo a Activo</span>
                        @endif
                    </div>

                    <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-4 leading-tight">{{ $doc->title }}</h3>
                    
                    <div class="flex items-center justify-between mt-10 pt-6 border-t border-slate-50">
                        <div>
                            <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest italic mb-1">Firmas Recabadas</p>
                            <p class="text-lg font-black text-indigo-600 italic leading-none">{{ $doc->signatures_count }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.compliance.edit', $doc->id) }}" class="p-3 bg-slate-100 text-slate-400 rounded-xl hover:bg-slate-200 transition-all">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <a href="{{ route('admin.compliance.show', $doc->id) }}" class="p-3 bg-slate-950 text-white rounded-xl hover:bg-indigo-600 transition-all">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <form action="{{ route('admin.compliance.destroy', $doc->id) }}" method="POST" onsubmit="return prompt('Para confirmar la eliminación definitiva de esta plantilla y TODAS sus firmas, escriba ELIMINAR:') === 'ELIMINAR';" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 bg-rose-50 text-rose-400 rounded-xl hover:bg-rose-600 hover:text-white transition-all">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-200">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest italic">No hay documentos legales configurados</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
