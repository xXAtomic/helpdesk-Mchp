@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="mb-12 border-b border-slate-100 pb-10">
        <a href="{{ route('user.compliance.index') }}" class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-slate-900 transition-all flex items-center gap-2 italic mb-6">
            <i class="fas fa-arrow-left"></i> Volver a documentos
        </a>
        <h1 class="text-4xl font-black text-slate-950 tracking-tighter uppercase italic leading-tight">{{ $document->title }}</h1>
        <p class="text-[0.65rem] font-black text-indigo-500 uppercase tracking-widest mt-3 italic">Versión del Documento: {{ $document->version }}</p>
    </div>

    <div class="bg-white p-12 rounded-[4rem] border border-slate-100 shadow-2xl mb-12 relative overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-4 {{ isset($signature) ? 'bg-emerald-500' : 'bg-slate-950' }}"></div>
        <div class="prose prose-slate max-w-none text-slate-700 font-medium italic leading-relaxed">
            {!! nl2br(e($document->content)) !!}
        </div>
    </div>

    @if(isset($signature))
        <div class="bg-emerald-50 p-10 rounded-[3rem] border border-emerald-100 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 shadow-xl shadow-emerald-200">
                <i class="fas fa-certificate"></i>
            </div>
            <h3 class="text-xl font-black text-emerald-900 uppercase italic tracking-tighter">Documento Firmado</h3>
            <p class="text-xs font-bold text-emerald-600/70 uppercase tracking-widest mt-2 italic">Aceptado el {{ $signature->signed_at->format('d/m/Y H:i') }}</p>
            <div class="mt-8 pt-6 border-t border-emerald-200 w-full flex justify-between px-10">
                <span class="text-[0.55rem] font-black text-emerald-400 uppercase italic">IP: {{ $signature->ip_address }}</span>
                <span class="text-[0.55rem] font-black text-emerald-400 uppercase italic text-right truncate w-40">UUID: {{ $signature->signature_token }}</span>
            </div>
        </div>
    @else
        <div class="bg-slate-50 p-10 rounded-[3rem] border border-slate-200">
            <form action="{{ route('user.compliance.sign', $document->id) }}" method="POST" class="space-y-8">
                @csrf
                <div class="flex items-start gap-4">
                    <input type="checkbox" name="accept_terms" id="accept" required
                           class="mt-1 w-6 h-6 rounded-lg text-indigo-600 focus:ring-indigo-500 border-gray-300">
                    <label for="accept" class="text-xs font-black text-slate-600 uppercase italic leading-relaxed cursor-pointer selection:bg-indigo-100">
                        He leído detenidamente el documento anterior y acepto voluntariamente los términos, condiciones y responsabilidades descritas en él. Entiendo que esta aceptación tiene carácter de firma digital legal.
                    </label>
                </div>

                <button type="submit" class="w-full bg-slate-950 text-white py-6 rounded-2xl font-black text-[0.8rem] uppercase tracking-[0.2em] hover:bg-emerald-600 transition-all shadow-2xl italic group">
                    Firmar Documento Oficial <i class="fas fa-signature ml-4 group-hover:rotate-12 transition-transform"></i>
                </button>
            </form>
        </div>
    @endif

    <p class="text-[0.6rem] text-slate-400 font-bold uppercase text-center mt-10 tracking-[0.4em] italic">
        Gravity Security & Compliance System • Certificado de Integridad Digital
    </p>
</div>
@endsection
