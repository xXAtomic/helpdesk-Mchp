@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA DE INCIDENTE (ESTILO CLONADO) -->
    <div class="mb-10 pb-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-3 mb-3">
                <span class="inline-flex px-3 py-1 rounded-md text-[0.6rem] font-black uppercase tracking-widest border"
                      style="background-color: {{ optional($ticket->status)->color }}10; color: {{ optional($ticket->status)->color }}; border-color: {{ optional($ticket->status)->color }}20;">
                    ● {{ optional($ticket->status)->name ?? 'Abierto' }}
                </span>
                <span class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-widest">REGISTRO #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight uppercase italic">{{ $ticket->title }}</h1>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mt-3">
                {{ optional($ticket->category)->name ?? 'GENERAL' }} • INICIADO POR {{ $ticket->user->name ?? 'Invitado' }}
            </p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="text-[0.65rem] font-bold text-slate-400 hover:text-slate-900 transition-all uppercase tracking-widest flex items-center gap-2 italic">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al listado
        </a>
    </div>

    <!-- CUERPO DE LA CONVERSACIÓN -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- COLUMNA IZQUIERDA: MENSAJES -->
        <div class="lg:col-span-3 space-y-10">
            
            <!-- MENSAJE ORIGINAL -->
            <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 font-bold border italic">
                        {{ substr($ticket->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900 uppercase italic">{{ $ticket->user->name ?? 'Invitado' }}</p>
                        <p class="text-[0.6rem] font-medium text-slate-400 uppercase tracking-widest italic">Solicitante · {{ $ticket->created_at->format('d/M H:i') }}</p>
                    </div>
                </div>
                <div class="text-[0.95rem] text-slate-600 leading-relaxed font-medium italic">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                <!-- ADJUNTOS INCIDENTE -->
                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-50 grid grid-cols-4 gap-4">
                    @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="group block overflow-hidden rounded-lg border border-gray-200 shadow-sm transition-all hover:border-indigo-400">
                            @if(Str::contains($attachment->file_type, 'image'))
                                <img src="{{ Storage::url($attachment->file_path) }}" class="aspect-video w-full object-cover">
                            @else
                                <div class="aspect-video w-full bg-slate-50 flex items-center justify-center text-[0.6rem] font-black text-slate-400 uppercase p-2">DOC: {{ $attachment->file_name }}</div>
                            @endif
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- RESPUESTAS (REPLIES) -->
            @foreach($ticket->replies as $reply)
                <div class="p-8 rounded-2xl border shadow-sm relative overflow-hidden 
                    {{ $reply->is_internal ? 'bg-amber-50 border-amber-200 shadow-amber-100' : ($reply->user->role->slug == 'admin' ? 'bg-slate-50 border-slate-200 shadow-md' : 'bg-white border-gray-100') }}">
                    
                    @if($reply->is_internal)
                        <div class="absolute right-0 top-0 px-4 py-1.5 bg-amber-500 text-white text-[0.55rem] font-black uppercase tracking-[0.2em] rounded-bl-2xl shadow-lg italic">
                            <i class="fas fa-lock mr-1"></i> NOTA INTERNA (SOLO STAFF)
                        </div>
                    @elseif($reply->user->role->slug == 'admin')
                        <div class="absolute right-0 top-0 px-3 py-1 bg-slate-900 text-white text-[0.55rem] font-black uppercase tracking-widest rounded-bl-xl italic">OFICIAL SOPORTE</div>
                    @endif

                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-lg {{ $reply->is_internal ? 'bg-amber-600' : 'bg-indigo-600' }} text-white flex items-center justify-center font-bold italic shadow-inner">
                            {{ substr($reply->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-black text-slate-900 uppercase italic">{{ $reply->user->name }}</p>
                            <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest italic leading-none mt-1">{{ $reply->created_at->format('d M, Y \a \l\a\s H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-[0.95rem] {{ $reply->is_internal ? 'text-amber-900' : 'text-slate-700' }} leading-relaxed font-medium italic">
                        {!! nl2br(e($reply->body)) !!}
                    </div>

                    <!-- ADJUNTOS RESPUESTA -->
                    @if($reply->attachments->count() > 0)
                        <div class="mt-8 grid grid-cols-4 gap-4">
                            @foreach($reply->attachments as $attachment)
                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="group block overflow-hidden rounded-lg border {{ $reply->is_internal ? 'border-amber-200 shadow-inner' : 'border-gray-200 shadow-sm' }} transition-all hover:scale-105">
                                    @if(Str::contains($attachment->file_type, 'image'))
                                        <img src="{{ Storage::url($attachment->file_path) }}" class="aspect-video w-full object-cover">
                                    @else
                                        <div class="aspect-video w-full flex items-center justify-center text-[0.6rem] font-black text-slate-400 uppercase p-2 bg-white/50">ARCHIVO: {{ $attachment->file_name }}</div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            
            <!-- FORMULARIO DE RESPUESTA (ESTILO CLONADO SLATE-950) -->
            <div class="bg-slate-950 p-10 rounded-[3rem] shadow-2xl mt-16 relative overflow-hidden border border-white/5">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl"></div>
                <h4 class="text-xl font-black text-white mb-8 tracking-tighter uppercase italic flex items-center gap-3">
                     <span class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-xs">🚀</span>
                     Registrar Intervención
                </h4>
                <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8 relative z-10">
                    @csrf
                    <div class="relative">
                        <textarea name="body" required rows="5" placeholder="Escribe tu observación detallada aquí..."
                                  class="w-full px-8 py-6 rounded-2xl bg-slate-900/50 border border-slate-800 text-white font-medium text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none placeholder:text-slate-600 italic shadow-inner"></textarea>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-4 bg-slate-900 px-6 py-4 rounded-2xl border border-slate-800 cursor-pointer hover:border-slate-600 transition-all group">
                                <i class="fas fa-paperclip text-indigo-400 group-hover:rotate-12 transition-transform"></i>
                                <span class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest italic">Anexar Evidencia</span>
                                <input type="file" name="attachments[]" multiple class="hidden">
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="is_internal" value="1" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-amber-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </div>
                                <span class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest group-hover:text-amber-400 transition-all italic">¿Nota Interna?</span>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-14 py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-slate-950 transition-all shadow-xl shadow-indigo-900/20 italic">
                            Ejecutar y Notificar 
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>

        <!-- COLUMNA DERECHA: CONTROLES ADMINISTRATIVOS -->
        <div class="space-y-8">
            <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm">
                <h5 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.2em] mb-8 italic">Controles de Gestión</h5>
                
                <div class="space-y-10">
                    <!-- Estado -->
                    <form action="{{ route('admin.tickets.status', $ticket->id) }}" method="POST">
                        @csrf
                        <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-2 italic">Actualizar Estado</p>
                        <select name="status_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-sm font-bold text-slate-900 shadow-sm outline-none focus:border-indigo-500 italic">
                            @foreach(App\Models\TicketStatus::all() as $status)
                                <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Técnico -->
                    <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                        @csrf
                        <p class="text-[0.6rem] font-bold text-gray-400 uppercase tracking-tight mb-2 italic">Asignar Técnico</p>
                        <select name="technician_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-sm font-bold text-slate-900 shadow-sm outline-none focus:border-indigo-500 italic">
                            <option value="">-- SIN ASIGNAR --</option>
                            @foreach(App\Models\User::whereHas('role', function($q){ $q->whereIn('slug', ['admin', 'technician']); })->get() as $tech)
                                <option value="{{ $tech->id }}" {{ $ticket->technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Info Contextual -->
                    <div class="pt-6 border-t border-gray-200 space-y-4">
                        <div>
                            <p class="text-[0.55rem] font-bold text-gray-400 uppercase tracking-widest italic">Prioridad</p>
                            <p class="text-xs font-bold text-slate-900 uppercase italic" style="color: {{ optional($ticket->priority)->color }}">● {{ optional($ticket->priority)->name ?? 'Baja' }}</p>
                        </div>
                        <div>
                            <p class="text-[0.55rem] font-bold text-gray-400 uppercase tracking-widest italic">Activo Vinculado</p>
                            <p class="text-xs font-bold text-slate-900 uppercase italic">{{ $ticket->asset->asset_tag ?? 'NINGUNO' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
