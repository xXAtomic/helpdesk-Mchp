@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    <!-- Header Premium -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Centro de Inteligencia Estratégica y Control Operativo</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Gravity Insight
            </p>
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

    <!-- SECCIÓN DE ANALÍTICA PREDICTIVA -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
        <div class="lg:col-span-12 bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-3xl shadow-2xl overflow-hidden group">
            <div class="flex items-center justify-between mb-8 border-b border-slate-800 pb-6">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                        <h3 class="text-white text-lg font-black uppercase tracking-tighter italic">Mapa de Calor: Presión por Departamento</h3>
                    </div>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mt-2 ml-5 italic">Identificación de áreas con mayor demanda de soporte técnico</p>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-slate-950 rounded-xl border border-slate-800">
                    <span class="w-2 h-2 bg-rose-500 rounded-full animate-pulse shadow-[0_0_10px_#f43f5e]"></span>
                    <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest">En Tiempo Real</span>
                </div>
            </div>
            <div id="departmentHeatChart" class="min-h-[350px]"></div>
        </div>
    </div>

    <!-- Widgets Tácticos Inferiores -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 g        <!-- Inventario -->
        <div class="bg-gradient-to-br from-blue-600/10 to-transparent border border-blue-500/20 p-6 rounded-2xl hover:border-blue-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-500/20 rounded-xl text-blue-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-desktop text-xl"></i>
                </div>
                <span class="text-xs text-blue-500 font-bold bg-blue-500/10 px-2 py-1 rounded">Activo</span>
            </div>
            <p class="text-slate-400 text-sm">Equipos Registrados (Patrimonio)</p>
            <h4 class="text-3xl font-black text-white mt-1">{{ number_format($equipmentCount, 0, ',', '.') }} un.</h4>
            <div class="mt-4 flex items-center text-xs text-slate-500">
                <i class="fas fa-sync-alt fa-spin mr-2"></i> Base de Datos Global
            </div>
        </div>

        <!-- Satisfaction CSAT -->
        <div class="bg-gradient-to-br from-indigo-600/10 to-transparent border border-indigo-500/20 p-6 rounded-2xl hover:border-indigo-500/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-500/20 rounded-xl text-indigo-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-smile text-xl"></i>
                </div>
                <span class="text-xs text-indigo-500 font-bold bg-indigo-500/10 px-2 py-1 rounded">CSAT</span>
            </div>
            <p class="text-slate-400 text-sm">Satisfacción Promedio</p>
            <h4 class="text-3xl font-black text-white mt-1">{{ $avgRating }} / 5.0</h4>
            <div class="mt-4 flex gap-1 items-center">
                @for($i=1; $i<=5; $i++)
                    <div class="h-1 flex-1 {{ $i <= $avgRating ? 'bg-yellow-400' : 'bg-slate-700' }} rounded-full transition-all"></div>
                @endfor
                <span class="text-[10px] text-yellow-400 ml-2 font-black italic">★ SCORE</span>
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
                <i class="fas fa-calendar-check mr-2 text-purple-500"></i> Reinicio en {{ Carbon\Carbon::now()->daysInMonth - Carbon\Carbon::now()->day }} días
            </div>
        </div>
    </div>

    <!-- SECCIÓN FINANCIERA DETALLADA 💵 -->
    <div class="mt-12 mb-8">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
            <h3 class="text-white text-lg font-black uppercase tracking-tighter italic">Salud Financiera TI (CLP)</h3>
            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[0.6rem] font-black uppercase rounded-lg border border-emerald-500/20 shadow-lg shadow-emerald-500/5">Auditoría en Tiempo Real</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Valor Total del Patrimonio Hardware -->
            <div class="bg-slate-900/60 border border-emerald-500/30 p-8 rounded-[2rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/80">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10 text-center md:text-left">
                    <p class="text-slate-400 text-[0.6rem] font-bold uppercase tracking-[0.2em] mb-4 italic">Inversión Hardware (Patrimonio)</p>
                    <h4 class="text-4xl font-black text-white italic tracking-tighter hover:text-emerald-400 transition-colors">
                        $ {{ number_format($totalHardwareInvestment, 0, ',', '.') }}
                    </h4>
                    <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-6 flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-shield-alt text-emerald-500"></i> Valor Total Activo
                    </p>
                </div>
            </div>

            <!-- COMPRAS: Reabastecimiento de Stock -->
            <div class="bg-slate-900/60 border border-indigo-500/30 p-8 rounded-[2rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/80">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10 text-center md:text-left">
                    <p class="text-slate-400 text-[0.6rem] font-bold uppercase tracking-[0.2em] mb-4 italic">Compras / Abastecimiento (Mes)</p>
                    <h4 class="text-4xl font-black text-white italic tracking-tighter hover:text-indigo-400 transition-colors">
                        $ {{ number_format($totalMonthlyPurchases, 0, ',', '.') }}
                    </h4>
                    <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-6 flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-shopping-basket text-indigo-500"></i> Adquisición de Insumos
                    </p>
                </div>
            </div>

            <!-- GASTOS: Consumo y Entregas -->
            <div class="bg-slate-900/60 border border-blue-500/30 p-8 rounded-[2rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/80">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <div class="relative z-10 text-center md:text-left">
                    <p class="text-slate-400 text-[0.6rem] font-bold uppercase tracking-[0.2em] mb-4 italic">Gasto Operativo (Entregas Mes)</p>
                    <h4 class="text-4xl font-black text-white italic tracking-tighter hover:text-blue-400 transition-colors">
                        $ {{ number_format($totalMonthlyConsumptions, 0, ',', '.') }}
                    </h4>
                    <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-6 flex items-center justify-center md:justify-start gap-2">
                        <i class="fas fa-walking text-blue-500"></i> Desembolso Material Real
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DE AUDITORÍA DETALLADA PARA EL BOSS 🕵️‍♂️ -->
    <div class="bg-slate-900/40 backdrop-blur-2xl border border-slate-800 p-8 rounded-[2.5rem] shadow-2xl mb-12">
        <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-6">
            <div>
                <h3 class="text-white text-lg font-black uppercase tracking-tighter italic">Bitácora de Control de Materiales</h3>
                <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-1">Monitoreo de quién solicita y quién autoriza el flujo de insumos</p>
            </div>
            <i class="fas fa-fingerprint text-indigo-500 text-2xl opacity-20"></i>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-500 text-[10px] font-black uppercase tracking-[0.15em] border-b border-white/5">
                        <th class="pb-4">Fecha</th>
                        <th class="pb-4">Insumo</th>
                        <th class="pb-4 text-center">Cant.</th>
                        <th class="pb-4 text-right">Valor Est.</th>
                        <th class="pb-4 text-center">Tipo</th>
                        <th class="pb-4">Responsable</th>
                        <th class="pb-4">Solicitante / Destino</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($recentTransactions as $log)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="py-4 text-[11px] font-mono text-slate-400">{{ $log->created_at->format('d/m H:i') }}</td>
                        <td class="py-4">
                            <span class="text-xs font-bold text-white tracking-tight">{{ $log->supply->name }}</span>
                            <span class="block text-[9px] text-slate-500 uppercase font-black">{{ $log->supply->brand ?? 'S/M' }}</span>
                        </td>
                        <td class="py-4 text-center">
                            <span class="px-2 py-1 bg-slate-800 rounded font-mono text-xs text-white">x{{ $log->quantity }}</span>
                        </td>
                        <td class="py-4 text-right">
                            <span class="text-xs font-bold text-emerald-400 tracking-tighter italic">$ {{ number_format($log->quantity * ($log->supply->unit_cost ?? 0), 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 text-center">
                            @if($log->action == 'RESTOCK')
                                <span class="px-2 py-0.5 bg-indigo-500/10 text-indigo-400 text-[8px] font-black uppercase rounded-lg border border-indigo-500/20 italic">COMPRA</span>
                            @else
                                <span class="px-2 py-0.5 bg-blue-500/10 text-blue-400 text-[8px] font-black uppercase rounded-lg border border-blue-500/20 italic">G-OPERACIÓN</span>
                            @endif
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-slate-800 text-[8px] flex items-center justify-center text-slate-400 uppercase font-black">
                                    {{ substr($log->admin->name ?? '?', 0, 1) }}
                                </div>
                                <span class="text-[10px] font-bold text-slate-300 uppercase truncate max-w-[100px]">{{ $log->admin->name ?? 'SISTEMA' }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            @if($log->action == 'RESTOCK')
                                <span class="text-[9px] text-slate-500 uppercase font-bold italic">Abastecimiento Almacén</span>
                            @else
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-user-tag text-blue-500/50 text-[10px]"></i>
                                    <span class="text-[10px] font-black text-white uppercase">{{ $log->user->name ?? 'RETIRO DIRECTO' }}</span>
                                </div>
                                @if($log->equipment_tag)
                                    <span class="block text-[8px] text-indigo-400 font-bold uppercase mt-0.5">EQ: {{ $log->equipment_tag }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

    // 1. Donut Chart - Ticket Status (DATOS REALES)
    const statusData = @json(array_values($statusStats));
    const statusLabels = @json(array_keys($statusStats));

    var optionsStatus = {
        series: statusData,
        chart: { type: 'donut', height: 280, background: 'transparent' },
        stroke: { show: false },
        colors: [colors.warning, colors.primary, colors.success],
        labels: statusLabels,
        legend: { position: 'bottom', labels: { colors: colors.muted }, markers: { radius: 12 } },
        dataLabels: { enabled: false },
        plotOptions: { pie: { donut: { size: '75%', background: 'transparent' } } },
        tooltip: { theme: 'dark' }
    };
    new ApexCharts(document.querySelector("#statusDonutChart"), optionsStatus).render();

    // 2. Main Trend Area Chart (DATOS REALES)
    var optionsMain = {
        series: [{
            name: 'Tickets Creados',
            data: @json($ticketsCreated)
        }],
        chart: { height: 350, type: 'area', toolbar: { show: false }, background: 'transparent', fontFamily: 'Inter, sans-serif' },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 4 },
        colors: [colors.primary],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05, stops: [0, 90, 100] } },
        xaxis: { 
            categories: @json($days), 
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: colors.muted, fontSize: '11px' } } 
        },
        yaxis: { labels: { style: { colors: colors.muted, fontSize: '11px' } } },
        grid: { borderColor: '#1e293b', strokeDashArray: 4 },
        tooltip: { theme: 'dark' }
    };
    new ApexCharts(document.querySelector("#mainTrendChart"), optionsMain).render();

    // 3. Department Heatmap (Análisis Predictivo)
    const deptStats = @json($ticketsByDepartment);
    const deptLabels = deptStats.map(d => d.name);
    const deptData = deptStats.map(d => d.total);

    var optionsHeat = {
        series: [{
            name: 'Total Tickets',
            data: deptData
        }],
        chart: {
            height: 350,
            type: 'bar',
            toolbar: { show: false },
            background: 'transparent',
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                borderRadius: 15,
                horizontal: true,
                distributed: true,
                barHeight: '70%',
                dataLabels: { position: 'top' }
            }
        },
        colors: deptData.map((val, idx) => {
            // El primero es la "zona caliente"
            if (val > 10) return '#f43f5e'; // Rojo intenso
            if (val > 5) return '#fb923c';  // Naranja
            return '#3b82f6';               // Azul estable
        }),
        xaxis: {
            categories: deptLabels,
            labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 700 } }
        },
        yaxis: {
            labels: { style: { colors: '#fff', fontSize: '12px', fontWeight: 800 } }
        },
        grid: { borderColor: '#1e293b', strokeDashArray: 4 },
        dataLabels: {
            enabled: true,
            formatter: (val) => val + " INCIDENTES",
            style: { colors: ['#fff'], fontSize: '10px', fontWeight: 900 }
        },
        tooltip: {
            theme: 'dark',
            y: { title: { formatter: (q) => "Demanda de Soporte: " } }
        }
    };
    new ApexCharts(document.querySelector("#departmentHeatChart"), optionsHeat).render();
});
</script>
@endsection
