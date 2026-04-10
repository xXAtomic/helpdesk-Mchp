<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800;900&display=swap');
        
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f3f4f6; padding: 60px 0; }
        .main { background: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; color: #0f172a; border-radius: 40px; overflow: hidden; box-shadow: 0 40px 80px -20px rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.1); }
        
        .header { background: #0f172a; padding: 60px 40px; text-align: center; position: relative; }
        .header h1 { margin: 0; color: #ffffff; font-size: 32px; font-weight: 900; letter-spacing: -2px; text-transform: uppercase; font-style: italic; line-height: 1; }
        .header .subtitle { color: #6366f1; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin-top: 15px; display: block; }
        
        .content { padding: 50px 50px; }
        .content h2 { margin: 0 0 20px 0; font-size: 24px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; font-style: italic; color: #0f172a; }
        
        .card { background-color: #f8fafc; padding: 35px; border-radius: 30px; margin: 30px 0; border: 1px solid #e2e8f0; position: relative; overflow: hidden; }
        .card::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: #6366f1; }
        
        .label { font-size: 9px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; display: block; margin-bottom: 5px; }
        .value { font-size: 18px; font-weight: 900; color: #0f172a; font-style: italic; text-transform: uppercase; }
        
        .button { display: inline-block; padding: 20px 45px; background-color: #4f46e5; color: #ffffff !important; text-decoration: none; border-radius: 18px; font-weight: 900; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-style: italic; margin-top: 30px; box-shadow: 0 15px 30px rgba(79, 70, 229, 0.3); transition: transform 0.3s; }
        
        .footer { padding: 40px; text-align: center; font-size: 9px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 3px; line-height: 2; font-style: italic; }
        p { line-height: 1.8; font-size: 15px; color: #475569; font-weight: 500; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <h1>GRAVITY // DESK</h1>
                    <span class="subtitle">Soporte TI Inteligente</span>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>¡Hola, {{ $ticket->user->name }}!</h2>
                    <p>Tu solicitud ha sido procesada por nuestra red de soporte. Un técnico asignado revisará tu caso de forma prioritaria.</p>
                    
                    <div class="card">
                        <span class="label">Ticket Neural ID</span>
                        <div class="value" style="color: #4f46e5;">#{{ $ticket->ticket_number }}</div>
                        
                        <div style="margin-top: 25px;">
                            <span class="label">Asunto de Solicitud</span>
                            <div class="value" style="font-size: 15px;">{{ $ticket->title }}</div>
                        </div>
                    </div>

                    <p>Puedes realizar el seguimiento dinámico de tu ticket ingresando a tu panel de usuario en la plataforma.</p>
                    
                    <div style="text-align: center;">
                        <a href="{{ config('app.url') }}/my-tickets/{{ $ticket->id }}" class="button">Ver Mi Solicitud</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    {{ config('app.institution_abbr') }} • GRAVITY v2.5 BY ATOMIC DEV<br>
                    SISTEMA DE GESTIÓN TI • NO RESPONDER
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
