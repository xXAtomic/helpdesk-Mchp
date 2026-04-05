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
