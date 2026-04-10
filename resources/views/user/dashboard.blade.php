@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA MINIMALISTA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">{{ config('app.institution') }} • Gestión de Recursos TI</h1>
            <p class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.6em] mt-4 italic">Gravity Dashboard</p>
        </div>
        <div class="mt-6 md:mt-0 flex gap-4">
            <span class="inline-flex items-center px-4 py-2 bg-slate-950 text-white rounded-lg text-[0.6rem] font-black uppercase tracking-[0.2em] italic shadow-lg shadow-indigo-100">
                Gravity v2.0
            </span>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS (ESTILO MY-TICKETS) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic">TICKETS ACTIVOS</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase">{{ auth()->user()->tickets()->where('status_id', '!=', 3)->count() }} SOLICITUDES</p>
        </div>
        <div class="bg-indigo-50 p-8 rounded-xl border border-indigo-100">
            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">RESUELTOS HOY</p>
            <p class="text-3xl font-black text-indigo-900 tracking-tighter italic uppercase font-black uppercase tracking-widest">{{ auth()->user()->tickets()->where('status_id', 3)->where('updated_at', '>=', now()->startOfDay())->count() }} CERRADOS</p>
        </div>
        <button onclick="document.getElementById('mi-equipamiento').scrollIntoView({behavior: 'smooth'})" 
                class="bg-white p-8 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-xl hover:border-indigo-200 text-left group">
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-1 italic group-hover:text-indigo-500 transition-colors">EQUIPOS ASIGNADOS</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase font-black uppercase tracking-widest">
                {{ $assignedAssets->count() }} {{ $assignedAssets->count() == 1 ? 'DISPOSITIVO' : 'DISPOSITIVOS' }}
                <i class="fas fa-arrow-down ml-2 text-indigo-400 opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-y-1"></i>
            </p>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12">
        
        <!-- ACCIONES PRINCIPALES -->
        <div class="lg:col-span-2 space-y-10">
            <!-- CARD: NUEVO TICKET -->
            <div class="group bg-white p-12 rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-[3] transition-transform duration-700 opacity-50"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg mb-8">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight italic mb-3">Nueva Solicitud</h3>
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-widest leading-relaxed mb-12">Reporta problemas técnicos o solicita asistencia inmediata al equipo TI de la organización.</p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest hover:bg-indigo-600 transition-colors shadow-lg">
                        Crear Ticket Ahora →
                    </a>
                </div>
            </div>

            <!-- TABLA DE ACTIVIDAD RECIENTE -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-[0.65rem] font-black text-gray-500 uppercase tracking-widest">Últimos Registros</h3>
                    <a href="{{ route('user.tickets.index') }}" class="text-[0.6rem] font-bold text-indigo-600 hover:text-indigo-900 uppercase italic">Ver todo el historial</a>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @forelse($latestTickets as $ticket)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-900">{{ $ticket->title }}</p>
                                    <p class="text-[0.65rem] font-medium text-slate-400 uppercase tracking-widest">{{ $ticket->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="inline-flex px-3 py-1 rounded-full text-[0.55rem] font-black uppercase tracking-tight"
                                          style="background-color: {{ optional($ticket->status)->color }}15; color: {{ optional($ticket->status)->color }};">
                                        {{ optional($ticket->status)->name ?? 'PROCESANDO' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-8 py-10 text-center text-[0.65rem] font-bold text-slate-300 uppercase tracking-widest">No hay actividad reciente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- COLUMNA LATERAL: DOCUMENTACIÓN Y COMPLIANCE -->
        <div class="space-y-8">
            <div class="bg-slate-950 p-10 rounded-[2.5rem] shadow-2xl overflow-hidden relative group">
                <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-indigo-500/10 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-white text-xl border border-white/10 mb-8">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight italic mb-3">Guías Técnicas</h3>
                    <p class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest leading-relaxed mb-10">Documentación oficial para autogestión de equipos y software operativo.</p>
                    <a href="{{ route('knowledge.index') }}" class="inline-block w-full bg-white text-slate-950 py-4 rounded-lg font-black text-[0.65rem] uppercase tracking-widest text-center hover:bg-indigo-400 transition-colors shadow-lg">
                        Explorar Manuales
                    </a>
                </div>
            </div>

            <!-- MI RESUMEN DE COMPLIANCE ✨ -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)]"></div>
                    <h5 class="text-[0.65rem] font-black text-slate-900 uppercase italic tracking-widest">Estado Legal</h5>
                </div>
                <div class="space-y-5">
                    <a href="{{ route('user.compliance.index') }}" class="block p-6 bg-slate-50 rounded-[1.5rem] border border-transparent hover:border-emerald-100 hover:bg-emerald-50/30 transition-all flex items-center gap-5 group/item">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-2xl shadow-sm border border-slate-100 group-hover/item:scale-110 transition-transform">📄</div>
                        <div>
                            <p class="text-[0.65rem] font-black text-slate-900 uppercase italic leading-none">Actas de Entrega</p>
                            @if($pendingComplianceCount > 0)
                                <p class="text-[0.55rem] font-bold text-amber-600 uppercase tracking-widest italic mt-1.5">
                                    {{ $pendingComplianceCount }} Pendiente{{ $pendingComplianceCount > 1 ? 's' : '' }}
                                </p>
                            @else
                                <p class="text-[0.55rem] font-bold text-emerald-600 uppercase tracking-widest italic mt-1.5">Todo al día</p>
                            @endif
                        </div>
                    </a>
                    
                    <div class="p-6 bg-slate-50 rounded-[1.5rem] border border-transparent flex items-center gap-5">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-2xl shadow-sm border border-slate-100">⚖️</div>
                        <div>
                            <p class="text-[0.65rem] font-black text-slate-900 uppercase italic leading-none">Políticas de Uso</p>
                            <p class="text-[0.55rem] font-bold text-slate-400 uppercase tracking-widest italic mt-1.5">Verificado via login</p>
                        </div>
                    </div>
                </div>
                
                @if($pendingComplianceCount > 0)
                    <div class="mt-8">
                        <a href="{{ route('user.compliance.index') }}" class="block w-full text-center bg-amber-500 text-white py-4 rounded-xl font-black text-[0.6rem] uppercase tracking-widest hover:bg-amber-600 transition-colors shadow-lg">
                            Firmar Pendientes Ahora
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- SECCIÓN: MI EQUIPAMIENTO ASIGNADO (FULL WIDTH SECTION) ✨ -->
    <div id="mi-equipamiento" class="space-y-8 scroll-mt-10 pb-20">
        <div class="flex items-center justify-between border-b border-gray-100 pb-6">
            <div class="flex items-center gap-4">
                <div class="w-2 h-8 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.4)]"></div>
                <div>
                    <h3 class="text-lg font-black text-slate-900 uppercase italic tracking-tighter">Inventario de Responsabilidad</h3>
                    <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-[0.2em] italic">Activos TI bajo su responsabilidad directa</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[0.6rem] font-black text-slate-500 uppercase italic">Registro Oficial {{ config('app.institution_abbr') }}</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($assignedAssets as $item)
                <div onclick="openAssetModal({{ json_encode($item) }})" 
                     class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-100/50 hover:-translate-y-2 transition-all duration-500 cursor-pointer relative overflow-hidden">
                    
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-50/30 rounded-full blur-2xl group-hover:bg-indigo-100/50 transition-colors duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-8">
                            <div class="w-16 h-16 bg-slate-950 rounded-2xl flex items-center justify-center text-white text-3xl shadow-xl group-hover:bg-indigo-600 transition-colors duration-500">
                                @if($item->type == 'Laptop') <i class="fas fa-laptop"></i>
                                @elseif($item->type == 'Desktop') <i class="fas fa-desktop"></i>
                                @elseif($item->type == 'Monitor') <i class="fas fa-tv"></i>
                                @elseif($item->type == 'Impresora') <i class="fas fa-print"></i>
                                @elseif($item->type == 'Smartphone') <i class="fas fa-mobile-alt"></i>
                                @else <i class="fas fa-box"></i> @endif
                            </div>
                            <div class="text-right">
                                <span class="text-[0.55rem] font-black text-indigo-500 bg-indigo-50 px-2 py-1 rounded-md uppercase tracking-widest italic border border-indigo-100 mb-2 inline-block">
                                    {{ $item->asset_tag }}
                                </span>
                                <div class="flex items-center justify-end gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->status == 'Operativo' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    <span class="text-[0.55rem] font-black text-slate-400 uppercase tracking-tighter italic">{{ $item->status }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <h4 class="text-xs font-black text-slate-400 uppercase italic tracking-tighter group-hover:text-indigo-600 transition-colors">{{ $item->brand }}</h4>
                            <p class="text-lg font-black text-slate-900 uppercase italic leading-none truncate">{{ $item->model }}</p>
                            <p class="text-[0.6rem] font-bold text-indigo-400 uppercase italic tracking-widest mt-3 pt-3 border-t border-slate-50">{{ $item->entity ?? config('app.institution') }}</p>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-[0.5rem] font-black text-slate-300 uppercase tracking-widest font-mono italic">{{ $item->serial_number }}</span>
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-300 group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-sm">
                                <i class="fas fa-search-plus text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 xl:col-span-4 py-20 bg-slate-50/50 rounded-[3rem] border-2 border-dashed border-slate-200 text-center relative group overflow-hidden">
                     <div class="absolute inset-0 bg-indigo-500/5 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                     <div class="relative z-10">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-slate-200 text-3xl mx-auto shadow-inner mb-6">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3 class="text-slate-900 font-black text-lg uppercase italic tracking-tighter">Inventario Personal Vacío</h3>
                        <p class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] italic max-w-sm mx-auto mt-2">No se han detectado activos vinculados a su cuenta. Contacte a TI si esto es un error.</p>
                     </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- MODAL DE DETALLE DE ACTIVO (FLOATING INFO) ✨ -->
<div id="assetModal" class="fixed inset-0 z-50 hidden overflow-y-auto px-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 bg-slate-950/90 transition-opacity" onclick="closeAssetModal()"></div>
        
        <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl transform transition-all border border-white/20">
            <!-- Header del Modal -->
            <div class="bg-slate-950 p-10 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex items-center gap-6">
                    <div id="modal-icon" class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center text-white text-4xl border border-white/10 shadow-inner">
                        <!-- Icono Dinámico -->
                    </div>
                    <div>
                        <span id="modal-tag" class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] mb-2 block italic">CARGANDO...</span>
                        <h3 id="modal-title" class="text-2xl font-black text-white italic uppercase tracking-tighter leading-none">EQUIPO TI</h3>
                        <p id="modal-subtitle" class="text-slate-400 text-[0.65rem] font-bold uppercase tracking-widest mt-2 border-l border-white/20 pl-4 italic">DETALLE TÉCNICO DE RESPONSABILIDAD</p>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="p-10 space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-slate-50 p-5 rounded-2xl border border-transparent">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Marca / Fabricante</p>
                        <p id="modal-brand" class="text-xs font-black text-slate-900 uppercase italic tracking-tight"></p>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-2xl border border-transparent">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Modelo Específidco</p>
                        <p id="modal-model" class="text-xs font-black text-slate-900 uppercase italic tracking-tight"></p>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-2xl border border-transparent">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Número de Serie</p>
                        <p id="modal-serial" class="text-xs font-mono font-black text-slate-900 uppercase tracking-tighter"></p>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-2xl border border-transparent">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Ubicación Actual</p>
                        <p id="modal-location" class="text-xs font-black text-slate-900 uppercase italic tracking-tight"></p>
                    </div>
                </div>

                <div id="modal-entity-row" class="bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100 flex items-center justify-between">
                    <div>
                        <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic mb-1">Entidad Perteneciente</p>
                        <p id="modal-entity" class="text-sm font-black text-indigo-600 uppercase italic tracking-tight"></p>
                    </div>
                    <div id="modal-status-badge" class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[0.6rem] font-black rounded-lg uppercase italic border border-emerald-200">
                        OPERATIVO
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <p class="text-[0.55rem] font-black text-slate-300 uppercase tracking-[0.2em] italic text-center leading-relaxed">
                        Este equipo es propiedad de la institución y está sujeto a las normativas de seguridad informática vigentes.
                    </p>
                </div>

                <button onclick="closeAssetModal()" class="w-full bg-slate-950 text-white py-5 rounded-2xl font-black text-[0.7rem] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl italic">
                    Cerrar Ventana
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openAssetModal(asset) {
        document.getElementById('modal-tag').innerText = asset.asset_tag;
        document.getElementById('modal-title').innerText = asset.brand + ' ' + asset.model;
        document.getElementById('modal-brand').innerText = asset.brand;
        document.getElementById('modal-model').innerText = asset.model;
        document.getElementById('modal-serial').innerText = asset.serial_number;
        document.getElementById('modal-location').innerText = asset.location || 'Oficina Central';
        document.getElementById('modal-entity').innerText = asset.entity || "{{ strtoupper(config('app.institution')) }}";
        
        const icons = {
            'Laptop': '💻',
            'Desktop': '🖥️',
            'Monitor': '📺',
            'Impresora': '🖨️',
            'Smartphone': '📱',
            'Servidor': '🗄️'
        };
        document.getElementById('modal-icon').innerText = icons[asset.type] || '📦';
        
        const modal = document.getElementById('assetModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAssetModal() {
        const modal = document.getElementById('assetModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection
