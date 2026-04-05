<x-app-layout>
    <div style="display: flex; min-height: 100vh; background: #020617; background-image: linear-gradient(135deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%); background-size: 60px 60px, 100% 100%; background-attachment: fixed; font-family: sans-serif; text-transform: uppercase;">
        
        <!-- SIDEBAR USUARIO (MCHP SOPORTE) -->
        <div style="width: 280px; background-color: #0f172a; color: white; display: flex; flex-direction: column; padding-top: 2rem;">
            <div style="padding: 0 2rem 2.5rem 2rem; border-bottom: 1px solid #1e293b; text-align: center;">
                <h1 style="font-size: 1.5rem; font-weight: 950; color: #fbbf24; font-style: italic;">MCHP SOPORTE</h1>
            </div>
            <nav style="flex: 1; padding: 2rem 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 1rem 1.5rem; font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🏠 INICIO</a>
                <a href="{{ route('user.tickets.index') }}" style="display: flex; align-items: center; padding: 1rem 1.5rem; font-size: 0.7rem; font-weight: 950; color: #0f172a; background-color: #fbbf24; text-decoration: none; border-radius: 1.2rem; box-shadow: 0 10px 15px rgba(251,191,36,0.3);">🎫 MIS SOLICITUDES</a>
                <a href="{{ route('knowledge.index') }}" style="display: flex; align-items: center; padding: 1rem 1.5rem; font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-decoration: none;">📚 MANUALES TI</a>
            </nav>
        </div>
        <!-- CONTENIDO FORMULARIO (MCHP SOPORTE) -->
        <div style="flex: 1; padding: 3rem; overflow-y: auto;">
            <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" 
                  style="background: white; padding: 4rem; border-radius: 3rem; box-shadow: 0 20px 40px rgba(0,0,0,0.05); max-width: 650px; margin: 0 auto; border: 1px solid #e2e8f0;">
                @csrf
                <h2 style="font-weight: 950; font-size: 1.4rem; margin-bottom: 3rem; color: #0f172a; font-style: italic;">NUEVA SOLICITUD DE APOYO</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;">NOMBRE DEL SOLICITANTE</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly style="width: 100%; padding: 0.8rem; border-radius: 1rem; border: 2px solid #f1f5f9; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; font-weight: 800;">
                    </div>
                    <div>
                        <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;">CORREO ELECTRÓNICO</label>
                        <input type="text" value="{{ Auth::user()->email }}" readonly style="width: 100%; padding: 0.8rem; border-radius: 1rem; border: 2px solid #f1f5f9; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; font-weight: 800;">
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 1rem;">ELGE TU DEPARTAMENTO</label>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.8rem;">
                        @foreach(["GTH", "FINANZAS", "SOPORTE TI", "REMESA"] as $dept)
                            <label style="cursor: pointer; position: relative;">
                                <input type="radio" name="department" value="{{ $dept }}" {{ $dept == "SOPORTE TI" ? "checked" : "" }} style="display: none;" class="dept-radio">
                                <div style="padding: 1rem 0.5rem; border-radius: 1.2rem; border: 2px solid #f1f5f9; text-align: center; font-size: 0.6rem; font-weight: 950; color: #64748b; background: white; transition: all 0.2s;" class="dept-box">
                                    {{ $dept }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;">ASUNTO DE LA SOLICITUD</label>
                    <input type="text" name="title" required style="width: 100%; padding: 0.8rem; border-radius: 1rem; border: 2px solid #f1f5f9; font-weight: 950;">
                </div>
                <div style="margin-bottom: 2rem;">
                    <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;">DETALLE DEL PROBLEMA</label>
                    <textarea name="description" required style="width: 100%; padding: 1.2rem; border-radius: 1.5rem; border: 2px solid #f1f5f9; min-height: 120px; font-weight: 600; text-transform: none;"></textarea>
                </div>
                <div style="margin-bottom: 3rem;">
                    <label style="font-size: 0.6rem; font-weight: 950; color: #64748b; display: block; margin-bottom: 0.5rem;">ADJUNTAR CAPTURA O ERROR (OPCIONAL)</label>
                    <input type="file" name="attachment" style="font-size: 0.7rem; font-weight: 950; color: #1e293b; background: #f8fafc; padding: 1rem; border-radius: 1.5rem; border: 2px dashed #cbd5e1; width: 100%;">
                </div>
                <button type="submit" style="width: 100%; background: #3b82f6; box-shadow: 0 10px 25px rgba(59,130,246,0.4); color: white; padding: 1.2rem; border-radius: 1.2rem; font-weight: 950; font-size: 0.9rem; cursor: pointer; border: none; box-shadow: 0 10px 20px rgba(37,99,235,0.2);">ENVIAR SOLICITUD AHORA 🚀</button>
            </form>
        </div>
    </div>
    <style>
        .dept-radio:checked + .dept-box { 
            background: #2563eb !important; 
            border-color: #2563eb !important; 
            color: white !important; 
            box-shadow: 0 10px 20px rgba(37,99,235,0.2); 
            transform: translateY(-3px); 
        }
        .dept-box:hover { border-color: #cbd5e1; background: #f8fafc; }
    </style>
</x-app-layout>
