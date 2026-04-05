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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
