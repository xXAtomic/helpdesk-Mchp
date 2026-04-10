@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE CUMPLIMIENTO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Gestión de Responsabilidad y Cumplimiento</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(99,102,241,0.5)]"></span>
                Gravity Compliance Engine • Legal Documentation
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.compliance.create') }}" 
               class="bg-indigo-600 hover:bg-white hover:text-slate-950 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-indigo-500/20 flex items-center gap-3 group">
                <i class="fas fa-file-contract group-hover:scale-110 transition-transform"></i>
                Nueva Plantilla +
            </a>
        </div>
    </div>

    <!-- CUADRÍCULA DE PROTOCOLOS LEGADOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($documents as $doc)
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[2.5rem] border border-white/5 shadow-2xl hover:border-indigo-500/30 transition-all group relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-600/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all"></div>
                
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="px-3 py-1 bg-slate-950 text-slate-500 text-[0.55rem] font-black uppercase tracking-widest rounded-lg border border-white/5 italic shadow-inner">v.{{ $doc->version }}</span>
                        @if($doc->requires_asset)
                            <span class="px-3 py-1 bg-amber-500/10 text-amber-500 text-[0.55rem] font-black uppercase tracking-widest rounded-lg border border-amber-500/20 italic shadow-lg shadow-amber-500/5">Vínculo a Activo</span>
                        @endif
                    </div>

                    <h3 class="text-xl font-black text-white uppercase italic tracking-tighter mb-6 leading-tight group-hover:text-indigo-400 transition-colors">{{ $doc->title }}</h3>
                    
                    <div class="mt-auto flex items-center justify-between pt-8 border-t border-white/5">
                        <div>
                            <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest italic mb-2">Firmas Integradas</p>
                            <div class="flex items-center gap-3">
                                <p class="text-2xl font-black text-white italic leading-none group-hover:text-indigo-500 transition-colors">{{ $doc->signatures_count }}</p>
                                <span class="text-[0.5rem] font-black text-slate-700 uppercase tracking-tighter">Registros</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.compliance.edit', $doc->id) }}" class="w-10 h-10 bg-slate-950 rounded-xl flex items-center justify-center text-slate-600 border border-white/5 hover:text-white hover:bg-slate-800 transition-all" title="Editar Estructura">
                                <i class="fas fa-edit text-[10px]"></i>
                            </a>
                            <a href="{{ route('admin.compliance.show', $doc->id) }}" class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-xl hover:bg-white hover:text-slate-950 transition-all" title="Ver Métrica Base">
                                <i class="fas fa-eye text-[10px]"></i>
                            </a>
                            <form action="{{ route('admin.compliance.destroy', $doc->id) }}" method="POST" onsubmit="return prompt('Para confirmar la eliminación definitiva de esta plantilla y TODAS sus firmas, escriba ELIMINAR:') === 'ELIMINAR';" class="inline text-[0.65rem] font-black uppercase italic">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-slate-950 rounded-xl flex items-center justify-center text-slate-800 border border-white/5 hover:bg-rose-600 hover:text-white hover:border-rose-500 transition-all" title="Eliminar Protocolo">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center bg-slate-900/40 rounded-[3rem] border border-dashed border-white/5">
                <i class="fas fa-shield-alt text-slate-800 text-5xl mb-6 opacity-20"></i>
                <p class="text-slate-600 font-black uppercase tracking-[0.4em] italic text-[0.65rem]">Protocolo de Seguridad Inactivo: Sin documentos legales.</p>
            </div>
        @endforelse
    </div>

    <!-- INFO PIE -->
    <div class="mt-12 flex justify-center">
        <p class="text-[0.5rem] font-black text-slate-800 uppercase tracking-[0.5em] italic">
            Gravity Compliance Hub • Atomic Dev 2024
        </p>
    </div>
</div>
@endsection
