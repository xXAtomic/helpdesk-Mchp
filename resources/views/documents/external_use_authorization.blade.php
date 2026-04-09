<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Autorización de Uso Externo TI</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10pt; color: #333; line-height: 1.6; padding: 45px; text-align: justify; }
        .header { text-align: center; margin-bottom: 25px; }
        .header h1 { font-size: 13pt; margin-bottom: 5px; text-transform: uppercase; }
        .title-box { text-align: center; margin-bottom: 30px; border: 2px solid #000; padding: 15px; background-color: #f9f9f9; }
        .title-box h2 { font-size: 11pt; margin: 0; text-transform: uppercase; font-weight: bold; }
        .property-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .property-table th, .property-table td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 8.5pt; }
        .property-table th { background-color: #eee; }
        .signature-area { margin-top: 60px; width: 100%; }
        .signature-box { width: 50%; border-top: 1px solid #000; margin: 0 auto; text-align: center; padding-top: 5px; }
        .footer-cert { margin-top: 40px; font-size: 7pt; color: #777; border-top: 1px solid #eee; padding-top: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $entity_full_name }}</h1>
        <p>RUT: {{ $entity_rut }} | Los Plátanos 2342, Viña del Mar</p>
    </div>

    <div class="title-box">
        <h2>TÉRMINO</h2>
        <h2>AUTORIZACIÓN Y USO EXTERNO DE LOS RECURSOS INFORMÁTICOS Y COMUNICACIÓN DE DATOS</h2>
    </div>

    <div class="content">
        <p>
            {{ $entity_full_name }}, persona jurídica privada, inscrita en el RUT <strong>{{ $entity_rut }}</strong>, 
            y domicilio social en Los Plátanos 2342, Viña del Mar, representada por su apoderado, el Sr. 
            <strong>{{ $user->entity === 'FESDG' ? 'Iván Morales (FESDG)' : 'Iván Morales (IASD)' }}</strong>, 
            declara, a quien corresponda y especialmente para efectos de transporte y uso fuera del domicilio social, que es el legítimo propietario 
            del equipo de procesamiento electrónico de datos identificado a continuación:
        </p>


        <table class="property-table">
            <thead>
                <tr>
                    <th>Equipo / Accesorio</th>
                    <th>Factura / Fecha de Emisión</th>
                    <th>Número de Serie / Tag</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->brand }} {{ $asset->model }}</td>
                    <td>Adquirido el {{ $asset->purchased_at ? $asset->purchased_at->format('d/m/Y') : 'Ver Registro Contable' }}</td>
                    <td>S/N: {{ $asset->serial_number }} | Tag: {{ $asset->asset_tag }}</td>
                </tr>
                @endforeach
                @if($assets->isEmpty())
                <tr><td colspan="3" style="text-align: center; color: #999;">No hay equipos asignados para esta autorización</td></tr>
                @endif
            </tbody>
        </table>

        <p>
            El dispositivo/equipo antes mencionado constituye una herramienta profesional del Sr. <strong>{{ $user->name }}</strong>, 
            titular del RUT <strong>{{ $user->rut ?? '___________________' }}</strong>, con domicilio en <strong>{{ $user->address ?? '____________________________' }}</strong>, 
            empleado de esta entidad, quien está autorizado a usarlo y transportarlo en sus desplazamientos, y a usarlo en cualquier lugar fuera de las instalaciones de la entidad, 
            a su servicio, por tiempo indefinido.
        </p>

        <p>
            Siendo esta la legítima expresión de la verdad, firmo a continuación para que produzca los efectos pretendidos y declarados, en la mejor forma establecida por la ley.
        </p>

        <div style="margin-top: 40px;">
            Viña del Mar, {{ now()->format('d') }} de {{ \Carbon\Carbon::now()->translatedFormat('F') }} del {{ now()->format('Y') }}
        </div>

        <div class="signature-area">
            <div class="signature-box" style="margin-top: 50px;">
                @if(isset($signature) && $signature->is_accepted)
                    <div style="color: #6366f1; font-weight: bold; font-size: 9pt; margin-bottom: 5px;">CERTIFICADO DIGITALMENTE POR GRAVITY TIC</div>
                @endif
                <strong>REPRESENTANTE LEGAL</strong><br>
                {{ $entity_full_name }}
            </div>
        </div>

        @if(isset($signature))
        <div class="footer-cert">
            Certificación Electrónica: {{ $signature->signature_token }}<br>
            Este documento cuenta con validez legal interna otorgada por la aceptación digital del usuario {{ $user->name }} el {{ $signature->signed_at->format('d/m/Y') }}.
        </div>
        @endif
    </div>
</body>
</html>
