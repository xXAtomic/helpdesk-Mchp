@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE INCIDENTE PREMIUM -->
    <div class="mb-12 pb-10 border-b border-white/5 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
        <div>
            <div class="flex items-center gap-4 mb-4">
                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[0.6rem] font-black uppercase tracking-[0.2em] border shadow-2xl animate-in fade-in"
                      style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}40;">
                    <span class="w-2 h-2 rounded-full bg-current animate-pulse mr-2 shadow-[0_0_8px_currentColor]"></span>
                    {{ optional($ticket->status)->name ?? 'EN PROCESO' }}
                </span>
                <span class="text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.4em] italic leading-none pt-1">
                    PROTOCOLO #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none mb-6">
                {{ $ticket->title }}
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] flex items-center gap-3 italic">
                <i class="fas fa-layer-group text-indigo-500"></i>
                {{ optional($ticket->category)->name ?? 'GENERAL' }} 
                <span class="text-slate-800 mx-2">|</span>
                <i class="fas fa-history text-slate-700"></i>
                FECHA DE INICIO: <span class="text-indigo-400">{{ $ticket->created_at->format('d/M/Y H:i') }}</span>
            </p>
        </div>
        <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-[1.5rem] border border-white/5 italic">
            <i class="fas fa-arrow-left text-[10px]"></i>
            Volver a mi Terminal
        </a>
    </div>

    <!-- ENCUESTA DE SATISFACCIÓN PREMIUM (SOLO SI ESTÁ CERRADO) -->
    @if(optional($ticket->status)->is_closed)
        <div class="mb-14 relative group">
            <div class="absolute inset-0 bg-indigo-600/10 blur-[100px] rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            
            @if(!$ticket->rating)
                <div class="bg-indigo-600/10 backdrop-blur-2xl p-10 lg:p-14 rounded-[4rem] border border-indigo-500/30 relative overflow-hidden shadow-3xl">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-12 relative z-10">
                        <div class="text-center lg:text-left">
                            <h3 class="text-3xl font-black text-white uppercase tracking-tighter italic leading-none mb-3">Certificación de Servicio</h3>
                            <p class="text-[0.65rem] font-black text-indigo-300 uppercase tracking-[0.4em] italic">Valida la resolución de tu incidente técnico</p>
                        </div>
                        
                        <form action="{{ route('user.tickets.rate', $ticket) }}" method="POST" class="w-full lg:w-auto flex flex-col sm:flex-row items-center gap-6 bg-slate-950/50 p-6 lg:p-8 rounded-[2.5rem] border border-white/5">
                            @csrf
                            <div class="flex items-center gap-3 bg-slate-900 px-8 py-4 rounded-2xl border border-white/5">
                                @for($i=1; $i<=5; $i++)
                                    <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="hidden peer" required>
                                    <label for="star{{ $i }}" class="cursor-pointer text-2xl text-slate-800 hover:text-indigo-400 hover:drop-shadow-[0_0_8px_rgba(129,140,248,0.5)] peer-checked:text-indigo-400 peer-checked:drop-shadow-[0_0_12px_rgba(129,140,248,0.6)] transition-all">
                                        ★
                                    </label>
                                @endfor
                            </div>
                            <input type="text" name="comment" placeholder="OPINIÓN TÉCNICA..." 
                                   class="bg-slate-900 border border-white/5 rounded-2xl px-6 py-4 text-[0.7rem] text-white placeholder:text-slate-800 font-black uppercase italic outline-none focus:border-indigo-500 w-full sm:w-64 tracking-widest">
                            <button type="submit" class="w-full sm:w-auto bg-white text-slate-950 px-10 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-[0.3em] hover:bg-indigo-600 hover:text-white transition-all italic shadow-2xl">
                                ENVIAR
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-slate-900/60 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 flex flex-col md:flex-row items-center justify-between gap-8 group/rated">
                    <div class="flex items-center gap-8 text-center md:text-left flex-col md:flex-row">
                        <div class="w-20 h-20 rounded-[2rem] bg-indigo-500/10 border border-indigo-500/20 flex flex-col items-center justify-center shadow-inner">
                            <span class="text-3xl font-black text-indigo-400 italic leading-none">{{ $ticket->rating->rating }}</span>
                            <span class="text-[0.5rem] font-black text-indigo-400/50 uppercase tracking-widest">RANK</span>
                        </div>
                        <div>
                            <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mb-3 italic">Tu Valoración Registrada</h4>
                            <div class="flex gap-1 mb-3">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star text-[10px] {{ $i <= $ticket->rating->rating ? 'text-indigo-400 drop-shadow-[0_0_8px_rgba(129,140,248,0.5)]' : 'text-slate-800' }}"></i>
                                @endfor
                            </div>
                            <p class="text-[0.8rem] font-black text-white uppercase italic tracking-tighter">"{!! nl2br(e($ticket->rating->comment ?? 'Sin comentarios adicionales.')) !!}"</p>
                        </div>
                    </div>
                    <div class="px-6 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-[0.55rem] font-black uppercase tracking-[0.3em] italic animate-pulse">
                        <i class="fas fa-check-circle mr-2"></i> Feedback Consolidado
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- CUERPO TÁCTICO -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- TRÁFICO DE MENSAJES -->
        <div class="lg:col-span-3 space-y-12">
            
            <!-- MENSAJE RAÍZ -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-3xl relative overflow-hidden group">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2/3 bg-white/20 rounded-r-full"></div>
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-slate-950 border border-white/5 flex items-center justify-center text-white font-black text-xl italic shadow-2xl">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[0.7rem] font-black text-white uppercase italic leading-none">{{ auth()->user()->name }}</p>
                        <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.3em] mt-2 italic">Solicitante · {{ $ticket->created_at->format('d/M H:i') }}</p>
                    </div>
                </div>
                <div class="text-[0.95rem] text-slate-300 leading-relaxed font-black uppercase italic tracking-tighter border-l-2 border-white/5 pl-8 mb-8">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                <!-- ADJUNTOS -->
                @php $origAttachments = $ticket->attachments()->whereNull('ticket_response_id')->get(); @endphp
                @if($origAttachments->count() > 0)
                    <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-6 pt-10 border-t border-white/5">
                        @foreach($origAttachments as $file)
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="block bg-slate-950 p-1 rounded-2xl border border-white/10 shadow-2xl hover:border-indigo-500/50 transition-all group/img overflow-hidden">
                                @if(Str::contains($file->file_type, 'image'))
                                    <img src="{{ asset('storage/' . $file->file_path) }}" class="aspect-video w-full object-cover rounded-xl filter grayscale group-hover/img:grayscale-0 transition-all duration-500">
                                @else
                                    <div class="aspect-video w-full flex flex-col items-center justify-center text-[0.55rem] font-black text-slate-600 uppercase p-4 italic group-hover/img:text-indigo-400">
                                        <i class="fas fa-file-invoice text-2xl mb-2"></i>
                                        {{ Str::limit($file->file_name, 15) }}
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- RESPUESTAS -->
            <div class="space-y-8 relative pl-6">
                <div class="absolute left-0 top-0 bottom-0 w-px bg-white/5"></div>
                
                @foreach($ticket->publicReplies as $reply)
                    @php $isStaff = ($reply->user->role_id ?? 3) != 3; @endphp
                    <div class="relative pl-14 group">
                        <div class="absolute left-[-4px] top-6 w-[8px] h-[8px] rounded-full {{ $isStaff ? 'bg-indigo-500 ring-4 ring-indigo-500/10 shadow-[0_0_10px_rgba(79,70,229,0.5)]' : 'bg-slate-700' }}"></div>
                        
                        <div class="p-8 rounded-[2.5rem] border shadow-2xl relative overflow-hidden transition-all hover:-translate-x-1
                             {{ $isStaff ? 'bg-indigo-500/5 border-indigo-500/20' : 'bg-slate-900 border-white/10' }}">
                            
                            @if($isStaff)
                                <div class="absolute right-0 top-0 px-6 py-2 bg-indigo-600 text-white text-[0.55rem] font-black uppercase tracking-[0.3em] rounded-bl-3xl shadow-xl italic flex items-center gap-2">
                                    <i class="fas fa-certificate text-[8px] animate-pulse"></i> SOPORTE OFICIAL TÉCNICO
                                </div>
                            @endif

                            <div class="flex items-center gap-5 mb-8">
                                <div class="w-12 h-12 rounded-xl {{ $isStaff ? 'bg-indigo-600' : 'bg-slate-950 border border-white/5' }} text-white flex items-center justify-center font-black italic shadow-2xl transition-transform duration-500">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[0.75rem] font-black text-white uppercase italic leading-none {{ $isStaff ? 'text-indigo-400' : '' }}">{{ $reply->user->name }}</p>
                                    <p class="text-[0.5rem] font-black text-slate-600 uppercase tracking-[0.3em] mt-2 italic">{{ $reply->created_at->format('d M, Y \- H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="text-[0.85rem] text-slate-300 leading-relaxed font-black uppercase italic tracking-tighter border-l border-white/10 pl-6">
                                {!! nl2br(e($reply->body)) !!}
                            </div>

                            @if($reply->attachments->count() > 0)
                                <div class="mt-8 grid grid-cols-3 sm:grid-cols-5 gap-4">
                                    @foreach($reply->attachments as $attachment)
                                        <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="block bg-slate-950 p-1 rounded-xl border border-white/5 transition-all hover:scale-105 group/rimg">
                                            @if(Str::contains($attachment->file_type, 'image'))
                                                <img src="{{ asset('storage/' . $attachment->file_path) }}" class="aspect-square w-full object-cover rounded-lg filter grayscale group-hover/rimg:grayscale-0">
                                            @else
                                                <div class="aspect-square w-full flex items-center justify-center text-[0.45rem] font-black text-slate-700 uppercase p-2 text-center italic">DOCUMENTACIÓN</div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ÁREA DE INTERVENCIÓN -->
            @if(!optional($ticket->status)->is_closed)
                <div class="bg-slate-950 p-12 rounded-[3.5rem] shadow-3xl mt-20 relative overflow-hidden border border-white/5">
                    <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.6em] mb-10 italic flex items-center gap-4 text-center">
                             <span class="w-12 h-px bg-slate-800"></span>
                             Responder a Soporte
                        </h4>
                        <form action="{{ route('user.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                            @csrf
                            <div class="relative">
                                <textarea name="body" required rows="5" placeholder="REDACTA TU RESPUESTA O ACLARACIÓN..."
                                          class="w-full px-10 py-10 rounded-[2.5rem] bg-slate-900 border border-white/5 text-white font-black text-[0.85rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase tracking-tighter shadow-inner"></textarea>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-10">
                                <label class="flex items-center gap-4 bg-slate-900 px-8 py-5 rounded-2xl border border-white/5 cursor-pointer hover:border-indigo-500/50 transition-all group whitespace-nowrap shadow-xl">
                                    <i class="fas fa-paperclip text-indigo-400 group-hover:rotate-45 transition-transform"></i>
                                    <span class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic leading-none pt-1">Anexar Captura</span>
                                    <input type="file" name="attachments[]" multiple class="hidden">
                                </label>
                                
                                <button type="submit" class="w-full sm:w-auto bg-white text-slate-950 px-16 py-6 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-slate-200 transition-all shadow-3xl italic flex items-center justify-center gap-6 group">
                                    ENVIAR OBSERVACIÓN
                                    <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-3 transition-transform"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- COLUMNA DERECHA -->
        <div class="space-y-10">
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-3xl sticky top-8">
                <h5 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mb-12 italic leading-none border-b border-white/5 pb-4">Parámetros del Ticket</h5>
                
                <div class="space-y-10">
                    <div>
                        <p class="text-[0.55rem] font-black text-slate-700 uppercase tracking-widest italic mb-2">Técnico Operativo</p>
                        <p class="text-[0.75rem] font-black text-indigo-400 uppercase italic tracking-tighter">{{ $ticket->technician->name ?? 'SQUAD SOPORTE TI' }}</p>
                    </div>
                    <div>
                        <p class="text-[0.55rem] font-black text-slate-700 uppercase tracking-widest italic mb-2">Urgencia Asignada</p>
                        <p class="text-[0.75rem] font-black text-white uppercase italic tracking-tighter flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            {{ optional($ticket->priority)->name ?? 'GENERAL' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[0.55rem] font-black text-slate-700 uppercase tracking-widest italic mb-2">Unidad / Entidad</p>
                        <p class="text-[0.75rem] font-black text-white uppercase italic tracking-tighter">{{ optional($ticket->department)->name ?? 'MChP' }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
