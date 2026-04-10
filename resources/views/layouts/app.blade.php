<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GRAVITY by Atomic Dev | Portal TI</title>
    
    <!-- Fuente Inter (Estilo SaaS Premium) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- --- DEPENDENCIAS PREMIUM --- -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-main: #020617; /* Slate 950 */
            --bg-sidebar: #020617;
            --bg-content: #020617;
            --text-main: #f8fafc;
            --sidebar-active: #6366f1;
        }

        body { 
            margin: 0; padding: 0; font-family: 'Inter', sans-serif; 
            background-color: var(--bg-main); color: var(--text-main);
            overflow: hidden; 
            transition: background-color 0.3s ease;
        }
        
        .main-wrapper { display: flex; height: 100vh; width: 100vw; }

        /* SIDEBAR MINIMALISTA PRO (64px) */
        .sidebar { 
            width: 64px; background: var(--bg-sidebar); display: flex; flex-direction: column; 
            align-items: center; padding: 0; border-right: 1px solid rgba(255,255,255,0.03); 
            transition: 0.3s; z-index: 50; 
        }
        
        .sidebar-brand {
            padding: 1.5rem 0; display: flex; justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,0.03); margin-bottom: 1.5rem;
        }

        .nav-icon { 
            width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; 
            color: #64748b; margin-bottom: 1rem; cursor: pointer; text-decoration: none; font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
            border: none; background: transparent;
        }
        
        .nav-icon:hover { 
            background: rgba(255,255,255,0.05); color: white; transform: scale(1.1);
        }
        
        .nav-icon.active { 
            background: var(--sidebar-active); color: white; box-shadow: 0 0 15px rgba(99, 102, 241, 0.4); 
        }

        /* ÁREA DE CONTENIDO */
        .content-area { flex: 1; display: flex; flex-direction: column; background: var(--bg-content); overflow-y: auto; position: relative; transition: background-color 0.3s ease; }

        /* SCROLLBAR PERSONALIZADA */
        .content-area::-webkit-scrollbar { width: 5px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        
        /* TOAST NOTIFICATIONS */
        .toast-container { 
            position: fixed; top: 1.5rem; right: 1.5rem; 
            z-index: 10000; display: flex; flex-direction: column; gap: 0.75rem; pointer-events: none;
        }
        .toast {
            background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px); 
            color: white; padding: 1.25rem 1.75rem; border-radius: 1.5rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.65rem; pointer-events: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.8);
            animation: toast-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards, toast-out 0.4s 4.5s forwards;
            display: flex; align-items: center; gap: 1rem; min-width: 320px;
            border: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="transition-colors duration-300">
    <div id="toast-container" class="toast-container"></div>

    <div class="main-wrapper">
        <!-- BARRA LATERAL MINIMALISTA -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}" class="transition-transform hover:scale-110 active:scale-95 duration-300">
                    @if(file_exists(public_path('img/logo.png')))
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/5">
                    @elseif(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/5">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xl border border-white/10">
                            G
                        </div>
                    @endif
                </a>
            </div>

            <nav style="display: flex; flex-direction: column; align-items: center; width: 100%; flex: 1;">
                
                @php
                    $roleId = auth()->user()->role_id ?? 3;
                @endphp

                <!-- 📊 DASHBOARD -->
                @if($roleId == 1)
                    <!-- BUSCADOR NEURAL 🧠 -->
                    <button onclick="toggleGlobalSearch()" class="nav-icon group relative" title="Búsqueda Neural (Ctrl+K)">
                        <i class="fas fa-search transition-transform group-hover:rotate-12"></i>
                        <span class="absolute left-full ml-4 px-2 py-1 bg-slate-900 text-white text-[0.5rem] font-bold rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50">BUSCAR</span>
                    </button>
                    <div class="my-2 border-b border-white/5 w-8"></div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="nav-icon {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">📊</a>
                @elseif($roleId == 2)
                    <a href="{{ route('boss.dashboard') }}" class="nav-icon {{ request()->routeIs('boss.dashboard') ? 'active' : '' }}" title="Mi Dashboard">📈</a>
                    <a href="{{ route('boss.reports') }}" class="nav-icon {{ request()->routeIs('boss.reports') ? 'active' : '' }}" title="Reportes Históricos">📋</a>
                @else
                    <a href="{{ route('dashboard') }}" class="nav-icon {{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Mi Dashboard">🏠</a>
                @endif

                <!-- 🎟️ TICKETS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.tickets.index') }}" class="nav-icon {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}" title="Gestión Tickets">🎟️</a>
                @else
                    <a href="{{ route('user.tickets.index') }}" class="nav-icon {{ request()->routeIs('user.tickets.*') ? 'active' : '' }}" title="Mis Tickets">🎟️</a>
                @endif

                <!-- 🖥️ INVENTARIO -->
                @if($roleId == 1)
                    <a href="{{ route('admin.inventory.index') }}" class="nav-icon {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" title="Inventario">🖥️</a>
                @endif

                <!-- 📦 INSUMOS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.supplies.index') }}" class="nav-icon {{ request()->routeIs('admin.supplies.*') ? 'active' : '' }}" title="Insumos y Stock">📦</a>
                @endif

                <!-- 📚 MANUALES -->
                @if($roleId == 1)
                    <a href="{{ route('admin.knowledge.index') }}" class="nav-icon {{ request()->routeIs('admin.knowledge.*') ? 'active' : '' }}" title="Gestión Manuales">📚</a>
                @else
                    <a href="{{ route('knowledge.index') }}" class="nav-icon {{ request()->routeIs('knowledge.*') ? 'active' : '' }}" title="Manuales">📚</a>
                @endif

                <!-- ⚖️ COMPLIANCE -->
                @if($roleId == 1)
                    <a href="{{ route('admin.compliance.index') }}" class="nav-icon {{ request()->routeIs('admin.compliance.*') ? 'active' : '' }}" title="Legal & Firmas">⚖️</a>
                @else
                    <a href="{{ route('user.compliance.index') }}" class="nav-icon {{ request()->routeIs('user.compliance.*') ? 'active' : '' }}" title="Mis Compromisos">⚖️</a>
                @endif

                <!-- 👥 USUARIOS -->
                @if($roleId == 1)
                    <a href="{{ route('admin.users.index') }}" class="nav-icon {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" title="Usuarios">👥</a>
                @endif

                <!-- 📊 REPORTES -->
                @if($roleId == 1)
                    <a href="{{ route('admin.reports.index') }}" class="nav-icon {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" title="Reportes Estratégicos">📊</a>
                @endif

                <div class="my-4 border-b border-white/5 mx-2"></div>

                <!-- 👤 MI PERFIL -->
                <a href="{{ route('profile.edit') }}" class="nav-icon {{ request()->routeIs('profile.*') ? 'active' : '' }}" title="Mi Perfil">👤</a>

            </nav>

            <!-- SALIR -->
            <div style="margin-top: auto; padding-bottom: 2rem; width: 100%; display: flex; justify-content: center;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-icon" style="background: none; border: none; cursor: pointer;" title="Cerrar Sesión">🚪</button>
                </form>
            </div>
        </div>

    <!-- CONTENIDO PRINCIPAL -->
        <main class="content-area">
            @if(isset($header))
                <header class="bg-slate-900/40 backdrop-blur-3xl border-b border-white/5 py-5 px-8 flex justify-between items-center shadow-2xl relative z-[40]">
                    <h1 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] italic">{{ $header }}</h1>
                    
                    @if(auth()->user()->role_id == 1)
                        <div class="hidden md:flex flex-1 max-w-md mx-8">
                            <div class="relative w-full group">
                                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-indigo-500 transition-colors pointer-events-none"></i>
                                <input type="text" readonly onclick="toggleGlobalSearch()" 
                                       placeholder="¿Qué buscas hoy? (Ctrl+K)"
                                       class="w-full bg-slate-950/50 border border-white/5 rounded-2xl py-2.5 pl-12 pr-4 text-[0.65rem] font-black uppercase italic text-slate-500 focus:outline-none focus:ring-1 focus:ring-white/10 cursor-pointer hover:bg-slate-950 transition-all tracking-widest">
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-6">
                        <!-- Notificaciones de Salud IT (Solo Admin) -->
                        @if(auth()->user()->role_id == 1)
                            <div class="relative group">
                                <button class="w-10 h-10 bg-slate-950 hover:bg-slate-900 rounded-xl flex items-center justify-center text-slate-500 group-hover:text-indigo-400 transition-all border border-white/5 relative">
                                    <i class="fas fa-bell"></i>
                                    @php
                                        $criticalAssets = \App\Models\Asset::whereNotNull('next_maintenance_at')
                                            ->where('next_maintenance_at', '<', now())
                                            ->count();
                                        $lowStockSupplies = \App\Models\Supply::whereColumn('stock', '<=', 'min_stock')->count();
                                        $totalAlerts = $criticalAssets + $lowStockSupplies;
                                    @endphp
                                    @if($totalAlerts > 0)
                                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-600 text-white text-[0.6rem] font-black rounded-lg flex items-center justify-center border-2 border-slate-950 animate-bounce">
                                            {{ $totalAlerts }}
                                        </span>
                                    @endif
                                </button>
                                
                                <!-- Dropdown de Alertas Mini -->
                                <div class="absolute right-0 mt-4 w-80 bg-slate-900 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.8)] border border-white/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-[100] p-6 backdrop-blur-2xl">
                                    <h4 class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mb-4 italic">Alertas de Gravity</h4>
                                    
                                    @if($criticalAssets > 0)
                                        <div class="flex items-start gap-4 p-4 bg-rose-500/10 rounded-2xl border border-rose-500/20 mb-2">
                                            <div class="text-xl">⚠️</div>
                                            <div>
                                                <p class="text-[0.6rem] font-black text-rose-500 uppercase italic">Mantenimientos</p>
                                                <p class="text-[0.55rem] font-bold text-rose-200/60 uppercase mt-1">{{ $criticalAssets }} equipos vencidos.</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($lowStockSupplies > 0)
                                        <div class="flex items-start gap-4 p-4 bg-amber-500/10 rounded-2xl border border-amber-500/20 mb-2">
                                            <div class="text-xl">📦</div>
                                            <div>
                                                <p class="text-[0.6rem] font-black text-amber-500 uppercase italic">Stock Crítico</p>
                                                <p class="text-[0.55rem] font-bold text-amber-200/60 uppercase mt-1">{{ $lowStockSupplies }} insumos por agotarse.</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($totalAlerts == 0)
                                        <p class="text-xs font-bold text-slate-500 text-center py-4 italic">Sistemas óptimos ✨</p>
                                    @endif
                                    <a href="{{ route('admin.dashboard') }}" class="block text-center mt-4 text-[0.55rem] font-black text-indigo-400 uppercase tracking-widest hover:underline italic">Ver Centro de Control →</a>
                                </div>

                            </div>
                        @endif

                        <div class="flex items-center gap-3 pl-6 border-l border-white/5">
                            <div class="text-right hidden sm:block">
                                <p class="text-[0.65rem] font-black text-white leading-none uppercase italic">{{ auth()->user()->name }}</p>
                                <p class="text-[0.55rem] font-medium text-slate-500 uppercase tracking-widest mt-1">{{ auth()->user()->role->name ?? 'Usuario' }}</p>
                            </div>
                            <div class="w-10 h-10 bg-slate-900 border border-white/5 rounded-xl flex items-center justify-center text-indigo-400 font-black text-sm shadow-lg overflow-hidden">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </header>
            @endif

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- 🤖 GRAVITYBOT: ASISTENTE DE IA GLOBAL ✨ -->
    <div id="gravity-bot" class="fixed bottom-10 right-10 z-[1000] flex flex-col items-end">
        
        <!-- Ventana de Chat (Oculta por defecto) -->
        <div id="bot-window" class="hidden w-[380px] md:w-[420px] bg-slate-900/90 backdrop-blur-3xl rounded-[2.5rem] shadow-[0_30px_100px_-20px_rgba(0,0,0,0.8)] border border-white/10 flex-col mb-6 overflow-hidden transition-all duration-300 transform origin-bottom-right opacity-0 scale-95" style="display: none;">
            <!-- Header Negro Gravity -->
            <div class="bg-slate-950 p-8 flex items-center justify-between relative overflow-hidden border-b border-white/5">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-14 h-14 bg-indigo-600/20 rounded-2xl flex items-center justify-center text-2xl border border-indigo-500/30 shadow-inner">
                        🧠
                    </div>
                    <div>
                        <h4 class="text-white font-black text-xl italic uppercase tracking-tighter leading-none">GravityBot</h4>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic leading-none">AI_CORE_ACTIVE</p>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="handleGravityBot(event)" class="group cursor-pointer w-10 h-10 bg-white/5 hover:bg-rose-500/20 rounded-xl flex items-center justify-center text-slate-500 border border-white/10 transition-all duration-300 relative z-[1001] pointer-events-auto">
                    <i class="fas fa-times group-hover:rotate-90 transition-transform"></i>
                </button>
            </div>

            <!-- Área de Mensajes -->
            <div id="bot-messages" class="flex-1 p-8 space-y-6 overflow-y-auto max-h-[400px] bg-slate-950/40 scroll-smooth custom-scrollbar">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-[0.7rem] font-bold shadow-lg shadow-indigo-500/20 shrink-0">GB</div>
                    <div class="bg-slate-900/80 p-6 rounded-3xl rounded-tl-none border border-white/5 text-[0.75rem] font-black text-slate-300 shadow-sm leading-relaxed italic uppercase tracking-wide">
                        SISTEMA INICIADO: Soy **GravityBot**. <br><br>¿En qué puedo asistirte en este nodo administrativo?
                    </div>
                </div>
            </div>

            <!-- Input de Texto -->
            <div class="p-8 bg-slate-950 border-t border-white/5">
                <form id="bot-form" onsubmit="askBot(event)" class="relative group">
                    <input type="text" id="bot-input" placeholder="INGRESAR COMANDO..." autocomplete="off"
                           class="w-full px-8 py-6 pr-16 bg-slate-900 border border-white/5 rounded-[1.5rem] text-white font-black italic focus:border-indigo-500/50 transition-all outline-none text-[0.7rem] placeholder:text-slate-700 tracking-widest shadow-inner">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white hover:scale-110 shadow-xl shadow-indigo-500/20 transition-all">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Botón Lanzador -->
        <button onclick="handleGravityBot(event)" id="bot-launcher" class="w-20 h-20 bg-slate-950 rounded-[2rem] flex items-center justify-center text-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all hover:scale-110 active:scale-90 border-4 border-indigo-600/20 group relative overflow-hidden">
            <span class="relative z-10">🧠</span>
            <div class="absolute top-2 right-2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-slate-950 animate-bounce"></div>
        </button>

    </div>

    <!-- 🧠 MODAL DE BÚSQUEDA NEURAL GLOBAL -->
    <div id="global-search-modal" class="fixed inset-0 z-[2000] hidden">
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-2xl" onclick="toggleGlobalSearch()"></div>
        <div class="relative max-w-2xl mx-auto mt-20 px-4">
            <div class="bg-slate-900/80 backdrop-blur-3xl rounded-[3rem] shadow-[0_0_100px_rgba(0,0,0,0.8)] overflow-hidden border border-white/10 transform transition-all scale-100">
                <div class="bg-slate-950 p-8 border-b border-white/5">
                    <div class="relative group">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-indigo-500 text-lg group-focus-within:scale-110 transition-transform"></i>
                        <input type="text" id="global-search-input" oninput="performGlobalSearch(this.value)" 
                               placeholder="PROCESAR CONSULTA (TICKETS, ACTIVOS, USUARIOS...)"
                               class="w-full bg-slate-900/50 border-2 border-white/5 rounded-2xl py-6 pl-16 pr-8 text-white font-black italic shadow-inner placeholder:text-slate-700 outline-none focus:border-indigo-500/50 transition-all text-sm uppercase tracking-widest">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 px-3 py-1 bg-slate-950 rounded-lg text-[0.5rem] font-black text-slate-600 uppercase italic border border-white/5 tracking-tighter">ESC_CLOSE</div>
                    </div>
                </div>
                <div id="global-search-results" class="max-h-[60vh] overflow-y-auto bg-transparent custom-scrollbar">
                    <!-- Resultados dinámicos -->
                </div>
                <div class="bg-slate-950 p-6 text-center border-t border-white/5">
                    <p class="text-[0.55rem] font-black text-slate-600 uppercase tracking-[0.5em] italic leading-none">Gravity Neural Interface • Core v4.0</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- MOTOR DE BÚSQUEDA NEURAL ---
        function toggleGlobalSearch() {
            const modal = document.getElementById('global-search-modal');
            if(modal && modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.getElementById('global-search-input').focus();
            } else if(modal) {
                modal.classList.add('hidden');
            }
        }

        // Shortcut Ctrl+K
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.key === 'Control') && e.key === 'k') {
                e.preventDefault();
                toggleGlobalSearch();
            }
            if (e.key === 'Escape') {
                const modal = document.getElementById('global-search-modal');
                if(modal) modal.classList.add('hidden');
            }
        });

        let searchTimeout;
        async function performGlobalSearch(q) {
            const resultsContainer = document.getElementById('global-search-results');
            if (q.length < 2) {
                resultsContainer.innerHTML = '';
                return;
            }

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(async () => {
                resultsContainer.innerHTML = '<div class="p-8 text-center text-slate-500 font-black italic animate-pulse uppercase text-[0.6rem] tracking-widest">PROCESANDO_CONSULTA...</div>';
                
                try {
                    const res = await fetch(`/admin/global-search?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="p-8 text-center text-slate-700 font-black italic text-[0.6rem] uppercase tracking-widest">SIN_COINCIDENCIAS_EN_EL_SISTEMA</div>';
                        return;
                    }

                    resultsContainer.innerHTML = data.map(item => `
                        <a href="${item.url}" class="flex items-center gap-6 p-6 hover:bg-white/[0.03] transition-all border-b border-white/5 group">
                            <div class="w-12 h-12 ${item.color} rounded-2xl flex items-center justify-center text-white text-lg shadow-lg group-hover:scale-110 transition-transform shadow-indigo-500/20">
                                <i class="${item.icon}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="text-[0.5rem] font-black text-slate-600 uppercase tracking-widest">${item.type}</span>
                                    <span class="w-1.5 h-1.5 bg-slate-800 rounded-full"></span>
                                    <h4 class="text-sm font-black text-white uppercase italic tracking-tight group-hover:text-indigo-400 transition-all">${item.title}</h4>
                                </div>
                                <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-widest mt-1.5 italic">${item.subtitle}</p>
                            </div>
                            <i class="fas fa-chevron-right text-slate-800 group-hover:text-indigo-500 group-hover:translate-x-2 transition-all"></i>
                        </a>
                    `).join('');
                } catch (e) {
                    resultsContainer.innerHTML = '<div class="p-8 text-center text-rose-500 font-black italic text-[0.6rem] uppercase">ERROR_EN_LA_RED_NEURONAL</div>';
                }
            }, 300);
        }

        window.handleGravityBot = function(e) {
            if(e) { e.preventDefault(); }
            const win = document.getElementById('bot-window');
            if(!win) return;

            const isHidden = win.classList.contains('hidden');

            if (isHidden) {
                win.classList.remove('hidden');
                win.style.display = 'flex';
                setTimeout(() => {
                    win.classList.remove('opacity-0', 'scale-95');
                    win.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                win.classList.remove('opacity-100', 'scale-100');
                win.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    win.classList.add('hidden');
                    win.style.display = 'none';
                }, 300);
            }
        }

        async function askBot(e) {
            e.preventDefault();
            const input = document.getElementById('bot-input');
            const container = document.getElementById('bot-messages');
            const query = input.value.trim();
            if (!query) return;

            input.disabled = true;
            appendMessage('user', query);
            input.value = '';

            const loadingId = 'loading-' + Date.now();
            appendMessage('bot', '...', loadingId);

            try {
                const response = await fetch('/gravity-bot/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ prompt: query })
                });
                const data = await response.json();
                const loadingEl = document.getElementById(loadingId);
                if(loadingEl) loadingEl.remove();
                
                appendMessage('bot', data.response);
            } catch (error) {
                const loadingEl = document.getElementById(loadingId);
                if(loadingEl) loadingEl.remove();
                appendMessage('bot', 'Error al conectar con la IA.');
            } finally {
                input.disabled = false;
                input.focus();
            }
        }

        function appendMessage(type, text, id = null) {
            const container = document.getElementById('bot-messages');
            const div = document.createElement('div');
            div.className = 'flex gap-4 ' + (type === 'user' ? 'flex-row-reverse' : '');
            if (id) div.id = id;
            
            const iconBg = type === 'user' ? 'bg-slate-200 text-slate-500' : 'bg-indigo-600 text-white';
            const bubbleBg = type === 'user' ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-slate-700 rounded-tl-none border border-slate-100 shadow-sm';

            div.innerHTML = `
                <div class="w-10 h-10 rounded-xl ${iconBg} flex items-center justify-center text-[0.7rem] font-black shrink-0">${type === 'user' ? '👤' : 'GB'}</div>
                <div class="${bubbleBg} p-6 rounded-3xl text-sm leading-relaxed">${text}</div>
            `;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        // --- SISTEMA DE TOASTS DINÁMICOS ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if(!container) return;

            const toast = document.createElement('div');
            toast.className = `toast \${type}`;
            
            const icons = { success: 'fa-check-circle', error: 'fa-exclamation-triangle', warning: 'fa-bell', info: 'fa-info-circle' };
            const colors = { success: 'text-emerald-400', error: 'text-rose-400', warning: 'text-amber-400', info: 'text-indigo-400' };

            toast.innerHTML = `
                <div class="toast-icon \${colors[type]} bg-white/5">
                    <i class="fas \${icons[type]}"></i>
                </div>
                <div class="flex-1">
                    <p class="leading-tight">\${message}</p>
                </div>
            `;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }
    <meta name="flash-success" content="{{ session('success') }}">
    <meta name="flash-error" content="{{ session('error') }}">
    <script>
        window.addEventListener('load', () => {
            const successMsg = document.querySelector('meta[name="flash-success"]')?.content;
            const errorMsg = document.querySelector('meta[name="flash-error"]')?.content;
            if (successMsg) showToast(successMsg);
            if (errorMsg) showToast(errorMsg, 'error');
        });
    </script>


</body>
</html>
