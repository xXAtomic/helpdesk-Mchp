<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY | ACCESO SEGURO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #020617;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(63, 66, 241, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(14, 165, 233, 0.1) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
            z-index: 0;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(40px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            box-shadow: 
                0 0 0 1px rgba(255, 255, 255, 0.05),
                0 40px 100px -20px rgba(0, 0, 0, 0.8);
            animation: card-reveal 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes card-reveal {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .input-gravity {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-gravity:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: #6366f1;
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.15);
            transform: scale(1.02);
        }

        .btn-gravity {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gravity::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: translateX(-100%);
            transition: 0.6s;
        }

        .btn-gravity:hover::after {
            transform: translateX(100%);
        }

        .btn-gravity:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .glow-orb {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: move 20s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(-20%, -20%); }
            to { transform: translate(20%, 20%); }
        }

        .gradient-text {
            background: linear-gradient(to bottom, #fff 20%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="glow-orb" style="top: -10%; left: -10%;"></div>
    <div class="glow-orb" style="bottom: -10%; right: -10%; animation-delay: -5s;"></div>

    <div class="login-card p-10 md:p-14 mx-4">
        <!-- BRANDING -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-[2rem] bg-indigo-500/5 border border-indigo-500/20 mb-8 shadow-2xl relative group">
                <div class="absolute inset-0 bg-indigo-500/10 rounded-[2rem] blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <span class="text-4xl relative z-10 transition-transform group-hover:scale-110">🛰️</span>
            </div>
            <h1 class="text-5xl font-black italic tracking-tighter uppercase gradient-text leading-none">Gravity</h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.6em] mt-4 opacity-70">Sistemas TI • Acceso Seguro</p>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-500/10 border border-red-500/20 rounded-3xl animate-pulse">
                <ul class="text-[0.65rem] font-bold text-red-400 uppercase tracking-widest leading-relaxed list-none m-0 p-0">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-3 italic"><i class="fas fa-shield-virus text-[0.6rem]"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-8">
            @csrf
            
            <div class="space-y-3">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.4em] ml-3">Credencial de Usuario</label>
                <div class="relative group">
                    <input type="email" name="email" required autofocus placeholder="mchp@identidad.cl"
                           class="w-full px-8 py-6 rounded-[2.5rem] input-gravity outline-none font-bold text-[0.95rem] placeholder:text-slate-800 transition-all">
                    <i class="fas fa-at absolute right-8 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-indigo-400 transition-colors"></i>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-[0.65rem] font-black text-slate-400 uppercase tracking-[0.4em] ml-3">Clave Encriptada</label>
                <div class="relative group">
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-8 py-6 rounded-[2.5rem] input-gravity outline-none font-bold text-[0.95rem] placeholder:text-slate-800 transition-all">
                    <i class="fas fa-fingerprint absolute right-8 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-indigo-400 transition-colors"></i>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-7 rounded-[2.5rem] btn-gravity text-white font-black text-[0.85rem] uppercase tracking-[0.5em] italic shadow-2xl flex items-center justify-center gap-6 group">
                    Autorizar Acceso <i class="fas fa-chevron-right text-[0.7rem] group-hover:translate-x-3 transition-transform"></i>
                </button>
            </div>

            <!-- FOOTER LINKS -->
            <div class="pt-8 flex flex-col items-center gap-8">
                <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
                
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-[0.7rem] font-black text-indigo-400 hover:text-white uppercase tracking-[0.3em] transition-all flex items-center gap-3 group italic">
                        <i class="fas fa-sparkles text-[0.6rem] group-hover:rotate-12 transition-transform"></i>
                        Vincular nueva cuenta
                    </a>
                @endif

                <p class="text-[0.55rem] font-bold text-slate-700 uppercase tracking-[0.8em] mt-2 italic">
                    Tecnología MChP • 2026
                </p>
            </div>
        </form>
    </div>
</body>
</html>

