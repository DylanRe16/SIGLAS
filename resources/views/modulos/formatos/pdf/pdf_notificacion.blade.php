<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación de Ausencia</title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        border: 1.5pt ;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 0.5pt solid #000;
        padding: 4pt 6pt;
        text-align: left;
    }
    .header-section {
        background-color: #e0e0e0;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 11pt;
    }
    .label {
        font-weight: bold;
        font-size: 9pt;
    }
    .data-text {
        font-size: 10pt;
        color: #333;
    }
    /* Estilo para las firmas en la parte inferior */
    .signature-box {
        height: 150pt;
        vertical-align: top;
        text-align: center;
    }
    .signature-title {
        /* font-weight: bold; */
        margin-bottom: 80pt;
        display: block;
    }
    .footer-label {
        font-size: 8pt;
        display: block;
        margin-top: 5pt;
    }
        .header-image { text-align: center; margin-bottom: 5px; }
        .header-image img { width: 100%; height: auto; }

    .tabla-permiso{
    width: 100%;
    table-layout: fixed; /* IMPORTANTE */
}
    </style>
</head>

<body>
     <div class="header-image">
        <img src="{{ public_path('imagenes/cintillo.jpg') }}">
    </div>
<br><br>

<table class="tabla-permiso">

    <colgroup>
        <col style="width:33.33%">
        <col style="width:33.33%">
        <col style="width:33.33%">
    </colgroup>

    <tr>
        <th colspan="2" class="header-section" style="font-size: 12pt; padding: 8px;">Notificación de Ausencia</th>
        <td colspan="1"><span class="label">Fecha de Elaboración:</span><br>{{ $fecha_actual }}</td>
    </tr>

    <tr>
        <th colspan="3" class="header-section">Datos del Funcionario</th>
    </tr>

    <tr>
        <td colspan="2">
            <span class="label">Nombre(s) y Apellido(s):</span>
            <span class="data-text">{{ $user->primer_nombre }} {{ $user->segundo_nombre }} {{ $user->primer_apellido }} {{ $user->segundo_apellido }}</span>
        </td>
        <td>
            <span class="label">Nro de Documento:</span>
            <span class="data-text">{{ number_format($user->cedula, 0, ',', '.') }}</span>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <span class="label">Cargo:</span>
            <span class="data-text">{{ $user->scargo_actual_ejerce }}</span>
        </td>
        <td>
            <span class="label">Cód. de Nómina:</span>
            <span class="data-text">{{ $user->ncodigo_nomina }}</span>
        </td>
    </tr>

    <tr>
        <td colspan="3">
            <span class="label">Unidad Administrativa:</span> <br>
            <span class="data-text">{{ $user->ubicacion }}</span>
        </td>
    </tr>

    <tr>
        <td colspan="3">
            <span class="label">Ubicación Física:</span> <br>
            <span class="data-text">{{ $user->subicacion_fisica }}</span>
        </td>
    </tr>

    <tr>
        <th colspan="3" class="header-section">Especificaciones de la Ausencia</th>
    </tr>

    <tr>
        <td colspan="1" class="label header-section" style="text-align:center;">Motivo</td>
        <td class="label header-section" style="text-align:center;">Fecha Solicitada</td>
        <td class="label header-section" style="text-align:center;">Duración</td>
    </tr>

    <tr>
        <td colspan="1" style="vertical-align: top;">{{ $motivo }}</td>
        <td style="padding:0;">
            <table style="border:none; width:100%;">
                <tr>
                    <td style="border:none; border-right:0.5pt solid #000; text-align:center; font-size:10pt;">
                        Desde<br><strong>{{ $fecha_inicio }}</strong>
                    </td>
                    <td style="border:none; text-align:center; font-size:10pt;">
                        Hasta<br><strong>{{ $fecha_final }}</strong>
                    </td>
                </tr>
            </table>
        </td>
        <td style="text-align:center; font-weight:bold; font-size: 13pt;">{{ $duracion }}</td>
    </tr>

    <tr>
        <th colspan="3" class="header-section">Soporte Legal</th>
    </tr>
    <tr>
        <td colspan="3" style="min-height: 30pt;">{{ $soporte_legal }}</td>
    </tr>

    <tr>
        <td class="signature-box">
            <span class="signature-title">Solicitado</span>
            <span class="data-text">{{ $user->primer_nombre }} {{ $user->primer_apellido }}</span>
            <span class="footer-label">Funcionario</span>
        </td>
        <td class="signature-box">
            <span class="signature-title">Autorizado</span>
            <span class="data-text">{{ $nombre }}</span>
            <span class="footer-label">Jefe(a) Inmediato</span>
        </td>
        <td class="signature-box">
            <span class="signature-title">Conformado</span>
            <span class="data-text">{{ $director }}</span>
            <span class="footer-label">Director(a)</span>
        </td>
    </tr>

</table>
</div>
</body>
</html>
