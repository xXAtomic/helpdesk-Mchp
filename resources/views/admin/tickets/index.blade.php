<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA Y BOTÓN -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4.5rem;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Gestión de Incidentes</h1>
                <p style="font-size: 0.85rem; color: #64748b; font-weight: 500; margin-top: 0.4rem;">Monitoriza y da respuesta a todas las solicitudes de soporte técnico.</p>
            </div>
            <button class="btn-primary" style="padding: 1rem 2.2rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem;" onclick="window.location.href='{{ route('admin.tickets.create') }}'">+ CREAR NUEVO TICKET</button>
        </div>

        <!-- 🏁 TARJETAS DE RESUMEN RÁPIDO (GRID) -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-bottom: 4.5rem;">
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Abiertos 🎟️</div>
                <div style="font-size: 2rem; font-weight: 900; color: #3b82f6; margin-top: 1rem;">{{ $stats['open'] }}</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Resueltos ✅</div>
                <div style="font-size: 2rem; font-weight: 900; color: #111827; margin-top: 1rem;">{{ $stats['closed'] }}</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">T. Respuesta ⏱️</div>
                <div style="font-size: 2rem; font-weight: 900; color: #111827; margin-top: 1rem;">{{ $stats['avg_time'] }}</div>
            </div>
            <div style="background: #111827; padding: 2rem; border-radius: 2rem; color: white;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #9ca3af; text-transform: uppercase;">Total Histórico</div>
                <div style="font-size: 2rem; font-weight: 900; color: white; margin-top: 1rem;">{{ $stats['total'] }}</div>
            </div>
        </div>

        <!-- TABLA DE TICKETS (SAAS PREMIUM) -->
        <div style="background: white; border-radius: 2.2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #fafafa; border-bottom: 1.5px solid #f1f5f9;">
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Ticket / Usuario</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Asunto</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Estado / Seguimiento</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Acción</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; color: #1e293b; font-weight: 500;">
                    @forelse($tickets as $t)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'">
                        <td style="padding: 2.2rem 2.8rem;">
                            <div style="font-weight: 800; color: #3b82f6; font-size: 0.95rem;">#{{ $t->ticket_number ?? 'TCK-'.$t->id }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 5px;">{{ $t->user->name ?? 'Invitado' }}</div>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <div style="font-weight: 800; color: #111827; padding-right: 2rem;">{{ $t->title ?? $t->subject }}</div>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <span style="background: {{ $t->closed_at ? '#f3f4f6' : '#eff6ff' }}; color: {{ $t->closed_at ? '#64748b' : '#3b82f6' }}; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.65rem; font-weight: 800;">
                                ● {{ $t->closed_at ? 'RESUELTO' : 'PENDIENTE' }}
                            </span>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <a href="{{ route('admin.tickets.show', $t->id) }}" style="text-decoration: none; background: #111827; color: white; padding: 0.8rem 1.5rem; border-radius: 14px; font-size: 0.72rem; font-weight: 700; transition: 0.2s;">GESTIONAR →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="padding: 6rem; text-align: center; color: #94a3b8; font-weight: 600;">No hay tickets pendientes hoy. ✨</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
1~<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh;">
        
        <!-- CABECERA Y BOTÓN -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4.5rem;">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #111827; letter-spacing: -0.5px;">Gestión de Incidentes</h1>
                <p style="font-size: 0.85rem; color: #64748b; font-weight: 500; margin-top: 0.4rem;">Monitoriza y da respuesta a todas las solicitudes de soporte técnico.</p>
            </div>
            <button class="btn-primary" style="padding: 1rem 2.2rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem;" onclick="window.location.href='{{ route('admin.tickets.create') }}'">+ CREAR NUEVO TICKET</button>
        </div>
        <!-- 🏁 TARJETAS DE RESUMEN RÁPIDO (GRID) -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-bottom: 4.5rem;">
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Abiertos 🎟️</div>
                <div style="font-size: 2rem; font-weight: 900; color: #3b82f6; margin-top: 1rem;">{{ $stats['open'] }}</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Resueltos ✅</div>
                <div style="font-size: 2rem; font-weight: 900; color: #111827; margin-top: 1rem;">{{ $stats['closed'] }}</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">T. Respuesta ⏱️</div>
                <div style="font-size: 2rem; font-weight: 900; color: #111827; margin-top: 1rem;">{{ $stats['avg_time'] }}</div>
            </div>
            <div style="background: #111827; padding: 2rem; border-radius: 2rem; color: white;">
                <div style="font-size: 0.65rem; font-weight: 1000; color: #9ca3af; text-transform: uppercase;">Total Histórico</div>
                <div style="font-size: 2rem; font-weight: 900; color: white; margin-top: 1rem;">{{ $stats['total'] }}</div>
            </div>
        </div>
        <!-- TABLA DE TICKETS (SAAS PREMIUM) -->
        <div style="background: white; border-radius: 2.2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #fafafa; border-bottom: 1.5px solid #f1f5f9;">
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Ticket / Usuario</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Asunto</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Estado / Seguimiento</th>
                        <th style="padding: 1.5rem 2.8rem; font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase;">Acción</th>
                    </tr>
                </thead>
                <tbody style="font-size: 0.85rem; color: #1e293b; font-weight: 500;">
                    @forelse($tickets as $t)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'">
                        <td style="padding: 2.2rem 2.8rem;">
                            <div style="font-weight: 800; color: #3b82f6; font-size: 0.95rem;">#{{ $t->ticket_number ?? 'TCK-'.$t->id }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 5px;">{{ $t->user->name ?? 'Invitado' }}</div>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <div style="font-weight: 800; color: #111827; padding-right: 2rem;">{{ $t->title ?? $t->subject }}</div>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <span style="background: {{ $t->closed_at ? '#f3f4f6' : '#eff6ff' }}; color: {{ $t->closed_at ? '#64748b' : '#3b82f6' }}; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.65rem; font-weight: 800;">
                                ● {{ $t->closed_at ? 'RESUELTO' : 'PENDIENTE' }}
                            </span>
                        </td>
                        <td style="padding: 2.2rem 2.8rem;">
                            <a href="{{ route('admin.tickets.show', $t->id) }}" style="text-decoration: none; background: #111827; color: white; padding: 0.8rem 1.5rem; border-radius: 14px; font-size: 0.72rem; font-weight: 700; transition: 0.2s;">GESTIONAR →</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="padding: 6rem; text-align: center; color: #94a3b8; font-weight: 600;">No hay tickets pendientes hoy. ✨</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
