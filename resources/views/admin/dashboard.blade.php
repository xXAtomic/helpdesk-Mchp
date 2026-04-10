@extends('layouts.app')

@section('content')
<div class="px-6 py-8 bg-slate-950 min-h-screen text-slate-200">
    
    <!-- CABECERA PREMIUM (GRAVITY STYLE) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-white/5 pb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">Terminal Administrativa Centralizada</h1>
            <p class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.6em] mt-4 flex items-center gap-2 italic">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                Gravity Insight • {{ config('app.institution_abbr') }}
            </p>
        </div>
        <div class="flex flex-col items-end gap-2">
            <span class="text-[0.55rem] font-black text-slate-500 uppercase tracking-widest italic">Nivel de Acceso: Root</span>
            <span class="inline-flex items-center px-6 py-2 bg-slate-900 border border-white/10 rounded-xl text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic shadow-2xl">
                 CORE_SYSTEM_NODE_01 // ACTIVE
            </span>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS DINÁMICOS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Pendientes -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:border-indigo-500/30 transition-all">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-500/10 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-3 italic">Solicitudes Cruciales</p>
            <p class="text-4xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $stats['open_tickets'] }} <span class="text-indigo-500">Tickets</span>
            </p>
        </div>

        <!-- Equipos -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:border-emerald-500/30 transition-all">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-3 italic">Capacidad Operativa</p>
            <p class="text-4xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $stats['total_equipment'] }} <span class="text-emerald-500">Activos</span>
            </p>
        </div>

        <!-- Total History -->
        <div class="bg-indigo-600/10 border border-indigo-500/20 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:border-indigo-500/50 transition-all">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-600/10 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest mb-3 italic">Historial de Reportes</p>
            <p class="text-4xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $stats['total_tickets'] }} <span class="text-indigo-400">Total</span>
            </p>
        </div>

        <!-- Alertas de Mantenimiento -->
        @if($stats['maintenance_pending'] > 0)
        <div class="bg-rose-600/10 border border-rose-500/30 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:border-rose-500/60 transition-all">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-600/10 rounded-full animate-ping"></div>
            <p class="text-[0.6rem] font-black text-rose-500 uppercase tracking-widest mb-3 italic">Alerta de Riesgo</p>
            <p class="text-4xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $stats['maintenance_pending'] }} <span class="text-rose-400">Vencidos</span>
            </p>
            <a href="{{ route('admin.inventory.index') }}" class="absolute inset-0 z-20"></a>
        </div>
        @else
        <div class="bg-slate-900/40 border border-white/5 p-8 rounded-[2.5rem] shadow-xl relative overflow-hidden group hover:border-slate-500 transition-all">
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-3 italic">Fuerza Laboral</p>
            <p class="text-4xl font-black text-white tracking-tighter italic uppercase leading-none">
                {{ $stats['total_users'] }} <span class="text-slate-500">Usuarios</span>
            </p>
        </div>
        @endif
    </div>

    <!-- SECCIÓN DE ANALÍTICAS VISUALES ✨ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        <!-- Gráfico: Volumen Semanal -->
        <div class="xl:col-span-2 bg-slate-900/40 backdrop-blur-2xl border border-white/5 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
            <div class="flex items-center justify-between mb-10">
                <div>
                     <span class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic mb-1 block">Flujo de Datos Críticos</span>
                     <h3 class="text-2xl font-black text-white uppercase italic tracking-tighter group-hover:text-indigo-400 transition-colors">Volumen Semanal</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="weeklyVolumeChart"></canvas>
            </div>
        </div>

        <!-- Gráfico: Distribución por Estatus -->
        <div class="bg-slate-900/40 backdrop-blur-2xl border border-white/5 p-10 rounded-[3rem] shadow-2xl relative group">
            <div class="flex items-center justify-between mb-10">
                <div>
                     <span class="text-[0.6rem] font-black text-emerald-400 uppercase tracking-widest italic mb-1 block">Estado de Red TI</span>
                     <h3 class="text-2xl font-black text-white uppercase italic tracking-tighter group-hover:text-emerald-400 transition-colors">Distribución</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            <div class="h-[280px] relative">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- TAREAS DE GESTIÓN RÁPIDA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2 space-y-8">
            <h4 class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] mb-4 italic ml-2">Módulos de Gestión Estratégica</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <a href="{{ route('admin.tickets.index') }}" class="group bg-indigo-600/5 backdrop-blur-xl border border-indigo-500/10 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden transition-all hover:-translate-y-2 hover:bg-indigo-600/10 hover:border-indigo-500/30 block">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/5 rounded-full group-hover:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 text-2xl border border-indigo-500/20 mb-8 transition-transform group-hover:rotate-12 shadow-lg shadow-indigo-500/10">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight italic mb-2 leading-none">Mesa de Ayuda</h3>
                        <p class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-[0.2em] leading-relaxed mb-10 italic">Resolución de Incidentes Corporativos</p>
                        <span class="text-[0.65rem] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-400/20 pb-1 group-hover:border-indigo-400 transition-all">TERMINAL DE RESPUESTA <i class="fas fa-arrow-right ml-2 text-[0.5rem]"></i></span>
                    </div>
                </a>

                <a href="{{ route('admin.inventory.index') }}" class="group bg-slate-900/40 backdrop-blur-xl border border-white/5 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden transition-all hover:-translate-y-2 hover:bg-slate-900/60 hover:border-emerald-500/30 block">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-500/5 rounded-full group-hover:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 text-2xl border border-emerald-500/20 mb-8 transition-transform group-hover:-rotate-12 shadow-lg shadow-emerald-500/10">
                            <i class="fas fa-cube"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight italic mb-2 leading-none">Inventario TI</h3>
                        <p class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-[0.2em] leading-relaxed mb-10 italic">Control de Activos y Patrimonio TI</p>
                        <span class="text-[0.65rem] font-black text-emerald-400 uppercase tracking-widest border-b border-emerald-400/20 pb-1 group-hover:border-emerald-400 transition-all">VER RECURSOS <i class="fas fa-arrow-right ml-2 text-[0.5rem]"></i></span>
                    </div>
                </a>
            </div>

            <!-- REGISTROS RECIENTES -->
            <div class="bg-slate-900/40 backdrop-blur-2xl border border-white/5 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden">
                <div class="flex items-center justify-between mb-10">
                     <h3 class="text-xl font-black text-white uppercase italic tracking-tighter">Últimas Solicitudes</h3>
                     <a href="{{ route('admin.tickets.index') }}" class="text-[0.6rem] font-black text-indigo-400 hover:text-white uppercase tracking-[0.2em] transition-all">HISTORIAL COMPLETO +</a>
                </div>
                <div class="space-y-4">
                    @foreach($recentTickets as $ticket)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 bg-slate-950/40 hover:bg-slate-900/80 rounded-[1.5rem] border border-white/5 transition-all group">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-xl border border-white/5 font-black italic text-slate-600 group-hover:text-indigo-400 group-hover:border-indigo-500/30 transition-all">
                                    {{ substr($ticket->ticket_number, -1) }}
                                </div>
                                <div>
                                    <h5 class="text-sm font-black text-white uppercase italic tracking-tight group-hover:translate-x-1 transition-transform">{{ $ticket->title }}</h5>
                                    <p class="text-[0.6rem] text-slate-500 font-bold uppercase tracking-widest mt-1 italic">{{ $ticket->user->name }} • {{ $ticket->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex items-center gap-6">
                                <span class="px-4 py-1.5 rounded-full text-[0.55rem] font-black text-white uppercase tracking-widest italic shadow-lg border border-white/10" style="background-color: {{ $ticket->status->color }}">
                                    {{ $ticket->status->name }}
                                </span>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="p-2 text-slate-600 hover:text-indigo-400 transition-all">
                                    <i class="fas fa-chevron-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- LATERAL: SEGURIDAD & PERFORMANCE -->
        <div class="space-y-10">
            <!-- WIDGET MANUALES -->
            <div class="bg-indigo-600 p-10 rounded-[3.5rem] shadow-2xl shadow-indigo-900/20 relative overflow-hidden group">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-white text-xl mb-6 backdrop-blur-md">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tighter italic mb-4">GravityBrain</h3>
                    <p class="text-[0.6rem] font-bold text-indigo-100/60 uppercase tracking-widest leading-relaxed mb-10">Base de Inteligencia TI y Manuales Operativos.</p>
                    <a href="{{ route('admin.knowledge.index') }}" class="block w-full bg-slate-950 text-white py-5 rounded-[1.5rem] font-black text-[0.65rem] uppercase tracking-[0.2em] text-center hover:bg-white hover:text-slate-950 transition-all shadow-2xl italic">
                        ENTRAR A KB-RESOURCES ←
                    </a>
                </div>
            </div>

            <!-- TECH WORKLOAD WIDGET 📊 -->
            <div class="bg-slate-900/40 backdrop-blur-3xl border border-white/5 p-10 rounded-[3rem] shadow-2xl group">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] italic leading-none">Staff Operativo</h4>
                    <span class="w-8 h-8 bg-slate-950 rounded-xl flex items-center justify-center text-slate-600 text-[10px] border border-white/5 shadow-inner"><i class="fas fa-shield-halved"></i></span>
                </div>
                
                <div class="space-y-7">
                    @foreach($stats['tech_workload'] as $tech)
                        <div>
                            <div class="flex justify-between items-end mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 bg-indigo-500/10 rounded-md flex items-center justify-center text-[10px] text-indigo-400 border border-indigo-500/20">
                                        {{ substr($tech->name, 0, 1) }}
                                    </div>
                                    <span class="text-[0.65rem] font-black text-slate-200 uppercase italic leading-none">{{ $tech->name }}</span>
                                </div>
                                <span class="text-[10px] font-black text-indigo-400 italic">{{ $tech->assigned_tickets_count }} TICKETS</span>
                            </div>
                            <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                                @php 
                                    $percent = $stats['open_tickets'] > 0 ? ($tech->assigned_tickets_count / $stats['open_tickets']) * 100 : 0;
                                @endphp
                                <div class="h-full bg-indigo-500 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    
                    @if($stats['tech_workload']->isEmpty())
                        <div class="text-center py-8 border border-dashed border-white/5 rounded-[2rem]">
                            <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-widest italic">ZONA INACTIVA</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8 pt-6 border-t border-white/5">
                    <a href="{{ route('admin.users.index') }}" class="w-full flex items-center justify-center gap-2 py-4 bg-slate-950 border border-white/5 text-white rounded-2xl text-[0.6rem] font-black uppercase tracking-widest hover:bg-slate-900 transition-all italic">
                        PERSONAL TI <i class="fas fa-users-cog ml-2"></i>
                    </a>
                </div>
            </div>

            <!-- INVENTORY HEALTH MINI-CHART 🧪 -->
            <div class="bg-slate-900/40 border border-white/5 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-indigo-500/5 transition-all"></div>
                <h4 class="text-[0.65rem] font-black text-slate-500 uppercase tracking-[0.4em] mb-8 italic">Métricas de Activos</h4>
                
                <div class="flex items-center justify-center mb-8 relative">
                    <canvas id="inventoryHealthChart" class="max-w-[140px] max-h-[140px]"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-lg font-black text-white italic leading-none">{{ $stats['total_equipment'] }}</span>
                        <span class="text-[0.5rem] font-bold text-slate-500 uppercase tracking-tighter mt-1">Total Hub</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach($stats['equipment_health'] as $health)
                        <div class="bg-slate-950/60 p-3 rounded-xl border border-white/5 flex items-center gap-3 group-hover:border-white/10 transition-all">
                            <div class="w-1.5 h-1.5 rounded-full {{ $health->status == 'Operativo' ? 'bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.5)]' : ($health->status == 'Mantenimiento' ? 'bg-amber-500 shadow-[0_0_5px_rgba(245,158,11,0.5)]' : 'bg-rose-500 shadow-[0_0_5px_rgba(239,68,68,0.5)]') }}"></div>
                            <div>
                                <p class="text-[0.5rem] font-black text-slate-500 uppercase italic leading-none mb-1">{{ $health->status }}</p>
                                <p class="text-xs font-black text-white italic leading-none">{{ $health->total }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <p class="text-[0.5rem] font-black text-slate-600 text-center uppercase tracking-[0.5em] italic mt-12">
                CRISADONES CONTROL • v2.6.2024 🚀
            </p>
        </div>

    </div>
</div>

    <!-- DATA HUB FOR ANALYTICS (DECOUPLED) -->
    <div id="dashboard-analytics-data" class="hidden"
         data-weekly-labels='@json($stats['weekly_volume']->pluck('date'))'
         data-weekly-totals='@json($stats['weekly_volume']->pluck('total'))'
         data-status-labels='@json($stats['by_status']->pluck('name'))'
         data-status-totals='@json($stats['by_status']->pluck('total'))'
         data-status-colors='@json($stats['by_status']->pluck('color'))'
         data-health-labels='@json($stats['equipment_health']->pluck('status'))'
         data-health-totals='@json($stats['equipment_health']->pluck('total'))'
         data-health-colors='@json($stats['equipment_health']->map(function($h){
             if($h->status == 'Operativo') return '#10b981';
             if($h->status == 'Mantenimiento') return '#f59e0b';
             return '#ef4444';
         }))'>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataNode = document.getElementById('dashboard-analytics-data');
        if (!dataNode) return;

        const parseData = (attr) => JSON.parse(dataNode.getAttribute(attr) || '[]');

        // Configuraciones Base Dark para Chart.js
        Chart.defaults.color = '#64748b';
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.weight = 'bold';
        
        const darkChartDefaults = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: { 
                    backgroundColor: '#0f172a',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    titleFont: { size: 10, weight: '900' },
                    bodyFont: { size: 10 },
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: 'rgba(255,255,255,0.03)', drawBorder: false },
                    ticks: { font: { size: 8 }, padding: 10 }
                },
                x: { 
                    grid: { display: false },
                    ticks: { font: { size: 8 }, padding: 10 }
                }
            }
        };

        // 1. Gráfico de Volumen Semanal
        const weeklyCtx = document.getElementById('weeklyVolumeChart').getContext('2d');
        const weeklyGradient = weeklyCtx.createLinearGradient(0, 0, 0, 300);
        weeklyGradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
        weeklyGradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: parseData('data-weekly-labels'),
                datasets: [{
                    label: 'SOLICITUDES',
                    data: parseData('data-weekly-totals'),
                    borderColor: '#6366f1',
                    borderWidth: 4,
                    backgroundColor: weeklyGradient,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverHoverBackgroundColor: '#fff',
                    pointHoverBorderWidth: 4
                }]
            },
            options: darkChartDefaults
        });

        // 2. Gráfico de Estatus (Circle Hub)
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: parseData('data-status-labels'),
                datasets: [{
                    data: parseData('data-status-totals'),
                    backgroundColor: parseData('data-status-colors'),
                    borderWidth: 0,
                    hoverOffset: 15,
                    weight: 2
                }]
            },
            options: {
                ...darkChartDefaults,
                cutout: '82%',
                plugins: {
                    ...darkChartDefaults.plugins,
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 25,
                            font: { size: 8, weight: 'bold' },
                            boxHeight: 5,
                            color: '#94a3b8'
                        }
                    }
                },
                scales: { x: { display: false }, y: { display: false } }
            }
        });

        // 3. Gráfico de Salud de Inventario (Neon)
        new Chart(document.getElementById('inventoryHealthChart'), {
            type: 'doughnut',
            data: {
                labels: parseData('data-health-labels'),
                datasets: [{
                    data: parseData('data-health-totals'),
                    backgroundColor: parseData('data-health-colors'),
                    borderWidth: 0,
                    hoverOffset: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '88%',
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    });
</script>
@endsection
