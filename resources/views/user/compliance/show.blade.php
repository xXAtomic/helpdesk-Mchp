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
        <div class="absolute inset-x-0 top-0 h-4 bg-slate-950"></div>
        <div class="prose prose-slate max-w-none text-slate-700 font-medium italic leading-relaxed">
            {!! nl2br(e($document->content)) !!}
        </div>
    </div>

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

    <p class="text-[0.6rem] text-slate-400 font-bold uppercase text-center mt-10 tracking-[0.4em] italic">
        Gravity Security & Compliance System • IP: {{ request()->ip() }}
    </p>
</div>
@endsection
