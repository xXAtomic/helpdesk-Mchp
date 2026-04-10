<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY 2.0 | ALTA DE AGENTE</title>
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
            padding: 60px 20px;
            position: relative;
        }

        /* Efecto de Nebulosa Táctica */
        .nebula {
            position: absolute;
            width: 900px;
            height: 900px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            animation: nebula-float 25s infinite alternate ease-in-out;
            pointer-events: none;
        }

        @keyframes nebula-float {
            from { transform: translate(-15%, -15%) scale(1); opacity: 0.6; }
            to { transform: translate(15%, 15%) scale(1.3); opacity: 0.8; }
        }

        .register-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 4rem;
            width: 100%;
            max-width: 720px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.6);
            animation: card-reveal 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 10;
        }

        @keyframes card-reveal {
            from { opacity: 0; transform: scale(0.97) translateY(40px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .input-gravity {
            background: rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1.5rem;
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
            border-radius: 1.5rem;
        }

        .btn-gravity:hover {
            background: #6366f1;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        .login-link {
            color: #6366f1;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: white;
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        /* Custom Scrollbar for Dark Mode */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #334155; }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.5rem center;
            background-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="nebula" style="top: -200px; left: -200px;"></div>
    <div class="nebula" style="bottom: -100px; right: -200px; background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);"></div>

    <div class="register-card p-10 md:p-14 lg:p-16">
        <!-- HEADER -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center mb-10 transform transition-all hover:scale-110 duration-700">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-20 h-auto drop-shadow-[0_0_20px_rgba(255,255,255,0.2)] grayscale brightness-200">
            </div>
            <h1 class="text-4xl lg:text-5xl font-black text-white tracking-widest uppercase italic leading-none drop-shadow-2xl">Alta de <span class="text-indigo-500">Agente</span></h1>
            <p class="text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.8em] mt-6 italic flex items-center justify-center gap-3 leading-none pt-1">
                <i class="fas fa-id-card text-indigo-400"></i>
                Protocolo de Vinculación Operativa
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-10 p-6 bg-rose-500/10 border border-rose-500/20 rounded-3xl">
                <ul class="text-[0.65rem] font-black text-rose-500 uppercase tracking-[0.3em] list-none m-0 p-0 italic space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-3"><i class="fas fa-exclamation-triangle"></i> ERROR: {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM TÁCTICO -->
        <form method="POST" action="{{ route('register') }}" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Denominación (Nombre)</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="EJ: JUAN"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                </div>
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Identidad (Apellido)</label>
                    <input type="text" name="lastname" required value="{{ old('lastname') }}" placeholder="EJ: PÉREZ"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Registro Civil (RUT)</label>
                    <input type="text" name="rut" required value="{{ old('rut') }}" placeholder="12.345.678-9"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                </div>
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Vector de Contacto (Teléfono)</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="+56 9 ..."
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                </div>
            </div>

            <div class="space-y-3 group">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Localización Particular (Dirección)</label>
                <input type="text" name="address" required value="{{ old('address') }}" placeholder="CALLE, NÚMERO, CIUDAD"
                       class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">ID Institucional (Email)</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="USUARIO@MCHP.CL"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.75rem] placeholder:text-slate-900 uppercase italic tracking-widest">
                </div>
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-indigo-400 uppercase tracking-[0.4em] ml-2 italic leading-none pt-1">Afiliación Operativa</label>
                    <select name="entity" required class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-[0.7rem] uppercase italic tracking-widest custom-select hover:border-indigo-500/50">
                        <option value="" disabled selected>SELECCIONE...</option>
                        <option value="IASD" {{ old('entity') == 'IASD' ? 'selected' : '' }} class="bg-slate-950">IASD (Iglesia)</option>
                        <option value="FESDG" {{ old('entity') == 'FESDG' ? 'selected' : '' }} class="bg-slate-950">FESDG (Fundación)</option>
                        <option value="BOTH" {{ old('entity') == 'BOTH' ? 'selected' : '' }} class="bg-slate-950">Ambas Entidades</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Cifrado de Acceso</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-lg placeholder:text-slate-900 tracking-[0.5em]">
                </div>
                <div class="space-y-3 group">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.4em] ml-2 italic group-focus-within:text-white transition-colors leading-none">Validación de Cifrado</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full px-8 py-5 rounded-2xl input-gravity outline-none font-black text-lg placeholder:text-slate-900 tracking-[0.5em]">
                </div>
            </div>

            <div class="pt-8">
                <button type="submit" class="w-full py-8 rounded-[2rem] btn-gravity font-black text-[0.9rem] uppercase tracking-[0.5em] italic shadow-2xl flex items-center justify-center gap-6 group">
                    VINCULAR AGENTE <i class="fas fa-user-shield text-[0.8rem] group-hover:rotate-12 transition-transform"></i>
                </button>
            </div>

            <div class="pt-10 text-center border-t border-white/5">
                <a href="{{ route('login') }}" class="login-link text-[0.65rem] font-black uppercase tracking-[0.4em] italic hover:scale-105 inline-block transition-transform flex items-center justify-center gap-4 group">
                    <i class="fas fa-arrow-left text-[0.5rem] group-hover:-translate-x-2 transition-transform"></i>
                    Regresar al Portal de Acceso
                </a>
            </div>
        </form>

        <p class="text-center text-[0.5rem] font-black text-slate-800 mt-14 uppercase tracking-[0.8em] italic">
            ATOMIC DEV SYSTEMS • NEURAL ENGINE 2026
        </p>
    </div>
</body>
</html>
