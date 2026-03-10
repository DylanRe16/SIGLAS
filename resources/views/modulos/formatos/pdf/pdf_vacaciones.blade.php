<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de Vacaciones</title>
</head>
 <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 10pt;
        margin: 0;
        padding: 0;
    }
   /* Aseguramos que las tablas se vean pegadas */
    .table-container {
        width: 100%;
        border-collapse: collapse;
        border: 1.5pt solid #000;
        margin-bottom: -1px; /* Truco para fusionar el borde inferior con la siguiente tabla */
    }
    .table-container td, .table-container th {
        border: 0.5pt solid #000;
        padding: 4px;
        vertical-align: top;
    }
    .header-bg {
        background-color: #e0e0e0;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
    }
    .label {
        font-weight: bold;
        font-size: 10pt;
        display: block;
    }
    /* Clase específica para quitar el borde superior de la segunda tabla si deseas */
    .table-bottom {
        border-top: none;
    }
        .header-image { text-align: center; margin-bottom: 5px; }
        .header-image img { width: 100%; height: auto; }

    </style>
</head>

<body>
    <div class="header-image">
        <img src="{{ public_path('imagenes/cintillo.jpg') }}">
    </div>
<br><br>

<table class="table-container">

    <tr>
        <th colspan="4" class="header-bg" style="font-size: 12pt; padding: 8px;">Solicitud de Vacaciones</th>

        <td colspan="2"><span class="label" style="font-size: 10pt;">Fecha de Elaboración:</span>
            <span style="font-weight:normal">{{ $fecha_actual }}</span>
        </td>
    </tr>

    <tr>
        <td colspan="4">
            <span class="label">Nombre(s) y Apellido(s) del Trabajador(a):</span>
            <span>{{ $user->primer_nombre }}  {{ $user->segundo_nombre }}   {{ $user->primer_apellido }} {{ $user->segundo_apellido }}</span>
        </td>

        <td colspan="2"><span class="label">Nro. de Documento:</span> <span class="data-text">{{ number_format($user->cedula, 0, ',', '.') }}</span></td>
    </tr>

    <tr>
        <td colspan="4">
            <span class="label">Cargo o Puesto de Trabajo Que Ejerce:</span>
            <span>{{ $user->cargo }}</span>
        </td>

         <td colspan="2">
            <span class="label">Correo Electrónico del Trabajador(a)</span>
            <span>{{ $user->semail }}</span>
        </td>
    </tr>

    {{-- <tr>

    </tr> --}}

    <tr>
        <td colspan="4">
            <span class="label">Ubicación Física:</span>
            <span >{{ $user->ubicacion }}</span>
        </td>

        <td colspan="2">
            <span class="label">Cód. de Nómina:</span>
            <span >{{ $user->ncodigo_nomina }}</span>
        </td>
    </tr>

    <tr class="header-bg" style="font-size: 6.5pt;">
        <td width="16%">FECHA DE INGRESO AL MINISTERIO</td>
        <td width="16%">AÑOS DE SERVICIO EN EL MINISTERIO</td>
        <td width="16%">AÑOS DE SERVICIO EN LA APN</td>
        <td width="16%">TOTAL AÑOS EN LA APN<br>(Ministerio + APN)</td>
        <td width="16%">PERIODO(S) VACACIONAL SOLICITADO</td>
        <td width="20%">FECHA EFECTIVA DE SALIDA</td>
    </tr>

    <tr style="text-align: center; height: 25px;">
        <td>{{  \Carbon\Carbon::parse($user->fecha_ingreso)->format('d-m-Y') }}</td>
        <td>{{ $años_servicio }}</td>
        <td>{{ $años_servicio_apn }}</td>
        <td>{{ $totalservicios }}</td>
        <td>{{ $lapso_vacacional_solicitado }}</td>
        <td>{{ \Carbon\Carbon::parse($fecha_deseada)->format('d-m-Y') }}</td>
    </tr>

    <tr>
    <th colspan="6" class="header-bg">FIRMAS</th>
    </tr>

<tr style="height: 123px;">
    <td colspan="2" style="width: 33%; vertical-align: bottom; text-align: center; padding-bottom: 10px;">

        <div style="border-top: 1px solid #000; margin: 0 10px;"></div>
        <span class="label">Trabajador (a)</span>
    </td>

    <td colspan="2" style="width: 33%; vertical-align: bottom; text-align: center; padding-bottom: 10px;">

        <div style="border-top: 1px solid #000; margin: 0 10px;"></div>
        <span class="label">Jefe(a) / Supervisor(a) Inmediato</span>
    </td>

    <td colspan="1" style="width: 24%; height: 70px; vertical-align: bottom; text-align: center; padding-bottom: 10px;">
        <div style="border-top: 1px solid #000; margin: 0 10px;"></div>
        <span class="label">Director(a) Gral</span>
    </td>

    <td colspan="1" style="width: 24%; vertical-align: middle; vertical-align: bottom; text-align: center; font-size: 9pt; border: 1px solid #000;">
         Sello de la Dirección<br>General o Estadal
    </td>
</tr>

    <tr>
        <th colspan="6" class="header-bg">PARA USO DE LA OFICINA DE GESTIÓN HUMANA</th>
    </tr>

    <tr class="header-bg" style="font-size: 7pt;">
        <td>Periodo</td>
        <td>Fecha efectiva de salida</td>
        <td>Fecha efectiva de culminación</td>
        <td>Fecha efectiva de regreso</td>
        <td colspan="2">Total días hábiles a disfrutar</td>
    </tr>

    @for($i=1; $i<=4; $i++)
    <tr style="height: 15pt;">
        <td>{{ $i }})</td>
        <td></td><td></td><td></td><td colspan="2"></td>
    </tr>
    @endfor

    {{-- <tr>
        <td class="text-center">{{ $i }})</td>
        <td></td> <td></td> <td></td> <td></td>
    </tr>
    @endforeach --}}

   <tr>
        <td colspan="6"><span class="label">Observaciones:</span><br>&nbsp;</td>
    </tr>

</table>

            <table class="table-container table-bottom">
                <tr>
                    <td colspan="3" class="header-bg" style="font-size: 12px; width: 75%;">Realizado y verificado por el analista en la Oficina de Gestión Humana</td>
                    <td rowspan="6" style="width: 25%; text-align: center; vertical-align: middle;">Sello de la Oficina de<br>Gestión Humana</td>
                </tr>

                <tr>
                    <td style="width: 35%"><span class="label">Nombre(s) y Apellido(s):</span><br>&nbsp;</td>
                    <td style="width: 20%"><span class="label">Fecha:</span><br>&nbsp;</td>
                    <td style="width: 20%"><span class="label">Firma:</span><br>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="3" class="header-bg" style="font-size: 12px;">Conformado por el Jefe(a) de la División de Registro y Control</td>
                </tr>

                <tr>
                    <td><span class="label">Nombre(s) y Apellido(s):</span><br>&nbsp;</td>
                    <td><span class="label">Fecha:</span><br>&nbsp;</td>
                    <td><span class="label">Firma:</span><br>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="3" class="header-bg" style="font-size: 12px;">Conformado por el Director(a) General de la Oficina de Gestión Humana</td>
                </tr>

                <tr>
                    <td><span class="label">Nombre(s) y Apellido(s):</span><br>&nbsp;</td>
                    <td><span class="label">Fecha:</span><br>&nbsp;</td>
                    <td><span class="label">Firma:</span><br>&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="4">
                        <div style="font-size: 12px; margin-top: 5px; font-family: Arial, sans-serif;">
                            <strong>Nota:</strong><br>
                            - En caso de existir cambio del Jefe Inmediato, la fecha de salida de vacaciones deberá ser autorizada por el nuevo Jefe(a)
                        inmediato.
                        <br>
                            - Para la solicitud de vacaciones debe remitirdos (2) copias de este formulario a la Oficina de Gestión Humana, con mínimo un mes
                        antes del inicio de las mismas.
                        </div>
                    </td>
                </tr>

            </table>


</body>
</html>
