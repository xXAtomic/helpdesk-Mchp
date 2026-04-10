@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA DE SEGURIDAD -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Gestión de Usuarios y Staff TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(59,130,246,0.5)]"></span>
                Gravity Identity Engine • Access Control
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.users.create') }}" 
               class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-2xl font-black italic uppercase tracking-widest text-[0.65rem] transition-all shadow-lg shadow-blue-500/20 flex items-center gap-3 group">
                <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                Nuevo Registro
            </a>
        </div>
    </div>

    <!-- TABLA DE IDENTIDADES PREMIUM -->
    <div class="bg-slate-900/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-950/40 border-b border-white/5">
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic">Identidad / Nodo Electrónico</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Protocolo de Acceso</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Entidad</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-center">Estado Vital</th>
                        <th class="px-8 py-6 text-[0.6rem] font-black text-slate-500 uppercase tracking-widest italic text-right">Comandos</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 italic">
                    @foreach($users as $user)
                    <tr class="hover:bg-white/[0.03] transition-all group duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-950 flex items-center justify-center text-blue-400 border border-white/5 group-hover:border-blue-500/30 transition-all shadow-xl font-black text-xs italic">
                                    {{ substr($user->name, 0, 1) }}{{ substr(strrchr($user->name, " "), 1, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-white uppercase tracking-tight group-hover:text-blue-400 transition-colors">{{ $user->name }}</div>
                                    <div class="text-[0.6rem] font-black text-slate-600 lowercase not-italic tracking-widest mt-0.5">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $roleColor = match($user->role->name ?? 'USER') {
                                    'Admin' => 'text-rose-400 bg-rose-500/10 border-rose-500/20',
                                    'Boss' => 'text-amber-400 bg-amber-500/10 border-amber-500/20',
                                    'Tech' => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                                    default => 'text-slate-400 bg-slate-800 border-white/5'
                                };
                            @endphp
                            <span class="px-4 py-1.5 rounded-xl text-[0.55rem] font-black tracking-widest border uppercase italic shadow-sm {{ $roleColor }}">
                                {{ $user->role->name ?? 'SIN PROTOCOLO' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($user->entity)
                                <span class="text-[0.6rem] font-black {{ $user->entity == 'IASD' ? 'bg-amber-500 text-slate-950' : 'bg-blue-600 text-white' }} px-3 py-1 rounded-lg uppercase tracking-widest shadow-lg">
                                    {{ $user->entity }}
                                </span>
                            @else
                                <span class="text-slate-800">-</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-2 text-emerald-500 font-black text-[0.55rem] tracking-widest uppercase italic">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full shadow-[0_0_8px_#10b981] animate-pulse"></span>
                                    ONLINE_CORE
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 text-slate-700 font-black text-[0.55rem] tracking-widest uppercase italic">
                                    <span class="w-1.5 h-1.5 bg-slate-800 rounded-full"></span>
                                    OFFLINE
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end items-center gap-4">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-9 h-9 bg-slate-950 rounded-xl flex items-center justify-center text-slate-500 border border-white/5 hover:bg-blue-600 hover:text-white hover:border-blue-500 shadow-xl transition-all" title="Modificar Nodo">
                                    <i class="fas fa-user-edit text-[10px]"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Eyectar este usuario del sistema?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-9 h-9 bg-slate-950 rounded-xl flex items-center justify-center text-slate-700 border border-white/5 hover:bg-rose-600 hover:text-white hover:border-rose-500 shadow-xl transition-all" title="Eliminar Registro">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
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
    
    <!-- FOOTER INFO -->
    <div class="mt-8 flex justify-center">
        <p class="text-[0.5rem] font-black text-slate-700 uppercase tracking-[0.6em] italic">
            Atomic Identity Protocol • Total Registros: {{ $users->count() }}
        </p>
    </div>
</div>
@endsection
