@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE INCIDENTE PREMIUM -->
    <div class="mb-12 pb-10 border-b border-white/5 flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
        <div>
            <div class="flex items-center gap-4 mb-4">
                @php
                    $statusColor = optional($ticket->status)->color ?? '#64748b';
                @endphp
                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[0.6rem] font-black uppercase tracking-[0.2em] border shadow-2xl animate-in fade-in zoom-in"
                      style="background-color: {{ $statusColor }}15; color: {{ $statusColor }}; border-color: {{ $statusColor }}40;">
                    <span class="w-2 h-2 rounded-full bg-current animate-pulse mr-2 shadow-[0_0_8px_currentColor]"></span>
                    {{ optional($ticket->status)->name ?? 'Abierto' }}
                </span>
                <span class="text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.4em] italic leading-none pt-1">
                    Operación #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                </span>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none mb-6">
                {{ $ticket->title }}
            </h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] flex items-center gap-3 italic">
                <i class="fas fa-microchip text-indigo-500"></i>
                {{ optional($ticket->category)->name ?? 'SISTEMA GENERAL' }} 
                <span class="text-slate-800 mx-2">|</span>
                <i class="fas fa-user-circle text-slate-700"></i>
                Iniciado por: <span class="text-indigo-400">{{ $ticket->user->name ?? 'Invitado' }}</span>
            </p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white transition-all uppercase tracking-[0.4em] flex items-center gap-4 bg-slate-900 px-8 py-4 rounded-[1.5rem] border border-white/5 italic">
            <i class="fas fa-chevron-left text-[10px]"></i>
            Regresar a la Terminal
        </a>
    </div>

    <!-- CUERPO TÁCTICO -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- COLUMNA IZQUIERDA: TRÁFICO DE MENSAJES -->
        <div class="lg:col-span-3 space-y-12">
            
            <!-- MENSAJE RAÍZ (ÓRDEN DE TRABAJO) -->
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-3xl relative overflow-hidden group">
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2/3 bg-indigo-600 rounded-r-full shadow-[0_0_15px_rgba(79,70,229,0.5)]"></div>
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-slate-950 border border-white/5 flex items-center justify-center text-white font-black text-xl italic shadow-2xl group-hover:bg-indigo-600 transition-all duration-700">
                        {{ substr($ticket->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[0.7rem] font-black text-white uppercase italic leading-none group-hover:text-indigo-400 transition-all">{{ $ticket->user->name ?? 'Invitado' }}</p>
                        <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.3em] mt-2 italic">Solicitante · {{ $ticket->created_at->format('d/M H:i') }}</p>
                    </div>
                </div>
                <div class="text-[0.95rem] text-slate-300 leading-relaxed font-black uppercase italic tracking-tighter border-l-2 border-white/5 pl-8 mb-10">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                <!-- ADJUNTOS INICIALES -->
                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-10 border-t border-white/5">
                    @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="block bg-slate-950 p-1 rounded-2xl border border-white/10 shadow-2xl hover:border-indigo-500/50 transition-all group/img">
                            @if(Str::contains($attachment->file_type, 'image'))
                                <img src="{{ Storage::url($attachment->file_path) }}" class="aspect-video w-full object-cover rounded-xl filter grayscale group-hover/img:grayscale-0 transition-all">
                            @else
                                <div class="aspect-video w-full flex flex-col items-center justify-center text-[0.55rem] font-black text-slate-600 uppercase p-4 italic group-hover/img:text-indigo-400">
                                    <i class="fas fa-file-invoice text-2xl mb-2"></i>
                                    {{ Str::limit($attachment->file_name, 15) }}
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- HISTORIAL DE RESPUESTAS (TIMELINE) -->
            <div class="space-y-8 relative">
                <div class="absolute left-7 top-0 bottom-0 w-px bg-white/5"></div>
                
                @foreach($ticket->replies as $reply)
                    <div class="relative pl-20 group">
                        <!-- Nodo de Timeline -->
                        <div class="absolute left-[25px] top-6 w-[6px] h-[6px] rounded-full {{ $reply->is_internal ? 'bg-amber-500 ring-4 ring-amber-500/10' : 'bg-indigo-500 ring-4 ring-indigo-500/10' }}"></div>
                        
                        <div class="p-8 rounded-[2.5rem] border shadow-2xl relative overflow-hidden transition-all hover:-translate-x-1
                            {{ $reply->is_internal ? 'bg-amber-500/5 border-amber-500/20' : ($reply->user->role->slug == 'admin' ? 'bg-slate-900 border-white/10' : 'bg-slate-900/60 border-white/5') }}">
                            
                            @if($reply->is_internal)
                                <div class="absolute right-0 top-0 px-6 py-2 bg-amber-600 text-white text-[0.55rem] font-black uppercase tracking-[0.3em] rounded-bl-3xl shadow-xl italic flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-[8px] animate-pulse"></i> BITÁCORA INTERNA TI
                                </div>
                            @elseif($reply->user->role->slug == 'admin')
                                <div class="absolute right-0 top-0 px-6 py-2 bg-indigo-600 text-white text-[0.55rem] font-black uppercase tracking-[0.3em] rounded-bl-3xl shadow-xl italic">COMUNICADO OFICIAL</div>
                            @endif

                            <div class="flex items-center gap-5 mb-8">
                                <div class="w-12 h-12 rounded-xl {{ $reply->is_internal ? 'bg-amber-600' : 'bg-indigo-600' }} text-white flex items-center justify-center font-black italic shadow-2xl border border-white/10 group-hover:scale-110 transition-transform duration-500">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-[0.75rem] font-black text-white uppercase italic leading-none group-hover:text-indigo-400 transition-colors">{{ $reply->user->name }}</p>
                                    <p class="text-[0.5rem] font-black text-slate-600 uppercase tracking-[0.3em] mt-2 italic">{{ $reply->created_at->format('d M, Y \- H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="text-[0.85rem] {{ $reply->is_internal ? 'text-amber-200' : 'text-slate-300' }} leading-relaxed font-black uppercase italic tracking-tighter border-l border-white/10 pl-6">
                                {!! nl2br(e($reply->body)) !!}
                            </div>

                            <!-- ADJUNTOS DE RESPUESTA -->
                            @if($reply->attachments->count() > 0)
                                <div class="mt-8 grid grid-cols-3 sm:grid-cols-5 gap-4">
                                    @foreach($reply->attachments as $attachment)
                                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="block bg-slate-950 p-1 rounded-xl border border-white/5 transition-all hover:scale-105 group/rimg">
                                            @if(Str::contains($attachment->file_type, 'image'))
                                                <img src="{{ Storage::url($attachment->file_path) }}" class="aspect-square w-full object-cover rounded-lg filter grayscale group-hover/rimg:grayscale-0">
                                            @else
                                                <div class="aspect-square w-full flex items-center justify-center text-[8px] font-black text-slate-700 uppercase p-2 text-center italic">DOC: {{ $attachment->file_name }}</div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- ÁREA DE INTERVENCIÓN (INPUT) -->
            <div class="bg-slate-950 p-12 rounded-[3.5rem] shadow-3xl mt-20 relative overflow-hidden border border-white/5">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/5 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.6em] mb-10 italic flex items-center gap-4">
                         <span class="w-12 h-px bg-slate-800"></span>
                         Terminal de Operaciones
                    </h4>
                    <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        <div class="relative">
                            <textarea name="body" required rows="6" placeholder="ESCRIBA SU OBSERVACIÓN TÉCNICA O RESPUESTA AL USUARIO..."
                                      class="w-full px-10 py-10 rounded-[2.5rem] bg-slate-900 border border-white/5 text-white font-black text-[0.85rem] focus:border-indigo-500 transition-all outline-none placeholder:text-slate-800 italic uppercase tracking-tighter shadow-inner"></textarea>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-10">
                            <div class="flex items-center gap-8">
                                <label class="flex items-center gap-4 bg-slate-900 px-8 py-5 rounded-2xl border border-white/5 cursor-pointer hover:border-indigo-500/50 transition-all group whitespace-nowrap shadow-xl">
                                    <i class="fas fa-plus-circle text-indigo-400 group-hover:rotate-90 transition-all"></i>
                                    <span class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic leading-none pt-1">Adjuntar Protocolo</span>
                                    <input type="file" name="attachments[]" multiple class="hidden">
                                </label>

                                <label class="flex items-center gap-4 cursor-pointer group whitespace-nowrap">
                                    <div class="relative">
                                        <input type="checkbox" name="is_internal" value="1" class="sr-only peer">
                                        <div class="w-12 h-7 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-amber-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-inner"></div>
                                    </div>
                                    <span class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest group-hover:text-amber-500 transition-all italic leading-none pt-1">Nota Interna Staff</span>
                                </label>
                            </div>
                            
                            <button type="submit" class="w-full sm:w-auto bg-white text-slate-950 px-16 py-6 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-3xl italic flex items-center justify-center gap-6 group">
                                REGISTRAR Y NOTIFICAR 
                                <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-3 transition-transform"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLUMNA DERECHA: PANELES DE CONTROL TÉCNICO -->
        <div class="space-y-10">
            <div class="bg-slate-900/40 backdrop-blur-xl p-10 rounded-[3rem] border border-white/5 shadow-3xl sticky top-8 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-600/5 rounded-full blur-2xl group-hover:scale-150 transition-all duration-1000"></div>
                <div class="relative z-10">
                    <h5 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.5em] mb-12 italic leading-none border-b border-white/5 pb-4">Gestión de Estatus</h5>
                    
                    <div class="space-y-12">
                        <!-- ESTADO -->
                        <form action="{{ route('admin.tickets.status', $ticket->id) }}" method="POST" class="group/f">
                            <p class="text-[0.6rem] font-black text-slate-700 uppercase tracking-widest mb-4 italic leading-none">Estado del Incidente</p>
                            <div class="relative">
                                <select name="status_id" onchange="this.form.submit()" class="w-full px-6 py-4 rounded-xl bg-slate-950 border border-white/5 text-[0.7rem] font-black text-slate-300 shadow-xl outline-none focus:border-indigo-500 italic uppercase appearance-none custom-select">
                                    @foreach(App\Models\TicketStatus::all() as $status)
                                        <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-signal absolute right-6 top-1/2 -translate-y-1/2 text-slate-800 text-[10px]"></i>
                            </div>
                        </form>

                        <!-- ASIGNACIÓN -->
                        <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST" class="group/f">
                            <p class="text-[0.6rem] font-black text-slate-700 uppercase tracking-widest mb-4 italic leading-none">Técnico Responsable</p>
                            <div class="relative">
                                <select name="technician_id" onchange="this.form.submit()" class="w-full px-6 py-4 rounded-xl bg-slate-950 border border-white/5 text-[0.7rem] font-black text-slate-300 shadow-xl outline-none focus:border-indigo-500 italic uppercase appearance-none custom-select">
                                    <option value="">-- NO ASIGNADO --</option>
                                    @foreach(App\Models\User::whereHas('role', function($q){ $q->whereIn('slug', ['admin', 'technician']); })->get() as $tech)
                                        <option value="{{ $tech->id }}" {{ $ticket->technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-user-shield absolute right-6 top-1/2 -translate-y-1/2 text-slate-800 text-[10px]"></i>
                            </div>
                        </form>

                        <!-- FICHA TÉCNICA -->
                        <div class="pt-8 border-t border-white/5 space-y-8">
                            <div>
                                <p class="text-[0.55rem] font-black text-slate-700 uppercase tracking-widest italic mb-2">Prioridad</p>
                                <p class="text-[0.7rem] font-black uppercase italic flex items-center gap-2" style="color: {{ optional($ticket->priority)->color }}">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ optional($ticket->priority)->name ?? 'Baja' }}
                                </p>
                            </div>
                            @if($ticket->asset)
                            <div class="p-6 bg-slate-950 rounded-2xl border border-white/5 group/asset hover:border-indigo-500/30 transition-all">
                                <p class="text-[0.55rem] font-black text-slate-700 uppercase tracking-widest italic mb-2">Activo Vinculado</p>
                                <p class="text-[0.7rem] font-black text-indigo-400 uppercase italic leading-none mb-2">{{ $ticket->asset->asset_tag }}</p>
                                <p class="text-[0.55rem] font-black text-slate-600 uppercase italic tracking-tighter">{{ $ticket->asset->model }}</p>
                            </div>
                            @endif
                        </div>

                        @if($ticket->rating)
                        <!-- PANEL DE SATISFACCIÓN DEL USUARIO -->
                        <div class="pt-8 border-t border-white/5 group">
                            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] mb-6 italic leading-none group-hover:text-white transition-all">Satisfacción del Usuario</p>
                            <div class="bg-indigo-500/5 p-6 rounded-3xl border border-indigo-500/10 shadow-inner relative overflow-hidden">
                                <div class="absolute -right-4 -top-4 w-12 h-12 bg-indigo-500/10 rounded-full blur-xl"></div>
                                <div class="flex items-center gap-2 mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-[10px] {{ $i <= $ticket->rating->rating ? 'text-indigo-400 drop-shadow-[0_0_8px_rgba(129,140,248,0.5)]' : 'text-slate-800' }}"></i>
                                    @endfor
                                    <span class="ml-auto text-[0.65rem] font-black text-indigo-400 italic">{{ $ticket->rating->rating }}.0</span>
                                </div>
                                <div class="text-[0.6rem] text-slate-400 font-bold uppercase italic tracking-tighter leading-relaxed">
                                    "{!! nl2br(e($ticket->rating->comment ?? 'Sin comentarios adicionales.')) !!}"
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-select { background-image: none; }
</style>
@endsection
