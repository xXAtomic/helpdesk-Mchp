@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <!-- HEADER DE FICHA TÉCNICA -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6 bg-slate-950 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
        <div class="relative z-10 flex items-center gap-8">
            <div class="w-24 h-24 bg-white/5 rounded-[2rem] flex items-center justify-center text-white text-5xl border border-white/10 shadow-inner">
                <i class="fas fa-microchip"></i>
            </div>
            <div>
                <span class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] mb-2 block italic">Ficha Técnica Centralizada</span>
                <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none">{{ $item->asset_tag }}</h1>
                <p class="text-slate-400 font-bold mt-2 italic">{{ $item->brand }} {{ $item->model }}</p>
            </div>
        </div>
        <div class="relative z-10 flex flex-col items-end gap-3">
             <span class="px-4 py-2 bg-emerald-500/10 text-emerald-400 rounded-xl text-[0.6rem] font-black uppercase tracking-widest border border-emerald-500/20 italic">
                 {{ $item->status }} // ACTUAL
             </span>
             <a href="{{ route('admin.inventory.edit', $item->id) }}" class="text-[0.6rem] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-all">
                 Editar Recurso <i class="fas fa-edit ml-1"></i>
             </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- DETALLES DE HARDWARE -->
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 text-xs"><i class="fas fa-info"></i></span>
                    Especificaciones del Sistema
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-6 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Número de Serie</p>
                        <p class="text-sm font-black text-slate-900 uppercase font-mono">{{ $item->serial_number }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Categoría</p>
                        <p class="text-sm font-black text-slate-900 uppercase italic">{{ $item->type }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Ubicación Física</p>
                        <p class="text-sm font-black text-slate-900 uppercase italic">{{ $item->location }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all">
                        <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Usuario Asignado</p>
                        <p class="text-sm font-black text-indigo-600 uppercase italic">{{ $item->user->name ?? 'SIN ASIGNAR' }}</p>
                    </div>
                </div>
            </div>

            <!-- LOGS DE MANTENIMIENTO -->
            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-8 flex items-center gap-3">
                    <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600 text-xs"><i class="fas fa-history"></i></span>
                    Historial de Intervenciones
                </h3>
                
                <div class="space-y-6">
                    @forelse($item->logs as $log)
                        <div class="flex gap-6 relative">
                            @if(!$loop->last)
                                <div class="absolute left-4 top-10 bottom-0 w-px bg-slate-100"></div>
                            @endif
                            <div class="w-8 h-8 rounded-full bg-slate-900 border-4 border-white shadow-lg z-10 shrink-0 flex items-center justify-center text-[10px] text-indigo-400 font-black italic">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 p-6 bg-slate-50 rounded-3xl group hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all border border-transparent hover:border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[0.6rem] font-black text-indigo-600 uppercase tracking-widest italic">{{ $log->action }}</span>
                                    <span class="text-[0.55rem] font-medium text-slate-400 uppercase">{{ $log->created_at->format('d M, Y H:i') }}</span>
                                </div>
                                <p class="text-sm font-medium text-slate-700 leading-relaxed italic">"{{ $log->details }}"</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="w-5 h-5 bg-slate-200 rounded-full flex items-center justify-center text-[8px] text-slate-500 font-bold">U</div>
                                    <span class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest italic">{{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 opacity-30">
                            <i class="fas fa-folder-open text-4xl mb-4 block"></i>
                            <p class="text-xs font-black uppercase tracking-widest italic">Sin registros de auditoría</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- BARRA LATERAL: CONTROL Y QR -->
        <div class="space-y-10">
            <!-- QR CODE (GENERADO AL VUELO) ✨ -->
            <div class="bg-indigo-900 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden flex flex-col items-center group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-800 to-indigo-950 opacity-100"></div>
                <div class="relative z-10 text-center w-full">
                    <h3 class="text-sm font-black text-white/50 uppercase tracking-[0.2em] mb-8 italic">Acceso Rápido Móvil</h3>
                    
                    <div class="bg-white p-6 rounded-[2rem] shadow-2xl mb-8 group-hover:scale-105 transition-transform duration-500 mx-auto w-fit">
                        <div id="qrcode"></div>
                    </div>
                    
                    <p class="text-[0.6rem] font-bold text-white/40 uppercase tracking-widest leading-relaxed mb-8 italic">
                        Escanea para acceder a esta ficha técnica desde cualquier terminal móvil.
                    </p>
                    
                    <button onclick="window.print()" class="w-full bg-white text-indigo-900 py-5 rounded-[1.5rem] font-black text-[0.7rem] uppercase tracking-widest hover:bg-slate-950 hover:text-white transition-all shadow-xl italic">
                        Imprimir Etiqueta QR
                    </button>
                </div>
            </div>

            <!-- STATUS CARD -->
            <div class="bg-white p-8 rounded-[3rem] border border-gray-100 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-slate-50 rounded-bl-[2rem] flex items-center justify-center text-slate-300">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-[0.4em] mb-4 italic ml-2">Monitor de Vida Útil</p>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-transparent hover:border-indigo-100 transition-all">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm border border-slate-100"><i class="far fa-calendar-alt"></i></div>
                        <div>
                             <p class="text-[0.5rem] font-black text-slate-400 uppercase italic">Registro Inicial</p>
                             <p class="text-[0.65rem] font-black text-slate-900 uppercase italic tracking-tighter">{{ $item->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm border border-slate-100"><i class="fas fa-tools"></i></div>
                        <div>
                             <p class="text-[0.5rem] font-black text-indigo-400 uppercase italic">Último Mantenimiento</p>
                             <p class="text-[0.65rem] font-black text-slate-900 uppercase italic tracking-tighter">{{ $item->last_maintenance_at ? $item->last_maintenance_at->format('d/m/Y') : 'SIN REGISTROS' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 {{ ($item->next_maintenance_at && $item->next_maintenance_at->isPast()) ? 'bg-rose-50 border-rose-100' : 'bg-emerald-50 border-emerald-100' }} rounded-2xl border">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center {{ ($item->next_maintenance_at && $item->next_maintenance_at->isPast()) ? 'text-rose-600' : 'text-emerald-600' }} shadow-sm border border-slate-100"><i class="fas fa-clock"></i></div>
                        <div>
                             <p class="text-[0.5rem] font-black {{ ($item->next_maintenance_at && $item->next_maintenance_at->isPast()) ? 'text-rose-400' : 'text-emerald-400' }} uppercase italic">Próxima Revisión</p>
                             <p class="text-[0.65rem] font-black text-slate-900 uppercase italic tracking-tighter">{{ $item->next_maintenance_at ? $item->next_maintenance_at->format('d/m/Y') : 'NO PROGRAMADA' }}</p>
                        </div>
                    </div>
                    
                    <button onclick="document.getElementById('maintenanceModal').classList.remove('hidden')" class="w-full mt-4 flex items-center justify-center gap-2 py-4 bg-slate-950 text-white rounded-2xl text-[0.6rem] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl italic">
                         <i class="fas fa-plus-circle"></i> Registrar Acción
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DE MANTENIMIENTO ✨ -->
<div id="maintenanceModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-950 bg-opacity-90 transition-opacity" aria-hidden="true" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/20">
            <div class="bg-slate-950 px-8 py-10 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-white text-3xl border border-white/10">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white italic uppercase tracking-tighter leading-none">Intervención Técnica</h3>
                        <p class="text-indigo-400 text-[0.6rem] font-bold uppercase tracking-[0.3em] mt-2 italic">Registro de Mantenimiento Preventivo</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.inventory.maintenance.store', $item->id) }}" method="POST" class="px-8 py-10 space-y-6">
                @csrf
                <div>
                    <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Detalles de la Operación</label>
                    <textarea name="details" rows="3" required class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all italic" placeholder="Describe el trabajo realizado..."></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Próximo Ciclo</label>
                        <input type="date" name="next_maintenance_at" required class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-sm font-black focus:ring-2 focus:ring-indigo-500 transition-all uppercase italic">
                    </div>
                    <div>
                        <label class="block text-[0.6rem] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Estado Final</label>
                        <select name="status" class="w-full bg-slate-50 border-transparent rounded-2xl p-4 text-sm font-black focus:ring-2 focus:ring-indigo-500 transition-all uppercase italic">
                            <option value="Operativo" {{ $item->status == 'Operativo' ? 'selected' : '' }}>Operativo</option>
                            <option value="Mantenimiento" {{ $item->status == 'Mantenimiento' ? 'selected' : '' }}>En Proceso</option>
                            <option value="Dañado" {{ $item->status == 'Dañado' ? 'selected' : '' }}>Dañado</option>
                            <option value="Baja" {{ $item->status == 'Baja' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>
                </div>
                
                <div class="pt-6 flex gap-4">
                    <button type="button" onclick="document.getElementById('maintenanceModal').classList.add('hidden')" class="flex-1 px-8 py-5 border-2 border-slate-100 rounded-2xl text-[0.7rem] font-black uppercase tracking-widest text-slate-400 hover:bg-slate-50 transition-all italic">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-[2] bg-indigo-600 text-white px-8 py-5 rounded-2xl text-[0.7rem] font-black uppercase tracking-widest hover:bg-slate-950 transition-all shadow-xl shadow-indigo-200 italic">
                        Confirmar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LIBRERÍA DE QR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const qrContainer = document.getElementById('qrcode');
        const currentUrl = window.location.href;
        
        new QRCode(qrContainer, {
            text: currentUrl,
            width: 180,
            height: 180,
            colorDark: "#0f172a",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    });
</script>

<style>
    @media print {
        .sidebar, .nav-icon, #gravity-bot, .bg-indigo-900 button, header { display: none !important; }
        .main-wrapper { display: block !important; }
        body { background: white !important; }
        .max-w-5xl { max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .bg-indigo-900 { background: white !important; color: black !important; border: 1px solid #eee !important; box-shadow: none !important; }
        .text-white\/50, .text-white\/40 { color: #666 !important; }
        #qrcode { margin: 0 auto; }
    }
</style>
@endsection
