@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Timeline / Chat Principal -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Post Original -->
        <div class="bg-white shadow rounded-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                        {{ substr($ticket->user->name ?? 'Usuario', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $ticket->user->name ?? 'Usuario Solicitante' }}</h3>
                        <p class="text-xs text-gray-500">Reportado: {{ $ticket->created_at->format('d M Y, H:i') ?? '12 Oct 2023, 10:30' }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 text-gray-700 whitespace-pre-wrap leading-relaxed">
                {{ $ticket->description ?? 'El usuario describió su problema aquí. Pantalla azul al iniciar el sistema contable.' }}
                
                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="mt-6 pt-4 border-t">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3 italic">Archivos Adjuntos Iniciales:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="flex items-center p-2 border rounded hover:bg-gray-50 transition text-sm text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            <span class="truncate">{{ $attachment->file_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Respuestas -->
        @if(isset($ticket) && $ticket->replies->count() > 0)
            @foreach($ticket->replies as $reply)
            <div class="bg-white shadow rounded-lg border {{ $reply->user->isTechnician() ? 'border-blue-200' : 'border-gray-100' }} overflow-hidden ml-8">
                <div class="px-6 py-3 border-b {{ $reply->user->isTechnician() ? 'bg-blue-50' : 'bg-gray-50' }} flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full {{ $reply->user->isTechnician() ? 'bg-indigo-600' : 'bg-blue-500' }} flex items-center justify-center text-white font-bold mr-3 text-sm">
                            {{ substr($reply->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">
                                {{ $reply->user->name }}
                                @if($reply->user->isTechnician() || $reply->user->isAdmin())
                                    <span class="ml-2 px-2 py-0.5 rounded text-[10px] bg-indigo-100 text-indigo-800 uppercase tracking-widest">Soporte TI</span>
                                @endif
                            </h4>
                            <p class="text-xs text-gray-500">{{ $reply->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 text-sm text-gray-700 whitespace-pre-wrap">
                    {{ $reply->body }}
                    
                    @if($ticket->attachments->where('ticket_response_id', $reply->id)->count() > 0)
                    <div class="mt-4 pt-3 border-t">
                        <div class="flex flex-wrap gap-2">
                            @foreach($ticket->attachments->where('ticket_response_id', $reply->id) as $attachment)
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-gray-100 border border-gray-200 rounded-full hover:bg-gray-200 transition text-[11px] text-gray-600 font-medium">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                {{ $attachment->file_name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        @endif

        <!-- Formulario de Respuesta -->
        @if(!($ticket->status->is_closed ?? false))
        <div class="bg-white shadow rounded-lg border border-gray-100 overflow-hidden mt-8">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="font-bold text-gray-800 text-sm">Añadir un comentario</h3>
            </div>
            <form action="{{ route('user.tickets.reply', $ticket->id ?? 1) ?? '#' }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <textarea name="body" rows="4" required placeholder="Escribe tu respuesta o provee más información aquí..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none px-4 py-2 border mb-4"></textarea>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Adjuntar archivos (opcional)</label>
                    <input type="file" name="attachments[]" multiple class="block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded shadow hover:bg-blue-700 transition">Enviar Respuesta</button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-500 text-sm border">
            Este ticket está cerrado y ya no admite nuevas respuestas. Si tu problema persiste, por favor abre un nuevo ticket.
        </div>
        @endif
    </div>

    <!-- Sidebar de Meta-Datos del Ticket -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white shadow rounded-lg border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h3 class="font-bold text-gray-800 text-lg break-words">{{ $ticket->title ?? 'Problema General' }}</h3>
                <p class="text-xs font-mono text-gray-500 mt-1">#{{ $ticket->ticket_number ?? 'TCK-UNKNOWN' }}</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Estado Actual</p>
                    <span class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full" {!! 'style="background-color: ' . (optional($ticket->status)->color ?? '#eee') . '30; color: ' . (optional($ticket->status)->color ?? '#000') . ';"' !!}>
                        {{ optional($ticket->status)->name ?? 'En Revisión' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Prioridad Sugerida</p>
                    <p class="font-medium" {!! 'style="color: ' . (optional($ticket->priority)->color ?? '#333') . ';"' !!}>
                        {{ optional($ticket->priority)->name ?? 'Media' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Técnico Asignado</p>
                    <div class="mt-1 flex items-center">
                        @if(isset($ticket->technician))
                        <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold text-xs mr-2 border border-indigo-200">
                            {{ substr($ticket->technician->name, 0, 1) }}
                        </div>
                        <p class="text-sm font-medium text-gray-800">{{ $ticket->technician->name }}</p>
                        @else
                        <p class="text-sm text-gray-500 italic">Aún no asignado, en bandeja general.</p>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Categoría</p>
                    <p class="text-sm text-gray-800">{{ $ticket->category->name ?? 'Soporte General' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
