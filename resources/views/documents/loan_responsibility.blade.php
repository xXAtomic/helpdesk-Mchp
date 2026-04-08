<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responsabilidad de Préstamo TI</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11pt; color: #333; line-height: 1.5; padding: 40px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 14pt; margin-bottom: 5px; text-transform: uppercase; }
        .title-box { text-align: center; margin-bottom: 25px; border: 1.5px solid #000; padding: 10px; }
        .title-box h2 { font-size: 12pt; margin: 0; text-transform: uppercase; }
        .asset-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .asset-table th, .asset-table td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 9pt; }
        .asset-table th { background-color: #f2f2f2; }
        .signature-area { margin-top: 50px; width: 100%; }
        .signature-box { width: 45%; float: left; text-align: center; }
        .signature-line { border-top: 1px solid #000; margin-bottom: 5px; }
        .cert-box { margin-top: 80px; padding: 15px; border: 1px solid #eee; background-color: #fafafa; font-size: 8pt; clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $entity_full_name }}</h1>
        <p>RUT: {{ $entity_rut }}</p>
        <p>Sede Administrativa: Los Plátanos 2341, Viña del Mar</p>
    </div>

    <div class="title-box">
        <h2>TÉRMINO</h2>
        <h2>Responsabilidad de Préstamo de los Recursos Informáticos y Comunicación de Datos</h2>
    </div>

    <div class="content">
        <p>
            Por el presente documento, yo, <strong>{{ $user->name }}</strong>, y registrado en el número de cédula/DNI <strong>{{ $user->rut ?? '___________________' }}</strong>, 
            en adelante denominado usuario, declaro para todos los fines y efectos legales que recibí, en esta fecha, de 
            <strong>{{ $entity_full_name }} {{ $entity_rut }}</strong>, con sede administrativa ubicada en la calle Los Plátanos 2341, Viña del Mar, 
            en forma de préstamo, los equipos y accesorios enumerados a continuación, como herramientas de trabajo, que se encuentran en perfecto estado de uso y conservación, 
            comprometiéndome a cumplir todos los términos y condiciones contenidos en este documento:
        </p>

        <table class="asset-table">
            <thead>
                <tr>
                    <th>Equipo / Accesorio</th>
                    <th>Número de Serie</th>
                    <th>Razón del Préstamo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->brand }} {{ $asset->model }} ({{ $asset->asset_tag }})</td>
                    <td>{{ $asset->serial_number }}</td>
                    <td>Herramienta de Trabajo TI</td>
                </tr>
                @endforeach
                @for($i = count($assets); $i < 3; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <ol>
            <li>Declaro haber recibido el equipo descrito en el Contrato de Préstamo de Recursos de TI y Comunicación de Datos.</li>
            <li>Asumo la plena responsabilidad del uso y la seguridad de los recursos mencionados durante su uso, de conformidad con el Reglamento sobre el Uso de Recursos de TI y Comunicación de Datos.</li>
            <li>Me comprometo a devolver inmediatamente el equipo y todos sus accesorios en las mismas condiciones en que los recibí, dentro de la fecha especificada en este contrato.</li>
        </ol>

        <p style="margin-top: 30px;">
            Viña del Mar, {{ now()->format('d') }} de {{ \Carbon\Carbon::now()->translatedFormat('F') }} del {{ now()->format('Y') }}
        </p>

        <div class="signature-area">
            <div class="signature-box" style="margin-right: 50px;">
                @if(isset($signature) && $signature->is_accepted)
                    <div style="height: 50px; color: #6366f1; font-weight: bold; padding-top: 15px;">ACEPTADO ELECTRÓNICAMENTE</div>
                @else
                    <div style="height: 50px;"></div>
                @endif
                <div class="signature-line"></div>
                <p><strong>{{ $user->name }}</strong></p>
                <p>Usuario Firma</p>
            </div>
            
            <div class="signature-box">
                <div style="height: 50px;"></div>
                <div class="signature-line"></div>
                <p>Responsable TI</p>
                <p>Misión Chilena del Pacífico</p>
            </div>
        </div>

        @if(isset($signature))
        <div class="cert-box">
            <strong>🔐 Certificación de Firma Digital Gravity</strong><br>
            ID Transacción: {{ $signature->signature_token }}<br>
            IP Origen: {{ $signature->ip_address }} | Fecha: {{ $signature->signed_at->format('d/m/Y H:i:s') }}
        </div>
        @endif
    </div>
</body>
</html>
