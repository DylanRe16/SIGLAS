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
      .declaration {
        font-size: 1em;
        margin-bottom: 5mm;
        position: relative;
        z-index: 1;
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
      th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
      }
      th {
        background-color: #f0f0f0;
      }
      .text-center{
        text-align: center;
      }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">Ministerio del Poder Popular para el Proceso Social de Trabajo</div>
        </div>

        <div class="declaration">
            <h5 class="modal-title text-white" id="requisitosModalLabel">Requisitos para este trámite</h5>

            @if(isset($cita))
    <p>Estado: {{ $cita->empresa->estado->sdescripcion ?? 'No disponible' }}</p>
    <p>Municipio: {{ $cita->empresa->municipio->sdescripcion ?? 'No disponible' }}</p>
@else
    <p>No hay cita cargada.</p>
@endif

        </div>

        <div class="footer">
            <p>Ministerio del Poder Popular para el Trabajo</p>
        </div>
    </div>
</body>
</html>
