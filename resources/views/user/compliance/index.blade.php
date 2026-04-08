@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Mis Compromisos</h1>
        <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-3 italic">Gestión de Documentación y Responsabilidades de Usuario</p>
    </div>

    <!-- 🚩 DOCUMENTOS PENDIENTES -->
    <div class="mb-16">
        <h2 class="text-[0.65rem] font-black text-rose-500 uppercase tracking-[0.3em] mb-8 flex items-center gap-3 italic">
            <span class="w-10 h-[1px] bg-rose-200"></span> Pendientes de Firma
        </h2>
        
        @if($pending->isEmpty())
            <div class="bg-emerald-50 p-12 rounded-[3.5rem] border border-emerald-100 text-center relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/50 rounded-full blur-3xl"></div>
                <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-8 shadow-xl shadow-emerald-200">
                    <i class="fas fa-check-double"></i>
                </div>
                <h2 class="text-2xl font-black text-emerald-900 uppercase italic tracking-tighter mb-2">¡Todo al día!</h2>
                <p class="text-sm font-bold text-emerald-600/70 uppercase italic tracking-widest">No tienes documentos pendientes por firmar.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pending as $doc)
                    <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 hover:border-indigo-200 transition-all group">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white text-xl shadow-xl group-hover:bg-indigo-600 transition-all">
                                <i class="fas fa-file-contract"></i>
                            </div>
                            <div>
                                <span class="text-[0.5rem] font-black text-rose-500 uppercase tracking-widest italic mb-1 block">Acción Requerida</span>
                                <h3 class="text-lg font-black text-slate-900 uppercase italic tracking-tighter">{{ $doc->title }}</h3>
                            </div>
                        </div>
                        <a href="{{ route('user.compliance.show', $doc->id) }}" class="w-full md:w-auto bg-slate-950 text-white px-8 py-4 rounded-xl font-black text-[0.65rem] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl italic">
                            Revisar y Firmar <i class="fas fa-signature ml-3"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ✅ DOCUMENTOS FIRMADOS -->
    <div>
        <h2 class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-3 italic">
            <span class="w-10 h-[1px] bg-slate-200"></span> Historial de Firmas
        </h2>

        @if($signed->isEmpty())
            <p class="text-[0.6rem] font-bold text-slate-300 uppercase tracking-widest text-center italic py-10 border-2 border-dashed border-slate-50 rounded-[2rem]">Aún no has firmado ningún documento legal</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($signed as $sig)
                    <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-lg relative group overflow-hidden hover:shadow-2xl transition-all duration-500">
                        <div class="absolute -right-8 -top-8 w-24 h-24 bg-indigo-50 rounded-full opacity-40 group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-6">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[0.5rem] font-black uppercase tracking-widest rounded-lg italic border border-emerald-100">Certificado</span>
                                <span class="text-[0.55rem] font-bold text-slate-400 italic">{{ $sig->signed_at->format('d M, Y') }}</span>
                            </div>
                            <h3 class="text-md font-black text-slate-800 uppercase italic tracking-tighter mb-4 leading-tight group-hover:text-indigo-600 transition-colors">{{ $sig->document->title }}</h3>
                            
                            <div class="flex items-center justify-between mt-6 pt-6 border-t border-slate-50">
                                <span class="text-[0.5rem] font-mono text-slate-300 truncate w-32">ID: {{ substr($sig->signature_token, 0, 8) }}...</span>
                                <a href="{{ route('user.compliance.show', $sig->document->id) }}" class="text-[0.6rem] font-black text-indigo-600 uppercase tracking-widest hover:text-slate-950 transition-all italic flex items-center gap-2">
                                    Ver Documento <i class="fas fa-chevron-right text-[8px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
