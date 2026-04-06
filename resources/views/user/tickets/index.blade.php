@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex flex-col">
            <h2 class="text-4xl font-black text-[#020617] italic tracking-tighter uppercase leading-tight">MIS REQUERIMIENTOS 📋</h2>
            <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-[0.25em] mt-3">Estado actual de tus solicitudes técnicas y soporte TI</p>
        </div>
        
        <a href="{{ route('user.tickets.create') }}" 
           class="w-full md:w-auto bg-[#020617] hover:bg-blue-600 text-white px-10 py-5 rounded-[2rem] font-black text-[0.7rem] shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-center border-t border-white/10">
            + NUEVA SOLICITUD TI 🚀
        </a>
    </div>

    <!-- LISTADO DE TICKETS -->
    <div class="space-y-6">
        @forelse($tickets as $ticket)
            <a href="{{ route('user.tickets.show', $ticket) }}" 
               class="group flex flex-col md:flex-row items-center justify-between p-8 bg-white border-2 border-gray-100 rounded-[3rem] hover:border-blue-400/50 transition-all duration-300 shadow-sm hover:shadow-2xl relative overflow-hidden">
                
                <div class="flex items-center gap-8">
                    <!-- ID PRO -->
                    <div class="hidden md:flex w-24 h-12 bg-gray-50 border border-gray-100 rounded-2xl items-center justify-center font-black text-blue-600 text-[0.65rem] tracking-tighter uppercase shadow-inner">
                        #ID-{{ $ticket->id }}
                    </div>
                    
                    <div class="text-center md:text-left">
                        <h3 class="font-black text-xl text-gray-900 group-hover:text-blue-600 transition tracking-tight uppercase leading-tight">{{ $ticket->title }}</h3>
                        <p class="text-[0.65rem] text-gray-400 font-bold mt-2 uppercase tracking-[0.15em]">
                            Solicitado el {{ $ticket->created_at->format('d/m/Y') }} • 
                            <span class="text-blue-400">{{ $ticket->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-6 mt-6 md:mt-0">
                    <span class="px-8 py-3 rounded-full text-[0.6rem] font-black uppercase tracking-[0.2em] border-2 shadow-sm"
                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                        {{ optional($ticket->status)->name ?? 'PENDIENTE' }}
                    </span>
                    <i class="fas fa-chevron-right text-gray-200 group-hover:text-blue-500 group-hover:translate-x-2 transition-all"></i>
                </div>
            </a>
        @empty
            <!-- ÁREA DE EMPATE ZERO STATE PRO -->
            <div class="py-32 flex flex-col items-center justify-center bg-white rounded-[4rem] border-4 border-dashed border-gray-100 shadow-inner relative overflow-hidden">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -top-20 w-64 h-64 bg-gray-50/50 rounded-full blur-3xl"></div>
                
                <div class="w-24 h-24 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-8 text-gray-300 text-3xl shadow-sm border border-white">
                    <i class="fas fa-paper-plane"></i>
                </div>
                
                <h4 class="text-3xl font-black text-gray-900 italic tracking-tighter uppercase mb-3">BANDEJA DE ASISTENCIA LIMPIA 🚀</h4>
                <p class="text-[0.65rem] text-gray-400 font-bold uppercase tracking-[0.3em] mb-12">Estamos listos para ayudarte con lo que necesites.</p>
                
                <a href="{{ route('user.tickets.create') }}" 
                   class="bg-[#020617] hover:bg-blue-600 text-white px-12 py-6 rounded-[2.5rem] font-black text-[0.75rem] uppercase tracking-[0.2em] shadow-2xl transition-all transform hover:scale-105 active:scale-95 border-b-4 border-black/20">
                    REPORTAR UN NUEVO PROBLEMA →
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
