<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acta de Entrega de Equipamiento TI</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: {{ isset($isPreview) ? '10pt' : '11pt' }};
            line-height: {{ isset($isPreview) ? '1.4' : '1.5' }};
            color: #333;
            margin: 0;
            padding: {{ isset($isPreview) ? '10px' : '40px' }};
            background-color: {{ isset($isPreview) ? 'white' : 'transparent' }};
        }
        .header {
            text-align: center;
            margin-bottom: {{ isset($isPreview) ? '15px' : '30px' }};
        }
        .header h1 {
            font-size: {{ isset($isPreview) ? '12pt' : '14pt' }};
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .header p {
            font-size: 9pt;
            margin: 0;
        }
        .title-box {
            text-align: center;
            margin-bottom: 20px;
            border: 1.5px solid #000;
            padding: 8px;
        }
        .title-box h2 {
            font-size: 11pt;
            margin: 0;
            text-transform: uppercase;
        }
        .content {
            text-align: justify;
        }
        .asset-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .asset-table th, .asset-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }
        .asset-table th {
            background-color: #f2f2f2;
        }
        .footer-date {
            margin-top: 30px;
        }
        .signature-area {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            width: 45%;
            float: left;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-bottom: 5px;
        }
        .compliance-note {
            font-size: 7pt;
            color: #999;
            margin-top: 40px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            clear: both;
        }
        ol { padding-left: 20px; }
        li { margin-bottom: 10px; font-size: 9pt; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $entity_name }}</h1>
        <p>RUT: {{ $entity_rut }}</p>
        <p>Sede Administrativa: Los Plátanos 2341, Viña del Mar</p>
    </div>

    <div class="title-box">
        <h2>TÉRMINO</h2>
        <h2>RECIBIMIENTO Y DEVOLUCIÓN DE LOS RECURSOS INFORMÁTICOS Y COMUNICACIÓN DE LOS DATOS</h2>
    </div>

    <div class="content">
        <p>
            Por el presente documento, yo, <strong>{{ $user->name }}</strong>, rut <strong>{{ $user->rut ?? '___________________' }}</strong>, 
            en adelante denominado usuario, declaro para todos los fines y efectos legales que recibí, en esta fecha, de la 
            <strong>{{ $entity_full_name }}</strong>, los equipos y accesorios enumerados a continuación, como herramientas de trabajo, 
            los cuales se encuentran en perfecto estado de uso y conservación, comprometiéndome a cumplir todos los términos y condiciones contenidos en este documento:
        </p>

        <table class="asset-table">
            <thead>
                <tr>
                    <th>Equipo / Accesorio</th>
                    <th>Número de Serie</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->brand }} {{ $asset->model }} ({{ $asset->asset_tag }})</td>
                    <td>{{ $asset->serial_number }}</td>
                </tr>
                @endforeach
                {{-- Espacios vacíos si hay pocos activos para mantener el formato --}}
                @for($i = count($assets); $i < 4; $i++)
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            </tbody>
        </table>

        <ol>
            <li>Declaro haber recibido el equipo descrito en el Término de Recibimiento y Devolución de Recursos de Tecnologías de la Información y Comunicación de Datos.</li>
            <li>Me comprometo a devolver de forma inmediata todos los datos propiedad de <strong>{{ $entity_full_name }}</strong>, o propiedad de los clientes de <strong>{{ $entity_full_name }}</strong>, el equipo y todos sus accesorios en el mismo estado en que los recibí, salvo el desgaste natural por el uso normal y el tiempo, en las circunstancias que se enumeran a continuación:
                <ul style="list-style-type: lower-alpha;">
                    <li>Terminación del contrato de trabajo firmado con <strong>{{ $entity_full_name }}</strong>, cualquiera sea la causa.</li>
                    <li>Transferencia de mi contrato de trabajo, según lo determine la <strong>{{ $entity_full_name }}</strong>.</li>
                    <li>A solicitud de la <strong>{{ $entity_full_name }}</strong>, para efectos de actualización periódica del parque de equipos o para cualquier otro fin necesario.</li>
                </ul>
            </li>
            <li>Me comprometo a mantener y utilizar el equipo y todos sus accesorios de conformidad con el Reglamento sobre Utilización de Recursos Informáticos y de Comunicación de Datos.</li>
            <li>El presente término se celebra con carácter irrevocable e irreversible y tendrá una vigencia indefinida, hasta que el equipo y todos sus accesorios sean devueltos a <strong>{{ $entity_full_name }}</strong>, de conformidad con el punto 2 anterior.</li>
        </ol>

        <p class="footer-date">
            FECHA DE RECIBIMIENTO: Viña del Mar, {{ now()->format('d') }} de {{ \Carbon\Carbon::now()->translatedFormat('F') }} del {{ now()->format('Y') }}
        </p>

        <div class="signature-area">
            <div class="signature-box" style="margin-right: 50px;">
                @if(isset($signature) && $signature->is_accepted)
                    <div style="height: 60px; color: #6366f1; font-style: italic; font-weight: bold; padding-top: 20px;">
                        ACEPTADO ELECTRÓNICAMENTE<br>
                        <span style="font-size: 8pt; color: #999;">UUID: {{ substr($signature->signature_token, 0, 8) }}...</span>
                    </div>
                @else
                    <div style="height: 60px;"></div>
                @endif
                <div class="signature-line"></div>
                <p><strong>{{ $user->name }}</strong></p>
                <p>Usuario / Rut: {{ $user->rut ?? '___________________' }}</p>
            </div>
            
            </div>
        </div>

        @if(isset($signature) && $signature)
        <div style="margin-top: 50px; padding: 20px; border: 1px solid #e2e8f0; background-color: #f8fafc; border-radius: 8px; clear: both;">
            <table style="width: 100%; font-size: 9pt; color: #64748b;">
                <tr>
                    <td colspan="2" style="font-weight: bold; color: #1e293b; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                        🛡️ CERTIFICACIÓN DE FIRMA DIGITAL - GRAVITY COMPLIANCE
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; width: 30%; font-weight: bold; color: #444;">ID TRANSACCIÓN:</td>
                    <td style="padding-top: 10px;">{{ $signature->signature_token }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; color: #444;">DIRECCIÓN IP:</td>
                    <td>{{ $signature->ip_address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; color: #444;">FECHA DE FIRMA:</td>
                    <td>{{ $signature->signed_at ? $signature->signed_at->format('d/m/Y H:i:s') : 'PROCESANDO' }}</td>
                </tr>
            </table>
        </div>
        @endif

        <p style="font-size: 6pt; color: #bbb; margin-top: 10px; text-align: center; font-style: italic;">
                Este documento constituye un registro legal de aceptación de términos y condiciones. Los metadatos adjuntos certifican la identidad y el origen de la firma digital realizada en el sistema Gravity.
            </p>
        </div>
    </div>

</body>
</html>
