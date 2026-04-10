@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- HEADER DE BÓVEDA DE CUMPLIMIENTO -->
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-white/5 pb-10 gap-10">
        <div>
            <a href="{{ route('admin.compliance.index') }}" class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] hover:text-white transition-all flex items-center gap-3 italic mb-8 group">
                <i class="fas fa-chevron-left group-hover:-translate-x-2 transition-transform"></i> Regresar al Repositorio Legal
            </a>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-tight">{{ $document->title }}</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.5em] mt-4 flex items-center gap-3 italic">
                <i class="fas fa-fingerprint animate-pulse text-indigo-500"></i>
                Protocolo de Certificación • Versión: {{ $document->version }}
            </p>
        </div>
        <div class="mt-8 md:mt-0 bg-slate-900 border border-white/5 px-10 py-6 rounded-[2rem] text-center shadow-3xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-indigo-600/5 group-hover:bg-indigo-600/10 transition-colors"></div>
            <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.3em] mb-2 italic relative z-10">Registros Biométricos / Firmas</p>
            <p class="text-3xl font-black text-white italic leading-none relative z-10">{{ $document->signatures->count() }}</p>
        </div>
    </div>

    <!-- CONTENEDOR TÁCTICO -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
        
        <!-- VISUALIZADOR DE PLANTILLA (IZQUIERDA) -->
        <div class="xl:col-span-1">
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3.5rem] border border-white/5 shadow-3xl relative overflow-hidden group">
                <div class="absolute -right-20 -top-20 w-48 h-48 bg-white/5 rounded-full blur-3xl group-hover:bg-indigo-600/5 transition-all"></div>
                
                <div class="flex items-center gap-4 mb-10 relative z-10">
                    <div class="w-1 h-6 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></div>
                    <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] italic leading-none pt-1">Estructura del Documento</h4>
                </div>

                <div class="bg-slate-950 p-8 rounded-[2rem] border border-white/5 text-[0.8rem] text-slate-400 italic leading-relaxed line-clamp-[15] relative z-10 font-black uppercase tracking-tighter">
                    {!! nl2br(e($document->content)) !!}
                </div>
                
                <div class="mt-10 pt-10 border-t border-white/5 flex justify-center relative z-10">
                    <a href="{{ route('admin.compliance.edit', $document->id) }}" class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.4em] hover:text-white transition-all italic flex items-center gap-3">
                        <i class="fas fa-edit text-xs"></i>
                        Remodelar Manual Legal
                    </a>
                </div>
            </div>
        </div>

        <!-- TABLA DE AUDITORÍA DE FIRMANTES (DERECHA) -->
        <div class="xl:col-span-2">
            <div class="bg-slate-900/40 backdrop-blur-xl rounded-[3.5rem] border border-white/5 shadow-3xl overflow-hidden relative">
                <div class="absolute inset-0 bg-indigo-600/5 pointer-events-none"></div>
                <div class="overflow-x-auto relative z-10">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-950 border-b border-white/5">
                                <th class="px-10 py-8 text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] italic">Agente / Usuario</th>
                                <th class="px-10 py-8 text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] italic">Registro Cronológico</th>
                                <th class="px-10 py-8 text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] italic">Vínculo Digital</th>
                                <th class="px-10 py-8 text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] italic text-right">Validación</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($document->signatures as $signature)
                                <tr class="hover:bg-white/5 transition-all group/tr">
                                    <td class="px-10 py-8">
                                        <div class="flex items-center gap-5">
                                            <div class="w-12 h-12 bg-slate-950 rounded-2xl flex items-center justify-center text-indigo-400 font-black text-[0.9rem] italic border border-white/10 group-hover/tr:bg-indigo-600 group-hover/tr:text-white transition-all shadow-inner">
                                                {{ strtoupper(substr($signature->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="text-[0.8rem] font-black text-white uppercase italic leading-none group-hover/tr:text-indigo-400 transition-colors">{{ $signature->user->name }}</p>
                                                <p class="text-[0.55rem] font-black text-slate-600 uppercase italic mt-2 tracking-widest">{{ $signature->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8">
                                        <p class="text-[0.7rem] font-black text-white italic leading-none uppercase">{{ $signature->signed_at->format('d M / Y') }}</p>
                                        <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-widest mt-2 italic">{{ $signature->signed_at->format('H:i') }} Z</p>
                                    </td>
                                    <td class="px-10 py-8">
                                        <div class="flex flex-col gap-2">
                                            <span class="text-[0.5rem] font-black text-indigo-400 uppercase italic flex items-center gap-2">
                                                <i class="fas fa-network-wired text-[8px]"></i> IP: {{ $signature->ip_address }}
                                            </span>
                                            <span class="text-[0.5rem] font-mono text-slate-700 truncate w-40 italic uppercase tracking-tighter" title="{{ $signature->signature_token }}">ID: {{ $signature->signature_token }}</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8">
                                        <div class="flex items-center justify-end gap-6">
                                            <span class="inline-flex items-center px-5 py-2 bg-emerald-600/10 text-emerald-500 text-[0.5rem] font-black uppercase tracking-[0.2em] rounded-xl italic border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                                                Certificado Válido
                                            </span>
                                            <form action="{{ route('admin.compliance.signature.destroy', $signature->id) }}" method="POST" onsubmit="return prompt('PARA ANULAR ESTA FIRMA PERMANENTEMENTE, ESCRIBA ELIMINAR:') === 'ELIMINAR';">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-800 hover:text-rose-500 transition-all p-3 hover:bg-rose-500/10 rounded-xl">
                                                    <i class="fas fa-trash-alt text-[0.65rem]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-32 text-center">
                                        <p class="text-[0.65rem] font-black text-slate-700 uppercase tracking-[0.8em] italic leading-none">Cero registros detectados en la base de datos legal</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ocultar barra de desplazamiento manteniendo funcionalidad */
    .overflow-x-auto::-webkit-scrollbar { display: none; }
    .overflow-x-auto { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
