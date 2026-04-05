<x-app-layout>
    <div style="display: flex; min-height: 100vh; background-color: white; font-family: sans-serif; text-transform: uppercase; overflow: hidden;">
        
        <!-- SIDEBAR FULL-HIGH (CYBER-BLUE) -->
        <div style="width: 280px; position: fixed; height: 100vh; z-index: 100;
                    background: #020617; 
                    background-image: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%);
                    color: white; display: flex; flex-direction: column; box-shadow: 15px 0 35px rgba(0,0,0,0.1);">
            
            <!-- CAPA DE LÍNEAS TECH -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; opacity: 0.15; pointer-events: none;
                        background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px);"></div>
            <div style="padding: 3rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center;">
                <h1 style="font-size: 1.5rem; font-weight: 1000; color: #fbbf24; font-style: italic;">MCHP SOPORTE</h1>
            </div>
            <nav style="flex: 1; padding: 3rem 1.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 950; color: #0f172a; background-color: #fbbf24; text-decoration: none; border-radius: 1.5rem; box-shadow: 0 10px 20px rgba(251,191,36,0.3);">🏠 INICIO</a>
                <a href="{{ route('user.tickets.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🎫 MIS SOLICITUDES</a>
                <a href="{{ route('knowledge.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">❓ FAQ (PREGUNTAS)</a>
            </nav>
        </div>
        <!-- CONTENIDO PRINCIPAL (FONDO BLANCO) -->
        <div style="flex: 1; margin-left: 280px; padding: 4rem; overflow-y: auto;">
            
            <!-- CABECERA DE BIENVENIDA (TEXTO NEGRO) -->
            <div style="margin-bottom: 5rem;">
                <h2 style="font-size: 2.5rem; font-weight: 1000; color: #0f172a;">¡HOLA DE NUEVO, {{ Auth::user()->name }}! 👋</h2>
                <p style="font-size: 0.75rem; font-weight: 950; color: #64748b; letter-spacing: 2px;">¿QUÉ NECESITAS RESOLVER HOY?</p>
            </div>
            <!-- GRID DE ACCIONES -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
                <div style="background: white; padding: 5rem; border-radius: 4rem; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 40px 100px rgba(0,0,0,0.03);">
                    <img src="https://cdn-icons-png.flaticon.com/512/3233/3233503.png" style="width: 80px; margin-bottom: 3rem; opacity: 0.5;">
                    <h3 style="font-weight: 1000; font-size: 1.4rem; color: #0f172a; margin-bottom: 1.5rem;">NUEVO REQUERIMIENTO</h3>
                    <p style="font-size: 0.65rem; color: #64748b; margin-bottom: 4rem; font-weight: 800;">ABRE UN TICKET PARA SOPORTE TÉCNICO O FINANZAS.</p>
                    <a href="{{ route('user.tickets.create') }}" style="background: #3b82f6; box-shadow: 0 10px 25px rgba(59,130,246,0.4); color: white; padding: 1.4rem 3rem; border-radius: 1.5rem; font-weight: 1000; font-size: 0.8rem; text-decoration: none; box-shadow: 0 10px 20px rgba(37,99,235,0.2);">SOLICITAR AHORA 🚀</a>
                </div>
                <div style="background: white; padding: 5rem; border-radius: 4rem; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 40px 100px rgba(0,0,0,0.03);">
                    <img src="https://cdn-icons-png.flaticon.com/512/1066/1066371.png" style="width: 80px; margin-bottom: 3rem; opacity: 0.5;">
                    <h3 style="font-weight: 1000; font-size: 1.4rem; color: #0f172a; margin-bottom: 1.5rem;">BIBLIOTECA TÉCNICA</h3>
                    <p style="font-size: 0.65rem; color: #64748b; margin-bottom: 4rem; font-weight: 800;">REVISA MANUALES Y SOLUCIONES PASO A PASO.</p>
                    <a href="{{ route('knowledge.index') }}" style="background: #0f172a; color: white; padding: 1.4rem 3rem; border-radius: 1.5rem; font-weight: 1000; font-size: 0.8rem; text-decoration: none;">IR A MANUALES 📖</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
