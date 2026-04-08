@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-12 px-6">
    <div class="bg-white border-2 border-slate-200 p-8 rounded-3xl shadow-2xl relative overflow-hidden" id="printable-label">
        <!-- Logo y Cabecera -->
        <div class="flex items-center justify-between mb-8 border-b-2 border-slate-100 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xl italic">
                    G
                </div>
                <div>
                    <h2 class="text-sm font-black text-slate-800 uppercase tracking-tighter italic">Gravity <span class="text-indigo-600">Inventory</span></h2>
                    <p class="text-[0.6rem] text-slate-400 font-bold uppercase tracking-widest">Etiqueta de Activo Fijo</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[0.6rem] text-slate-500 font-black uppercase tracking-widest">Propiedad de:</p>
                <p class="text-[0.7rem] font-bold text-slate-800 uppercase italic">Misión Chilena del Pacífico</p>
            </div>
        </div>

        <!-- Cuerpo de la Etiqueta -->
        <div class="flex flex-col md:flex-row gap-10 items-center">
            <!-- QR Code -->
            <div class="bg-slate-50 p-4 rounded-3xl border border-slate-100 shadow-inner shrink-0">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode(route('admin.inventory.show', $item->id)) }}" 
                     alt="Asset QR" class="w-40 h-40">
                <p class="text-[0.55rem] text-center mt-3 font-bold text-slate-400 uppercase tracking-[0.2em]">Escanea para info</p>
            </div>

            <!-- Datos Técnicos -->
            <div class="flex-1 space-y-6">
                <div>
                    <label class="text-[0.65rem] font-black text-indigo-500 uppercase tracking-widest mb-1 block italic underline decoration-2">Asset Tag ID</label>
                    <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase underline decoration-indigo-200">{{ $item->asset_tag }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest block">Marca/Modelo</label>
                        <p class="text-[0.85rem] font-black text-slate-800 uppercase italic">{{ $item->brand }} {{ $item->model }}</p>
                    </div>
                    <div>
                        <label class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest block">Categoría</label>
                        <p class="text-[0.85rem] font-black text-slate-800 uppercase italic">{{ $item->type }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest block">Número de Serie</label>
                    <p class="text-[0.75rem] font-mono font-bold text-slate-600 uppercase">{{ $item->serial_number }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Decorativo -->
        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-between items-center italic">
            <span class="text-[0.5rem] font-bold text-slate-300 uppercase italic tracking-[0.3em]">Registro inmutable TI - Gravity v2.0</span>
            <span class="text-[0.55rem] font-black text-indigo-600 uppercase">{{ now()->format('Y') }}</span>
        </div>
    </div>

    <!-- Botonera de Acción -->
    <div class="mt-10 flex gap-4 no-print">
        <button onclick="window.print()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-indigo-200 flex items-center justify-center gap-3 transition-all uppercase tracking-widest text-xs italic">
            <i class="fas fa-print"></i> Imprimir Etiqueta
        </button>
        <a href="{{ route('admin.inventory.show', $item->id) }}" class="flex-1 bg-white border-2 border-slate-100 text-slate-500 font-black py-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-slate-50 transition-all uppercase tracking-widest text-xs italic">
             Volver a Ficha
        </a>
    </div>

    <style>
        @media print {
            body * { visibility: hidden !important; background: white !important; }
            #printable-label, #printable-label * { visibility: visible !important; }
            #printable-label { 
                position: fixed !important; 
                left: 50% !important; 
                top: 50% !important; 
                transform: translate(-50%, -50%) !important;
                width: 100mm !important; 
                height: 60mm !important;
                border: 1px solid #000 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 10mm !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</div>
@endsection
