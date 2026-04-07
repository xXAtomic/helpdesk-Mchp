@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    <!-- CABECERA PREMIUM (GRAVITY STYLE) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 border-b border-gray-100 pb-10">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-slate-900 rounded-[1.5rem] flex items-center justify-center text-white text-3xl shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <span class="relative z-10 italic">G</span>
            </div>
            <div>
                <h1 class="text-4xl font-black text-slate-950 tracking-tighter uppercase italic leading-none">Gravity Insight</h1>
                <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-3 flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                    Terminal Administrativa Centralizada • MChP
                </p>
            </div>
        </div>
        <div class="mt-8 md:mt-0 flex flex-col items-end gap-2">
            <span class="text-[0.55rem] font-black text-slate-300 uppercase tracking-widest italic">System Status: Stable</span>
            <span class="inline-flex items-center px-6 py-2 bg-slate-950 rounded-xl text-[0.65rem] font-black text-indigo-400 uppercase tracking-[0.2em] italic border border-white/10 shadow-xl">
                 ADMIN_SESSION_ACTIVE // PRO
            </span>
        </div>
    </div>

    <!-- ESTADOS RÁPIDOS DINÁMICOS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-12 h-12 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Solicitudes Cruciales</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">{{ $stats['open_tickets'] }} <span class="text-indigo-600">Pendientes</span></p>
        </div>
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-12 h-12 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Capacidad Operativa</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">{{ $stats['total_equipment'] }} <span class="text-emerald-600">Activos</span></p>
        </div>
        <div class="bg-indigo-900 p-8 rounded-[2rem] shadow-2xl shadow-indigo-100 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-800 to-indigo-950 opacity-100"></div>
            <div class="relative z-10">
                <p class="text-[0.6rem] font-black text-white/50 uppercase tracking-widest mb-2 italic">Reportes Totales</p>
                <p class="text-3xl font-black text-white tracking-tighter italic uppercase leading-none">{{ $stats['total_tickets'] }} <span class="text-indigo-400">Generados</span></p>
            </div>
        </div>
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm transition-all hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-12 h-12 bg-slate-50 rounded-full group-hover:scale-150 transition-transform"></div>
            <p class="text-[0.6rem] font-black text-gray-400 uppercase tracking-widest mb-2 italic">Fuerza Laboral</p>
            <p class="text-3xl font-black text-slate-900 tracking-tighter italic uppercase leading-none">{{ $stats['total_users'] }} <span class="text-slate-400">Registros</span></p>
        </div>
    </div>

    <!-- SECCIÓN DE ANALÍTICAS VISUALES (NEW) ✨ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
        <!-- Gráfico: Volumen Semanal -->
        <div class="xl:col-span-2 bg-white p-10 rounded-[2.5rem] border border-gray-50 shadow-sm hover:shadow-xl transition-all">
            <div class="flex items-center justify-between mb-10">
                <div>
                     <span class="text-[0.6rem] font-black text-indigo-500 uppercase tracking-widest italic mb-1 block">Data Stream</span>
                     <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Volumen de Solicitudes (7D)</h3>
                </div>
                <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner">
                    <i class="fas fa-chart-line text-lg"></i>
                </div>
            </div>
            <div class="h-[300px]">
                <canvas id="weeklyVolumeChart"></canvas>
            </div>
        </div>

        <!-- Gráfico: Distribución por Estatus -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-gray-50 shadow-sm hover:shadow-xl transition-all">
            <div class="flex items-center justify-between mb-10">
                <div>
                     <span class="text-[0.6rem] font-black text-emerald-500 uppercase tracking-widest italic mb-1 block">Health Check</span>
                     <h3 class="text-2xl font-black text-slate-900 uppercase italic tracking-tighter">Distribución</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                    <i class="fas fa-chart-pie text-lg"></i>
                </div>
            </div>
            <div class="h-[300px] relative">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- TAREAS DE GESTIÓN RÁPIDA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <div class="lg:col-span-2 space-y-8">
            <h4 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em] mb-4 italic ml-2">Módulos Estratégicos</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <a href="{{ route('admin.tickets.index') }}" class="group bg-slate-950 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden transition-all hover:-translate-y-1 block">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-white text-2xl border border-white/10 mb-8 transition-transform group-hover:rotate-12">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="text-2xl font-black text-white uppercase tracking-tight italic mb-2 leading-none">Mesa de Ayuda</h3>
                        <p class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-[0.2em] leading-relaxed mb-10 italic">Atención y resolución de incidentes corporativos</p>
                        <span class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest border-b border-indigo-400/20 pb-1">Acceder a Terminal <i class="fas fa-arrow-right ml-2 text-[0.5rem]"></i></span>
                    </div>
                </a>

                <a href="{{ route('admin.inventory.index') }}" class="group bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm relative overflow-hidden transition-all hover:shadow-2xl hover:-translate-y-1 block">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full group-hover:scale-125 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 text-2xl border border-indigo-100 mb-8 transition-transform group-hover:-rotate-12">
                            <i class="fas fa-cube"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight italic mb-2 leading-none">Inventario TI</h3>
                        <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-[0.2em] leading-relaxed mb-10 italic">Control de activos y hardware asignado</p>
                        <span class="text-[0.6rem] font-black text-indigo-600 uppercase tracking-widest border-b border-indigo-100 pb-1 group-hover:border-indigo-600 transition-all">Ver Recursos <i class="fas fa-arrow-right ml-2 text-[0.5rem]"></i></span>
                    </div>
                </a>
            </div>

            <!-- REGISTROS RECIENTES -->
            <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-10">
                     <h3 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">Actividad Reciente</h3>
                     <a href="{{ route('admin.tickets.index') }}" class="text-[0.6rem] font-black text-slate-400 hover:text-indigo-600 uppercase tracking-[0.2em] transition-all">Ver Historial Completo +</a>
                </div>
                <div class="space-y-4">
                    @foreach($recentTickets as $ticket)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 bg-slate-50 hover:bg-white rounded-2xl border border-transparent hover:border-slate-100 transition-all group">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-xl shadow-sm border border-slate-100 font-black italic text-slate-300">{{ substr($ticket->ticket_number, -1) }}</div>
                                <div>
                                    <h5 class="text-sm font-black text-slate-900 uppercase italic tracking-tight">{{ $ticket->title }}</h5>
                                    <p class="text-[0.6rem] text-slate-400 font-bold uppercase tracking-widest mt-1 italic">{{ $ticket->user->name }} • {{ $ticket->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex items-center gap-4">
                                <span class="px-3 py-1 rounded-lg text-[0.55rem] font-black text-white uppercase tracking-widest italic" style="background-color: {{ $ticket->status->color }}">
                                    {{ $ticket->status->name }}
                                </span>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="p-2 text-slate-300 hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- LATERAL: SEGURIDAD & PERFORMANCE -->
        <div class="space-y-10">
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 p-10 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
                <div class="relative z-10">
                    <h3 class="text-xl font-black text-white uppercase tracking-tighter italic mb-3">Guías Técnicas</h3>
                    <p class="text-[0.65rem] font-bold text-white/60 uppercase tracking-widest leading-relaxed mb-10">Administra la base de inteligencia GravityBrain y sus manuales operativos.</p>
                    <a href="{{ route('admin.knowledge.index') }}" class="inline-block w-full bg-white text-indigo-900 py-5 rounded-[1.5rem] font-black text-[0.7rem] uppercase tracking-widest text-center hover:bg-slate-950 hover:text-white transition-all shadow-xl italic">
                        GravityKnowledge ←
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-10 rounded-[3rem] border border-gray-100 shadow-inner">
                <h4 class="text-[0.6rem] font-black text-gray-400 uppercase tracking-[0.4em] mb-10 italic">Performance Radar</h4>
                <div class="space-y-10">
                    <div>
                        <div class="flex justify-between items-end mb-3">
                            <span class="text-[0.6rem] font-black text-slate-800 uppercase italic">Tasa de Resolución</span>
                            <span class="text-lg font-black text-indigo-600 italic leading-none">{{ $stats['total_tickets'] > 0 ? round(($stats['total_tickets'] - $stats['open_tickets']) / $stats['total_tickets'] * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full transition-all duration-1000" style="width: {{ $stats['total_tickets'] > 0 ? ($stats['total_tickets'] - $stats['open_tickets']) / $stats['total_tickets'] * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center justify-between p-2 rounded-xl hover:bg-white transition-all">
                             <div>
                                 <p class="text-[0.6rem] font-black text-slate-400 uppercase italic mb-1">Administración</p>
                                 <p class="text-[0.7rem] font-black text-slate-900 uppercase">Personal TI</p>
                             </div>
                             <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-slate-300 group-hover:text-indigo-600 transition-colors">
                                 <i class="fas fa-users-cog text-[0.8rem]"></i>
                             </div>
                        </a>
                    </div>
                </div>
            </div>

            <p class="text-[0.55rem] font-black text-slate-300 text-center uppercase tracking-[0.5em] italic mt-10">
                Gravity Platform v2.5 • Atomic Dev 🚀
            </p>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // DASHBOARD ANALYTICS ENGINE ✨💎🚀
    
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = () => document.body.classList.contains('dark');
        
        const chartDefaults = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { 
                        color: isDark() ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.03)', 
                        borderDash: [5, 5] 
                    },
                    ticks: { 
                        font: { size: 9, weight: 'bold', family: 'Inter' }, 
                        color: isDark() ? '#64748b' : '#94a3b8' 
                    }
                },
                x: { 
                    grid: { display: false },
                    ticks: { 
                        font: { size: 9, weight: 'bold', family: 'Inter' }, 
                        color: isDark() ? '#64748b' : '#94a3b8' 
                    }
                }
            }
        };

        // 1. Gráfico de Volumen Semanal (Linear)
        const weeklyCtx = document.getElementById('weeklyVolumeChart').getContext('2d');
        const weeklyGradient = weeklyCtx.createLinearGradient(0, 0, 0, 300);
        weeklyGradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
        weeklyGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(weeklyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($stats['weekly_volume']->pluck('date')) !!},
                datasets: [{
                    label: 'Solicitudes',
                    data: {!! json_encode($stats['weekly_volume']->pluck('total')) !!},
                    borderColor: '#4f46e5',
                    borderWidth: 4,
                    backgroundColor: weeklyGradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 3,
                    pointHoverRadius: 8
                }]
            },
            options: chartDefaults
        });

        // 2. Gráfico de Estatus (Donut)
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($stats['by_status']->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($stats['by_status']->pluck('total')) !!},
                    backgroundColor: {!! json_encode($stats['by_status']->pluck('color')) !!},
                    borderWidth: 0,
                    hoverOffset: 15,
                    weight: 2
                }]
            },
            options: {
                ...chartDefaults,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 25,
                            font: { weight: '900', size: 9, family: 'Inter' },
                            color: '#64748b',
                            textAlign: 'center',
                            boxHeight: 6
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 10 },
                        usePointStyle: true
                    }
                },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    });
</script>
@endsection
