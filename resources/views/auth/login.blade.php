<!DOCTYPE html>
<html lang="es">
<head>
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

</body>
</html>
