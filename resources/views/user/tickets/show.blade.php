@extends('layouts.app')

@section('content')
<div class="py-2 space-y-10">
    <!-- CABECERA PREMIUM DEL TICKET -->
    <div class="bg-white p-10 rounded-[3.5rem] shadow-2xl border-2 border-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-50/50 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-4">
                <span class="px-6 py-2 rounded-full text-[0.65rem] font-black uppercase tracking-[0.2em] border-2 shadow-sm"
                      style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}30;">
                    📍 {{ optional($ticket->status)->name ?? 'EN PROCESO' }}
                </span>
                <span class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-4 py-2 rounded-xl">
                    TICKET #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            <h2 class="text-4xl font-black text-[#020617] italic uppercase tracking-tighter leading-none">{{ $ticket->title }}</h2>
            <p class="text-[0.65rem] font-black text-blue-500 uppercase tracking-[0.3em] mt-4 opacity-80 italic">
                {{ optional($ticket->category)->name ?? 'GENERAL' }} • SOLICITADO EL {{ $ticket->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="flex items-center gap-4 relative z-10">
            <a href="{{ route('user.tickets.index') }}" class="bg-gray-950 hover:bg-blue-600 text-white px-10 py-5 rounded-[2rem] font-black text-[0.7rem] shadow-xl shadow-gray-200 transition-all transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest flex items-center gap-3">
                <i class="fas fa-chevron-left text-xs"></i> VOLVER AL LISTADO
            </a>
        </div>
    </div>

    <!-- LÍNEA DE TIEMPO DE RESPUESTAS (ULTRA-MODERNO) -->
    <div class="space-y-8">
        <!-- MENSAJE ORIGINAL DEL USUARIO -->
        <div class="bg-white p-10 rounded-[3.5rem] shadow-sm border border-gray-100 relative group hover:shadow-2xl transition-all duration-500">
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 text-xl shadow-inner border border-white">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <p class="font-black text-gray-950 text-base uppercase tracking-tight italic">{{ auth()->user()->name }}</p>
                        <p class="text-[0.65rem] text-gray-400 font-bold uppercase tracking-widest">{{ $ticket->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="bg-blue-600 text-white text-[0.6rem] font-black px-4 py-2 rounded-full uppercase tracking-tighter shadow-lg shadow-blue-200">
                    REQUERIMIENTO INICIAL
                </div>
            </div>
            <div class="text-gray-600 font-medium leading-loose text-[0.95rem] bg-gray-50/50 p-8 rounded-[2rem] border border-white">
                {!! nl2br(e($ticket->description)) !!}
            </div>
        </div>

        <!-- RESPUESTAS DEL STAFF O USUARIO -->
        @foreach($ticket->replies as $reply)
            @php
                $isStaff = ($reply->user->role_id ?? 3) != 3;
            @endphp
            <div class="relative {{ $isStaff ? 'md:ml-20' : '' }}">
                @if($isStaff)
                    <div class="absolute -left-10 top-1/2 -translate-y-1/2 hidden md:block text-blue-200 text-2xl">
                        <i class="fas fa-reply fa-flip-horizontal"></i>
                    </div>
                @endif
                <div class="p-10 rounded-[3.5rem] border-2 transition-all duration-500 
                    {{ $isStaff ? 'bg-[#020617] border-blue-500/20 text-white shadow-2xl' : 'bg-white border-gray-100 text-gray-900 shadow-sm hover:shadow-xl' }}">
                    <div class="flex justify-between items-center mb-8">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-lg
                                {{ $isStaff ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                                {{ substr($reply->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black {{ $isStaff ? 'text-white' : 'text-gray-950' }} text-base uppercase tracking-tight italic">
                                    {{ $reply->user->name }}
                                    @if($isStaff)
                                        <span class="ml-3 text-[0.55rem] bg-blue-500/30 text-blue-300 px-3 py-1 rounded-lg tracking-[0.2em] font-black uppercase text-xs">
                                            SOPORTE TI
                                        </span>
                                    @endif
                                </p>
                                <p class="text-[0.65rem] {{ $isStaff ? 'text-gray-500' : 'text-gray-400' }} font-bold uppercase tracking-widest mt-1">
                                    REPLICADO {{ $reply->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-[0.9rem] leading-relaxed opacity-95">
                        {!! nl2br(e($reply->body)) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- PANEL DE ACCIÓN (FORMULARIO DE RESPUESTA) -->
    @if(!optional($ticket->status)->is_closed)
        <div class="bg-white p-12 rounded-[4rem] shadow-2xl border-2 border-gray-50 relative overflow-hidden">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-blue-50/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10">
                <h4 class="text-2xl font-black text-[#020617] mb-10 italic uppercase tracking-tighter flex items-center gap-4">
                    RESPONDER A SOPORTE <span class="h-1 flex-1 bg-gray-50 rounded-full"></span> 📥
                </h4>
                
                <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                    @csrf
                    <div class="group">
                        <textarea name="body" required rows="5" placeholder="ESCRIBE TU MENSAJE AQUÍ..."
                                  class="w-full px-10 py-8 rounded-[3rem] bg-gray-50 border-2 border-transparent font-bold text-gray-900 shadow-inner focus:bg-white focus:border-blue-500/20 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder:text-gray-300 uppercase"></textarea>
                    </div>
                    
                    <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                        <div class="w-full md:w-auto">
                            <label class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 block italic">ADJUNTAR MÁS EVIDENCIA</label>
                            <label class="flex items-center gap-4 bg-gray-50 px-8 py-4 rounded-full border-2 border-dashed border-gray-200 cursor-pointer hover:border-blue-400 transition-all">
                                <i class="fas fa-paperclip text-blue-500"></i>
                                <span class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">SUBIR ARCHIVOS</span>
                                <input type="file" name="attachments[]" multiple class="hidden">
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full md:w-auto px-16 py-7 rounded-[2.5rem] bg-[#020617] text-white font-black text-[0.8rem] shadow-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-2 active:scale-95 uppercase tracking-[0.2em] border-b-4 border-black/20 flex items-center gap-4">
                            ENVIAR RESPUESTA <i class="fas fa-paper-plane text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="bg-gray-950 p-12 rounded-[4rem] text-center border-b-4 border-blue-600 shadow-2xl">
            <h4 class="text-white font-black text-xl italic uppercase tracking-tighter mb-4">REQUERIMIENTO FINALIZADO ✨</h4>
            <p class="text-[0.65rem] text-gray-500 font-black uppercase tracking-[0.4em] leading-loose max-w-md mx-auto">
                Este ticket ha sido marcado como CERRADO. Si el problema persiste, por favor abre un nuevo requerimiento.
            </p>
        </div>
    @endif
</div>
@endsection
