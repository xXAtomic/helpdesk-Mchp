<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAVITY by Atomic Dev | SOLICITAR ACCESO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9;
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(99, 102, 241, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(59, 130, 246, 0.05) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 20px;
        }

        .register-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 3.5rem;
            width: 100%;
            max-width: 650px;
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 40px 60px -20px rgba(0, 0, 0, 0.1);
            animation: card-reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes card-reveal {
            from { opacity: 0; transform: scale(0.98) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
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
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gravity:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(99, 102, 241, 0.4);
            filter: brightness(1.1);
        }

        select.input-gravity {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.5rem center;
            background-size: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="register-card p-10 md:p-16 shadow-2xl">
        <!-- HEADER -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center mb-8 transform transition-transform hover:scale-105">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-32 h-auto drop-shadow-xl">
            </div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none mb-4">Nueva Cuenta</h1>
            <p class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-[0.5em] italic flex items-center justify-center gap-2">
                Registro de Funcionario
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-10 p-5 bg-red-50 border border-red-100 rounded-[2rem]">
                <ul class="text-[0.7rem] font-bold text-red-500 uppercase tracking-widest list-none m-0 p-0 space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-3 italic"><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Nombre</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Ej: Juan"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Apellido</label>
                    <input type="text" name="lastname" required value="{{ old('lastname') }}" placeholder="Ej: Pérez"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">RUT</label>
                    <input type="text" name="rut" required value="{{ old('rut') }}" placeholder="12.345.678-9"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Teléfono</label>
                    <input type="text" name="phone" required value="{{ old('phone') }}" placeholder="+56 9 ..."
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Dirección Particular</label>
                <input type="text" name="address" required value="{{ old('address') }}" placeholder="Calle, Número, Ciudad"
                       class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Correo Institucional</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="usuario@mchp.cl"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Entidad</label>
                    <select name="entity" required class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm cursor-pointer">
                        <option value="" disabled selected>Seleccione...</option>
                        <option value="IASD" {{ old('entity') == 'IASD' ? 'selected' : '' }}>IASD (Iglesia)</option>
                        <option value="FESDG" {{ old('entity') == 'FESDG' ? 'selected' : '' }}>FESDG (Fundación)</option>
                        <option value="BOTH" {{ old('entity') == 'BOTH' ? 'selected' : '' }}>Ambas Entidades</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
                <div class="space-y-2">
                    <label class="block text-[0.6rem] font-black text-slate-500 uppercase tracking-[0.3em] ml-3">Confirmar</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                           class="w-full px-7 py-5 rounded-2xl input-gravity outline-none font-bold text-sm">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-6 rounded-3xl btn-gravity font-black text-[0.85rem] uppercase tracking-[0.3em] italic shadow-2xl flex items-center justify-center gap-4 group">
                    Vincular Cuenta <i class="fas fa-user-plus text-[0.7rem] group-hover:rotate-12 transition-transform"></i>
                </button>
            </div>

            <div class="pt-8 text-center border-t border-slate-50">
                <a href="{{ route('login') }}" class="text-[0.65rem] font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest transition-colors flex items-center justify-center gap-3 italic group">
                    <i class="fas fa-arrow-left text-[0.5rem] group-hover:-translate-x-1 transition-transform"></i> Volver al Portal de Acceso
                </a>
            </div>
        </form>

        <p class="text-center text-[0.5rem] font-bold text-slate-300 mt-12 uppercase tracking-[0.6em] italic">
            {{ config('app.institution') }} • Atomic Dev
        </p>
    </div>
</body>
</html>

