@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12">
        <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Mis Compromisos</h1>
        <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-3 italic">Gestión de Documentación y Responsabilidades de Usuario</p>
    </div>

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
        <div class="space-y-6">
            @foreach($pending as $doc)
                <div class="bg-white p-10 rounded-[3rem] border-2 border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 hover:border-indigo-200 transition-all group">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-white text-2xl shadow-xl group-hover:bg-indigo-600 transition-all">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div>
                            <span class="text-[0.55rem] font-black text-indigo-500 uppercase tracking-widest italic mb-1 block">Requiere Firma Digital</span>
                            <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">{{ $doc->title }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('user.compliance.show', $doc->id) }}" class="w-full md:w-auto bg-slate-950 text-white px-10 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl italic">
                        Revisar y Firmar <i class="fas fa-signature ml-3"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
