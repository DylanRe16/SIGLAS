<!DOCTYPE html>
<html>
<head>
    <title>Recibo de Pago</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .text-right { text-align: right; }
        .total-row { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h3>MINISTERIO DEL PODER POPULAR PARA EL TRABAJO</h3>
        <h4>Recibo de Pago - Quincena {{ $quincena }}, Mes {{ $mes }}</h4>
    </div>

    <p><strong>Cédula:</strong> {{ $user->cedula }} | <strong>Nombre:</strong> {{ $user->name }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Descripción Concepto</th>
                <th>Asignaciones</th>
                <th>Deducciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos as $c)
            <tr>
                <td>{{ $c->descripcion_concepto }}</td>
                <td class="text-right">{{ $c->categoria == 1 ? number_format($c->monto, 2, ',', '.') : '' }}</td>
                <td class="text-right">{{ $c->categoria == 2 ? number_format($c->monto, 2, ',', '.') : '' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td>TOTALES</td>
                <td class="text-right">{{ number_format($totalAsignas, 2, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalDeduce, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right"><strong>NETO A COBRAR:</strong></td>
                <td class="text-right"><strong>{{ number_format($totalAsignas - $totalDeduce, 2, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>