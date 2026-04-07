@extends('layouts.app')

@section('content')
<div class="px-8 py-10 max-w-7xl mx-auto">
    
    <!-- HEADER EJECUTIVO -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-slate-100 pb-10 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 bg-slate-950 text-white text-[0.65rem] font-black uppercase tracking-[0.3em] rounded-md italic shadow-2xl shadow-indigo-200">Intelligence Unit</span>
            </div>
            <h1 class="text-5xl font-black text-slate-950 tracking-tighter italic uppercase leading-none">
                Reportes <span class="text-indigo-600">Estratégicos</span>
            </h1>
            <p class="text-slate-500 font-bold tracking-tight mt-4 text-[0.7rem] uppercase italic leading-relaxed max-w-lg">
                Métricas de rendimiento en tiempo real y análisis de capacidad operativa para la toma de decisiones gerenciales.
            </p>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.reports.csv') }}" class="bg-white border-2 border-slate-100 text-slate-950 px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[0.7rem] hover:bg-slate-50 transition-all flex items-center gap-3 shadow-sm group">
                <i class="fas fa-file-excel text-emerald-500 group-hover:scale-110 transition-transform"></i>
                Exportar CSV
            </a>
            <button onclick="window.print()" class="bg-slate-950 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-black italic uppercase tracking-widest text-[0.7rem] transition-all shadow-xl hover:shadow-indigo-200 flex items-center gap-3 group">
                <i class="fas fa-file-pdf text-indigo-400 group-hover:rotate-12 transition-transform"></i>
                Generar PDF
            </button>
        </div>
    </div>

    <!-- KPI'S DE ALTA VISIBILIDAD -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-indigo-600 p-10 rounded-[3rem] shadow-2xl shadow-indigo-100 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="relative z-10">
                <p class="text-[0.65rem] font-black text-white/60 uppercase tracking-[0.3em] mb-4 italic">Activos Totales</p>
                <h3 class="text-6xl font-black text-white tracking-tighter italic mb-4">{{ $totalAssets }}</h3>
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                    <p class="text-[0.6rem] font-black text-white/50 uppercase italic tracking-widest leading-none">Inventario Actualizado</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 italic">Tickets Totales</p>
                <h3 class="text-6xl font-black text-slate-950 tracking-tighter italic mb-4">{{ $totalTickets }}</h3>
                <div class="flex items-center gap-3">
                   <p class="text-[0.65rem] font-bold text-emerald-500 uppercase italic">↑ 12% Mensual</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-950 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
             <div class="relative z-10 text-center">
                <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4 italic">Efectividad 30D</p>
                <div class="text-5xl font-black text-white tracking-tighter italic mb-4">
                    {{ $totalTickets > 0 ? round(($resolvedLast30Days / $totalTickets) * 100) : 0 }}%
                </div>
                <p class="text-[0.6rem] text-slate-500 font-black uppercase italic tracking-widest">{{ $resolvedLast30Days }} Resueltos</p>
             </div>
        </div>
    </div>

    <!-- ANÁLISIS GRÁFICO AVANZADO -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- DISTRIBUCIÓN DE HARDWARE -->
        <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm">
            <h4 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-10 flex items-center gap-3">
                 <span class="w-1h h-6 bg-indigo-600 rounded-full"></span>
                 Distribución de Activos
            </h4>
            <div id="assetsByTypeChart"></div>
        </div>

        <!-- ESTADO OPERATIVO -->
        <div class="bg-white p-10 rounded-[4rem] border border-slate-100 shadow-sm">
            <h4 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter mb-10 flex items-center gap-3">
                 <span class="w-1h h-6 bg-emerald-500 rounded-full"></span>
                 Capacidad Operativa
            </h4>
            <div id="assetsByStatusChart"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grafica por Tipo
        const assetsByType = @json($assetsByType);
        new ApexCharts(document.querySelector("#assetsByTypeChart"), {
            series: assetsByType.map(i => i.count),
            chart: { type: 'donut', height: 350 },
            labels: assetsByType.map(i => i.type),
            colors: ['#0f172a', '#4f46e5', '#10b981', '#f59e0b', '#ef4444'],
            dataLabels: { enabled: false },
            legend: { position: 'bottom', fontFamily: 'Inter', fontWeight: 700 }
        }).render();

        // Grafica por Estado
        const assetsByStatus = @json($assetsByStatus);
        new ApexCharts(document.querySelector("#assetsByStatusChart"), {
            series: [{
                name: 'Equipos',
                data: assetsByStatus.map(i => i.count)
            }],
            chart: { type: 'bar', height: 350, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 15, columnWidth: '50%', distributed: true } },
            xaxis: { categories: assetsByStatus.map(i => i.status) },
            colors: ['#10b981', '#f59e0b', '#ef4444', '#64748b'],
            legend: { show: false }
        }).render();
    });
</script>

<style>
    @media print {
        .sidebar, #gravity-bot, .bg-white.border-b, button, .group.bg-white, .btn-print { display: none !important; }
        .main-wrapper { display: block !important; padding: 0 !important; }
        body { background: white !important; -webkit-print-color-adjust: exact !important; }
        .content-area { margin: 0 !important; width: 100% !important; overflow: visible !important; }
        .bg-indigo-600 { background: #4f46e5 !important; color: white !important; }
        .bg-slate-950 { background: #0f172a !important; color: white !important; }
    }
</style>
@endsection
