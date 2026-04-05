<x-app-layout>
    <div style="display: flex; flex-direction: column; height: 100vh;">

        <!-- CABECERA DE USUARIOS -->
        <div style="padding: 2.5rem 3.5rem; background: white; border-bottom: 2px solid #f1f5f9; display: flex; justify-content: space-between; align-items: end;">
            <div>
                <h1 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Gestión de Usuarios</h1>
                <p style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; margin-top: 0.6rem; text-transform: uppercase; letter-spacing: 1px;">Control de acceso y perfiles del sistema</p>
            </div>
            <button class="btn-primary" style="padding: 0.8rem 2rem; font-size: 0.8rem; border-radius: 12px; font-weight: 800;">👥 NUEVO USUARIO</button>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div style="flex: 1; padding: 4rem 3.5rem; overflow-y: auto; background: #fdfdfd;">
            
            <!-- TARJETA CONTENEDORA DE TABLA -->
            <div style="background: white; border-radius: 1.5rem; border: 1px solid #e5e7eb; box-shadow: 0 4px 20px rgba(0,0,0,0.02); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f9fafb;">
                            <th style="padding: 1.2rem 2.5rem;">USUARIO / E-MAIL</th>
                            <th style="padding: 1.2rem 2.5rem;">ROL / NIVEL</th>
                            <th style="padding: 1.2rem 2.5rem;">ESTADO</th>
                            <th style="padding: 1.2rem 2.5rem;">MIEMBRO DESDE</th>
                            <th style="padding: 1.2rem 2.5rem; text-align: right;">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="transition: 0.2s;">
                            <td style="padding: 1.5rem 2.5rem;">
                                <div style="display: flex; align-items: center; gap: 1.2rem;">
                                    <?php 
                                        $initials = strtoupper(substr($user->name, 0, 2));
                                        $colors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#3b82f6'];
                                        $bgColor = $colors[array_rand($colors)];
                                    ?>
                                    <div class="avatar" style="width: 42px; height: 42px; background: {{ $bgColor }}; font-size: 0.9rem; font-weight: 800; border: 3px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">{{ $initials }}</div>
                                    <div>
                                        <div style="font-weight: 700; color: #111827; font-size: 0.95rem;">{{ $user->name }}</div>
                                        <div style="font-size: 0.75rem; color: #6b7280; text-transform: lowercase;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 1.5rem 2.5rem;">
                                <div style="font-size: 0.8rem; font-weight: 700; color: #111827;">{{ $user->role->name ?? 'Usuario' }}</div>
                                <div style="font-size: 0.65rem; color: #94a3b8; font-weight: 500; text-transform: uppercase;">ACCESO ESTÁNDAR</div>
                            </td>
                            <td style="padding: 1.5rem 2.5rem;">
                                <span style="background: #f0fdf4; color: #166534; padding: 0.35rem 0.9rem; border-radius: 1rem; font-size: 0.7rem; font-weight: 800;">
                                    ACTIVO 🟢
                                </span>
                            </td>
                            <td style="padding: 1.5rem 2.5rem; font-size: 0.85rem; color: #64748b; font-weight: 600;">
                                📅 {{ $user->created_at->format('d M, Y') }}
                            </td>
                            <td style="padding: 1.5rem 2.5rem; text-align: right;">
                                <button style="background: none; border: 1px solid #e5e7eb; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.65rem; color: #6b7280; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='none'">EDITAR</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- FOOTER DE PÁGINA (OPCIONAL) -->
            <div style="margin-top: 2rem; display: flex; justify-content: space-between; align-items: center; padding: 0 1rem;">
                <p style="font-size: 0.75rem; color: #94a3b8; font-weight: 500;">Mostrando {{ $users->count() }} usuarios totales registrados.</p>
            </div>
            
        </div>

    </div>
</x-app-layout>
