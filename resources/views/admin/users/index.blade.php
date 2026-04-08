@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6">
    <!-- CABECERA -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-900 italic tracking-tighter uppercase mb-2">Gestión de Usuarios 👥</h2>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Administra los accesos y roles del personal de la organización.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-slate-900 text-white px-8 py-4 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest shadow-xl shadow-blue-500/20 transition-all italic">
            + Nuevo Usuario
        </a>
    </div>

    <!-- MENSAJES DE ESTADO -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 rounded-2xl font-bold text-sm italic">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-600 rounded-2xl font-bold text-sm italic">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABLA DE USUARIOS -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden transition-all hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6 text-[0.65rem] font-black text-slate-400 uppercase tracking-widest">Nombre / Email</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-slate-400 uppercase tracking-widest">Rol de Acceso</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-slate-400 uppercase tracking-widest text-center">Entidad</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-slate-400 uppercase tracking-widest">Estado</th>
                        <th class="px-8 py-6 text-[0.65rem] font-black text-slate-400 uppercase tracking-widest text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/80 transition uppercase italic group">
                        <td class="px-8 py-6">
                            <div class="font-black text-slate-900 text-sm tracking-tighter group-hover:text-blue-600 transition-colors">{{ $user->name }}</div>
                            <div class="text-[0.6rem] font-bold text-slate-400 mt-1 lowercase not-italic">{{ $user->email }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-[0.6rem] font-black tracking-widest border border-slate-200">
                                {{ $user->role->name ?? 'SIN ROL' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($user->entity)
                                <span class="text-[0.65rem] font-black {{ $user->entity == 'IASD' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }} px-2 py-0.5 rounded italic uppercase tracking-tighter">
                                    {{ $user->entity }}
                                </span>
                            @else
                                <span class="text-[0.55rem] font-bold text-slate-300 italic uppercase">-</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            @if($user->is_active)
                                <span class="text-green-500 font-black text-[0.6rem] tracking-widest flex items-center gap-1.5 active-pulse-indicator">
                                    ● ACTIVO
                                </span>
                            @else
                                <span class="text-slate-300 font-black text-[0.6rem] tracking-widest flex items-center gap-1.5">
                                    ○ INACTIVO
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end items-center gap-4">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-slate-400 hover:text-blue-600 transition font-black text-[0.6rem] tracking-widest">
                                    EDITAR
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-600 transition font-black text-[0.6rem] tracking-widest uppercase">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .active-pulse-indicator {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endsection
