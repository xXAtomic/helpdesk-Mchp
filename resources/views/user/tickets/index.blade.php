@extends('layouts.app')

@php
    $header = 'HISTORIAL DE REQUERIMIENTOS 📋';
@endphp

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 italic tracking-tighter uppercase mr-4">ESTADO DE TUS SOLICITUDES 🎟️</h2>
            <p class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-[0.2em] leading-none mt-2">Gestiona y revisa el progreso de tus tickets de TI</p>
        </div>
        
        <a href="{{ route('user.tickets.create') }}" 
           class="bg-[#020617] hover:bg-blue-600 text-white px-10 py-5 rounded-[2rem] font-black text-[0.7rem] shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest flex items-center gap-3">
            <span class="text-lg">+</span> NUEVA SOLICITUD TÉCNICA
        </a>
    </div>

    <!-- LISTADO DE TICKETS -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($tickets as $ticket)
            <a href="{{ route('user.tickets.show', $ticket) }}" 
               class="group flex items-center justify-between p-8 bg-white border border-gray-100 rounded-[2.5rem] hover:border-blue-500/50 transition-all duration-300 shadow-sm hover:shadow-2xl relative overflow-hidden">
                
                <!-- DECORACIÓN -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50/30 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-center gap-8 relative z-10">
                    <!-- NUMERACIÓN -->
                    <div class="w-28 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-center font-black text-blue-600 text-[0.7rem] tracking-tighter shadow-inner">
                        #ID-{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    <div>
                        <h3 class="font-black text-xl text-gray-900 group-hover:text-blue-600 transition tracking-tight uppercase">{{ $ticket->title }}</h3>
                        <div class="flex items-center gap-3 mt-2">
                            <p class="text-[0.65rem] text-gray-400 font-bold uppercase tracking-widest">
                                {{ $ticket->created_at->format('d M, Y') }}
                            </p>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <p class="text-[0.65rem] text-blue-400 font-bold uppercase tracking-widest">
                                {{ $ticket->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-8 relative z-10">
                    <span class="px-6 py-3 rounded-full text-[0.65rem] font-black uppercase tracking-[0.15em] border shadow-sm"
                          style="background-color: {{ optional($ticket->status)->color }}10; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                        {{ optional($ticket->status)->name ?? 'PENDIENTE' }}
                    </div>
                    <div class="text-gray-300 group-hover:text-blue-500 transition-colors">
                        <i class="fas fa-chevron-right text-sm"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="py-32 text-center bg-white rounded-[4rem] border-2 border-dashed border-gray-100 shadow-inner">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300 text-3xl">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h4 class="text-gray-900 font-black text-2xl italic uppercase tracking-tighter">SIN HISTORIAL DE SOLICITUDES ✨</h4>
                <p class="text-[0.65rem] text-gray-400 font-bold uppercase tracking-[0.2em] mt-3">Tu bandeja está limpia. ¿Necesitas ayuda con algo?</p>
                <a href="{{ route('user.tickets.create') }}" 
                   class="inline-block mt-10 bg-blue-600 hover:bg-[#020617] text-white px-10 py-5 rounded-[2rem] font-black text-[0.7rem] uppercase tracking-widest shadow-xl transition-all">
                    CREAR MI PRIMER TICKET →
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
