@extends('layouts.app')

@section('content')
<div class="py-2">
    <!-- CABECERA -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 italic tracking-tighter uppercase">BASE DE CONOCIMIENTOS 📚</h2>
            <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest leading-none">Gestiona los manuales técnicos y guías de usuario para un soporte más eficiente.</p>
        </div>
        <a href="{{ route('admin.knowledge.create') }}" class="bg-[#020617] text-white px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest shadow-xl hover:bg-blue-600 transition">
            + NUEVO MANUAL
        </a>
    </div>

    <!-- GRID DE TARJETAS (ESTILO PREMIUM) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($manuals as $manual)
        <div class="group bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:border-blue-100 transition-all duration-500 relative overflow-hidden">
            <!-- Icono Decorativo -->
            <div class="absolute -right-4 -top-4 text-8xl opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-500 select-none italic font-black">
                {{ $loop->iteration }}
            </div>

            <div class="relative z-10">
                <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[0.6rem] font-black rounded-lg uppercase tracking-widest mb-4 border border-blue-100">
                    {{ $manual->category ?? 'SOPORTE' }}
                </span>
                
                <h3 class="text-xl font-black text-gray-900 uppercase italic tracking-tighter leading-tight mb-3 group-hover:text-blue-600 transition-colors">
                    {{ $manual->title }}
                </h3>
                
                <p class="text-xs text-gray-400 font-medium leading-relaxed mb-6 line-clamp-3 uppercase italic">
                    {{ Str::limit(strip_tags($manual->content), 120) }}
                </p>

                <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                    <a href="{{ route('admin.knowledge.edit', $manual->id) }}" class="text-[0.6rem] font-black text-gray-300 hover:text-blue-600 tracking-widest uppercase transition">
                        EDITAR ESTRUCTURA
                    </a>
                    <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <span class="text-xs">→</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
            <p class="text-gray-300 font-black text-sm uppercase italic tracking-widest">No hay manuales cargados en el sistema ✨</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
