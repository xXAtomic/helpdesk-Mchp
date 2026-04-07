@extends('layouts.app')

@section('content')
<div class="px-6 py-8 min-h-screen">
    <!-- Header Premium Adaptive -->
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 dark:border-white/5 pb-10">
        <div>
            <h1 class="text-4xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:to-purple-500 tracking-tighter uppercase italic leading-none">
                Hub Estratégico IT
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-4 text-[0.65rem] font-black uppercase tracking-[0.3em] flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Estado de Salud de Infraestructura • MChP
            </p>
        </div>
        <div class="flex items-center gap-6">
            <div class="hidden md:flex flex-col items-end">
                <span class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest italic">System Status</span>
                <span class="text-emerald-500 text-xs font-mono font-black animate-pulse">HUB_SYNC_ACTIVE</span>
            </div>
            <div class="w-16 h-16 bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 rounded-2xl shadow-xl flex items-center justify-center text-blue-500 text-2xl group transition-transform hover:rotate-12">
                <i class="fas fa-microchip"></i>
            </div>
        </div>
    </div>

    <!-- Panel de Control Principal (Adaptive) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
        <!-- Salud Global (Donut) -->
        <div class="lg:col-span-4 bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-10 rounded-[2.5rem] shadow-sm relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50 dark:bg-blue-500/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <h3 class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 italic">Distribución de Carga</h3>
            <div id="statusDonutChart" class="min-h-[250px] relative z-10"></div>
            <div class="flex justify-around mt-8 border-t border-gray-50 dark:border-white/5 pt-8 relative z-10">
                <div class="text-center">
                    <p class="text-2xl font-black text-slate-900 dark:text-white italic leading-none">{{ $openTickets + $closedTickets }}</p>
                    <p class="text-[0.55rem] font-black text-slate-400 uppercase mt-2 tracking-widest">Total</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-black text-emerald-500 italic leading-none">{{ $closedTickets }}</p>
                    <p class="text-[0.55rem] font-black text-slate-400 uppercase mt-2 tracking-widest">Finalizados</p>
                </div>
            </div>
        </div>

        <!-- Tendencia y Carga (Area) -->
        <div class="lg:col-span-8 bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-10 rounded-[2.5rem] shadow-sm relative group overflow-hidden">
             <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-50 dark:bg-indigo-500/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <div class="flex items-center justify-between mb-8 relative z-10">
                <h3 class="text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.2em] italic">Flujo Operativo Mensual</h3>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                         <span class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.4)]"></span>
                         <span class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest mt-1">Nuevos Tickets</span>
                    </div>
                </div>
            </div>
            <div id="mainTrendChart" class="min-h-[300px] relative z-10"></div>
        </div>
    </div>

    <!-- Widgets Tácticos Inferiores Adaptive -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Inventario -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-8 rounded-[2rem] hover:shadow-2xl hover:-translate-y-2 transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:scale-125 transition-transform">
                <i class="fas fa-desktop text-6xl text-slate-900 dark:text-white"></i>
            </div>
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-blue-50 dark:bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-600 text-xl border border-blue-100 dark:border-blue-500/20 group-hover:rotate-12 transition-all">
                    <i class="fas fa-desktop"></i>
                </div>
                <span class="text-[0.55rem] font-black text-blue-600 bg-blue-50 dark:bg-blue-600/20 px-3 py-1 rounded-lg uppercase tracking-widest border border-blue-100 dark:border-blue-600/30">ACTIVO</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-[0.6rem] font-black uppercase tracking-widest italic">Activos Monitoreados</p>
            <h4 class="text-4xl font-black text-slate-900 dark:text-white mt-2 leading-none italic uppercase tracking-tighter">{{ $totalAssets }}</h4>
            <div class="mt-8 flex items-center text-[0.55rem] font-bold text-slate-300 uppercase tracking-widest italic">
                <i class="fas fa-sync-alt fa-spin mr-2"></i> Real-time sync • ON
            </div>
        </div>

        <!-- SLA Performance -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-8 rounded-[2rem] hover:shadow-2xl hover:-translate-y-2 transition-all group overflow-hidden relative">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-600/10 rounded-2xl flex items-center justify-center text-emerald-600 text-xl border border-emerald-100 dark:border-emerald-500/20 group-hover:-rotate-12 transition-all">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <span class="text-[0.55rem] font-black text-emerald-600 bg-emerald-50 dark:bg-emerald-600/20 px-3 py-1 rounded-lg uppercase tracking-widest border border-emerald-100 dark:border-emerald-600/30">98.2%</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-[0.6rem] font-black uppercase tracking-widest italic">Nivel de Servicio</p>
            <h4 class="text-4xl font-black text-emerald-500 mt-2 leading-none italic uppercase tracking-tighter">Óptimo</h4>
            <div class="mt-8 flex gap-1 items-center">
                 <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full w-[98%] bg-emerald-500 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                 </div>
            </div>
        </div>

        <!-- Tiempo de Respuesta -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-8 rounded-[2rem] hover:shadow-2xl hover:-translate-y-2 transition-all group overflow-hidden relative">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-amber-50 dark:bg-amber-600/10 rounded-2xl flex items-center justify-center text-amber-600 text-xl border border-amber-100 dark:border-amber-500/20 group-hover:scale-110 transition-all">
                    <i class="fas fa-history"></i>
                </div>
                <span class="text-[0.55rem] font-black text-amber-600 bg-amber-50 dark:bg-amber-600/20 px-3 py-1 rounded-lg uppercase tracking-widest border border-amber-100 dark:border-amber-600/30">-14% VS SEM_PAS</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-[0.6rem] font-black uppercase tracking-widest italic">Tiempo Promedio</p>
            <h4 class="text-4xl font-black text-slate-900 dark:text-white mt-2 leading-none italic uppercase tracking-tighter">{{ $avgResponseTime }}</h4>
            <div class="mt-8 text-[0.55rem] font-black text-slate-300 uppercase italic tracking-widest">
                "Eficiencia Operativa Max"
            </div>
        </div>

        <!-- Fuerza Laboral -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-white/5 p-8 rounded-[2rem] hover:shadow-2xl hover:-translate-y-2 transition-all group overflow-hidden relative border border-purple-500/10">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 bg-purple-50 dark:bg-purple-600/10 rounded-2xl flex items-center justify-center text-purple-600 text-xl border border-purple-100 dark:border-purple-500/20 group-hover:scale-110 transition-all">
                    <i class="fas fa-user-shield"></i>
                </div>
                <span class="text-[0.45rem] font-bold text-slate-300 uppercase tracking-widest italic">GERENCIA TI</span>
            </div>
            <p class="text-slate-400 dark:text-slate-500 text-[0.6rem] font-black uppercase tracking-widest italic">Tickets Críticos (Jefe)</p>
            <h4 class="text-4xl font-black text-slate-900 dark:text-white mt-2 leading-none italic uppercase tracking-tighter">{{ $inProcessTickets }}</h4>
            <div class="mt-8 flex -space-x-2">
                @for($i=1; $i<=5; $i++)
                <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 border-2 border-white dark:border-slate-950 flex items-center justify-center text-[0.6rem] font-black text-indigo-500 shadow-sm">
                    T{{$i}}
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = () => document.body.classList.contains('dark');
    
    // Definición de Colores Premium Adaptables
    const colors = {
        primary: '#3b82f6',
        secondary: '#6366f1',
        success: '#10b981',
        danger: '#ef4444',
        warning: '#f59e0b',
        muted: isDark() ? '#64748b' : '#94a3b8',
        border: isDark() ? 'rgba(255,255,255,0.05)' : '#f1f5f9'
    };

    // 1. Donut Chart - Ticket Status
    var optionsStatus = {
        series: [{{ $openTickets }}, {{ $closedTickets }}, {{ $inProcessTickets }}],
        chart: { type: 'donut', height: 280, background: 'transparent' },
        stroke: { show: false },
        colors: [colors.primary, colors.success, colors.danger],
        labels: ['Pendientes', 'Resueltos', 'Urgentes'],
        legend: { position: 'bottom', labels: { colors: colors.muted }, markers: { radius: 12 } },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '75%', background: 'transparent' } } },
        tooltip: { theme: isDark() ? 'dark' : 'light' }
    };
    new ApexCharts(document.querySelector("#statusDonutChart"), optionsStatus).render();

    // 2. Main Trend Area Chart
    var optionsMain = {
        series: [{
            name: 'Solicitudes TI',
            data: [12, 19, 15, 27, 22, 35, 30] // Data dummy o venir del controller
        }],
        chart: { height: 350, type: 'area', toolbar: { show: false }, background: 'transparent', fontFamily: 'Inter, sans-serif' },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 4 },
        colors: [colors.primary],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 90, 100] } },
        xaxis: { 
            categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'], 
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: colors.muted, fontSize: '11px', fontWeight: 'bold' } } 
        },
        yaxis: { labels: { style: { colors: colors.muted, fontSize: '11px', fontWeight: 'bold' } } },
        grid: { borderColor: colors.border, strokeDashArray: 4 },
        tooltip: { theme: isDark() ? 'dark' : 'light' }
    };
    new ApexCharts(document.querySelector("#mainTrendChart"), optionsMain).render();
});
</script>
@endsection
