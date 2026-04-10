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
        
        .header { background: #4f46e5; padding: 60px 40px; text-align: center; position: relative; }
        .header h1 { margin: 0; color: #ffffff; font-size: 32px; font-weight: 900; letter-spacing: -2px; text-transform: uppercase; font-style: italic; line-height: 1; }
        .header .subtitle { color: rgba(255,255,255,0.6); font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin-top: 15px; display: block; }
        
        .content { padding: 50px 50px; }
        .content h2 { margin: 0 0 20px 0; font-size: 24px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; font-style: italic; color: #0f172a; }
        
        .reply-card { background-color: #f8fafc; padding: 35px; border-radius: 30px; margin: 30px 0; border: 1px solid #e2e8f0; border-left: 6px solid #4f46e5; }
        
        .author-tag { font-size: 9px; font-weight: 900; color: #6366f1; text-transform: uppercase; letter-spacing: 2px; display: block; margin-bottom: 15px; font-style: italic; }
        .message-body { font-size: 16px; color: #0f172a; font-style: italic; font-weight: 500; line-height: 1.8; }
        
        .button { display: inline-block; padding: 20px 45px; background-color: #0f172a; color: #ffffff !important; text-decoration: none; border-radius: 18px; font-weight: 900; font-size: 12px; text-transform: uppercase; letter-spacing: 2px; font-style: italic; margin-top: 30px; box-shadow: 0 15px 30px rgba(15, 23, 42, 0.3); transition: transform 0.3s; }
        
        .footer { padding: 40px; text-align: center; font-size: 9px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 3px; line-height: 2; font-style: italic; }
        p { line-height: 1.8; font-size: 15px; color: #475569; font-weight: 500; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <h1>GRAVITY // UPDATE</h1>
                    <span class="subtitle">Notificación de Respuesta</span>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>Nuevo mensaje en ticket #{{ $ticket->ticket_number }}</h2>
                    <p>Un miembro de nuestro equipo técnico ha respondido a tu solicitud:</p>
                    
                    <div class="reply-card">
                        <span class="author-tag">ENVIADO POR {{ $reply->user->name }}</span>
                        <div class="message-body">
                            "{{ $reply->body }}"
                        </div>
                    </div>

                    <p>Puedes leer la conversación completa y adjuntar archivos adicionales ingresando al portal de soporte.</p>
                    
                    <div style="text-align: center;">
                        <a href="{{ config('app.url') }}/my-tickets/{{ $ticket->id }}" class="button">Continuar Conversación</a>
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
