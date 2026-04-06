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

    <!-- LÍNEA DE TIEMPO DE RESPUESTAS -->
    <div class="space-y-8">
        <!-- MENSAJE ORIGINAL -->
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

            <!-- ADJUNTOS DEL TICKET ORIGINAL -->
            @php $origAttachments = $ticket->attachments()->whereNull('ticket_response_id')->get(); @endphp
            @if($origAttachments->count() > 0)
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($origAttachments as $file)
                        <div class="group/file relative">
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="block overflow-hidden rounded-2xl border-2 border-gray-100 group-hover/file:border-blue-500 transition-all shadow-sm">
                                @if(Str::contains($file->file_type, 'image'))
                                    <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . $file->file_path) }}" class="w-full h-full object-cover group-hover/file:scale-110 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="aspect-square bg-gray-50 flex flex-col items-center justify-center gap-2">
                                        <span class="text-3xl">📄</span>
                                        <span class="text-[0.5rem] font-black text-gray-400 uppercase tracking-tighter">{{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}</span>
                                    </div>
                                @endif
                                <div class="bg-white p-3 border-t border-gray-50">
                                    <p class="text-[0.55rem] font-black text-gray-500 uppercase truncate text-center">{{ $file->file_name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- RESPUESTAS -->
        @foreach($ticket->replies as $reply)
            @php $isStaff = ($reply->user->role_id ?? 3) != 3; @endphp
            <div class="relative {{ $isStaff ? 'md:ml-20' : '' }}">
                <div class="p-10 rounded-[3.5rem] border-2 transition-all duration-500 
                    {{ $isStaff ? 'bg-[#020617] border-blue-500/20 text-white shadow-2xl' : 'bg-white border-gray-100 text-gray-900 shadow-sm hover:shadow-xl' }}">
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-lg
                            {{ $isStaff ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                            {{ substr($reply->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black {{ $isStaff ? 'text-white' : 'text-gray-950' }} text-base uppercase tracking-tight italic">
                                {{ $reply->user->name }}
                                @if($isStaff)
                                    <span class="ml-3 text-[0.55rem] bg-blue-500/30 text-blue-300 px-3 py-1 rounded-lg tracking-[0.2em] font-black uppercase text-xs">SOPORTE TI</span>
                                @endif
                            </p>
                            <p class="text-[0.65rem] {{ $isStaff ? 'text-gray-500' : 'text-gray-400' }} font-bold uppercase tracking-widest mt-1">
                                {{ $reply->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="text-[0.9rem] leading-relaxed opacity-95 mb-4">
                        {!! nl2br(e($reply->body)) !!}
                    </div>

                    <!-- ADJUNTOS DE LA RESPUESTA -->
                    @php $replyAttachments = $ticket->attachments()->where('ticket_response_id', $reply->id)->get(); @endphp
                    @if($replyAttachments->count() > 0)
                        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($replyAttachments as $file)
                                <div class="group/file relative">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" 
                                       class="block overflow-hidden rounded-[2rem] border-2 transition-all 
                                       {{ $isStaff ? 'border-white/10 bg-white/5 hover:border-blue-500' : 'border-gray-50 bg-gray-50 hover:border-blue-500' }}">
                                        @if(Str::contains($file->file_type, 'image'))
                                            <div class="aspect-video bg-black flex items-center justify-center overflow-hidden">
                                                <img src="{{ asset('storage/' . $file->file_path) }}" class="w-full h-full object-cover group-hover/file:scale-125 transition-transform duration-700">
                                            </div>
                                        @else
                                            <div class="aspect-video flex flex-col items-center justify-center gap-2">
                                                <span class="text-2xl">📄</span>
                                                <span class="text-[0.5rem] font-black uppercase {{ $isStaff ? 'text-gray-500' : 'text-gray-400' }}">DOCUMENTO</span>
                                            </div>
                                        @endif
                                        <div class="p-3 {{ $isStaff ? 'bg-white/5' : 'bg-white' }} border-t {{ $isStaff ? 'border-white/10' : 'border-gray-50' }}">
                                            <p class="text-[0.55rem] font-bold uppercase truncate text-center {{ $isStaff ? 'text-gray-400' : 'text-gray-500' }}">{{ $file->file_name }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- PANEL DE ACCIÓN (FORMULARIO DE RESPUESTA) -->
    @if(!optional($ticket->status)->is_closed)
        <div class="bg-white p-12 rounded-[4rem] shadow-2xl border-2 border-gray-50 relative overflow-hidden">
            <h4 class="text-2xl font-black text-[#020617] mb-10 italic uppercase tracking-tighter flex items-center gap-4">
                RESPONDER A SOPORTE <span class="h-1 flex-1 bg-gray-50 rounded-full"></span> 📥
            </h4>
            
            <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                <textarea name="body" required rows="5" placeholder="ESCRIBE TU MENSAJE AQUÍ..."
                          class="w-full px-10 py-8 rounded-[3rem] bg-gray-50 border-2 border-transparent font-bold text-gray-900 shadow-inner focus:bg-white focus:border-blue-500/20 transition-all outline-none placeholder:text-gray-300 uppercase"></textarea>
                
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <label class="flex items-center gap-4 bg-gray-50 px-8 py-4 rounded-full border-2 border-dashed border-gray-200 cursor-pointer hover:border-blue-400 transition-all">
                        <i class="fas fa-paperclip text-blue-500"></i>
                        <span class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">AñADIR EVIDENCIA</span>
                        <input type="file" name="attachments[]" multiple class="hidden">
                    </label>
                    <button type="submit" class="bg-[#020617] text-white px-16 py-7 rounded-[2.5rem] font-black text-[0.8rem] uppercase tracking-[0.2em] shadow-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-2 active:scale-95 border-b-4 border-black/20 flex items-center gap-4">
                        ENVIAR RESPUESTA <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
