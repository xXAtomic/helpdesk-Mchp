<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tus tickets reportados</h2>
    <a href="{{ route('user.tickets.create') ?? '#' }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
        + Abrir Nuevo Ticket
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">TICKET ID</th>
                    <th class="px-6 py-4 font-semibold">TEMA / ASUNTO</th>
                    <th class="px-6 py-4 font-semibold">ESTADO</th>
                    <th class="px-6 py-4 font-semibold">ÚLTIMA ACTUALIZACIÓN</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @if(isset($tickets) && $tickets->count() > 0)
                    @foreach ($tickets as $ticket)
                    <tr class="hover:bg-blue-50 transition cursor-pointer" data-href="{{ route('user.tickets.show', $ticket) }}" onclick="window.location=this.dataset.href;">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600 hover:underline">
                            {{ $ticket->ticket_number }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                            {{ $ticket->title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                  {!! 'style="background-color: ' . (optional($ticket->status)->color ?? '#cbd5e1') . '30; color: ' . (optional($ticket->status)->color ?? '#334155') . ';"' !!}>
                                {{ optional($ticket->status)->name ?? 'En proceso' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ticket->updated_at->diffForHumans() }}
                        </td>
                    </tr>
                    @endforeach
                @else
                    <!-- Dummy state para visualización -->
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">TCK-20231015-A1F9</td>
                        <td class="px-6 py-4 text-sm text-gray-800">Mi correo corporativo dejó de sincronizar</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente Técnico</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Hace 2 horas</td>
                    </tr>
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">TCK-20231010-B2X3</td>
                        <td class="px-6 py-4 text-sm text-gray-800">Requerimiento de Teclado y Mouse nuevos</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Resuelto</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Hace 5 días</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
=======
<x-app-layout>
    <div style="display: flex; min-height: 100vh; background-color: #f8fafc; font-family: sans-serif; text-transform: uppercase; overflow: hidden;">
        
        <!-- SIDEBAR FULL-HIGH (CYBER-BLUE) -->
        <div style="width: 280px; position: fixed; height: 100vh; z-index: 100;
                    background: #020617; 
                    background-image: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%);
                    color: white; display: flex; flex-direction: column; box-shadow: 15px 0 35px rgba(0,0,0,0.1);">
            
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; opacity: 0.15; pointer-events: none;
                        background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px);"></div>
            <div style="padding: 3rem 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: center;">
                <h1 style="font-size: 1.5rem; font-weight: 1000; color: #fbbf24; font-style: italic;">MCHP SOPORTE</h1>
            </div>
            <nav style="flex: 1; padding: 3rem 1.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">🏠 INICIO</a>
                <a href="{{ route('user.tickets.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 950; color: #0f172a; background-color: #fbbf24; text-decoration: none; border-radius: 1.5rem; box-shadow: 0 10px 20px rgba(251,191,36,0.3);">🎫 MIS TICKETS</a>
                <a href="{{ route('knowledge.index') }}" style="display: flex; align-items: center; padding: 1.2rem 2rem; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-decoration: none;">❓ FAQ (PREGUNTAS)</a>
            </nav>
        </div>
        <!-- CONTENIDO PRINCIPAL (FONDO BLANCO) -->
        <div style="flex: 1; margin-left: 280px; padding: 4rem; overflow-y: auto;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4rem;">
                <h2 style="font-weight: 1000; font-size: 2.2rem; color: #0f172a; font-style: italic;">MIS TICKETS 🔥</h2>
                <a href="{{ route('user.tickets.create') }}" style="background: #3b82f6; box-shadow: 0 10px 25px rgba(59,130,246,0.4); color: white; padding: 1.2rem 2.5rem; border-radius: 1.5rem; font-weight: 1000; font-size: 0.75rem; text-decoration: none; box-shadow: 0 10px 20px rgba(37,99,235,0.2);">+ NUEVO REQUERIMIENTO</a>
            </div>
            <!-- LISTADO DE TICKETS CON MARCO INDIVIDUAL -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($tickets as $ticket)
                    <a href="{{ route('user.tickets.show', $ticket) }}" 
                       style="text-decoration: none; display: flex; align-items: center; justify-content: space-between; 
                              padding: 2.2rem 3rem; background: white; border: 2px solid #cbd5e1; border-radius: 2.5rem; 
                              transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                        
                        <div style="display: flex; align-items: center; gap: 2.5rem;">
                            <!-- NUMERACIÓN TICKET-000 -->
                            <div style="width: 100px; padding: 0.8rem; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 1rem; text-align: center; font-weight: 1000; color: #2563eb; font-size: 0.65rem;">
                                TICKET-{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}
                            </div>
                            
                            <div>
                                <h3 style="font-weight: 1000; font-size: 1.1rem; color: #0f172a; margin: 0; letter-spacing: -0.5px;">{{ $ticket->title }}</h3>
                                <p style="font-size: 0.6rem; color: #94a3b8; font-weight: 950; margin-top: 0.5rem; letter-spacing: 1px;">CAPTURED AT {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="background: #ecfdf5; color: #10b981; padding: 0.7rem 1.8rem; border-radius: 2rem; font-size: 0.65rem; font-weight: 1000; border: 1.5px solid #d1fae5; box-shadow: 0 5px 15px rgba(16,185,129,0.1);">
                                🚀 {{ $ticket->status }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        a:hover { border-color: #cbd5e1 !important; transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0,0,0,0.05) !important; }
    </style>
</x-app-layout>
>>>>>>> origin/servidor-maraton-ayer
