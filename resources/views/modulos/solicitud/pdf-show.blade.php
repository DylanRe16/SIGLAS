<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cita Generada</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            /* Marca de agua repetida usando SVG como background */
        }
        .codigo {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        .qr {
            text-align: center;
            margin-top: 20px;
        }
        .url {
            font-size: 0.9rem;
            color: #0066cc;
            margin-top: 8px;
        }

        .marca-agua {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        z-index: 0;
        pointer-events: none;
    }
        .marca-agua span {
            position: absolute;
            color: rgb(230,230,230);
            font-size: 20px;
            font-family: Arial, sans-serif;
            opacity: 0.7;
            transform: rotate(-30deg);
            white-space: nowrap;
        }
        .contenido {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>

    <div class="marca-agua">
        <span style="top:10px;left:30px;">SGS</span>
        <span style="top:80px;left:120px;">SGS</span>
        <span style="top:150px;left:210px;">SGS</span>
        <span style="top:220px;left:60px;">SGS</span>
        <span style="top:300px;left:180px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <span style="top:400px;left:100px;">SGS</span>
        <!-- Puedes agregar más si quieres -->
    </div>
    <div class="contenido">
        <h2>Cita Generada</h2>
        <div class="codigo">
            <strong>Código de la cita:</strong> {{ $cita->codigo }}
        </div>
        <table>
            <tr>
                <th>Nombre</th>
                <td>{{ $cita->persona->sprimer_nombre }}</td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td>{{ $cita->persona->sprimer_apellido }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $cita->dfecha_cita ?? 'sin fecha asignada' }}</td>
            </tr>
            <tr>
                <th>Hora</th>
                <td>{{ $cita->hora ?? 'sin hora asignada' }}</td>
            </tr>
            <tr>
                <th>Motivo</th>
                <td>{{ $cita->tipoSolicitud->sdescripcion }}</td>
            </tr>
            <tr>
                <th>Empresa</th>
                <td>{{ $cita->empresa->srazon_social }}</td>
            </tr>
            <tr>
                <th>RIF</th>
                <td>{{ $cita->empresa->srif }}</td>
            </tr>
            <tr>
                <th>Estatus</th>
                <td>{{ $cita->estatus->sdescripcion ?? 'sin estatus asignado' }}</td>
            </tr>
        </table>
        <div class="qr">
            <p>Presente este código QR el día de su cita:</p>
            <img src="{{ $qr }}" alt="QR de la cita">
            <div class="url">
                <small>{{ $url }}</small>
            </div>
        </div>
    </div>
    

</body>
</html>