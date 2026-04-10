<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY 2.0 | ACCESO SEGURO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #020617;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 20px; /* Incrementado el padding vertical para el scroll */
            position: relative;
        }

        /* Efecto de Nebulosa Táctica */
        .nebula {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            animation: nebula-float 20s infinite alternate ease-in-out;
            pointer-events: none;
        }

        @keyframes nebula-float {
            from { transform: translate(-10%, -10%) scale(1); }
            to { transform: translate(10%, 10%) scale(1.2); }
        }

        .login-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 3.5rem;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: card-reveal 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 10;
        }

        @keyframes card-reveal {
            from { opacity: 0; transform: scale(0.95) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .input-gravity {
            background: rgba(2, 6, 23, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1.25rem;
        }

        .input-gravity:focus {
            background: #020617;
            border-color: #6366f1;
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.15);
            transform: translateY(-2px);
        }

        .btn-gravity {
            background: white;
            color: #020617;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1.25rem;
        }

        .btn-gravity:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .register-link {
            color: #6366f1;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: white;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        /* Branding Glow */
        .logo-container {
            position: relative;
        }
        .logo-container::after {
            content: '';
            position: absolute;
            inset: -10px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
            z-index: -1;
            filter: blur(15px);
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="nebula" style="top: -200px; left: -200px;"></div>
    <div class="nebula" style="bottom: -200px; right: -200px; background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);"></div>

    <div class="login-card p-10 md:p-12">
        <!-- BRANDING -->
        <div class="text-center mb-10">
            <div class="logo-container inline-flex items-center justify-center mb-8 transform transition-all hover:scale-110 duration-700">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-20 h-auto drop-shadow-[0_0_20px_rgba(255,255,255,0.2)] grayscale brightness-200">
            </div>
            <h1 class="text-4xl font-black text-white tracking-widest uppercase italic leading-none drop-shadow-2xl">Gravity <span class="text-indigo-500">2.0</span></h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.8em] mt-5 italic flex items-center justify-center gap-3 leading-none pt-1">
                <i class="fas fa-shield-alt text-indigo-400"></i>
                Protocolo de Acceso
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-6 bg-rose-500/10 border border-rose-500/20 rounded-3xl text-center backdrop-blur-md">
                <ul class="text-[0.65rem] font-black text-rose-500 uppercase tracking-[0.3em] list-none m-0 p-0 italic leading-tight">
                    @foreach ($errors->all() as $error)
                        <li>ACCESO DENEGADO: CREDENCIALES INVÁLIDAS</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM TÁCTICO -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-3 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors">Identificador (Email)</label>
                <div class="relative">
                    <input type="email" name="email" required autofocus placeholder="ID_AGENTE@MCHP.CL"
                           class="w-full px-6 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                    <i class="fas fa-user-circle absolute right-6 top-1/2 -translate-y-1/2 text-slate-900"></i>
                </div>
            </div>

            <div class="space-y-3 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors">Cifrado de Acceso</label>
                <div class="relative">
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-6 py-5 rounded-2xl input-gravity outline-none font-black text-lg placeholder:text-slate-900 tracking-[0.5em]">
                    <i class="fas fa-lock absolute right-6 top-1/2 -translate-y-1/2 text-slate-900"></i>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-6 rounded-2xl btn-gravity font-black text-[0.8rem] uppercase tracking-[0.4em] italic shadow-2xl flex items-center justify-center gap-6 group">
                    EJECUTAR ENTRADA
                    <i class="fas fa-chevron-right text-[10px] group-hover:translate-x-2 transition-transform"></i>
                </button>
            </div>

            <div class="text-center pt-8 border-t border-white/5">
                <p class="text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] italic mb-3">
                    ¿Sin credenciales de acceso?
                </p>
                <a href="{{ route('register') }}" class="register-link text-[0.65rem] font-black uppercase tracking-[0.3em] italic hover:scale-105 inline-block transition-transform">
                    SOLICITAR REGISTRO DE USUARIO
                </a>
            </div>
        </form>

        <p class="text-center text-[0.5rem] font-black text-slate-800 mt-14 uppercase tracking-[1em] italic">
            ATOMIC DEV SYSTEMS • NEURAL ENGINE 2026
        </p>
    </div>

    <!-- Micro-animación de fondo -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const amount = 30;
            const x = (e.clientX / window.innerWidth - 0.5) * amount;
            const y = (e.clientY / window.innerHeight - 0.5) * amount;
            document.querySelector('.login-card').style.transform = `translate(${x}px, ${y}px)`;
        });
    </script>
</body>
</html>
