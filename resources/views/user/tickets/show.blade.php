@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA DE INCIDENTE -->
    <div class="mb-10 pb-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="inline-flex px-3 py-1 rounded-md text-[0.6rem] font-black uppercase tracking-widest border"
                      style="background-color: {{ optional($ticket->status)->color }}10; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}20;">
                    ● {{ optional($ticket->status)->name ?? 'EN PROCESO' }}
                </span>
                <span class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest">REGISTRO #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $ticket->title }}</h1>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-3">
                {{ optional($ticket->category)->name ?? 'GENERAL' }} • INICIADO POR {{ auth()->user()->name }}
            </p>
        </div>
        <a href="{{ route('user.tickets.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-slate-900 transition-all uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver
        </a>
    </div>

    <!-- ENCUESTA DE SATISFACCIÓN (SI ESTÁ CERRADO) -->
    @if(optional($ticket->status)->is_closed)
        @if(!$ticket->rating)
            <div class="mb-12 bg-gradient-to-br from-indigo-600 to-indigo-900 p-8 rounded-3xl shadow-xl shadow-indigo-500/20 group relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left">
                        <h3 class="text-xl font-black text-white uppercase tracking-tight italic">¡Tu opinión nos importa!</h3>
                        <p class="text-indigo-100 text-[0.7rem] font-medium uppercase tracking-widest mt-1">Califica la atención recibida para este incidente</p>
                    </div>
                    <form action="{{ route('user.tickets.rate', $ticket) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4 bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                        @csrf
                        <div class="flex gap-2">
                            @for($i=1; $i<=5; $i++)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="hidden peer" required>
                                <label for="star{{ $i }}" class="cursor-pointer text-2xl text-indigo-300 hover:text-yellow-400 peer-checked:text-yellow-400 transition-all duration-200">
                                    ★
                                </label>
                            @endfor
                        </div>
                        <input type="text" name="comment" placeholder="Comentario opcional..." class="bg-indigo-950/50 border-none rounded-lg px-4 py-2 text-[0.7rem] text-white placeholder:text-indigo-300/50 focus:ring-1 focus:ring-yellow-400 outline-none w-full sm:w-48">
                        <button type="submit" class="bg-yellow-400 text-indigo-950 px-6 py-2 rounded-lg font-black text-[0.65rem] uppercase tracking-widest hover:bg-white transition-all">
                            Enviar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-12 bg-slate-50 border border-slate-200 p-6 rounded-2xl flex items-center justify-between">
                <div>
                    <h4 class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-1">Tu Valoración de este Servicio</h4>
                    <div class="flex items-center gap-4">
                        <div class="flex text-yellow-500 text-lg">
                            @for($i=1; $i<=5; $i++)
                                {{ $i <= $ticket->rating->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                        <p class="text-sm font-bold text-slate-900 italic">"{{ $ticket->rating->comment ?? 'Sin comentarios adicionales.' }}"</p>
                    </div>
                </div>
                <div class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-md text-[0.6rem] font-black uppercase">Feedback Registrado</div>
            </div>
        @endif
    @endif

    <!-- CUERPO DE LA CONVERSACIÓN -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- COLUMNA IZQUIERDA: MENSAJES -->
        <div class="lg:col-span-3 space-y-10">
            
            <!-- MENSAJE ORIGINAL -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 font-bold border">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-[0.6rem] font-medium text-slate-400 uppercase tracking-widest">Solicitante · {{ $ticket->created_at->format('d/M H:i') }}</p>
                    </div>
                </div>
                <div class="text-[0.95rem] text-slate-600 leading-relaxed font-medium">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                <!-- ADJUNTOS INCIDENTE -->
                @php $origAttachments = $ticket->attachments()->whereNull('ticket_response_id')->get(); @endphp
                @if($origAttachments->count() > 0)
                    <div class="mt-10 grid grid-cols-3 sm:grid-cols-4 gap-4 pt-8 border-t border-gray-50">
                        @foreach($origAttachments as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="group block overflow-hidden rounded-xl border border-gray-100 hover:border-indigo-200 transition-all">
                                @if(Str::contains($file->file_type, 'image'))
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="aspect-square w-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                    <div class="aspect-square bg-slate-50 flex items-center justify-center text-2xl">📄</div>
                                @endif
                                <div class="p-2 bg-white text-center">
                                    <p class="text-[0.6rem] font-bold text-slate-400 uppercase truncate px-2">{{ $file->file_name }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- RESPUESTAS -->
            @foreach($ticket->publicReplies as $reply)
                @php $isStaff = ($reply->user->role_id ?? 3) != 3; @endphp
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden {{ $isStaff ? 'bg-slate-50 border-slate-200' : '' }}">
                    @if($isStaff)
                        <div class="absolute right-0 top-0 px-3 py-1 bg-slate-900 text-white text-[0.55rem] font-black uppercase tracking-widest rounded-bl-xl">SOPORTE TI</div>
                    @endif
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-lg {{ $isStaff ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center font-bold">
                            {{ substr($reply->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold {{ $isStaff ? 'text-slate-900' : 'text-slate-900' }}">{{ $reply->user->name }}</p>
                            <p class="text-[0.6rem] font-medium text-slate-400 uppercase tracking-widest">{{ $reply->created_at->format('d/M H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-[0.95rem] text-slate-700 leading-relaxed font-medium">
                        {!! nl2br(e($reply->body)) !!}
                    </div>

                    <!-- ADJUNTOS RESPUESTA -->
                    @if($reply->attachments->count() > 0)
                        <div class="mt-8 grid grid-cols-4 gap-4">
                            @foreach($reply->attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="group block overflow-hidden rounded-lg border border-gray-200">
                                    @if(Str::contains($attachment->file_type, 'image'))
                                        <img src="{{ asset('storage/' . $attachment->file_path) }}" class="aspect-video w-full object-cover">
                                    @else
                                        <div class="aspect-video bg-white flex items-center justify-center text-xl">📄</div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- FORMULARIO DE RESPUESTA -->
            @if(!optional($ticket->status)->is_closed)
                <div class="bg-slate-950 p-10 rounded-3xl shadow-xl mt-16">
                    <h4 class="text-lg font-bold text-white mb-8 tracking-tight uppercase">Responder Mensaje</h4>
                    <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <textarea name="body" required rows="4" placeholder="Escribe tu observación detallada aquí..."
                                  class="w-full px-6 py-5 rounded-xl bg-slate-900 border border-slate-800 text-white font-medium text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none placeholder:text-slate-600"></textarea>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                            <label class="flex items-center gap-4 bg-slate-900 px-6 py-3 rounded-lg border border-slate-800 cursor-pointer hover:border-slate-600 transition-all">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                <span class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest">Incluir Evidenceia</span>
                                <input type="file" name="attachments[]" multiple class="hidden">
                            </label>
                            
                            <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-10 py-4 rounded-lg font-bold text-[0.7rem] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/20">
                                Enviar Respuesta
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <!-- COLUMNA DERECHA: INFORMACIÓN LATERAL -->
        <div class="space-y-8">
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100">
                <h5 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-6">Detalles del Soporte</h5>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Técnico Asignado</p>
                        <p class="text-sm font-bold text-slate-900 uppercase tracking-tight">{{ $ticket->technician->name ?? 'SIN ASIGNAR' }}</p>
                    </div>
                    <div>
                        <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Prioridad</p>
                        <p class="text-sm font-bold text-slate-900 uppercase tracking-tight">{{ optional($ticket->priority)->name ?? 'ESTÁNDAR' }}</p>
                    </div>
                    <div>
                        <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-1">Departamento</p>
                        <p class="text-sm font-bold text-slate-900 uppercase tracking-tight">{{ optional($ticket->department)->name ?? 'MChP' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
