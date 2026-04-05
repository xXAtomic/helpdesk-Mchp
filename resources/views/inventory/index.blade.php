<x-app-layout>
    <div style="display: flex; flex-direction: column; height: 100vh;">

        <!-- CABECERA DE INVENTARIO -->
        <div style="padding: 2.5rem 3.5rem; background: #fdfdfd; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: end;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Gestión de Inventario</h1>
                <p style="font-size: 0.8rem; color: #6b7280; font-weight: 500; margin-top: 0.5rem;">Control detallado de activos tecnológicos del centro</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-filter">🖨️ Exportar Listado</button>
                <button class="btn-primary" style="padding: 0.8rem 1.8rem; font-size: 0.8rem;">📦 Registrar Equipo</button>
            </div>
        </div>

        <!-- FILTROS RÁPIDOS (TIPO SAAS) -->
        <div style="padding: 1.2rem 3.5rem; background: #fafafa; border-bottom: 1px solid #f3f4f6; display: flex; gap: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #2563eb; font-weight: 700; font-size: 0.75rem; text-transform: uppercase;">
                <span style="background: #2563eb; width: 6px; height: 6px; border-radius: 50%;"></span> Todos los Equipos
            </div>
            <div style="color: #94a3b8; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; cursor: pointer;">En Mantenimiento</div>
            <div style="color: #94a3b8; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; cursor: pointer;">Dados de Baja</div>
        </div>

        <!-- TABLA DE EQUIPOS -->
        <div style="flex: 1; padding: 2rem 3.5rem; overflow-y: auto; background: white;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #f1f5f9; border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="padding: 1.2rem 1.5rem;">ETIQUETA / TIPO</th>
                        <th style="padding: 1.2rem 1.5rem;">CÓDIGO SERIAL</th>
                        <th style="padding: 1.2rem 1.5rem;">MARCA Y MODELO</th>
                        <th style="padding: 1.2rem 1.5rem;">UBICACIÓN</th>
                        <th style="padding: 1.2rem 1.5rem;">ESTADO</th>
                        <th style="padding: 1.2rem 1.5rem;">RESPONSABLE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipment as $item)
                    <tr>
                        <td style="padding: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 40px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">💻</div>
                                <div>
                                    <div style="font-weight: 700; color: #111827; font-size: 0.9rem;">{{ $item->asset_tag }}</div>
                                    <div style="font-size: 0.7rem; color: #3b82f6; font-weight: 800; text-transform: uppercase;">{{ $item->type }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1.5rem;">
                            <span style="font-family: monospace; color: #64748b; font-size: 0.8rem; background: #f1f5f9; padding: 0.3rem 0.6rem; border-radius: 5px;">
                                {{ $item->serial_number ?? 'S/N' }}
                            </span>
                        </td>
                        <td style="padding: 1.5rem; font-weight: 600; color: #334155;">
                            {{ $item->brand }} - {{ $item->model }}
                        </td>
                        <td style="padding: 1.5rem; color: #64748b; font-weight: 500; font-size: 0.8rem;">
                            📍 {{ $item->location ?? 'No definida' }}
                        </td>
                        <td style="padding: 1.5rem;">
                            <span style="background: #ecfdf5; color: #059669; padding: 0.4rem 1rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 800; border: 1px solid #d1fae5;">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="padding: 1.5rem;">
                             <div style="display: flex; align-items: center; gap: 0.8rem;">
                                <div class="avatar" style="width: 24px; height: 24px; background: #64748b; font-size: 0.6rem;">
                                    {{ strtoupper(substr($item->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 600;">{{ $item->user->name ?? 'Sin asignar' }}</span>
                             </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
1~<x-app-layout>
    <div style="display: flex; flex-direction: column; height: 100vh;">
        <!-- CABECERA DE INVENTARIO -->
        <div style="padding: 2.5rem 3.5rem; background: #fdfdfd; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: end;">
            <div>
                <h1 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Gestión de Inventario</h1>
                <p style="font-size: 0.8rem; color: #6b7280; font-weight: 500; margin-top: 0.5rem;">Control detallado de activos tecnológicos del centro</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn-filter">🖨️ Exportar Listado</button>
                <button class="btn-primary" style="padding: 0.8rem 1.8rem; font-size: 0.8rem;">📦 Registrar Equipo</button>
            </div>
        </div>
        <!-- FILTROS RÁPIDOS (TIPO SAAS) -->
        <div style="padding: 1.2rem 3.5rem; background: #fafafa; border-bottom: 1px solid #f3f4f6; display: flex; gap: 2rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #2563eb; font-weight: 700; font-size: 0.75rem; text-transform: uppercase;">
                <span style="background: #2563eb; width: 6px; height: 6px; border-radius: 50%;"></span> Todos los Equipos
            </div>
            <div style="color: #94a3b8; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; cursor: pointer;">En Mantenimiento</div>
            <div style="color: #94a3b8; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; cursor: pointer;">Dados de Baja</div>
        </div>
        <!-- TABLA DE EQUIPOS -->
        <div style="flex: 1; padding: 2rem 3.5rem; overflow-y: auto; background: white;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #f1f5f9; border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr>
                        <th style="padding: 1.2rem 1.5rem;">ETIQUETA / TIPO</th>
                        <th style="padding: 1.2rem 1.5rem;">CÓDIGO SERIAL</th>
                        <th style="padding: 1.2rem 1.5rem;">MARCA Y MODELO</th>
                        <th style="padding: 1.2rem 1.5rem;">UBICACIÓN</th>
                        <th style="padding: 1.2rem 1.5rem;">ESTADO</th>
                        <th style="padding: 1.2rem 1.5rem;">RESPONSABLE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipment as $item)
                    <tr>
                        <td style="padding: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 40px; height: 40px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">💻</div>
                                <div>
                                    <div style="font-weight: 700; color: #111827; font-size: 0.9rem;">{{ $item->asset_tag }}</div>
                                    <div style="font-size: 0.7rem; color: #3b82f6; font-weight: 800; text-transform: uppercase;">{{ $item->type }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1.5rem;">
                            <span style="font-family: monospace; color: #64748b; font-size: 0.8rem; background: #f1f5f9; padding: 0.3rem 0.6rem; border-radius: 5px;">
                                {{ $item->serial_number ?? 'S/N' }}
                            </span>
                        </td>
                        <td style="padding: 1.5rem; font-weight: 600; color: #334155;">
                            {{ $item->brand }} - {{ $item->model }}
                        </td>
                        <td style="padding: 1.5rem; color: #64748b; font-weight: 500; font-size: 0.8rem;">
                            📍 {{ $item->location ?? 'No definida' }}
                        </td>
                        <td style="padding: 1.5rem;">
                            <span style="background: #ecfdf5; color: #059669; padding: 0.4rem 1rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 800; border: 1px solid #d1fae5;">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="padding: 1.5rem;">
                             <div style="display: flex; align-items: center; gap: 0.8rem;">
                                <div class="avatar" style="width: 24px; height: 24px; background: #64748b; font-size: 0.6rem;">
                                    {{ strtoupper(substr($item->user->name ?? '?', 0, 2)) }}
                                </div>
                                <span style="font-size: 0.8rem; font-weight: 600;">{{ $item->user->name ?? 'Sin asignar' }}</span>
                             </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
