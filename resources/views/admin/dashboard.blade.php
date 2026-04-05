<<<<<<< HEAD
@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tickets Abiertos</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $openTickets ?? 0 }}</div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Mis Tickets Asignados</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $myTickets ?? 0 }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">Equipos en Inventario</div>
        <div class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAssets ?? 0 }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b">
        <h3 class="font-bold text-gray-800">Acciones Rápidas</h3>
    </div>
    <div class="p-6">
        <p class="text-gray-600 mb-4">Bienvenido al sistema. Puedes gestionar el Help Desk usando el panel lateral.</p>
        <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Ver Listado de Tickets
        </a>
    </div>
</div>
@endsection
=======
<x-app-layout>
    <div style="background: #fdfdfd; padding: 4rem 3.5rem; min-height: 100vh; overflow-y: auto;">
        
        <!-- CABECERA PERSONALIZADA -->
        <div style="margin-bottom: 4rem;">
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #111827; letter-spacing: -0.8px;">Bienvenido, Administrador 👋</h1>
            <p style="font-size: 0.95rem; color: #64748b; font-weight: 500; margin-top: 0.5rem;">Aquí tienes un vistazo rápido al estado actual de tu infraestructura tecnológica.</p>
        </div>

        <!-- 🏁 TARJETAS DE MÉTRICAS (GRID 4 COLUMNAS) -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-bottom: 4rem;">
            <!-- CARD: TOTAL TICKETS -->
            <div style="background: white; padding: 2.2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                <div style="font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem;">Tickets Totales</div>
                <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                    <div style="font-size: 2.2rem; font-weight: 900; color: #111827;">{{ $stats['total_tickets'] }}</div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: #10b981;">+ Activos</div>
                </div>
            </div>

<!-- CARD: TICKETS PENDIENTES (SIMETRÍA TOTAL) -->
<div style="background: white; padding: 2.2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
    <div style="font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem;">Tickets Pendientes</div>
    <div style="font-size: 2.2rem; font-weight: 900; color: #111827;">{{ $stats['open_tickets'] }}</div>
</div>

            <!-- CARD: EQUIPOS -->
            <div style="background: white; padding: 2.2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                <div style="font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem;">Equipos Registrados</div>
                <div style="font-size: 2.2rem; font-weight: 900; color: #111827;">{{ $stats['total_equipment'] }}</div>
            </div>

            <!-- CARD: USUARIOS -->
            <div style="background: white; padding: 2.2rem; border-radius: 2rem; border: 1.2px solid #f1f5f9; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                <div style="font-size: 0.7rem; font-weight: 1000; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem;">Usuarios Registrados</div>
                <div style="font-size: 2.2rem; font-weight: 900; color: #111827;">{{ $stats['total_users'] }}</div>
            </div>
        </div>

        <!-- 🏢 SECCIÓN INFERIOR: TABLA DE ACTIVIDAD -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;">
            
            <!-- LISTADO DE TICKETS RECIENTES -->
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 2rem;">Actividad de Tickets Reciente</h3>
                <div style="background: white; border-radius: 2rem; border: 1.2px solid #f1f5f9; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tbody style="font-size: 0.85rem; font-weight: 500; color: #1e293b;">
                            @forelse($recentTickets as $ticket)
                            <tr style="border-bottom: 1px solid #f8fafc; transition: 0.2s;" onmouseover="this.style.background='#fcfcfc'">
                                <td style="padding: 1.8rem 2.5rem;">
                                    <div style="font-weight: 800; color: #111827; font-size: 0.95rem;">{{ $ticket->subject }}</div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.4rem;">Por: {{ $ticket->user->name }} • {{ $ticket->created_at->diffForHumans() }}</div>
                                </td>
                                <td style="padding: 1.8rem 2.5rem; text-align: right;">
                                    <span style="background: #eff6ff; color: #2563eb; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">VER MÁS →</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td style="padding: 4rem; text-align: center; color: #94a3b8;">No hay actividad reciente. ✨</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- BARRA DE ACCIONES RÁPIDAS -->
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 2rem;">Acciones Rápidas</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <button class="btn-primary" style="padding: 1.2rem; border-radius: 15px; font-weight: 700;" onclick="window.location.href='{{ route('admin.tickets.index') }}'">🎟️ GESTIONAR TICKETS</button>
                    <button class="btn-primary" style="padding: 1.2rem; border-radius: 15px; font-weight: 700; background: #fafafa; border: 1.5px solid #e2e8f0; color: #111827;" onclick="window.location.href='{{ route('admin.inventory.create') }}'">🖥️ REGISTRAR EQUIPO</button>
                    <button class="btn-primary" style="padding: 1.2rem; border-radius: 15px; font-weight: 700; background: #fafafa; border: 1.5px solid #e2e8f0; color: #111827;" onclick="window.location.href='{{ route('admin.knowledge.create') }}'">📚 REDACTAR MANUAL</button>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
>>>>>>> origin/servidor-maraton-ayer
