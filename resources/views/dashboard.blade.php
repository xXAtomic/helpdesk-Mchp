@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-2">
    <!-- BIENVENIDA DINÁMICA -->
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <span class="text-[0.65rem] font-black text-blue-500 uppercase tracking-[0.3em] mb-2 block italic">CENTRO DE CONTROL</span>
            <h2 class="text-4xl font-extrabold text-[#020617] tracking-tighter uppercase leading-none">HOLA, {{ explode(' ', auth()->user()->name)[0] }} 👋</h2>
            <p class="text-sm font-bold text-gray-400 mt-2 uppercase tracking-widest">¿En qué podemos ayudarte hoy desde el departamento de TI?</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('user.tickets.create') }}" class="bg-[#020617] text-white px-8 py-4 rounded-[1.5rem] font-black text-[0.7rem] uppercase tracking-widest shadow-2xl hover:bg-blue-600 transition-all transform hover:-translate-y-1 flex items-center gap-3">
                <span class="text-lg">＋</span> NUEVO REQUERIMIENTO
            </a>
        </div>
    </div>

    <!-- MÉTRICAS RÁPIDAS (ESTILO GLASS) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all duration-500">
            <div class="absolute -right-4 -bottom-4 text-6xl opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">🎟️</div>
            <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">TICKETS ACTIVOS</p>
            <p class="text-5xl font-black text-[#020617] tracking-tighter text-center">
                {{ auth()->user()->tickets()->whereIn('status', ['open', 'pending'])->count() }}
            </p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all duration-500">
            <div class="absolute -right-4 -bottom-4 text-6xl opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">✅</div>
            <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">SOLUCIONADOS</p>
            <p class="text-5xl font-black text-[#020617] tracking-tighter text-center">
                {{ auth()->user()->tickets()->where('status', 'resolved')->count() }}
            </p>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-xl transition-all duration-500">
            <div class="absolute -right-4 -bottom-4 text-6xl opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">📦</div>
            <p class="text-[0.65rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic text-center">EQUIPOS ASIGNADOS</p>
            <p class="text-5xl font-black text-[#020617] tracking-tighter text-center">
                {{ auth()->user()->inventories()->count() }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SECCIÓN IZQUIERDA: ÚLTIMAS ACTUALIZACIONES -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-[0.7rem] font-black text-gray-900 uppercase tracking-[0.2em] italic">MIS ÚLTIMOS TICKETS</h3>
                <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-black text-blue-500 uppercase hover:underline italic">VER TODO →</a>
            </div>

            <div class="bg-white rounded-[3rem] border border-gray-100 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[0.6rem] font-black text-gray-400 uppercase tracking-widest italic">Ticket</th>
                            <th class="px-8 py-5 text-[0.6rem] font-black text-gray-400 uppercase tracking-widest italic">Estado</th>
                            <th class="px-8 py-5 text-[0.6rem] font-black text-gray-400 uppercase tracking-widest italic text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse(auth()->user()->tickets()->latest()->take(5)->get() as $ticket)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900 line-clamp-1 uppercase tracking-tight">{{ $ticket->title }}</span>
                                    <span class="text-[0.6rem] text-gray-400 font-bold uppercase mt-1 tracking-widest">{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                @php
                                    $statusClasses = [
                                        'open' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'resolved' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'closed' => 'bg-gray-50 text-gray-600 border-gray-100'
                                    ];
                                    $statusLabels = [
                                        'open' => 'Abierto',
                                        'pending' => 'En Espera',
                                        'resolved' => 'Resuelto',
                                        'closed' => 'Cerrado'
                                    ];
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-[0.6rem] font-black uppercase tracking-widest border {{ $statusClasses[$ticket->status] ?? $statusClasses['open'] }}">
                                    • {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right text-xs">
                                <a href="{{ route('user.tickets.show', $ticket->id) }}" class="font-black text-gray-900 border-b-2 border-transparent hover:border-blue-500 transition-all uppercase tracking-widest">DETALLES</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center">
                                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest italic italic">No tienes tickets registrados aún.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SECCIÓN DERECHA: RECURSOS RÁPIDOS -->
        <div class="space-y-8">
            <!-- ACCESO A MANUALES -->
            <div class="bg-gradient-to-br from-indigo-900 to-blue-900 p-8 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <h4 class="text-white text-xl font-black italic tracking-tighter uppercase mb-2 relative z-10">BASE DE CONOCIMIENTOS 📚</h4>
                <p class="text-white/60 text-[0.65rem] font-bold uppercase tracking-widest mb-6 leading-relaxed relative z-10">Revisa nuestras guías antes de reportar una falla.</p>
                <a href="{{ route('knowledge.index') }}" class="inline-block bg-white text-blue-900 px-6 py-3 rounded-2xl font-black text-[0.65rem] uppercase tracking-widest shadow-xl transform hover:scale-105 transition-all relative z-10">
                    EXPLORAR GUÍAS →
                </a>
            </div>

            <!-- MI EQUIPO (WIDGET MINI) -->
            <div class="bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm">
                <h4 class="text-[0.7rem] font-black text-gray-900 uppercase tracking-[0.2em] italic mb-6">MI EQUIPO ASIGNADO 🖥️</h4>
                <div class="space-y-4">
                    @forelse(auth()->user()->inventories()->take(3)->get() as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50/50 rounded-2xl border border-transparent hover:border-blue-100 transition-all">
                        <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-lg">💡</div>
                        <div>
                            <p class="text-[0.65rem] font-black text-gray-900 uppercase tracking-tight">{{ $item->model }}</p>
                            <p class="text-[0.55rem] font-bold text-gray-400 uppercase italic">{{ $item->serial_number }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[0.6rem] font-bold text-gray-300 uppercase italic text-center py-4">No hay equipos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
