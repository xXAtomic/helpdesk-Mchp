<<<<<<< HEAD
@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    <!-- Timeline / Modificaciones / Conversación (Lado izquierdo amplio) -->
    <div class="lg:col-span-3 space-y-6">
        
        <!-- Panel de Control Rápido de Técnico -->
        <div class="bg-indigo-50 rounded-lg border border-indigo-100 p-4 shadow-sm flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-indigo-800 font-bold text-sm">Gestionar Ticket: </span>
                <form action="{{ route('admin.tickets.status', $ticket->id ?? 1) ?? '#' }}" method="POST" class="flex space-x-2">
                    @csrf
                    <select name="status_id" class="border-gray-300 text-sm rounded shadow-sm py-1.5 focus:border-indigo-500 focus:ring px-2">
                        @if(isset($statuses))
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ ($ticket->status_id ?? 1) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        @else
                            <option>En Progreso</option>
                            <option>Resuelto</option>
                            <option>Cerrado</option>
                        @endif
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white text-xs px-3 py-1.5 rounded hover:bg-indigo-700">Actualizar</button>
                </form>
            </div>
        </div>

        <!-- Post Original -->
        <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ $ticket->title ?? 'Falla de Red en la sucursal Norte' }}</h3>
                    <p class="text-sm text-gray-500">Reportado por <span class="font-bold">{{ $ticket->user->name ?? 'Juan Solicitante' }}</span> - {{ $ticket->created_at->format('d/m/Y H:i') ?? 'Ayer' }}</p>
                </div>
            </div>
            <div class="p-6 text-gray-700 whitespace-pre-wrap leading-relaxed text-sm">
                {{ $ticket->description ?? 'Descripción original del problema detallada por el usuario al crear la solicitud inicial...' }}

                @if($ticket->attachments->whereNull('ticket_response_id')->count() > 0)
                <div class="mt-6 pt-4 border-t">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Archivos Adjuntos:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($ticket->attachments->whereNull('ticket_response_id') as $attachment)
                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="flex items-center p-2 border rounded hover:bg-gray-50 transition text-xs text-blue-600 bg-white">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            <span class="truncate">{{ $attachment->file_name }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Respuestas y Notas Internas -->
        @if(isset($ticket) && $ticket->replies->count() > 0)
            @foreach($ticket->replies as $reply)
            <div class="shadow rounded-lg border {{ $reply->is_internal ? 'bg-yellow-50 border-yellow-200' : 'bg-white border-gray-200' }} overflow-hidden ml-8">
                <div class="px-6 py-3 border-b flex items-center justify-between {{ $reply->is_internal ? 'border-yellow-200' : 'bg-gray-50' }}">
                    <div>
                        <h4 class="font-bold text-sm {{ $reply->is_internal ? 'text-yellow-800' : 'text-gray-800' }}">
                            {{ $reply->user->name }} 
                            @if($reply->is_internal) <span class="ml-2 text-xs bg-yellow-200 px-2 py-0.5 rounded uppercase tracking-wider">Nota Interna Privada</span> @endif
                        </h4>
                        <p class="text-xs text-gray-500">{{ $reply->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="p-5 text-sm {{ $reply->is_internal ? 'text-yellow-900' : 'text-gray-700' }} whitespace-pre-wrap">
                    {{ $reply->body }}

                    @if($ticket->attachments->where('ticket_response_id', $reply->id)->count() > 0)
                    <div class="mt-4 pt-3 border-t {{ $reply->is_internal ? 'border-yellow-200' : 'border-gray-100' }}">
                        <div class="flex flex-wrap gap-2">
                            @foreach($ticket->attachments->where('ticket_response_id', $reply->id) as $attachment)
                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 {{ $reply->is_internal ? 'bg-yellow-200 text-yellow-800' : 'bg-gray-100 text-gray-600' }} border {{ $reply->is_internal ? 'border-yellow-300' : 'border-gray-200' }} rounded-full hover:opacity-80 transition text-[11px] font-medium">
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

        <!-- Formulario Técnico para responder -->
        <div class="bg-white shadow rounded-lg border border-gray-200 overflow-hidden mt-8">
            <form action="{{ route('admin.tickets.reply', $ticket->id ?? 1) ?? '#' }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-sm">Añadir una respuesta</h3>
                    <label class="flex items-center space-x-2 text-sm text-yellow-600 bg-yellow-100 px-3 py-1 rounded cursor-pointer hover:bg-yellow-200 transition">
                        <input type="checkbox" name="is_internal" value="1" class="rounded text-yellow-500 focus:ring-yellow-500">
                        <span class="font-medium">Hacer nota interna (Oculto al usuario)</span>
                    </label>
                </div>
                <div class="p-6">
                    <textarea name="body" rows="4" required placeholder="Escribe tu interacción aquí..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 outline-none px-4 py-2 border mb-3"></textarea>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adjuntar archivos (imágenes, PDFs, etc.)</label>
                        <input type="file" name="attachments[]" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded flex items-center shadow hover:bg-blue-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Enviar / Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Right para Asignaciones e Información (Lado Derecho) -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- Tarjeta de Asignación -->
        <div class="bg-white shadow rounded-lg border border-gray-200 p-5">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest border-b pb-2 mb-4">Técnico Asignado</h3>
            <form action="{{ route('admin.tickets.assign', $ticket->id ?? 1) ?? '#' }}" method="POST">
                @csrf
                <select name="technician_id" class="w-full border-gray-300 rounded text-sm mb-3 focus:border-blue-500 focus:ring py-2 px-3 border" onchange="this.form.submit()">
                    <option value="">-- Sin Asignar --</option>
                    @if(isset($technicians))
                        @foreach($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ ($ticket->technician_id ?? 0) == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                        @endforeach
                    @else
                        <option value="1">Admin Local</option>
                        <option value="2">Tecnico Especialista</option>
                    @endif
                </select>
                <div class="text-xs text-center text-gray-400">Seleccionar reasigna el ticket.</div>
            </form>
        </div>

        <!-- Propiedades Estáticas del Ticket -->
        <div class="bg-white shadow rounded-lg border border-gray-200">
            <div class="p-5 space-y-4">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">ID de Ticket</p>
                    <p class="font-mono text-sm font-bold text-gray-800">{{ $ticket->ticket_number ?? 'TCK-2023-XXXX' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Prioridad</p>
                    <span class="mt-1 px-2 py-0.5 text-xs font-bold rounded" {!! 'style="background-color: ' . ($ticket->priority->color ?? '#eee') . '20; color: ' . ($ticket->priority->color ?? '#000') . '"' !!}>
                        {{ $ticket->priority->name ?? 'Evaluando' }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Inventario asociado</p>
                    @if(isset($ticket->asset))
                    <a href="#" class="text-blue-600 text-sm font-bold hover:underline">
                        {{ $ticket->asset->asset_tag }} - {{ $ticket->asset->model }}
                    </a>
                    @else
                    <p class="text-sm text-gray-500">Ningún activo vinculado</p>
                    @endif
                </div>
                <!-- Mini Log visualizador -->
                <div class="pt-4 border-t">
                    <a href="#" class="text-indigo-600 hover:underline text-xs flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ver historial de auditoría
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
=======
<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA DEL TICKET -->
        <div style="margin-bottom: 4rem; display: flex; align-items: flex-start; justify-content: space-between;">
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <a href="{{ route('admin.tickets.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem;">←</a>
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Ticket #{{ $ticket->ticket_number ?? $ticket->id }}</h1>
                    <div style="display: flex; gap: 1rem; align-items: center; margin-top: 0.5rem;">
                        <span style="background: #eff6ff; color: #3b82f6; padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.7rem; font-weight: 800;">● {{ $ticket->closed_at ? 'CERRADO' : 'ABIERTO' }}</span>
                        <p style="font-size: 0.85rem; color: #64748b; font-weight: 500;">Iniciado por: <span style="font-weight: 800; color: #1e293b;">{{ $ticket->user->name }}</span> • {{ $ticket->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem;">
            
            <!-- LADO IZQUIERDO: CONVERSACIÓN -->
            <div>
                <!-- MENSAJE ORIGINAL -->
                <div style="background: white; padding: 3rem; border-radius: 2.2rem; border: 1.2px solid #f1f5f9; margin-bottom: 3rem; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #111827; margin-bottom: 1.5rem;">Descripción del Problema 🚨</h3>
                    <p style="font-size: 0.95rem; color: #4b5563; line-height: 1.8;">{{ $ticket->description }}</p>
                </div>

                <!-- RESPUESTAS (HISTORIAL) -->
                @foreach($ticket->responses as $r)
                <div style="margin-bottom: 2rem; display: flex; flex-direction: column; {{ $r->user_id == auth()->id() ? 'align-items: flex-end;' : 'align-items: flex-start;' }}">
                    <div style="max-width: 80%; background: {{ $r->user_id == auth()->id() ? '#111827' : '#f1f5f9' }}; color: {{ $r->user_id == auth()->id() ? 'white' : '#1e293b' }}; 
                                padding: 1.5rem 2rem; border-radius: 1.8rem; border-{{ $r->user_id == auth()->id() ? 'bottom-right' : 'bottom-left' }}: 0;">
                        <p style="font-size: 0.9rem; line-height: 1.6;">{{ $r->content }}</p>
                    </div>
                    <div style="font-size: 0.7rem; color: #94a3b8; font-weight: 700; margin-top: 0.8rem; margin-{{ $r->user_id == auth()->id() ? 'right' : 'left' }}: 1rem;">
                        {{ $r->user->name }} • {{ $r->created_at->diffForHumans() }}
                    </div>
                </div>
                @endforeach

                <!-- FORMULARIO DE RESPUESTA -->
                <div style="background: white; padding: 2.5rem; border-radius: 2.2rem; border: 1.5px solid #3b82f6; margin-top: 4rem; box-shadow: 0 20px 40px rgba(59, 130, 246, 0.05);">
                    <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <label style="display: block; font-size: 0.75rem; font-weight: 900; color: #3b82f6; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 1.5rem;">Enviar Respuesta Técnica</label>
                        <textarea name="content" required placeholder="Escribe tu respuesta aquí..." style="width: 100%; min-height: 150px; padding: 1.2rem; border-radius: 15px; border: 1.5px solid #f1f5f9; outline: none; transition: 0.2s; font-size: 0.95rem;" onfocus="this.style.border-color='#3b82f6'"></textarea>
                        <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                            <button type="submit" class="btn-primary" style="padding: 1.1rem 3rem; border-radius: 14px; font-weight: 800;">ENVIAR MENSAJE ✅</button>
                        </div>
                    </form>
                </div>
            </div>

@if($ticket->attachment_path)
<div style="margin-top: 3rem; background: #fafafa; padding: 2rem; border-radius: 20px; border: 1.5px solid #f1f5f9;">
    <h4 style="font-size: 0.75rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; margin-bottom: 1.5rem;">Adjunto: Captura de Pantalla</h4>
    <a href="{{ asset('storage/' . $ticket->attachment_path) }}" target="_blank">
        <img src="{{ asset('storage/' . $ticket->attachment_path) }}" style="max-width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
    </a>
</div>
@endif


            <!-- LADO DERECHO: DETALLES EXTRA / ACCIONES -->
            <div>
                <div style="background: #fafafa; padding: 2.5rem; border-radius: 2rem; position: sticky; top: 2rem;">
                    <h4 style="font-size: 0.75rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 1.5rem;">Información Adicional</h4>
                    
                    <div style="margin-bottom: 2rem;">
                        <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #1e293b;">Departamento</span>
                        <span style="font-size: 0.85rem; color: #64748b;">{{ $ticket->department->name ?? 'Soporte General' }}</span>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #1e293b;">Prioridad Asignada</span>
                        <span style="background: #fff7ed; color: #d97706; padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.7rem; font-weight: 1000; margin-top: 5px; display: inline-block;">● {{ $ticket->priority->name ?? 'MEDIA' }}</span>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 2rem;">

                    <button class="btn-primary" style="width: 100%; padding: 1.1rem; border-radius: 15px; background: transparent; border: 1.5px solid #ef4444; color: #ef4444; font-weight: 800;">⚠️ CERRAR TICKET</button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
>>>>>>> origin/servidor-maraton-ayer
