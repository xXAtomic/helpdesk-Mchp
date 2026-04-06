@extends('layouts.app')

@section('content')
<div class="px-6 py-8 max-w-[1600px] mx-auto">
    
    <!-- HEADER MINIMALISTA -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6 border-b border-slate-100 pb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[0.6rem] font-black uppercase tracking-widest border border-indigo-100 italic">
                    Ticket #{{ $ticket->id }}
                </span>
                <span class="text-[0.6rem] font-bold text-slate-300 uppercase tracking-widest">•</span>
                <span class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest italic">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">{{ $ticket->title }}</h1>
            <p class="text-[0.7rem] font-bold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-2">
                <span class="w-2 h-2 bg-slate-300 rounded-full"></span>
                Solicitante: <span class="text-slate-600 italic">{{ $ticket->user->name ?? 'Invitado' }}</span>
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.tickets.index') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-xl font-black text-[0.65rem] uppercase tracking-widest transition-all italic">
                ← Volver al Listado
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

        <!-- LADO IZQUIERDO: CONVERSACIÓN -->
        <div class="lg:col-span-3 space-y-10">
            
            <!-- BLOQUE INICIAL DEL INCIDENTE -->
            <div class="bg-white p-10 rounded-[2.5rem] border-2 border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-2 h-full bg-slate-900"></div>
                <h3 class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-6 italic">Descripción del Incidente</h3>
                <div class="text-base font-medium text-slate-700 leading-relaxed">
                    {!! nl2br(e($ticket->description)) !!}
                </div>

                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="mt-10 pt-8 border-t-2 border-slate-50">
                    <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-4 italic italic">Archivos Adjuntos</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" 
                           class="px-5 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl flex items-center gap-2 hover:border-indigo-200 transition-all group">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            <span class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest truncate max-w-[150px]">{{ $attachment->file_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- HISTORIAL DE RESPUESTAS (Thread Estilo Moderno) -->
            <div class="space-y-6 relative pl-4">
                <div class="absolute left-6 top-0 bottom-0 w-1 bg-slate-100 rounded-full"></div>
                
                @foreach($ticket->replies as $reply)
                    <div class="relative flex flex-col {{ $reply->user_id == auth()->id() ? 'items-end' : 'items-start' }}">
                        <div class="absolute -left-2 top-8 w-4 h-4 rounded-full bg-white border-4 {{ $reply->user_id == auth()->id() ? 'border-indigo-600' : 'border-amber-400' }} shadow-sm"></div>
                        
                        <div class="max-w-[90%] bg-white p-8 rounded-[2rem] border-2 {{ $reply->user_id == auth()->id() ? 'border-indigo-100 shadow-indigo-50/50' : 'border-slate-200 shadow-sm' }}">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-8 h-8 rounded-full {{ $reply->user_id == auth()->id() ? 'bg-indigo-600' : 'bg-amber-400' }} flex items-center justify-center text-white font-black text-[0.6rem] border-2 border-white shadow-sm italic italic">
                                    {{ substr($reply->user->name, 0, 1) }}
                                </div>
                                <span class="text-[0.65rem] font-black text-slate-900 uppercase tracking-tight italic italic">{{ $reply->user->name }}</span>
                                <span class="text-[0.55rem] font-bold text-slate-300 uppercase tracking-widest">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-[0.95rem] font-medium text-slate-600 leading-relaxed italic italic">
                                {!! nl2br(e($reply->body)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- PANEL DE RESPUESTA FINAL (Fondo Oscuro Premium) -->
            <div class="bg-slate-950 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden border border-slate-800">
                <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/10 rounded-full -mr-40 -mt-40 blur-[100px]"></div>
                <h4 class="text-xl font-black text-white mb-8 italic uppercase tracking-tighter flex items-center gap-3">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                    Intervención Técnica
                </h4>
                <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                    @csrf
                    <textarea name="body" required rows="5" placeholder="ESCRIBE TU RESPUESTA TÉCNICA AQUÍ..."
                              class="w-full px-8 py-8 rounded-[2.5rem] bg-white/5 border-2 border-white/10 text-white font-bold text-[0.9rem] focus:border-indigo-500 focus:bg-white/10 transition-all outline-none placeholder:text-slate-600 mb-8 italic italic"></textarea>
                    
                    <div class="flex flex-col md:flex-row justify-between items-center gap-8 bg-white/5 p-6 rounded-[2rem] border border-white/5">
                        <div class="w-full md:w-auto">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center border border-white/10 group-hover:bg-indigo-600 transition-colors">
                                    <svg class="w-5 h-5 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="text-[0.65rem] font-black text-slate-400 group-hover:text-white transition-colors uppercase tracking-widest italic italic">Adjuntar Material</span>
                                <input type="file" name="attachments[]" multiple class="hidden">
                            </label>
                        </div>
                        <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-white hover:text-slate-900 text-white px-14 py-5 rounded-2xl font-black text-[0.7rem] transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-[0.2em] italic italic">
                            Enviar Solución 🚀
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- LADO DERECHO: CONTROLES -->
        <div class="lg:col-span-1 space-y-8">
            
            <!-- PANEL DE CONTROL -->
            <div class="bg-white p-8 rounded-[2.5rem] border-2 border-slate-200 shadow-sm">
                <h4 class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 border-b border-slate-50 pb-4 italic">Gestión de Caso</h4>
                
                <div class="space-y-8">
                    <!-- Cambio de Estado -->
                    <form action="{{ route('admin.tickets.status', $ticket->id) }}" method="POST">
                        @csrf
                        <label class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-3 block italic italic">Estado Resolutivo</label>
                        <select name="status_id" onchange="this.form.submit()" 
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-2 border-slate-100 font-black text-[0.7rem] text-slate-900 outline-none focus:border-indigo-500 transition-all uppercase tracking-widest italic italic">
                            @foreach(App\Models\TicketStatus::all() as $status)
                                <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Asignación Técnico -->
                    <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                        @csrf
                        <label class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-3 block italic italic">Técnico Responsable</label>
                        <select name="technician_id" onchange="this.form.submit()" 
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border-2 border-slate-100 font-black text-[0.7rem] text-slate-900 outline-none focus:border-indigo-500 transition-all uppercase tracking-widest italic italic">
                            <option value="">-- SIN ASIGNAR --</option>
                            @foreach(App\Models\User::whereHas('role', function($q){ $q->whereIn('slug', ['admin', 'technician']); })->get() as $tech)
                                <option value="{{ $tech->id }}" {{ $ticket->technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- METADATOS TÉCNICOS -->
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl border-2 border-indigo-700">
                <h4 class="text-[0.6rem] font-black text-indigo-200 uppercase tracking-widest mb-6 italic">Información Técnica</h4>
                <div class="space-y-6">
                    <div class="bg-indigo-700/50 p-5 rounded-2xl border border-indigo-400/20">
                        <p class="text-[0.5rem] font-black text-indigo-300 uppercase tracking-widest mb-1 italic">Prioridad de Atencion</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ optional($ticket->priority)->color }}"></span>
                            <p class="text-xs font-black text-white uppercase italic tracking-wider">{{ optional($ticket->priority)->name ?? 'BAJA' }}</p>
                        </div>
                    </div>
                    <div class="bg-indigo-700/50 p-5 rounded-2xl border border-indigo-400/20">
                        <p class="text-[0.5rem] font-black text-indigo-300 uppercase tracking-widest mb-1 italic italic">Activo Vinculado</p>
                        <p class="text-xs font-black text-white uppercase tracking-widest italic">{{ $ticket->asset->asset_tag ?? 'HARDWARE EXTERNO' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
