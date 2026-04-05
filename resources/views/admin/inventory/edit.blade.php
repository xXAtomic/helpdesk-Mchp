<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA -->
        <div style="margin-bottom: 3rem; display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ route('admin.inventory.index') }}" style="text-decoration: none; color: #94a3b8; font-size: 1.5rem;">←</a>
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827;">Actualizar Equipo: {{ $item->inventory_code }}</h1>
                <p style="font-size: 0.85rem; color: #64748b;">Modifica los detalles del activo tecnológico.</p>
            </div>
        </div>

        <!-- FORMULARIO SAAS -->
        <div style="max-width: 900px; background: white; border-radius: 2rem; border: 1px solid #e5e7eb; padding: 4rem; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
            <form action="{{ route('admin.inventory.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- SECCIÓN 1: IDENTIFICACIÓN -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 3rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Nombre del Equipo</label>
                        <input type="text" name="name" value="{{ $item->name }}" required style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Cód. Inventario</label>
                        <input type="text" name="inventory_code" value="{{ $item->inventory_code }}" required style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; font-weight: 600;">
                    </div>
                </div>

                <!-- SECCIÓN 2: DATOS TÉCNICOS -->
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 3rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Marca</label>
                        <input type="text" name="brand" value="{{ $item->brand }}" required style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Modelo</label>
                        <input type="text" name="model" value="{{ $item->model }}" placeholder="Ej: Latitude 5420" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Estado Actual</label>
                        <select name="status" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; background: white; height: 58px;">
                            <option value="Operativo" {{ $item->status == 'Operativo' ? 'selected' : '' }}>● Operativo</option>
                            <option value="Mantenimiento" {{ $item->status == 'Mantenimiento' ? 'selected' : '' }}>● Mantenimiento</option>
                            <option value="De baja" {{ $item->status == 'De baja' ? 'selected' : '' }}>● De baja</option>
                        </select>
                    </div>
                </div>

                <!-- SECCIÓN 3: UBICACIÓN -->
                <div style="margin-bottom: 3rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 900; color: #64748b; margin-bottom: 1rem; text-transform: uppercase;">Ubicación / Oficina</label>
                    <input type="text" name="location" value="{{ $item->location }}" style="width: 100%; padding: 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0;">
                </div>

                <!-- BOTONES -->
                <div style="display: flex; justify-content: flex-end; gap: 1.5rem; padding-top: 2rem; border-top: 1px solid #f1f5f9;">
                    <button type="submit" class="btn-primary" style="padding: 1.1rem 3.5rem; font-size: 0.8rem; border-radius: 14px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);">GUARDAR CAMBIOS 💾</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
