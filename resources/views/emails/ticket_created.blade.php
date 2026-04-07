<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 0; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f8fafc; padding-bottom: 60px; }
        .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; color: #1e293b; border-radius: 24px; overflow: hidden; margin-top: 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); }
        .header { background: #0f172a; padding: 40px; text-align: center; }
        .content { padding: 40px; }
        .footer { padding: 30px; text-align: center; font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }
        .button { display: inline-block; padding: 16px 32px; background-color: #4f46e5; color: #ffffff !important; text-decoration: none; border-radius: 12px; font-weight: 800; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; transition: all 0.3s; }
        .ticket-box { background-color: #f1f5f9; padding: 25px; border-radius: 16px; margin: 25px 0; border-left: 4px solid #4f46e5; }
        h1 { margin: 0; color: #ffffff; font-size: 24px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; font-style: italic; }
        p { line-height: 1.6; font-size: 15px; color: #475569; }
        .tag { font-family: monospace; font-weight: bold; color: #4f46e5; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td class="header">
                    <h1>GRAVITY // HELP DESK</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p style="font-weight: 900; color: #0f172a; font-size: 18px; margin-bottom: 10px;">¡Hola, {{ $ticket->user->name }}!</p>
                    <p>Tu solicitud ha sido registrada con éxito en nuestro sistema central. Un técnico especializado revisará los detalles a la brevedad.</p>
                    
                    <div class="ticket-box">
                        <p style="margin: 0; font-size: 11px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Número de Ticket</p>
                        <p style="margin: 5px 0 15px 0; font-size: 20px; font-weight: 900; color: #0f172a; font-family: monospace;">{{ $ticket->ticket_number }}</p>
                        
                        <p style="margin: 0; font-size: 11px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Asunto</p>
                        <p style="margin: 5px 0 0 0; font-weight: 700; color: #334155;">{{ $ticket->title }}</p>
                    </div>

                    <p>Puedes realizar el seguimiento dinámico de tu ticket ingresando a tu panel de usuario en Gravity.</p>
                    
                    <div style="text-align: center;">
                        <a href="{{ config('app.url') }}/user/tickets/{{ $ticket->id }}" class="button">Ver Mi Solicitud</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    MChP • SISTEMA DE GESTIÓN TI GRAVITY v2.5<br>
                    No responder a este correo automático.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
