@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

    <!-- LADO IZQUIERDO: CONVERSACIÓN Y DETALLE -->
    <div class="lg:col-span-3 space-y-8">
        
        <!-- BLOQUE DE INFORMACIÓN DEL TICKET -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-100 italic">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ $ticket->title }}</h2>
                    <p class="text-xs font-bold text-gray-400 mt-2 uppercase tracking-widest">
                        REPORTADO POR {{ $ticket->user->name ?? 'USUARIO' }} • {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="text-[0.6rem] font-black text-blue-500 bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 uppercase tracking-widest">
                        #{{ $ticket->ticket_number ?? 'TCK-'.$ticket->id }}
                    </span>
                </div>
            </div>
            <div class="text-sm font-medium text-gray-600 leading-relaxed bg-gray-50/50 p-8 rounded-3xl border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div>
                {!! nl2br(e($ticket->description)) !!}

                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-4">Evidencia Adjunta:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="p-4 bg-white border border-gray-100 rounded-2xl flex items-center gap-3 hover:border-blue-300 transition">
                            <span class="text-[0.6rem] font-black text-blue-600 truncate">{{ $attachment->file_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- HISTORIAL DE RESPUESTAS -->
        <div class="space-y-6">
            @foreach($ticket->replies as $reply)
                <div class="flex {{ $reply->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[85%] bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 {{ $reply->user_id == auth()->id() ? 'border-r-8 border-r-blue-600 rounded-tr-none' : 'border-l-8 border-l-amber-400 rounded-tl-none' }}">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full {{ $reply->user_id == auth()->id() ? 'bg-blue-600' : 'bg-amber-400' }} flex items-center justify-center text-white font-black text-[0.6rem]">
                                {{ substr($reply->user->name, 0, 1) }}
                            </div>
                            <span class="text-[0.65rem] font-black text-gray-900 uppercase tracking-tight">{{ $reply->user->name }}</span>
                            <span class="text-[0.55rem] font-bold text-gray-300 uppercase">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-sm font-medium text-gray-600 leading-relaxed">
                            {!! nl2br(e($reply->body)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- PANEL DE RESPUESTA TÉCNICA -->
        <div class="bg-[#020617] p-10 rounded-[3.5rem] shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
            <h4 class="text-lg font-black text-white mb-8 italic uppercase tracking-tighter flex items-center gap-3">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                ENVIAR RESPUESTA AL USUARIO
            </h4>
            <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <textarea name="body" required rows="4" placeholder="ESCRIBE TU INTERVENCIóN TéCNICA AQUí..."
                          class="w-full px-8 py-6 rounded-[2rem] bg-white/5 border-2 border-white/10 text-white font-bold text-sm focus:border-blue-500 focus:bg-white/10 transition outline-none placeholder:text-gray-600 mb-6"></textarea>
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="w-full md:w-auto">
                        <input type="file" name="attachments[]" multiple class="text-[0.65rem] text-gray-500 font-black uppercase">
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-12 py-5 rounded-2xl font-black text-sm hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 uppercase tracking-widest">
                        ENVIAR Y NOTIFICAR 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LADO DERECHO: ACCIONES TéCNICAS -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- ESTADO Y PRIORIDAD -->
        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-6">Controles de Gestión</h4>
            
            <form action="{{ route('admin.tickets.status', $ticket->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[0.55rem] font-black text-gray-400 uppercase mb-2 block">Actualizar Estado</label>
                    <select name="status_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 font-black text-[0.7rem] outline-none focus:border-blue-500 transition">
                        @foreach(App\Models\TicketStatus::all() as $status)
                            <option value="{{ $status->id }}" {{ $ticket->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST" class="mt-6 border-t pt-6">
                @csrf
                <div>
                    <label class="text-[0.55rem] font-black text-gray-400 uppercase mb-2 block">Asignar Técnico</label>
                    <select name="technician_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 font-black text-[0.7rem] outline-none focus:border-blue-500 transition">
                        <option value="">-- SIN ASIGNAR --</option>
                        @foreach(App\Models\User::whereHas('role', function($q){ $q->whereIn('slug', ['admin', 'technician']); })->get() as $tech)
                            <option value="{{ $tech->id }}" {{ $ticket->technician_id == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- INFO EXTRA -->
        <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-gray-100">
            <h4 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-4">Metadatos</h4>
            <div class="space-y-4">
                <div>
                    <p class="text-[0.5rem] font-black text-gray-300 uppercase">Prioridad Sugerida</p>
                    <p class="text-xs font-black" style="color: {{ optional($ticket->priority)->color }}">● {{ optional($ticket->priority)->name ?? 'MEDIA' }}</p>
                </div>
                <div>
                    <p class="text-[0.5rem] font-black text-gray-300 uppercase">Asset Vinculado</p>
                    <p class="text-xs font-black text-gray-900 uppercase">{{ $ticket->asset->asset_tag ?? 'NINGUNO' }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
