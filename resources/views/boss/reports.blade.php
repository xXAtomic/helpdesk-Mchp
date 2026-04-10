@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen">
    <!-- Header Archivo -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none">Archivo Histórico <span class="text-indigo-500">Gravity</span></h1>
            <p class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <i class="fas fa-archive text-indigo-500"></i>
                Registro Maestro de Operaciones Mensuales
            </p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('boss.dashboard') }}" class="px-6 py-3 bg-slate-900 text-slate-300 text-[0.6rem] font-black uppercase tracking-widest rounded-xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all flex items-center gap-3">
                <i class="fas fa-arrow-left text-indigo-400"></i> Volver a Tiempo Real
            </a>
            <button onclick="window.print()" class="px-6 py-3 bg-indigo-600 text-white text-[0.6rem] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-500/20 hover:bg-indigo-700 transition-all flex items-center gap-3">
                <i class="fas fa-file-pdf"></i> Exportar Auditoría
            </button>
        </div>
    </div>

    <!-- Filtro de Año (Simulado por ahora para diseño) -->
    <div class="flex gap-2 mb-10 overflow-x-auto pb-4 custom-scrollbar">
        @foreach([2026, 2025] as $year)
            <button class="px-8 py-3 {{ $year == 2026 ? 'bg-indigo-500/10 border-indigo-500/50 text-indigo-400' : 'bg-slate-900/50 border-slate-800 text-slate-600' }} border-[1px] rounded-full text-[0.65rem] font-black uppercase tracking-widest transition-all">
                {{ $year }}
            </button>
        @endforeach
    </div>

    <!-- Timeline de Reportes -->
    <div class="space-y-12">
        @foreach($history as $month)
        <div class="relative group">
            <!-- Conector lateral -->
            <div class="absolute -left-3 top-0 bottom-0 w-1 bg-gradient-to-b from-indigo-500/50 to-transparent rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Columna Mes -->
                <div class="lg:col-span-3">
                    <div class="p-8 bg-slate-900/40 backdrop-blur-xl border border-slate-800 rounded-3xl group-hover:border-indigo-500/30 transition-all">
                        <h4 class="text-2xl font-black text-white uppercase italic tracking-tighter">{{ $month['month_name'] }}</h4>
                        <div class="mt-4 flex items-center gap-3">
                            <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 text-[0.5rem] font-black uppercase rounded border border-emerald-500/20 italic">Cierre Confirmado</span>
                        </div>
                        <div class="mt-8 space-y-4">
                            <div class="flex justify-between items-center text-[0.6rem] text-slate-500 uppercase font-black tracking-widest">
                                <span>Calificación CSAT</span>
                                <span class="text-indigo-400">★ {{ $month['csat'] }}</span>
                            </div>
                            <div class="h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500" style="width: <?= ($month['csat'] / 5) * 100 ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen Operativo -->
                <div class="lg:col-span-9 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Tickets Creados -->
                    <div class="bg-slate-900/30 border border-slate-800 p-6 rounded-3xl hover:bg-slate-900/50 transition-all">
                        <p class="text-slate-500 text-[0.55rem] font-black uppercase tracking-widest italic mb-2">Demanda Mensual</p>
                        <h5 class="text-3xl font-black text-white italic tracking-tighter">{{ $month['created'] }}</h5>
                        <p class="text-[0.45rem] text-slate-600 font-bold uppercase mt-2">Tickets Ingresados</p>
                    </div>

                    <!-- Tickets Resueltos -->
                    <div class="bg-slate-900/30 border border-slate-800 p-6 rounded-3xl hover:bg-slate-900/50 transition-all">
                        <p class="text-emerald-500 text-[0.55rem] font-black uppercase tracking-widest italic mb-2">Eficiencia</p>
                        <h5 class="text-3xl font-black text-white italic tracking-tighter">{{ $month['resolved'] }}</h5>
                        <div class="flex items-center gap-2 mt-2">
                             @php $rate = $month['created'] > 0 ? round(($month['resolved'] / $month['created']) * 100) : 100 @endphp
                             <span class="text-[0.55rem] font-black text-slate-400 capitalize italic">{{ $rate }}% de Ratio</span>
                        </div>
                    </div>

                    <!-- Inversión Hardware -->
                    <div class="bg-slate-900/30 border border-slate-800 p-6 rounded-3xl hover:bg-indigo-500/10 hover:border-indigo-500/20 transition-all">
                        <p class="text-blue-400 text-[0.55rem] font-black uppercase tracking-widest italic mb-2">CapEx: Hardware</p>
                        <h5 class="text-3xl font-black text-white italic tracking-tighter">${{ number_format($month['investment'], 0, ',', '.') }}</h5>
                        <p class="text-[0.45rem] text-slate-600 font-bold uppercase mt-2">Nuevos Activos</p>
                    </div>

                    <!-- Gasto Insumos -->
                    <div class="bg-slate-900/30 border border-slate-800 p-6 rounded-3xl hover:bg-amber-500/10 hover:border-amber-500/20 transition-all">
                        <p class="text-amber-400 text-[0.55rem] font-black uppercase tracking-widest italic mb-2">OpEx: Insumos</p>
                        <h5 class="text-3xl font-black text-white italic tracking-tighter">${{ number_format($month['expense'], 0, ',', '.') }}</h5>
                        <p class="text-[0.45rem] text-slate-600 font-bold uppercase mt-2">Material Utilizado</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Footer de Auditoría -->
    <div class="mt-20 pt-10 border-t border-slate-900 text-center">
        <img src="{{ asset('img/logo.png') }}" class="w-8 h-8 mx-auto grayscale opacity-20 mb-4" alt="Gravity Logo">
        <p class="text-[0.5rem] font-black text-slate-600 uppercase tracking-[0.5em] italic">Gravity Enterprise Intelligence v2.0 - Reporte Maestro de Gestión</p>
    </div>
</div>

<style>
    @media print {
        .bg-slate-950 { background: white !important; color: black !important; }
        .bg-slate-900\/40, .bg-slate-900\/30 { background: #f8fafc !important; border: 1px solid #e2e8f0 !important; border-radius: 12px !important; }
        .text-white { color: #0f172a !important; }
        button, a, .custom-scrollbar { display: none !important; }
        .lg\:col-span-3, .lg\:col-span-9 { padding: 10px !important; }
        .grid { display: block !important; }
        .space-y-12 > div { page-break-inside: avoid; margin-bottom: 2rem !important; }
    }
</style>
@endsection
