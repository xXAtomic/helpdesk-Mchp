<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TICKETS | ACCESO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { margin: 0; padding: 0; display: flex; min-height: 100vh; background: #020617; background-image: linear-gradient(135deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), linear-gradient(225deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), linear-gradient(45deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), linear-gradient(315deg, rgba(30, 41, 59, 0.5) 25%, transparent 25%), radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.2) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(37, 99, 235, 0.2) 0%, transparent 40%); background-size: 60px 60px, 60px 60px, 60px 60px, 60px 60px, 100% 100%, 100% 100%; background-attachment: fixed; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; text-transform: uppercase; align-items: center; justify-content: center; }
        .grid-tech { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0.15; pointer-events: none; background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px); }
        .login-card { width: 100%; max-width: 450px; padding: 4rem; background: white; border-radius: 4rem; box-shadow: 0 40px 100px rgba(0,0,0,0.6); border: 1px solid #e2e8f0; text-align: center; position: relative; z-index: 1; }
    </style>
</head>
<body>
    <div class="grid-tech"></div>
    
    <div class="login-card">
        <!-- LOGO MCHP SOPORTE -->
        <div style="margin-bottom: 4rem;">
            <h1 style="font-size: 2.3rem; font-weight: 1000; color: #0f172a; font-style: italic; letter-spacing: -1px; margin: 0;">MCHP SOPORTE</h1>
            <p style="font-size: 0.6rem; color: #64748b; font-weight: 950; letter-spacing: 4px; margin-top: 1rem;">CENTRO DE GESTIÓN TÉCNICA</p>
        </div>

        <!-- BLOQUE DE ERRORES -->
        @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 1rem; margin-bottom: 2rem; font-size: 0.8rem; text-transform: none;">
                <ul style="list-style: none; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div style="margin-bottom: 1.8rem; text-align: left;">
                <label style="font-size: 0.65rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.8rem; padding-left: 0.8rem;">CORREO CORPORATIVO</label>
                <input type="email" name="email" required autofocus style="width: 100%; padding: 1.3rem; border-radius: 1.5rem; border: 2px solid #cbd5e1; background: #f8fafc; color: #0f172a; font-weight: 900; font-size: 0.9rem; box-sizing: border-box; outline: none;">
            </div>

            <div style="margin-bottom: 2.5rem; text-align: left;">
                <label style="font-size: 0.65rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.8rem; padding-left: 0.8rem;">CONTRASEÑA DE ACCESO</label>
                <input type="password" name="password" required style="width: 100%; padding: 1.3rem; border-radius: 1.5rem; border: 2px solid #cbd5e1; background: #f8fafc; color: #0f172a; font-weight: 900; font-size: 0.9rem; box-sizing: border-box; outline: none;">
            </div>

            <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 1.4rem; border-radius: 1.8rem; font-weight: 950; font-size: 0.85rem; cursor: pointer; border: none; box-shadow: 0 15px 30px rgba(37,99,235,0.3); margin-bottom: 2.5rem; transition: transform 0.2s;">
                INGRESAR AL SISTEMA 🚀
            </button>

            <div style="display: flex; align-items: center; justify-content: center; gap: 1rem; margin-bottom: 2.2rem;">
                <div style="flex: 1; height: 1.5px; background: #e2e8f0;"></div>
                <span style="font-size: 0.6rem; color: #94a3b8; font-weight: 950; letter-spacing: 1px;">¿ERES NUEVO?</span>
                <div style="flex: 1; height: 1.5px; background: #e2e8f0;"></div>
            </div>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" style="display: block; width: 100%; background: #0f172a; color: #fbbf24; padding: 1.3rem; border-radius: 1.8rem; font-weight: 950; font-size: 0.75rem; text-decoration: none; box-sizing: border-box; border: 2px solid #0f172a; transition: all 0.2s;">
                    CREAR CUENTA NUEVA ✨
                </a>
            @endif
        </form>
    </div>
</body>
</html>
