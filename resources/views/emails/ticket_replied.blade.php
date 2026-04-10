<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f1f5f9; padding-bottom: 60px; }
        .main { background: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; color: #1e293b; border-radius: 32px; overflow: hidden; margin-top: 40px; }
        .header { background: #4f46e5; padding: 40px; text-align: center; }
        .content { padding: 40px; }
        .footer { padding: 30px; text-align: center; font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }
        .button { display: inline-block; padding: 16px 32px; background-color: #0f172a; color: #ffffff !important; text-decoration: none; border-radius: 12px; font-weight: 800; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; }
        .reply-box { background-color: #f8fafc; padding: 30px; border-radius: 20px; margin: 25px 0; border: 1px solid #e2e8f0; position: relative; }
        h1 { margin: 0; color: #ffffff; font-size: 26px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; font-style: italic; }
        p { line-height: 1.6; font-size: 15px; color: #475569; }
        .author { font-[0.6rem] font-black uppercase text-indigo-600 tracking-widest block mb-2; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <h1>GRAVITY UPDATE</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p style="font-weight: 900; color: #0f172a; font-size: 18px; margin-bottom: 5px;">Nuevo mensaje en tu ticket #{{ $ticket->ticket_number }}</p>
                    <p>Tu solicitud ha recibido una nueva respuesta por parte de un miembro del equipo técnico.</p>
                    
                    <div class="reply-box">
                        <span style="font-[0.6rem] font-black uppercase text-indigo-600 tracking-widest block mb-2; font-size: 10px;">Enviado por: {{ $reply->user->name }}</span>
                        <div style="font-size: 15px; color: #1e293b; font-style: italic;">
                            {{ $reply->body }}
                        </div>
                    </div>

                    <p>Puedes leer la conversación completa y adjuntar archivos adicionales ingresando al portal.</p>
                    
                    <div style="text-align: center;">
                        <a href="{{ config('app.url') }}/user/tickets/{{ $ticket->id }}" class="button">Continuar Conversación</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    {{ config('app.institution_abbr') }} • SISTEMA DE GESTIÓN TI GRAVITY v2.5<br>
                    No responder a este mensaje.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
