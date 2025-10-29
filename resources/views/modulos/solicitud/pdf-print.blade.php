<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boleta de Registro</title>
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      padding: 20mm;
      line-height: 1.5;
      position: relative;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .title {
      font-size: 1.2em;
      font-weight: bold;
      margin-bottom: 5mm;
    }

    .footer {
      margin-top: 10mm;
      text-align: center;
      font-size: 0.9em;
      position: relative;
      z-index: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10mm;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f0f0f0;
    }

    .fecha {
      text-align: left;

    }
  </style>
</head>
<!--  -->

<body>
  <div class="container">
    <!-- <div class="header">
          </div> -->
    <div style="text-align: right">
      @if (ucwords(strtolower($entidad->sdescripcion)) == 'Distrito Capital')
      Caracas, {{now()->translatedFormat('d \d\e F \d\e Y')}}
      @else
      {{ ucwords(strtolower($entidad->sdescripcion)) }}, {{now()->translatedFormat('d \d\e F \d\e Y')}}
      @endif
    </div>

    <div class="declaration">
      <div>{{$persona->ssexo == 'F' ? 'Estimada Cuidadana' : 'Estimado Cuidadano'}}:</div>
      <div>{{ $persona->sprimer_nombre }} {{ $persona->sprimer_apellido }}. V-{{ $persona->ndocumento }}</div>
      <div style=" text-align: justify">
          Le informamos que su atención para la solicitud de <strong>{{ $cita->tipoSolicitud->sdescripcion }}</strong>, está programada para el día
          <strong>{{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->translatedFormat('l d \d\e F \d\e Y') }}</strong>
          a las <strong>{{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->translatedFormat('h:i a') }}</strong>,
          en la <strong>Inspectoria del Trabajo "{{ $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdescripcion }}"</strong>,
          {{ $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdireccion }}, será {{$persona->ssexo == 'F' ? 'atendida ' : 'atendido '}} 
          por {{ $cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->sexo == '1' ? 'la' : 'el' }} Abg. 
          <strong>{{ trim(strtoupper($cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->primer_nombre) ?? '[nombre no encontrado]' )}}
          {{ trim(strtoupper($cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->primer_apellido)) ?? '[apellido no encontrado]'}}</strong>.
      </div>

      <div>
        <strong>Presentar copias de los siguientes recaudos, si los tiene:</strong>
      </div>

      <div>
        <ul>
          @forelse($cita->tipoSolicitud->requisitos as $requisito)
          {{-- muestra los requisitos habilitados --}}
          @if ($requisito->benabled == 1)
          <li>{{ $requisito->sdescripcion }}</li>
          @endif
          @empty
          No hay requisitos registrados para este tipo de solicitud.
          @endforelse
        </ul>
      </div>
    </div>

    {{-- <div style="text-align: center">
          Atentamente,<br>
          Ministerio del Poder Popular para el Proceso Social del Trabajo <br>
          Inspectoria del Trabajo "{{$cita->solicitudProcurador->personalRolUnidadSust->unidadSust->sdescripcion}}"
  </div>

  <p>
    <strong>
      Nota: Si usted pierde esta cita, debera realizar una nueva solicitud.
    </strong>
  </p> --}}



  <!-- @isset($cita)
            <table>
                <tr>
                    <th>RIF</th>
                    <td>{{ $cita->empresa->srif ?? 'No disponible' }}</td>
                </tr>
                <tr>
                    <th>Razón Social</th>
                    <td>{{ $cita->empresa->srazon_social ?? 'No disponible' }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ $cita->empresa->estado->sdescripcion ?? 'No disponible' }}</td>
                </tr>
                <tr>
                    <th>Municipio</th>
                    <td>{{ $cita->empresa->municipio->sdescripcion ?? 'No disponible' }}</td>
                </tr>
                <tr>
                    <th>Parroquia</th>
                    <td>{{ $cita->empresa->parroquia->sdescripcion ?? 'No disponible' }}</td>
                </tr>
            </table>
        @else
            <p>No se encontró información de la cita.</p>
        @endisset
 -->




  <!-- <div class="footer">
            <p>Ministerio del Poder Popular para el Trabajo</p>
        </div> -->
  </div>
</body>

</html>