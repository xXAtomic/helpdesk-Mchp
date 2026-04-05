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
