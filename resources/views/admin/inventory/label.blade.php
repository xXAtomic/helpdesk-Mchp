<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta {{ $item->asset_tag }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        @page {
            size: auto;
            margin: 0mm;
        }
        @media print {
            body { background: white !important; margin: 0 !important; cursor: default; }
            .no-print { display: none !important; }
            #label-container {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            #printable-label {
                width: 100mm !important;
                height: 60mm !important;
                border: 1px solid #e2e8f0 !important;
                padding: 8mm !important;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body class="p-10">

<div class="max-w-xl mx-auto" id="label-container">
    <div class="bg-white border-2 border-slate-100 p-8 rounded-3xl shadow-2xl relative overflow-hidden" id="printable-label">
        <!-- Logo y Cabecera -->
        <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-lg italic">G</div>
                <div>
                    <h2 class="text-[0.7rem] font-black text-slate-800 uppercase tracking-tighter italic leading-none">Gravity <span class="text-indigo-600">Inventory</span></h2>
                    <p class="text-[0.45rem] text-slate-400 font-bold uppercase tracking-widest mt-1">Activo Fijo TI</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[0.45rem] text-slate-500 font-black uppercase tracking-widest mb-0.5">Propiedad de:</p>
                <p class="text-[0.55rem] font-bold text-slate-800 uppercase italic">Misión Chilena del Pacífico</p>
            </div>
        </div>

        <!-- Cuerpo -->
        <div class="flex items-start gap-8">
            <!-- QR -->
            <div class="bg-slate-50 p-3 rounded-2xl border border-slate-100 shrink-0">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode(route('admin.inventory.show', $item->id)) }}" 
                     alt="QR" class="w-28 h-28">
            </div>

            <div class="flex-1 space-y-4">
                <div>
                    <label class="text-[0.45rem] font-black text-indigo-500 uppercase tracking-widest mb-0.5 block italic">Asset Tag ID</label>
                    <p class="text-xl font-black text-slate-900 tracking-tighter italic uppercase border-b-2 border-indigo-100 inline-block">{{ $item->asset_tag }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[0.4rem] font-black text-slate-400 uppercase tracking-widest block">Marca/Modelo</label>
                        <p class="text-[0.6rem] font-black text-slate-800 uppercase italic leading-tight">{{ $item->brand }}<br>{{ $item->model }}</p>
                    </div>
                    <div>
                        <label class="text-[0.4rem] font-black text-slate-400 uppercase tracking-widest block">Categoría</label>
                        <p class="text-[0.6rem] font-black text-slate-800 uppercase italic">{{ $item->type }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-[0.4rem] font-black text-slate-400 uppercase tracking-widest block">N° de Serie</label>
                    <p class="text-[0.6rem] font-mono font-bold text-slate-600 uppercase tracking-tight">{{ $item->serial_number }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-slate-50 flex justify-between items-center opacity-50">
            <span class="text-[0.4rem] font-bold text-slate-300 uppercase tracking-[0.2em]">Gravity v2.0</span>
            <span class="text-[0.45rem] font-black text-indigo-400 uppercase">{{ now()->format('Y') }}</span>
        </div>
    </div>

    <!-- Botonera -->
    <div class="mt-10 flex gap-4 no-print">
        <button onclick="window.print()" class="flex-1 bg-slate-950 text-white font-black py-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-indigo-600 transition-all uppercase tracking-widest text-[0.6rem] italic shadow-xl">
             Imprimir Etiqueta
        </button>
        <button onclick="window.close()" class="flex-1 bg-white border border-slate-200 text-slate-400 font-black py-4 rounded-2xl flex items-center justify-center transition-all uppercase tracking-widest text-[0.6rem] italic">
             Cerrar
        </button>
    </div>
</div>

</body>
</html>
