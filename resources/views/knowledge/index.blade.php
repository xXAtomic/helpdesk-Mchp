<x-app-layout>
    <div style="display: flex; min-height: 100vh; background-color: white; font-family: sans-serif; text-transform: uppercase; overflow: hidden;">
        
        <!-- SIDEBAR FULL-HIGH (CYBER-BLUE) -->
        <div style="width: 280px; position: fixed; height: 100vh; z-index: 100;
                    background: #020617; 
                    background-image: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%);
                    color: white; display: flex; flex-direction: column; box-shadow: 15px 0 35px rgba(0,0,0,0.1);">
            
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; opacity: 0.15; pointer-events: none;
                        background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px);"></div>
            <div style="padding: 3rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center;">
                <h1 style="font-size: 1.5rem; font-weight: 1000; color: #fbbf24; font-style: italic;">MCHP SOPORTE</h1>
            </div>
            <nav style="flex: 1; padding: 3rem 1.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🏠 INICIO</a>
                <a href="{{ route('user.tickets.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🎫 MIS TICKETS</a>
                <a href="{{ route('knowledge.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 950; color: #0f172a; background-color: #fbbf24; text-decoration: none; border-radius: 1.5rem; box-shadow: 0 10px 20px rgba(251,191,36,0.3);">❓ FAQ (PREGUNTAS)</a>
            </nav>
        </div>
        <!-- CONTENIDO PRINCIPAL (FONDO BLANCO) -->
        <div style="flex: 1; margin-left: 280px; padding: 4rem; overflow-y: auto;">
            <header style="margin-bottom: 4rem;">
                <h2 style="font-size: 2rem; font-weight: 950; color: #0f172a; font-style: italic;">❓ FAQ (PREGUNTAS)</h2>
                <p style="font-size: 0.65rem; font-weight: 950; color: #64748b; letter-spacing: 2px;">MANUALES OFICIALES Y GUÍAS DE APOYO</p>
            </header>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 3rem;">
                @forelse($manuals as $manual)
                    <div style="background: white; padding: 3rem; border-radius: 3rem; border: 1px solid #f1f5f9; box-shadow: 0 20px 50px rgba(0,0,0,0.03);">
                        <h3 style="font-weight: 950; font-size: 1rem; color: #0f172a; margin-bottom: 1rem;">{{ $manual->title }}</h3>
                        <p style="font-size: 0.65rem; color: #64748b; font-weight: 800; line-height: 1.6; margin-bottom: 2.5rem; text-transform: none;">{{ $manual->description }}</p>
                        <a href="{{ asset('storage/' . $manual->file_path) }}" target="_blank" style="background: #2563eb; color: white; padding: 1rem 2rem; border-radius: 1.5rem; font-weight: 950; font-size: 0.65rem; text-decoration: none; display: inline-block;">LEER MANUAL 📖</a>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 10rem; border: 3px dashed #f1f5f9; border-radius: 4rem; color: #94a3b8; font-weight: 950;">AÚN NO HAY MATERIAL DISPONIBLE</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
