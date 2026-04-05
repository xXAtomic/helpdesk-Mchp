<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4rem;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Inventario de Equipos</h1>
                <p style="font-size: 0.85rem; color: #64748b; font-weight: 500; margin-top: 0.4rem;">Gestiona y rastrea todos los activos tecnológicos de la institución.</p>
            </div>
            <button class="btn-primary" style="padding: 0.9rem 2rem; border-radius: 12px; font-weight: 700;" onclick="window.location.href='{{ route('admin.inventory.create') }}'">+ REGISTRAR EQUIPO</button>
        </div>

        <!-- TABLA DE INVENTARIO -->
        <div style="background: white; border-radius: 1.8rem; border: 1px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #fafafa; border-bottom: 1.5px solid #f1f5f9;">
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Código / S.N</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Nombre del Equipo</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Tipo</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Ubicación</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Estado</th>
                        <th style="padding: 1.5rem 2rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Acciones</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; color: #1e293b; font-weight: 500;">
                    @forelse($items as $item)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'">
                        <td style="padding: 1.5rem 2rem;">
                            <div style="font-weight: 800; color: #3b82f6;">{{ $item->inventory_code }}</div>
                            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">{{ $item->serial_number }}</div>
                        </td>
                        <td style="padding: 1.5rem 2rem;">
                            <div style="font-weight: 800;">{{ $item->name }}</div>
                            <div style="font-size: 0.75rem; color: #64748b;">{{ $item->brand }} {{ $item->model }}</div>
                        </td>
                        <td style="padding: 1.5rem 2rem;">{{ $item->type }}</td>
                        <td style="padding: 1.5rem 2rem; color: #64748b;">{{ $item->location ?? 'N/A' }}</td>
                        <td style="padding: 1.5rem 2rem;">
                            <span style="background: {{ $item->status == 'Operativo' ? '#ecfdf5' : '#fff7ed' }}; 
                                       color: {{ $item->status == 'Operativo' ? '#059669' : '#d97706' }}; 
                                       padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.7rem; font-weight: 800;">
                                ● {{ $item->status }}
                            </span>
                        </td>
                        <td style="padding: 1.5rem 2rem; display: flex; gap: 0.8rem;">
                            <a href="{{ route('admin.inventory.edit', $item->id) }}" style="text-decoration: none;">✏️</a>
                            <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; cursor: pointer;">❌</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 4rem; text-align: center; color: #94a3b8; font-weight: 600;">No hay equipos registrados en el inventario.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
