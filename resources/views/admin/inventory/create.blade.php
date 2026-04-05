<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA -->
        <div style="margin-bottom: 3rem; display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.inventory.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem;">←</a>
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827;">Registrar Nuevo Equipo</h1>
                <p style="font-size: 0.85rem; color: #64748b;">Añade los detalles técnicos del activo al inventario.</p>
            </div>
        </div>

        <!-- FORMULARIO SAAS -->
        <div style="max-width: 900px; background: white; border-radius: 2rem; border: 1px solid #e5e7eb; padding: 4rem; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <form action="{{ route('admin.inventory.store') }}" method="POST">
                @csrf
                
                <!-- SECCIÓN 1: IDENTIFICACIÓN -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; letter-spacing: 1px; text-transform: uppercase;">Nombre del Equipo</label>
                        <input type="text" name="name" required placeholder="Ej: Laptop Dell Latitude" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; letter-spacing: 1px; text-transform: uppercase;">Cód. Inventario (TI-XXX)</label>
                        <input type="text" name="inventory_code" required placeholder="Ej: TI-001" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                    </div>
                </div>

                <!-- SECCIÓN 2: DATOS TÉCNICOS -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Marca</label>
                        <input type="text" name="brand" required placeholder="Ej: Dell" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Nº de Serie</label>
                        <input type="text" name="serial_number" required placeholder="Ej: SN-492931" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Tipo</label>
                        <select name="type" required style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; height: 58px; background: white;">
                            <option value="Laptop">Laptop</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Impresora">Impresora</option>
                            <option value="Servidor">Monitor</option>
                        </select>
                    </div>
                </div>

                <!-- SECCIÓN 3: UBICACIÓN Y ESTADO -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Ubicación</label>
                        <input type="text" name="location" placeholder="Ej: Oficina Central, Piso 2" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Estado Inicial</label>
                        <select name="status" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; height: 58px; background: white;">
                            <option value="Operativo">● Operativo</option>
                            <option value="Mantenimiento">● Mantenimiento</option>
                            <option value="De baja">● De baja</option>
                        </select>
                    </div>
                </div>

                <!-- BOTONES -->
                <div style="display: flex; justify-content: flex-end; gap: 1.5rem; padding-top: 2rem; border-top: 1px solid #f1f5f9;">
                    <button type="submit" class="btn-primary" style="padding: 1.1rem 3.5rem; font-size: 0.8rem; border-radius: 14px;">PUBLICAR EN INVENTARIO ✅</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
