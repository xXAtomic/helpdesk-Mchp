<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TI Help Desk') }}</title>
    
    <!-- Fuente Inter (Estilo SaaS Premium) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- --- DEPENDENCIAS PREMIUM --- -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        :root {
            --bg-main: #f3f4f6;
            --bg-sidebar: #0f172a;
            --bg-content: #f8fafc;
            --text-main: #0f172a;
            --sidebar-active: #2563eb;
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
            align-items: center; padding: 0; border-right: 1px solid rgba(255,255,255,0.05); 
            transition: 0.3s; z-index: 50; 
        }
        
        .sidebar-brand {
            padding: 1.5rem 0; display: flex; justify-content: center;
            border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 1.5rem;
        }

        .nav-icon { 
            width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; 
            color: #94a3b8; margin-bottom: 1rem; cursor: pointer; text-decoration: none; font-size: 1.2rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
            border: none; background: transparent;
        }
        
        .nav-icon:hover { 
            background: rgba(255,255,255,0.1); color: white; transform: scale(1.1);
        }
        
        .nav-icon.active { 
            background: var(--sidebar-active); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); 
        }

        /* ÁREA DE CONTENIDO */
        .content-area { flex: 1; display: flex; flex-direction: column; background: var(--bg-content); overflow-y: auto; position: relative; transition: background-color 0.3s ease; }

        /* SCROLLBAR PERSONALIZADA */
        .content-area::-webkit-scrollbar { width: 6px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        /* TOAST NOTIFICATIONS (CYBER-BLUE) */
        .toast-container { 
            position: fixed; top: 2rem; left: 50%; transform: translateX(-50%); 
            z-index: 9999; display: flex; flex-direction: column; gap: 0.75rem; pointer-events: none;
        }
        .toast {
            background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(20px); border: 2px solid rgba(79, 70, 229, 0.4);
            color: white; padding: 1rem 2rem; border-radius: 1.5rem; font-weight: 800; font-style: italic;
            text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.75rem; pointer-events: auto;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 20px rgba(79, 70, 229, 0.2);
            animation: toast-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards, toast-out 0.5s 4.5s forwards;
            display: flex; align-items: center; gap: 0.75rem; min-width: 300px;
        }
        @keyframes toast-in { from { transform: translateY(-100px) scale(0.8); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }
        @keyframes toast-out { from { transform: translateY(0) scale(1); opacity: 1; } to { transform: translateY(-50px) scale(0.9); opacity: 0; } }
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
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/10">
                    @elseif(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg shadow-lg border border-white/10">
                    @else
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-xl border border-white/20">
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

                <!-- 📚 MANUALES -->
                @if($roleId == 1)
                    <a href="{{ route('admin.knowledge.index') }}" class="nav-icon {{ request()->routeIs('admin.knowledge.*') ? 'active' : '' }}" title="Gestión Manuales">📚</a>
                @else
                    <a href="{{ route('knowledge.index') }}" class="nav-icon {{ request()->routeIs('knowledge.*') ? 'active' : '' }}" title="Manuales">📚</a>
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
                <header class="bg-white border-b border-gray-200 py-4 px-8 flex justify-between items-center shadow-sm">
                    <h1 class="text-xl font-bold text-gray-800">{{ $header }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-bold px-2 py-1 bg-gray-100 text-gray-600 rounded-lg">
                            {{ auth()->user()->role->name ?? 'Usuario' }}
                        </span>
                        <span class="text-sm font-medium text-gray-500">{{ auth()->user()->name }}</span>
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
        <div id="bot-window" class="hidden w-[380px] md:w-[420px] bg-white rounded-[2.5rem] shadow-[0_30px_100px_-20px_rgba(0,0,0,0.5)] border border-slate-100 flex-col mb-6 overflow-hidden transition-all duration-300 transform origin-bottom-right opacity-0 scale-95" style="display: none;">
            <!-- Header Negro Gravity -->
            <div class="bg-slate-950 p-8 flex items-center justify-between relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-14 h-14 bg-indigo-600/20 rounded-2xl flex items-center justify-center text-2xl border border-indigo-500/30">
                        🧠
                    </div>
                    <div>
                        <h4 class="text-white font-black text-xl italic uppercase tracking-tighter leading-none">GravityBot</h4>
                        <div class="flex items-center gap-2 mt-3">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.5)]"></span>
                            <p class="text-[0.6rem] font-black text-indigo-400 uppercase tracking-widest italic">Inteligencia TI Activa</p>
                        </div>
                    </div>
                </div>
                <button type="button" id="bot-close" onclick="gravityBotToggle()" class="cursor-pointer w-10 h-10 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center text-slate-400 border border-white/5 transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Área de Mensajes -->
            <div id="bot-messages" class="flex-1 p-8 space-y-6 overflow-y-auto max-h-[400px] bg-slate-50/50 scroll-smooth">
                <div class="flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-[0.7rem] font-bold shadow-lg shrink-0">GB</div>
                    <div class="bg-white p-6 rounded-3xl rounded-tl-none border border-slate-100 text-sm font-medium text-slate-700 shadow-sm leading-relaxed italic">
                        ¡Hola! Soy **GravityBot**, tu asistente inteligente. <br><br>¿En qué puedo ayudarte hoy?
                    </div>
                </div>
            </div>

            <!-- Input de Texto -->
            <div class="p-8 bg-white border-t border-slate-100">
                <form id="bot-form" onsubmit="askBot(event)" class="relative group">
                    <input type="text" id="bot-input" placeholder="¿Cómo te ayudo?..." autocomplete="off"
                           class="w-full px-8 py-6 pr-16 bg-slate-50 border-2 border-transparent rounded-[1.5rem] text-slate-900 font-bold focus:bg-white focus:border-indigo-500 transition-all outline-none italic text-sm placeholder:text-slate-300">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 w-12 h-12 bg-slate-950 rounded-xl flex items-center justify-center text-indigo-400 hover:scale-110 shadow-xl group-hover:bg-indigo-600 transition-all">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Botón Lanzador -->
        <button onclick="gravityBotToggle()" id="bot-launcher" class="w-20 h-20 bg-slate-950 rounded-[2rem] flex items-center justify-center text-3xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all hover:scale-110 active:scale-90 border-4 border-indigo-600/20 group relative overflow-hidden">
            <span class="relative z-10">🧠</span>
            <div class="absolute top-2 right-2 w-4 h-4 bg-emerald-500 rounded-full border-4 border-slate-950 animate-bounce"></div>
        </button>

    </div>

    <!-- 🧠 MODAL DE BÚSQUEDA NEURAL GLOBAL -->
    <div id="global-search-modal" class="fixed inset-0 z-[2000] hidden">
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-xl" onclick="toggleGlobalSearch()"></div>
        <div class="relative max-w-2xl mx-auto mt-20 px-4">
            <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-white/20 transform transition-all scale-100">
                <div class="bg-slate-950 p-8">
                    <div class="relative group">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-indigo-400 text-lg group-hover:scale-110 transition-transform"></i>
                        <input type="text" id="global-search-input" oninput="performGlobalSearch(this.value)" 
                               placeholder="¿Qué estás buscando? (Tickets, Activos, Usuarios...)"
                               class="w-full bg-slate-900 border-2 border-slate-800 rounded-2xl py-6 pl-16 pr-8 text-white font-bold italic placeholder:text-slate-600 outline-none focus:border-indigo-500 transition-all text-lg">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 px-3 py-1 bg-slate-800 rounded-lg text-[0.6rem] font-black text-slate-500 uppercase italic border border-white/5">ESC PARA CERRAR</div>
                    </div>
                </div>
                <div id="global-search-results" class="max-h-[60vh] overflow-y-auto bg-white custom-scrollbar">
                    <!-- Resultados dinámicos -->
                </div>
                <div class="bg-slate-50 p-4 text-center border-t border-slate-100">
                    <p class="text-[0.55rem] font-black text-slate-400 uppercase tracking-widest italic leading-none">Powered by Gravity Neural Search v1.0</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- MOTOR DE BÚSQUEDA NEURAL ---
        function toggleGlobalSearch() {
            const modal = document.getElementById('global-search-modal');
            if(modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.getElementById('global-search-input').focus();
            } else {
                modal.classList.add('hidden');
            }
        }

        // Shortcut Ctrl+K
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                toggleGlobalSearch();
            }
            if (e.key === 'Escape') {
                document.getElementById('global-search-modal').classList.add('hidden');
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
                resultsContainer.innerHTML = '<div class="p-8 text-center text-slate-400 font-bold italic animate-pulse lowercase text-xs tracking-widest">procesando consulta neural...</div>';
                
                try {
                    const res = await fetch(`/admin/global-search?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="p-8 text-center text-slate-400 font-bold italic text-xs uppercase tracking-widest">Sin coincidencias en el sistema</div>';
                        return;
                    }

                    resultsContainer.innerHTML = data.map(item => `
                        <a href="${item.url}" class="flex items-center gap-6 p-6 hover:bg-slate-50 transition-all border-b border-slate-50 group first:rounded-t-3xl last:rounded-b-3xl">
                            <div class="w-12 h-12 ${item.color} rounded-2xl flex items-center justify-center text-white text-lg shadow-lg group-hover:scale-110 transition-transform">
                                <i class="${item.icon}"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="text-[0.5rem] font-black text-slate-400 uppercase tracking-widest">${item.type}</span>
                                    <span class="w-1 h-1 bg-slate-200 rounded-full"></span>
                                    <h4 class="text-sm font-black text-slate-900 uppercase italic tracking-tight">${item.title}</h4>
                                </div>
                                <p class="text-[0.6rem] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">${item.subtitle}</p>
                            </div>
                            <i class="fas fa-chevron-right text-slate-200 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all"></i>
                        </a>
                    `).join('');
                } catch (e) {
                    resultsContainer.innerHTML = '<div class="p-8 text-center text-rose-500 font-bold italic text-xs">Error en la red neuronal de búsqueda</div>';
                }
            }, 300);
        }

        function gravityBotToggle() {
            const win = document.getElementById('bot-window');
            if(!win) return;

            // Si está oculto o tiene la clase hiddes, lo mostramos
            if (win.style.display === 'none' || win.classList.contains('hidden')) {
                win.style.display = 'flex';
                win.classList.remove('hidden');
                setTimeout(() => {
                    win.classList.remove('opacity-0', 'scale-95');
                    win.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                // De lo contrario, iniciamos animación de salida
                win.classList.remove('opacity-100', 'scale-100');
                win.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    win.style.display = 'none';
                    win.classList.add('hidden');
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
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ prompt: query })
                });
                const data = await response.json();
                document.getElementById(loadingId).remove();
                
                if (data.debug) {
                    console.error('GravityBot Debug:', data.debug);
                    appendMessage('bot', data.response + '<br><small class="opacity-50">Debug: ' + data.debug + '</small>');
                } else {
                    appendMessage('bot', data.response);
                }
            } catch (error) {
                document.getElementById(loadingId).remove();
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

        // --- SISTEMA DE TOASTS ---
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'toast';
            const icon = type === 'success' ? '✅' : '⚠️';
            toast.innerHTML = `<span>${icon}</span> <span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }

        @if(session('success'))
            showToast("{{ session('success') }}");
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    </script>

</body>
</html>
