<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA TICKETS | REGISTRO</title>
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
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0.15; pointer-events: none;
                background-image: repeating-linear-gradient(45deg, #3b82f6 0px, #3b82f6 1px, transparent 1px, transparent 20px);"></div>
    <div style="width: 100%; max-width: 500px; padding: 4rem; background: white; border-radius: 4rem; box-shadow: 0 40px 100px rgba(0,0,0,0.6); border: 1px solid #e2e8f0; text-align: center; position: relative; z-index: 1; margin: 2rem;">
        
        <div style="margin-bottom: 3rem;">
            <h1 style="font-size: 2rem; font-weight: 1000; color: #0f172a; font-style: italic; letter-spacing: -1px; margin: 0;">MCHP REGISTRO</h1>
            <p style="font-size: 0.6rem; color: #64748b; font-weight: 950; letter-spacing: 4px; margin-top: 1rem;">CREAR NUEVO PERFIL TÉCNICO</p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- NAME -->
            <div style="margin-bottom: 1.5rem; text-align: left;">
                <label style="font-size: 0.6rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.6rem; padding-left: 0.5rem;">NOMBRE COMPLETO</label>
                <input type="text" name="name" required style="width: 100%; padding: 1.1rem; border-radius: 1.2rem; border: 2px solid #cbd5e1; background: #f8fafc; font-weight: 950; box-sizing: border-box;">
            </div>
            <!-- EMAIL -->
            <div style="margin-bottom: 1.5rem; text-align: left;">
                <label style="font-size: 0.6rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.6rem; padding-left: 0.5rem;">CORREO CORPORATIVO</label>
                <input type="email" name="email" required style="width: 100%; padding: 1.1rem; border-radius: 1.2rem; border: 2px solid #cbd5e1; background: #f8fafc; font-weight: 950; box-sizing: border-box;">
            </div>
            <!-- PASSWORD -->
            <div style="margin-bottom: 1.5rem; text-align: left;">
                <label style="font-size: 0.6rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.6rem; padding-left: 0.5rem;">CONTRASEÑA</label>
                <input type="password" name="password" required style="width: 100%; padding: 1.1rem; border-radius: 1.2rem; border: 2px solid #cbd5e1; background: #f8fafc; font-weight: 950; box-sizing: border-box;">
            </div>
            <!-- CONFIRM PASSWORD -->
            <div style="margin-bottom: 2.5rem; text-align: left;">
                <label style="font-size: 0.6rem; font-weight: 950; color: #1e293b; display: block; margin-bottom: 0.6rem; padding-left: 0.5rem;">CONFIRMAR CONTRASEÑA</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 1.1rem; border-radius: 1.2rem; border: 2px solid #cbd5e1; background: #f8fafc; font-weight: 950; box-sizing: border-box;">
            </div>
            <button type="submit" style="width: 100%; background: #2563eb; color: white; padding: 1.3rem; border-radius: 1.5rem; font-weight: 950; font-size: 0.85rem; cursor: pointer; border: none; box-shadow: 0 10px 20px rgba(37,99,235,0.3); margin-bottom: 2rem;">
                FINALIZAR REGISTRO ✨
            </button>
            <a href="{{ route('login') }}" style="display: block; color: #64748b; font-weight: 950; font-size: 0.7rem; text-decoration: none;">👤 ¿YA TIENES CUENTA? LOG IN AQUÍ</a>
        </form>
    </div>
</body>
</html>
