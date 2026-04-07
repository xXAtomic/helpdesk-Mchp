<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY | ACCESO SEGURO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(37, 99, 235, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(79, 70, 229, 0.15) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 2rem 0;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: 0;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .login-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 3rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 10;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.7);
        }

        .input-gravity {
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-gravity:focus {
            background: rgba(255, 255, 255, 0.07);
            border-color: #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .btn-gravity {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gravity:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.4);
            filter: brightness(1.1);
        }

        .gravity-logo-text {
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(10px, -30px); }
        }

        .floating-orb {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            filter: blur(60px);
            animation: float 15s ease-in-out infinite;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="floating-orb" style="top: -5%; left: -5%;"></div>
    <div class="floating-orb" style="bottom: -5%; right: -5%; animation-delay: -7s;"></div>

    <div class="login-card p-10 md:p-12 mx-4">
        <!-- HEADER -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-[1.5rem] bg-indigo-500/10 border border-indigo-500/20 mb-6 shadow-inner transform -rotate-6">
                 <span class="text-3xl">🛰️</span>
            </div>
            <h1 class="text-4xl font-black italic tracking-tighter uppercase gravity-logo-text leading-none">Gravity</h1>
            <p class="text-[0.55rem] font-black text-slate-500 uppercase tracking-[0.5em] mt-3">Access Portal • 2.0</p>
        </div>

        <!-- ERROR BLOCK -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                <ul class="text-[0.65rem] font-bold text-red-500 uppercase tracking-widest leading-relaxed list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2 italic"><i class="fas fa-exclamation-circle text-[0.5rem]"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Email Address</label>
                <div class="relative group">
                    <input type="email" name="email" required autofocus placeholder="correo@mchp.cl"
                           class="w-full px-6 py-5 rounded-2xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                    <i class="fas fa-envelope absolute right-6 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-blue-500 transition-colors"></i>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Access Key</label>
                <div class="relative group">
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-6 py-5 rounded-2xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                    <i class="fas fa-lock absolute right-6 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-blue-500 transition-colors"></i>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-6 rounded-3xl btn-gravity text-white font-black text-[0.8rem] uppercase tracking-[0.4em] italic shadow-2xl transition-all flex items-center justify-center gap-4 group">
                    Ingresar <i class="fas fa-arrow-right text-[0.6rem] group-hover:translate-x-2 transition-transform"></i>
                </button>
            </div>

            <!-- EXTRA LINKS -->
            <div class="pt-6 flex flex-col items-center gap-6">
                <div class="flex items-center gap-4 w-full">
                    <div class="h-[1px] bg-white/5 flex-1"></div>
                    <span class="text-[0.5rem] font-black text-slate-700 uppercase tracking-widest">Global Support</span>
                    <div class="h-[1px] bg-white/5 flex-1"></div>
                </div>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-[0.6rem] font-black text-indigo-400 hover:text-white uppercase tracking-[0.2em] transition-all border-b border-indigo-500/20 hover:border-white pb-1 italic">
                        Solicitar cuenta ✨
                    </a>
                @endif
            </div>
        </form>

        <!-- FOOTER -->
        <p class="text-center text-[0.5rem] font-black text-slate-800 mt-10 uppercase tracking-[0.6em] italic">
            Misión Chilena del Pacífico • 2026
        </p>
    </div>
</body>
</html>
