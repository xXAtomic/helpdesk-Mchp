<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY | SOLICITAR ACCESO</title>
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
            max-width: 500px;
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

    <div class="login-card p-10 md:p-14 mx-4">
        <!-- HEADER -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black italic tracking-tighter uppercase gravity-logo-text leading-none mb-4">Nueva Cuenta</h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] italic">Registro de Personal • Plataforma Gravity</p>
        </div>

        <!-- ERROR BLOCK -->
        @if ($errors->any())
            <div class="mb-8 p-5 bg-red-500/10 border border-red-500/20 rounded-2xl">
                <ul class="text-[0.65rem] font-bold text-red-500 uppercase tracking-widest leading-loose list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2 italic"><i class="fas fa-exclamation-circle text-[0.5rem]"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Nombre</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Ej: Juan"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Apellido</label>
                    <input type="text" name="lastname" required value="{{ old('lastname') }}" placeholder="Ej: Pérez"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">RUT</label>
                    <input type="text" name="rut" required value="{{ old('rut') }}" placeholder="12.345.678-9"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Teléfono</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="+56 9 ..."
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Dirección Particular</label>
                <input type="text" name="address" required value="{{ old('address') }}" placeholder="Calle, Número, Ciudad"
                       class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
            </div>

            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Correo Institucional</label>
                <div class="relative">
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="usuario@mchp.cl"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                    <i class="fas fa-envelope absolute right-7 top-1/2 -translate-y-1/2 text-slate-700"></i>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.3em] ml-2">Entidad Perteneciente</label>
                <select name="entity" required class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] appearance-none cursor-pointer">
                    <option value="" disabled selected>Seleccione Entidad</option>
                    <option value="IASD" {{ old('entity') == 'IASD' ? 'selected' : '' }}>IASD (Iglesia Adventista)</option>
                    <option value="FESDG" {{ old('entity') == 'FESDG' ? 'selected' : '' }}>FESDG (Fundación Sanders)</option>
                    <option value="BOTH" {{ old('entity') == 'BOTH' ? 'selected' : '' }}>Ambas Entidades</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.2em] ml-2">Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-600 uppercase tracking-[0.2em] ml-2">Confirmar</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full px-7 py-5 rounded-3xl input-gravity outline-none font-bold text-[0.9rem] placeholder:text-slate-800 transition-all">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-6 rounded-3xl btn-gravity text-white font-black text-[0.85rem] uppercase tracking-[0.4em] italic shadow-2xl transition-all">
                    Crear mi cuenta ✨
                </button>
            </div>

            <div class="pt-8 text-center border-t border-white/5">
                <a href="{{ route('login') }}" class="text-[0.65rem] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-colors italic">
                    ← Volver al inicio de sesión
                </a>
            </div>
        </form>

        <p class="text-center text-[0.5rem] font-bold text-slate-800 mt-10 uppercase tracking-[0.6em]">
            Soporte TI MChP • 2026
        </p>
    </div>
</body>
</html>
