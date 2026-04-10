<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f1f5f9; padding: 40px 0; }
        .main { background: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; color: #1e293b; border-radius: 28px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .header { background: #4f46e5; padding: 45px 40px; text-align: center; }
        .content { padding: 45px 40px; }
        .footer { padding: 30px; text-align: center; font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; line-height: 1.8; }
        .button { display: inline-block; padding: 18px 36px; background-color: #0f172a; color: #ffffff !important; text-decoration: none; border-radius: 14px; font-weight: 900; font-size: 13px; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 25px; box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2); }
        .reply-card { background-color: #f8fafc; padding: 30px; border-radius: 20px; margin: 30px 0; border: 1px solid #e2e8f0; border-left: 5px solid #4f46e5; }
        h1 { margin: 0; color: #ffffff; font-size: 26px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; font-style: italic; }
        h2 { margin: 0; color: #0f172a; font-size: 20px; font-weight: 900; letter-spacing: -0.5px; }
        p { line-height: 1.7; font-size: 15px; color: #475569; margin: 15px 0; }
        .author-tag { font-size: 10px; font-weight: 900; color: #6366f1; text-transform: uppercase; letter-spacing: 2px; display: block; margin-bottom: 12px; }
        .message-body { font-size: 16px; color: #1e293b; font-style: italic; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <h1>{{ config('app.name') }} // UPDATE</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h2>Actualización en tu ticket #{{ $ticket->ticket_number }}</h2>
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
                    <strong>{{ config('app.institution_abbr') }} • SISTEMA DE GESTIÓN TI GRAVITY</strong><br>
                    No responder a este mensaje.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
