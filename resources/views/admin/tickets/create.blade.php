<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <div style="margin-bottom: 3rem; display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.tickets.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem; transition: 0.2s;" onmouseover="this.style.color='#111827'">←</a>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Nuevo Ticket de Soporte</h1>
        </div>

        <div style="max-width: 900px; background: white; border-radius: 2.5rem; border: 1.2px solid #e5e7eb; padding: 4.5rem; box-shadow: 0 20px 60px rgba(0,0,0,0.03);">
            <form action="{{ route('admin.tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- FILA 1: NOMBRE Y CORREO -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-bottom: 2.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">Nombre del Solicitante</label>
                        <input type="text" name="name" required placeholder="Nombre completo" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #f1f5f9; background: #fafafa; font-weight: 600;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">Correo Electrónico</label>
                        <input type="email" name="email" required placeholder="correo@ejemplo.com" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #f1f5f9; background: #fafafa; font-weight: 600;">
                    </div>
                </div>

                <!-- FILA 2: DEPARTAMENTO Y ASUNTO -->
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2.5rem; margin-bottom: 2.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">Departamento</label>
                        <select name="department" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #f1f5f9; background: #fafafa; font-weight: 600;">
                            <option>Soporte Técnico</option>
                            <option>Infraestructura</option>
                            <option>Sistemas</option>
                            <option>Redes</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">Asunto</label>
                        <input type="text" name="title" required placeholder="Resumen corto del problema" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #f1f5f9; background: #fafafa; font-weight: 600;">
                    </div>
                </div>

                <!-- DESCRIPCIÓN -->
                <div style="margin-bottom: 2.5rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.8rem;">Descripción Detallada</label>
                    <textarea name="description" required placeholder="Explora los detalles del problema aquí..." style="width: 100%; min-height: 180px; padding: 1.2rem; border-radius: 15px; border: 1.5px solid #f1f5f9; background: #fafafa; outline: none; line-height: 1.6;"></textarea>
                </div>

                <!-- SUBIR CAPTURA -->
                <div style="margin-bottom: 4rem; padding: 2rem; border: 2px dashed #e2e8f0; border-radius: 20px; text-align: center; background: #fafafa;">
                    <label style="cursor: pointer;">
                        <span style="display: block; font-size: 1.5rem; margin-bottom: 0.5rem;">📸</span>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #1e293b;">Subir Capturas de Pantalla</span>
                        <input type="file" name="attachment" style="display: none;">
                        <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 5px;">Formato JPG, PNG o PDF (Máx. 5MB)</p>
                    </label>
                </div>

                <!-- BOTONES -->
                <div style="display: flex; justify-content: flex-end; gap: 1.5rem;">
                    <button type="button" onclick="history.back()" style="padding: 1.1rem 2.5rem; border-radius: 14px; font-weight: 800; color: #64748b; background: transparent; border: 1.5px solid #e2e8f0;">CANCELAR</button>
                    <button type="submit" class="btn-primary" style="padding: 1.1rem 3.5rem; border-radius: 14px; font-weight: 800;">CREAR TICKET ✅</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
