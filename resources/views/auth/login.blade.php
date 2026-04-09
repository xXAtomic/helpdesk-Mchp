<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY by Atomic Dev | ACCESO SEGURO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(99, 102, 241, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 3rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 40px 60px -20px rgba(0, 0, 0, 0.1);
            animation: card-reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes card-reveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-gravity {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        .input-gravity:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-gravity {
            background: #0f172a;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gravity:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3);
        }

        .register-link {
            color: #6366f1;
            transition: all 0.2s ease;
        }

        .register-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card p-10 md:p-12 shadow-2xl">
        <!-- BRANDING -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center mb-8 transform transition-transform hover:scale-105">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-32 h-auto drop-shadow-xl">
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Gravity</h1>
            <p class="text-[0.6rem] font-black text-slate-400 uppercase tracking-[0.4em] mt-2 italic flex items-center justify-center gap-2">
                Acceso Centralizado <span class="w-1 h-1 bg-slate-300 rounded-full"></span> by Atomic Dev
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-100 rounded-2xl text-center">
                <ul class="text-[0.65rem] font-bold text-red-500 uppercase tracking-widest list-none m-0 p-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-2">Email</label>
                <input type="email" name="email" required autofocus placeholder="tu@identidad.cl"
                       class="w-full px-6 py-4 rounded-2xl input-gravity outline-none font-bold text-sm placeholder:text-slate-300">
            </div>

            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-2">Contraseña</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full px-6 py-4 rounded-2xl input-gravity outline-none font-bold text-sm placeholder:text-slate-300">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-5 rounded-2xl btn-gravity font-black text-[0.75rem] uppercase tracking-[0.3em] italic shadow-lg flex items-center justify-center gap-3">
                    Ingresar <i class="fas fa-chevron-right text-[0.6rem]"></i>
                </button>
            </div>

            <div class="text-center pt-8 border-t border-slate-50">
                <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest italic">
                    ¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="register-link ml-1">Regístrate aquí ✨</a>
                </p>
            </div>
        </form>

        <p class="text-center text-[0.5rem] font-bold text-slate-300 mt-10 uppercase tracking-[0.5em] italic">
            Atomic Dev • 2026
        </p>
    </div>
</body>
</html>


