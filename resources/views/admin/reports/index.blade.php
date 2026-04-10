@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    <!-- Header Premium -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Reportes Estratégicos y Auditoría TI</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Panel de Control de Gestión
            </p>
        </div>
        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col items-end mr-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Estado del Sistema</span>
                <span class="text-emerald-400 text-sm font-mono tracking-tighter">DATA_SYNC_ACTIVE_OK</span>
            </div>
            <div class="p-4 bg-slate-900/80 border border-blue-500/30 rounded-2xl shadow-lg shadow-blue-500/10 backdrop-blur-md">
                <i class="fas fa-file-invoice-dollar text-blue-400"></i>
            </div>
        </div>
    </div>

    <!-- Fila 1: Gráficos de Control Superior (Tickets) -->
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

    <!-- Fila 2: Métricas Rápidas (Puntos de Control) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Inventario -->
        <div class="bg-gradient-to-br from-blue-600/10 to-transparent border border-blue-500/20 p-6 rounded-2xl hover:border-blue-500/50 transition-all group shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-500/20 rounded-xl text-blue-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-desktop text-xl"></i>
                </div>
                <span class="text-xs text-blue-500 font-bold bg-blue-500/10 px-2 py-1 rounded">Activo</span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Equipos (Patrimonio)</p>
            <h4 class="text-3xl font-black text-white mt-1 italic tracking-tighter">{{ number_format($equipmentCount, 0, ',', '.') }} un.</h4>
            <div class="mt-4 flex items-center text-[10px] text-slate-500 font-black italic">
                <i class="fas fa-sync-alt fa-spin mr-2"></i> BASE GLOBAL
            </div>
        </div>

        <!-- Satisfaction CSAT -->
        <div class="bg-gradient-to-br from-indigo-600/10 to-transparent border border-indigo-500/20 p-6 rounded-2xl hover:border-indigo-500/50 transition-all group shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-indigo-500/20 rounded-xl text-indigo-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-smile text-xl"></i>
                </div>
                <span class="text-xs text-indigo-500 font-bold bg-indigo-500/10 px-2 py-1 rounded">CSAT</span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Satisfacción</p>
            <h4 class="text-3xl font-black text-white mt-1 italic tracking-tighter">{{ $avgRating }} / 5.0</h4>
            <div class="mt-4 flex gap-1 items-center">
                @for($i=1; $i<=5; $i++)
                    <div class="h-1 flex-1 {{ $i <= $avgRating ? 'bg-indigo-400' : 'bg-slate-700' }} rounded-full transition-all"></div>
                @endfor
            </div>
        </div>

        <!-- Tiempo de Respuesta -->
        <div class="bg-gradient-to-br from-amber-600/10 to-transparent border border-amber-500/20 p-6 rounded-2xl hover:border-amber-500/50 transition-all group shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-500/20 rounded-xl text-amber-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <span class="text-xs text-amber-500 font-bold bg-amber-500/10 px-2 py-1 rounded">SLA</span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Respuesta Prom.</p>
            <h4 class="text-3xl font-black text-white mt-1 italic tracking-tighter">{{ $avgResponseTime }}</h4>
            <div class="mt-4 text-[10px] italic text-slate-500 font-bold uppercase tracking-[0.2em]">
                Rendimiento Optimo
            </div>
        </div>

        <!-- Tickets Atendidos Mes -->
        <div class="bg-gradient-to-br from-purple-600/10 to-transparent border border-purple-500/20 p-6 rounded-2xl hover:border-purple-500/50 transition-all group shadow-xl">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-500/20 rounded-xl text-purple-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-double text-xl"></i>
                </div>
                <span class="text-[10px] text-purple-400 font-bold bg-purple-500/10 px-2 py-1 rounded italic uppercase tracking-tighter">{{ Carbon\Carbon::now()->format('F') }}</span>
            </div>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Tickets Mes</p>
            <h4 class="text-3xl font-black text-white mt-1 italic tracking-tighter">{{ str_pad($monthlyResolvedCount, 2, '0', STR_PAD_LEFT) }}</h4>
            <div class="mt-4 flex items-center text-[9px] text-slate-500 uppercase tracking-widest font-black italic">
                <i class="fas fa-calendar mr-2 text-purple-500"></i> RESET EN {{ Carbon\Carbon::now()->daysInMonth - Carbon\Carbon::now()->day }} DÍAS
            </div>
        </div>
    </div>

    <!-- Fila 3: Salud Financiera (Contenedor Independiente) -->
    <div class="mt-12 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
            <h3 class="text-white text-lg font-black uppercase tracking-tighter italic leading-none">Salud Financiera TI (CLP)</h3>
            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-[0.6rem] font-black uppercase rounded-lg border border-emerald-500/20">Auditoría Real</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Patrimonio -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/60 hover:border-emerald-500/30">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <p class="text-slate-400 text-[0.6rem] font-black uppercase tracking-[0.2em] mb-4 italic">Inversión Hardware</p>
                <h4 class="text-4xl font-black text-white italic tracking-tighter">$ {{ number_format($totalHardwareInvestment, 0, ',', '.') }}</h4>
                <p class="text-[9px] text-emerald-500 font-black uppercase tracking-widest mt-6">VALORIZACIÓN PATRIMONIAL</p>
            </div>

            <!-- Compras -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/60 hover:border-indigo-500/30">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <p class="text-slate-400 text-[0.6rem] font-black uppercase tracking-[0.2em] mb-4 italic">Compras / Abastecimiento</p>
                <h4 class="text-4xl font-black text-white italic tracking-tighter">$ {{ number_format($totalMonthlyPurchases, 0, ',', '.') }}</h4>
                <p class="text-[9px] text-indigo-500 font-black uppercase tracking-widest mt-6">INGRESO STOCK ({{ Carbon\Carbon::now()->format('M Y') }})</p>
            </div>

            <!-- Gastos -->
            <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group transition-all hover:bg-slate-900/60 hover:border-blue-500/30">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-blue-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform"></div>
                <p class="text-slate-400 text-[0.6rem] font-black uppercase tracking-[0.2em] mb-4 italic">Gasto Operativo</p>
                <h4 class="text-4xl font-black text-white italic tracking-tighter">$ {{ number_format($totalMonthlyConsumptions, 0, ',', '.') }}</h4>
                <p class="text-[9px] text-blue-500 font-black uppercase tracking-widest mt-6">RETIRO MATERIAL ({{ Carbon\Carbon::now()->format('M Y') }})</p>
            </div>
        </div>
    </div>

    <!-- Fila 4: Bitácora de Auditoría (Ancho Completo) -->
    <div class="bg-slate-900/40 backdrop-blur-2xl border border-white/5 p-8 rounded-[2.5rem] shadow-2xl mb-12 overflow-hidden">
        <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-6">
            <div>
                <h3 class="text-white text-lg font-black uppercase tracking-tighter italic">Bitácora de Control de Movimientos</h3>
                <p class="text-[0.6rem] text-slate-500 font-bold uppercase mt-2 tracking-[0.2em]">Registro Histórico de Inversión y Consumo</p>
            </div>
            <i class="fas fa-fingerprint text-indigo-500 text-3xl opacity-20"></i>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead class="border-b border-white/10 uppercase italic">
                    <tr class="text-slate-500 text-[10px] font-black tracking-widest">
                        <th class="pb-5 pr-4">Fecha</th>
                        <th class="pb-5 pr-4">Insumo / Marca</th>
                        <th class="pb-5 text-center">Cant.</th>
                        <th class="pb-5 text-right">Monto CLP</th>
                        <th class="pb-5 text-center">Tipo</th>
                        <th class="pb-5 px-6">Responsable</th>
                        <th class="pb-5">Destino / Solicitante</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach($recentTransactions as $log)
                    <tr class="group hover:bg-white/[0.03] transition-colors border-b border-white/5 italic">
                        <td class="py-5 whitespace-nowrap">
                            <span class="text-[11px] font-black text-white italic tracking-tighter">{{ $log->created_at->format('d/m/Y') }}</span>
                            <span class="block text-[9px] text-indigo-400 font-mono italic uppercase">{{ $log->created_at->format('H:i') }} hrs</span>
                        </td>
                        <td class="py-5">
                            <span class="text-xs font-black text-white uppercase tracking-tight italic">{{ $log->supply->name }}</span>
                            <span class="block text-[9px] text-slate-500 uppercase font-bold italic tracking-tighter">{{ $log->supply->brand ?? 'S/Marca' }}</span>
                        </td>
                        <td class="py-5 text-center">
                            <span class="px-3 py-1 bg-slate-800 text-white border border-white/10 rounded-lg font-mono text-xs shadow-lg uppercase">x{{ $log->quantity }}</span>
                        </td>
                        <td class="py-5 text-right">
                            @php $value = $log->quantity * ($log->supply->unit_cost ?? 0); @endphp
                            <span class="text-[11px] font-black {{ $value > 0 ? 'text-emerald-300' : 'text-rose-400' }} tracking-tighter italic">$ {{ number_format($value, 0, ',', '.') }}</span>
                        </td>
                        <td class="py-5 text-center">
                            @if($log->action == 'RESTOCK')
                                <span class="px-3 py-1 bg-indigo-500 text-white text-[8px] font-black uppercase rounded-full shadow-lg italic">COMPRA</span>
                            @else
                                <span class="px-3 py-1 bg-blue-600 text-white text-[8px] font-black uppercase rounded-full shadow-lg italic">GASTO</span>
                            @endif
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-slate-200 uppercase tracking-tight italic shadow-white/5">{{ $log->admin->name ?? 'SISTEMA' }}</span>
                            </div>
                        </td>
                        <td class="py-5">
                            @if($log->action == 'RESTOCK')
                                <span class="text-[9px] text-indigo-400 font-black uppercase italic tracking-tighter">📦 Abastecimiento Almacén</span>
                            @else
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[10px] font-black text-white uppercase italic tracking-tight">{{ $log->user->name ?? 'RETIRO' }}</span>
                                    @if($log->equipment_tag)
                                        <span class="text-[8px] text-blue-400 font-black uppercase italic">Equip: {{ $log->equipment_tag }}</span>
                                    @endif
                                </div>
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
    const colors = {
        primary: '#3b82f6',
        secondary: '#6366f1',
        success: '#10b981',
        danger: '#ef4444',
        warning: '#f59e0b',
        muted: '#94a3b8'
    };

    // 1. Donut Chart - Ticket Status
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

    // 2. Main Trend Area Chart
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
});
</script>
@endsection
