<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Constancia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 20px; }
        .card-valid { border-top: 5px solid #28a745; }
        .logo-mpppst { max-width: 200px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container text-center">
        <img src="https://www.mpppst.gob.ve/mpppst/wp-content/uploads/2023/04/logo-mpppst.png" class="logo-mpppst" alt="Logo">
        
        <div class="card card-valid shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-success fs-6">✓ DOCUMENTO VÁLIDO</span>
                </div>
                <h4 class="card-title">Verificación Digital</h4>
                <hr>
                <div class="text-start">
                    <p><strong>Trabajador:</strong> {{ $nombre }}</p>
                    <p><strong>Cédula:</strong> {{ $cedula }}</p>
                    <p><strong>Cargo:</strong> {{ $cargo }}</p>
                    <p><strong>Sueldo Mensual:</strong> {{ $monto }} Bs.</p>
                    <p><strong>Fecha Emisión:</strong> {{ $fecha }}</p>
                </div>
                <div class="mt-3 small text-muted">
                    Token: <span class="text-break">{{ $token }}</span>
                </div>
            </div>
        </div>
        <p class="mt-4 text-muted small">Ministerio del Poder Popular para el Proceso Social de Trabajo</p>
    </div>
</body>
</html>