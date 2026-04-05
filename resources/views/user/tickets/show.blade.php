<<<<<<< HEAD
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
=======
<x-app-layout>
    <div style="display: flex; min-height: 100vh; background-color: #f1f5f9; font-family: sans-serif; text-transform: uppercase;">
        <div style="width: 280px; background-color: #0f172a; color: white; display: flex; flex-direction: column; padding-top: 2rem;">
            <div style="padding: 0 2rem 2.5rem 2rem; border-bottom: 1px solid #1e293b; text-align: center;">
                <h1 style="font-size: 1.8rem; font-weight: 900; color: #fbbf24; font-style: italic;">GLPITICK</h1>
            </div>
            <nav style="flex: 1; padding: 2rem 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🏠 INICIO</a>
                <a href="{{ route('user.tickets.index') }}" style="display: flex; align-items: center; padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 900; color: white; background-color: #fbbf24; color: #0f172a; text-decoration: none; border-radius: 1.2rem;">🎫 MIS TICKETS</a>
            </nav>
        </div>
        <div style="flex: 1; padding: 4rem; overflow-y: auto;">
            <div style="max-width: 1000px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
                <div style="background: white; padding: 2rem; border-radius: 2rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e2e8f0;">
                    <h2 style="font-weight: 950; font-size: 1.2rem;">{{ $ticket->title }}</h2>
                    <span style="font-size: 0.6rem; font-weight: 900; background: #e2e8f0; padding: 0.5rem 1rem; border-radius: 0.8rem;">ESTADO: {{ $ticket->status }}</span>
                </div>
                @foreach($ticket->responses as $response)
                <div style="background: white; padding: 2rem; border-radius: 2rem; border-left: 8px solid {{ $response->user->is_admin ? '#fbbf24' : '#2563eb' }};">
                    <div style="font-size: 0.6rem; font-weight: 900; color: #64748b; margin-bottom: 0.8rem;">{{ $response->user->name }} • {{ $response->created_at->diffForHumans() }}</div>
                    <p style="font-size: 0.9rem; font-weight: 600; text-transform: none;">{{ $response->message }}</p>
                </div>
                @endforeach
                <div style="background: white; padding: 3rem; border-radius: 3rem; border: 1px solid #e2e8f0;">
                    <h4 style="font-weight: 900; font-size: 0.7rem; margin-bottom: 1.5rem;">ESCRIBIR RESPUESTA</h4>
                    <form action="{{ route('admin.tickets.responses.store', $ticket) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="message" style="width: 100%; padding: 1.5rem; border: 2px solid #cbd5e1; border-radius: 1.5rem; min-height: 120px; font-weight: 800; background: #f8fafc; outline: none; margin-bottom: 2rem;" required style="width: 100%; border-radius: 1rem; border: 2px solid #f1f5f9; min-height: 100px; text-transform: none;"></textarea>
<div style='margin-bottom: 2rem;'>        <label style='font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;'>ADJUNTAR ARCHIVO (OPCIONAL)</label>        <input type='file' name='attachment' style='font-size: 0.7rem; font-weight: 900; color: #1e293b; background: #f8fafc; padding: 0.8rem; border-radius: 1rem; border: 2px dashed #cbd5e1; width: 100%;'>    </div>
                        <button type="submit" style="background: #2563eb; color: white; padding: 1rem 3rem; border-radius: 1.5rem; font-weight: 950; font-size: 0.8rem; cursor: pointer; border: none; box-shadow: 0 10px 20px rgba(37,99,235,0.2);" style="margin-top: 1.5rem; background: #2563eb; color: white; border: none; padding: 1rem 3rem; border-radius: 1rem; font-weight: 900; cursor: pointer;">ENVIAR 📤</button>
                    </form>
>>>>>>> origin/servidor-maraton-ayer
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</div>
@endsection
=======
</x-app-layout>
>>>>>>> origin/servidor-maraton-ayer
