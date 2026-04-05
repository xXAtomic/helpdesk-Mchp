@extends('layouts.app')

@section('content')
<div class="py-2">
    <!-- CABECERA -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 italic tracking-tighter uppercase">INVENTARIO PREMIUM 🖥️</h2>
            <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest leading-none">Control total de activos, hardware y equipamiento tecnológico de la misión.</p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.inventory.create') }}" class="bg-[#020617] text-white px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest shadow-xl hover:bg-blue-600 transition">
                + NUEVO ELEMENTO
            </a>
        </div>
    </div>

    <!-- MÉTRICAS DE HARDWARE -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2">Total Equipos</p>
            <p class="text-3xl font-black text-gray-900 italic tracking-tighter">{{ $items->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2">En Uso</p>
            <p class="text-3xl font-black text-blue-600 italic tracking-tighter">{{ $items->where('status', 'ACTIVO')->count() }}</p>
        </div>
        <div class="bg-blue-600 p-6 rounded-[2rem] shadow-xl">
            <p class="text-[0.6rem] font-black text-blue-100 uppercase tracking-widest mb-2">Disponibles</p>
            <p class="text-3xl font-black text-white italic tracking-tighter">{{ $items->where('status', 'DISPONIBLE')->count() }}</p>
        </div>
    </div>

    <!-- TABLA DE ACTIVOS -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Código / Tag</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Equipo</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 uppercase italic font-bold text-gray-900">
                @forelse($items as $item)
                <tr class="hover:bg-gray-50/80 transition duration-200">
                    <td class="px-8 py-6">
                        <div class="text-blue-600 tracking-tighter text-sm">#{{ $item->code ?? $item->serial_number }}</div>
                        <div class="text-[0.6rem] text-gray-400 not-italic font-bold mt-1 tracking-widest">{{ $item->brand }} - {{ $item->model ?? '' }}</div>
                    </td>
                    <td class="px-8 py-6">
                        <div class="text-sm tracking-tighter">{{ $item->name }}</div>
                        <div class="text-[0.55rem] text-gray-300">{{ $item->type }}</div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[0.55rem] font-black tracking-widest {{ $item->status == 'ACTIVO' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                            ● {{ $item->status ?? 'ACTIVO' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('admin.inventory.edit', $item->id) }}" class="text-gray-400 hover:text-blue-600 transition text-[0.6rem] font-black tracking-widest">EDITAR</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <p class="text-gray-300 font-black text-sm italic tracking-widest uppercase">No hay equipos registrados todavía ✨</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
