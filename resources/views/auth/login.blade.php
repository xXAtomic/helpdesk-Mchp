<!DOCTYPE html>
<html lang="es">
<head>
<<<<<<< HEAD
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión | TI Help Desk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header Decorativo -->
        <div class="h-32 bg-blue-600 flex flex-col justify-center items-center text-white p-6 relative overflow-hidden">
            <!-- Partículas UI (fondo abstracto simple) -->
            <div class="absolute -right-4 -top-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
            <div class="absolute -left-10 -bottom-10 w-40 h-40 rounded-full bg-white opacity-10"></div>
            
            <h1 class="text-3xl font-extrabold tracking-widest z-10">GLPI<span class="text-blue-200">TICK</span></h1>
            <p class="text-blue-100 text-sm mt-1 z-10">Identifícate para continuar</p>
        </div>

        <!-- Formulario -->
        <form method="POST" action="/login" class="p-8">
            @csrf
            
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico</label>
                <input type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    placeholder="tecnico@empresa.com">
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center space-x-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span>Recordarme</span>
                </label>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">¿Olvidaste tu clave?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow transition transform hover:-translate-y-0.5">
                Ingresar al Sistema
            </button>
        </form>

        <div class="px-8 py-4 bg-gray-50 border-t text-center text-xs text-gray-500">
            Plataforma Profesional de Gestión TI &copy; 2026
        </div>
    </div>

=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TICKETS | ACCESO</title>
</head>
<body style="margin: 0; padding: 0; display: flex; min-height: 100vh; 
             background: #020617; 
             background-image: 
                linear-gradient(135deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), 
                linear-gradient(225deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), 
                linear-gradient(45deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), 
                linear-gradient(315deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%),
                radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.2) 0%, transparent 40%);
             background-size: 60px 60px, 60px 60px, 60px 60px, 60px 60px, 100% 100%, 100% 100%;
             background-attachment: fixed;
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
             text-transform: uppercase; 
             align-items: center; 
             justify-content: center;">
    <!-- CAPA DE LÍNEAS TECH DE FONDO -->
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0.15; pointer-events: none;
                background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px);"></div>
    <div style="width: 100%; max-width: 450px; padding: 4rem; background: white; border-radius: 4rem; box-shadow: 0 40px 100px rgba(0,0,0,0.6); border: 1px solid #e2e8f0; text-align: center; position: relative; z-index: 1;">
        
        <!-- LOGO MCHP SOPORTE -->
        <div style="margin-bottom: 4rem;">
            <h1 style="font-size: 2.3rem; font-weight: 1000; color: #0f172a; font-style: italic; letter-spacing: -1px; margin: 0;">MCHP SOPORTE</h1>
            <p style="font-size: 0.6rem; color: #64748b; font-weight: 950; letter-spacing: 4px; margin-top: 1rem;">CENTRO DE GESTIÓN TÉCNICA</p>
        </div>

         <!-- BLOQUE DE ERRORES (Añade esto) -->
        @if ($errors->any())
       <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 1rem; margin-bottom: 2rem; font-size: 0.8rem; text-transform: none;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                  @endforeach
              </ul>
    	   </div>
	@endif


        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- EMAIL -->
            <div style="margin-bottom: 1.8rem; text-align: left;">
                <label style="font-size: 0.65rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.8rem; padding-left: 0.8rem;">CORREO CORPORATIVO</label>
                <input type="email" name="email" required autofocus style="width: 100%; padding: 1.3rem; border-radius: 1.5rem; border: 2px solid #cbd5e1; background: #f8fafc; color: #0f172a; font-weight: 900; font-size: 0.9rem; box-sizing: border-box; outline: none;">
            </div>
            <!-- PASSWORD -->
            <div style="margin-bottom: 2.5rem; text-align: left;">
                <label style="font-size: 0.65rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.8rem; padding-left: 0.8rem;">CONTRASEÑA DE ACCESO</label>
                <input type="password" name="password" required style="width: 100%; padding: 1.3rem; border-radius: 1.5rem; border: 2px solid #cbd5e1; background: #f8fafc; color: #0f172a; font-weight: 900; font-size: 0.9rem; box-sizing: border-box; outline: none;">
            </div>
            <!-- BOTÓN LOG IN -->
            <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 1.4rem; border-radius: 1.8rem; font-weight: 950; font-size: 0.85rem; cursor: pointer; border: none; box-shadow: 0 15px 30px rgba(37,99,235,0.3); margin-bottom: 2.5rem; transition: transform 0.2s;">
                INGRESAR AL SISTEMA 🚀
            </button>
            <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 2.2rem;">
                <div style="flex: 1; height: 1.5px; background: #e2e8f0;"></div>
                <span style="font-size: 0.6rem; color: #94a3b8; font-weight: 950; letter-spacing: 1px;">¿ERES NUEVO?</span>
                <div style="flex: 1; height: 1.5px; background: #e2e8f0;"></div>
            </div>
            <!-- BOTÓN REGISTRARSE -->
            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="display: block; width: 100%; background: #0f172a; color: #fbbf24; padding: 1.3rem; border-radius: 1.8rem; font-weight: 950; font-size: 0.75rem; text-decoration: none; box-sizing: border-box; border: 2px solid #0f172a; transition: all 0.2s;">
                    CREAR CUENTA NUEVA ✨
                </a>
            @endif
        </form>
    </div>
>>>>>>> origin/servidor-maraton-ayer
</body>
</html>
