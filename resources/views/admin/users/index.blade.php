@extends('layouts.app')

@section('content')
<div class="py-2">
    <!-- CABECERA -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-3xl font-black text-gray-900 italic tracking-tighter uppercase">GESTIóN DE USUARIOS 👥</h2>
            <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest leading-none">Administra los accesos y roles del personal técnico y usuarios finales.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest shadow-xl shadow-blue-500/20 hover:bg-blue-700 transition">
            + NUEVO USUARIO
        </a>
    </div>

    <!-- TABLA DE USUARIOS -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Nombre / Email</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Rol</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                    <th class="px-8 py-6 text-[0.65rem] font-black text-gray-400 uppercase tracking-widest text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/80 transition uppercase italic">
                    <td class="px-8 py-6">
                        <div class="font-black text-gray-900 text-sm tracking-tighter">{{ $user->name }}</div>
                        <div class="text-[0.6rem] font-bold text-gray-400 mt-1 lowercase not-italic">{{ $user->email }}</div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-600 text-[0.6rem] font-black tracking-widest border border-gray-200">
                            {{ $user->role->name ?? 'USUARIO' }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-green-500 font-black text-[0.6rem] tracking-widest flex items-center gap-1.5 animate-pulse">
                            ● ACTIVO
                        </span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <button class="text-gray-400 hover:text-blue-600 transition font-black text-[0.6rem] tracking-widest">
                            EDITAR
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
