@extends('layouts.admin')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
        <h2 class="text-xl font-bold text-gray-800">Listado de Tickets</h2>
        <div>
            <!-- Filters -->
            <select class="border-gray-300 rounded-md text-sm">
                <option>Todos los Estados</option>
                <option>Abiertos</option>
                <option>Cerrados</option>
            </select>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 text-xs uppercase tracking-wider">
                    <th class="px-6 py-3">Número</th>
                    <th class="px-6 py-3">Título</th>
                    <th class="px-6 py-3">Usuario / Solicitante</th>
                    <th class="px-6 py-3">Estado</th>
                    <th class="px-6 py-3">Prioridad</th>
                    <th class="px-6 py-3">Técnico</th>
                    <th class="px-6 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $ticket->ticket_number }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <span class="block truncate max-w-xs" title="{{ $ticket->title }}">{{ $ticket->title }}</span>
                        <span class="text-xs text-gray-400">Hace {{ $ticket->created_at->diffForHumans() }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $ticket->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                {!! 'style="background-color: ' . ($ticket->status->color ?? '#eee') . '20; color: ' . ($ticket->status->color ?? '#000') . ';"' !!}>
                            {{ $ticket->status->name ?? 'Desconocido' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span {!! 'style="color: ' . ($ticket->priority->color ?? '#000') . ';"' !!} class="font-bold">
                            {{ $ticket->priority->name ?? 'Baja' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $ticket->technician->name ?? 'Sin asignar' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900">Detalles</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay tickets registrados en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($tickets->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
