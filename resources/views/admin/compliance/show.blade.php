@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between border-b border-slate-100 pb-10">
        <div>
            <a href="{{ route('admin.compliance.index') }}" class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-slate-900 transition-all flex items-center gap-2 italic mb-6">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
            <h1 class="text-4xl font-black text-slate-950 tracking-tighter uppercase italic leading-tight">{{ $document->title }}</h1>
            <p class="text-[0.65rem] font-black text-indigo-500 uppercase tracking-widest mt-3 italic">Versión Actual: {{ $document->version }} • Reporte de Cumplimiento</p>
        </div>
        <div class="mt-8 md:mt-0 bg-slate-950 px-8 py-5 rounded-2xl text-center shadow-xl">
            <p class="text-[0.55rem] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Total Firmas</p>
            <p class="text-2xl font-black text-white italic leading-none">{{ $document->signatures->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
        <!-- Detalle del Contrato/Documento -->
        <div class="xl:col-span-1">
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl relative overflow-hidden h-fit">
                <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16"></div>
                <h4 class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-8 italic relative z-10">Contenido del Template</h4>
                <div class="prose prose-sm prose-slate max-w-none text-slate-600 italic leading-relaxed line-clamp-10 relative z-10">
                    {!! nl2br(e($document->content)) !!}
                </div>
                <div class="mt-8 pt-8 border-t border-slate-50 flex justify-center">
                    <a href="{{ route('admin.compliance.edit', $document->id) }}" class="text-[0.65rem] font-black text-indigo-600 uppercase tracking-widest hover:text-slate-950 transition-all italic">Editar Contenido <i class="fas fa-edit ml-2"></i></a>
                </div>
            </div>
        </div>

        <!-- Tabla de Firmantes -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-2xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-950">
                            <th class="px-8 py-6 text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic">Usuario</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic">Fecha de Firma</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic">Metadatos (IP/Token)</th>
                            <th class="px-8 py-6 text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($document->signatures as $signature)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-black text-xs group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                            {{ strtoupper(substr($signature->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 uppercase italic">{{ $signature->user->name }}</p>
                                            <p class="text-[0.6rem] font-bold text-slate-400 italic">{{ $signature->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="text-xs font-black text-slate-700 italic">{{ $signature->signed_at->format('d/m/Y') }}</p>
                                    <p class="text-[0.6rem] font-bold text-slate-400 italic">{{ $signature->signed_at->format('H:i') }} hrs</p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[0.55rem] font-black text-slate-400 uppercase italic">IP: {{ $signature->ip_address }}</span>
                                        <span class="text-[0.5rem] font-mono text-slate-300 truncate w-32" title="{{ $signature->signature_token }}">ID: {{ $signature->signature_token }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[0.55rem] font-black uppercase tracking-widest rounded-full italic border border-emerald-100">
                                            Firma Válida
                                        </span>
                                        <form action="{{ route('admin.compliance.signature.destroy', $signature->id) }}" method="POST" onsubmit="return prompt('Para anular esta firma permanentemente, escriba ELIMINAR:') === 'ELIMINAR';">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-600 transition-colors p-2">
                                                <i class="fas fa-trash-alt text-[0.65rem]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <p class="text-sm font-bold text-slate-300 uppercase tracking-[0.3em] italic">Aún no hay firmas registradas para este documento</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
