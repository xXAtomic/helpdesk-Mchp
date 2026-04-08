@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    <!-- Header Premium -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-500 tracking-tight">
                Hub Estratégico IT
            </h1>
            <p class="text-slate-400 mt-2 text-lg">Monitoreo de rendimiento y salud de infraestructura en tiempo real.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col items-end mr-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Sistema Operativo</span>
                <span class="text-emerald-400 text-sm font-mono tracking-tighter">NODE_SERVER_ACTIVE_01</span>
            </div>
            <div class="p-4 bg-slate-900/80 border border-blue-500/30 rounded-2xl shadow-lg shadow-blue-500/10 backdrop-blur-md animate-pulse">
                <i class="fas fa-microchip text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Panel de Control Principal (ApexCharts) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Salud Global (Donut) -->
        <div class="lg:col-span-4 bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <i class="fas fa-chart-pie text-6xl text-white"></i>
            </div>
            <h3 class="text-slate-400 text-sm font-bold uppercase tracking-widest mb-6">Estado de Tickets</h3>
            <div id="statusDonutChart" class="min-h-[250px]"></div>
            <div class="flex justify-around mt-6 border-t border-slate-800 pt-6">
                <div class="text-center">
                    <p class="text-2xl font-bold text-white">{{ $ticketsCount }}</p>
                    <p class="text-[10px] text-slate-500 uppercase">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-blue-400">{{ $resolvedCount }}</p>
                    <p class="text-[10px] text-slate-500 uppercase">Resueltos</p>
                </div>
            </div>
        </div>

        <!-- Tendencia y Carga (Area) -->
        <div class="lg:col-span-8 bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-3xl shadow-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-slate-400 text-sm font-bold uppercase tracking-widest">Flujo Operativo (Semanales)</h3>
                <div class="flex gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                    <span class="text-[10px] text-slate-400 uppercase tracking-tighter">Tickets Entrantes</span>
                </div>
            </div>
            <div id="mainTrendChart" class="min-h-[300px]"></div>
        </div>
    </div>

    <!-- Widgets Tácticos Inferiores -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Inventario -->
        <div class="bg-gradient-to-br from-blue-600/10 to-transparent border border-blue-500/20 p-6 rounded-2xl hover:border-blue-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-500/20 rounded-xl text-blue-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-desktop text-xl"></i>
                </div>
                <span class="text-xs text-blue-500 font-bold bg-blue-500/10 px-2 py-1 rounded">Activo</span>
            </div>
            <p class="text-slate-400 text-sm">Equipos Monitoreados</p>
            <h4 class="text-3xl font-black text-white mt-1">{{ $equipmentCount }}</h4>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <i class="fas fa-sync-alt fa-spin mr-2"></i> Actualizado hace 2 min
            </div>
        </div>

        <!-- SLA Performance -->
        <div class="bg-gradient-to-br from-emerald-600/10 to-transparent border border-emerald-500/20 p-6 rounded-2xl hover:border-emerald-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-emerald-500/20 rounded-xl text-emerald-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tachometer-alt text-xl"></i>
                </div>
                <span class="text-xs text-emerald-500 font-bold bg-emerald-500/10 px-2 py-1 rounded">98.2%</span>
            </div>
            <p class="text-slate-400 text-sm">Índice de Cumplimiento SLA</p>
            <h4 class="text-3xl font-black text-white mt-1">Óptimo</h4>
            <div class="mt-4 flex gap-1">
                @for($i=0; $i<5; $i++) <div class="h-1 flex-1 bg-emerald-500/50 rounded-full"></div> @endfor
            </div>
        </div>

        <!-- Tiempo de Respuesta -->
        <div class="bg-gradient-to-br from-amber-600/10 to-transparent border border-amber-500/20 p-6 rounded-2xl hover:border-amber-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-500/20 rounded-xl text-amber-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <span class="text-xs text-amber-500 font-bold bg-amber-500/10 px-2 py-1 rounded">-12% vs ayer</span>
            </div>
            <p class="text-slate-400 text-sm">Tiempo Prom. Respuesta</p>
            <h4 class="text-3xl font-black text-white mt-1">{{ $avgResponseTime }}</h4>
            <div class="mt-4 text-xs italic text-slate-500">
                "Excelente rendimiento del equipo"
            </div>
        </div>

        <!-- Tickets Atendidos Mes -->
        <div class="bg-gradient-to-br from-purple-600/10 to-transparent border border-purple-500/20 p-6 rounded-2xl hover:border-purple-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-500/20 rounded-xl text-purple-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
                <span class="text-[10px] text-purple-400 font-bold bg-purple-500/10 px-2 py-1 rounded uppercase tracking-tighter">{{ Carbon\Carbon::now()->translatedFormat('M Y') }}</span>
            </div>
            <p class="text-slate-400 text-sm">Tickets Resueltos Mes</p>
            <h4 class="text-3xl font-black text-white mt-1">{{ str_pad($monthlyResolvedCount, 2, '0', STR_PAD_LEFT) }}</h4>
            <div class="mt-4 flex items-center text-[10px] text-slate-500 uppercase tracking-widest italic">
                <i class="fas fa-calendar-check mr-2 text-purple-500"></i> Reinicio en {{ Carbon\Carbon::now()->endOfMonth()->diffInDays() }} días
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Definición de Colores Premium
    const colors = {
        primary: '#3b82f6',
        secondary: '#6366f1',
        success: '#10b981',
        danger: '#ef4444',
        warning: '#f59e0b',
        muted: '#94a3b8'
    };

    // 1. Donut Chart - Ticket Status
    var optionsStatus = {
        series: [44, 25, 12],
        chart: { type: 'donut', height: 280, background: 'transparent' },
        stroke: { show: false },
        colors: [colors.primary, colors.success, colors.danger],
        labels: ['Pendientes', 'Resueltos', 'Críticos'],
        legend: { position: 'bottom', labels: { colors: colors.muted }, markers: { radius: 12 } },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '75%', background: 'transparent' } } },
        tooltip: { theme: 'dark' }
    };
    new ApexCharts(document.querySelector("#statusDonutChart"), optionsStatus).render();

    // 2. Main Trend Area Chart
    var optionsMain = {
        series: [{
            name: 'Tickets Creados',
            data: [12, 19, 15, 27, 22, 35, 30]
        }, {
            name: 'Equipos Reparados',
            data: [10, 15, 13, 20, 18, 25, 22]
        }],
        chart: { height: 350, type: 'area', toolbar: { show: false }, background: 'transparent', fontFamily: 'Inter, sans-serif' },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 4 },
        colors: [colors.primary, colors.success],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 90, 100] } },
        xaxis: { 
            categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'], 
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: colors.muted, fontSize: '11px' } } 
        },
        yaxis: { labels: { style: { colors: colors.muted, fontSize: '11px' } } },
        grid: { borderColor: '#1e293b', strokeDashArray: 4 },
        tooltip: { theme: 'dark' }
    };
    new ApexCharts(document.querySelector("#mainTrendChart"), optionsMain).render();
});
</script>
@endsection
