<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responsabilidad, Conciencia y Compromiso</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11pt; color: #333; line-height: 1.6; padding: 40px; text-align: justify; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 14pt; margin-bottom: 5px; text-transform: uppercase; }
        .title-box { text-align: center; margin-bottom: 30px; border: 1.5px solid #000; padding: 12px; }
        .title-box h2 { font-size: 12pt; margin: 0; text-transform: uppercase; }
        .content p { margin-bottom: 15px; }
        .signature-area { margin-top: 60px; width: 100%; border-top: 1px solid #eee; padding-top: 30px; }
        .signature-box { width: 50%; margin: 0 auto; text-align: center; }
        .signature-line { border-top: 1px solid #000; margin-bottom: 10px; width: 80%; margin-left: auto; margin-right: auto; }
        .cert-footer { margin-top: 50px; font-size: 7.5pt; color: #999; border-top: 1px dashed #ccc; padding-top: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $entity_full_name }}</h1>
        <p>RUT: {{ $entity_rut }}</p>
    </div>

    <div class="title-box">
        <h2>TÉRMINO</h2>
        <h2>RESPONSABILIDAD, CONCIENCIA Y COMPROMISO</h2>
    </div>

    <div class="content">
        <p>
            Por este instrumento, yo <strong>{{ $user->name }}</strong> titular de la identificación n.º <strong>{{ $user->rut ?? '___________________' }}</strong>, 
            domiciliado en la dirección <strong>{{ $user->address ?? '____________________________' }}</strong>, servidor de la 
            {{ $entity_full_name }}, RUT n.º {{ $entity_rut }}, con sede administrativa ubicada en Los Plátanos 2341, Viña del Mar, 
            <strong>DECLARO</strong>, como servidor-usuario de equipos informáticos puestos a mi disposición, en mis actividades, a los efectos de la ley:
        </p>

        <ol>
            <li>Que, en esta fecha, se me entregó copia del REGLAMENTO DE USO DE RECURSOS INFORMÁTICOS y de la POLÍTICA DE SEGURIDAD DE LA INFORMACIÓN adoptados por la Misión Chilena del Pacífico y, además, la dirección de correo electrónico corporativa para uso profesional hasta la fecha de mi salida de la organización.</li>
            <li>Que, habiéndolas leído, tengo pleno y completo conocimiento de todo su contenido.</li>
            <li>Que, al suscribirme a las mismas, las acepto en todos sus términos y me obligo y comprometo a cumplirlas y observarlas sin reserva ni limitación alguna.</li>
            <li>Que acepto y me someto expresamente a las sanciones penales, económicas, administrativas, laborales o eclesiásticas previstas y aplicables a cada caso, incluyendo obligarme a pagar cualquier indemnización que pueda determinarse y/o exigirse, incluso por terceros, derivada de cualquier acto u omisión de mi parte.</li>
        </ol>

        <div style="margin-top: 40px;">
            Viña del Mar, {{ now()->format('d') }} de {{ \Carbon\Carbon::now()->translatedFormat('F') }} del {{ now()->format('Y') }}
        </div>

        <div class="signature-area">
            <div class="signature-box">
                @if(isset($signature) && $signature->is_accepted)
                    <div style="color: #6366f1; font-weight: bold; font-style: italic; margin-bottom: 5px;">
                        ACEPTADO ELECTRÓNICAMENTE POR @if($user->entity === 'BOTH') AMBAS ENTIDADES @else {{ $entity_name }} @endif
                    </div>
                @endif
                <div class="signature-line"></div>
                <p><strong>{{ $user->name }}</strong></p>
                <p>Identificación: {{ $user->rut ?? 'N/A' }}</p>
            </div>
        </div>

        @if(isset($signature))
        <div class="cert-footer">
            Este documento ha sido generado por el Sistema Gravity TIC. <br>
            ID de Firma: {{ $signature->signature_token }} | Dirección IP: {{ $signature->ip_address }} | Registro: {{ $signature->signed_at->format('d/m/Y H:i:s') }}
        </div>
        @endif
    </div>
</body>
</html>
