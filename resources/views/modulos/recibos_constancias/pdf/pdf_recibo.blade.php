<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago - Ordinario</title>
    <style>
        @page { margin: 0.5cm 1.5cm 1cm 1.5cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        
        .header-image { text-align: center; margin-bottom: 10px; width: 100%; }
        .header-image img { width: 100%; height: auto; max-height: 85px; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .blue-cell { background-color: #1F497D; color: white; font-weight: bold; padding: 5px; border: 1px solid #1F497D; text-align: center; font-size: 10px; }
        .data-cell { background-color: #F2F2F2; padding: 5px; border: 1px solid #ccc; text-align: center; font-size: 10px; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #1F497D; }
        .main-table thead th { background-color: #1F497D; color: white; padding: 8px; font-size: 11px; border: 1px solid #1F497D; }
        .main-table tbody td { border: 1px solid #DCE6F1; padding: 6px; font-size: 10px; }
        .main-table tbody tr:nth-child(even) { background-color: #F9FBFF; }
        
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .total-row { background-color: #DCE6F1; font-weight: bold; }
        
        .title-main { color: #1F497D; text-align: center; margin: 10px 0; font-size: 16px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header-image">
        @if($cintillo)
            <img src="{{ $cintillo }}" alt="Cintillo">
        @endif
    </div>

    <h2 class="title-main">RECIBO DE PAGO - QUINCENA {{ $quincena }}</h2>

    <table class="header-table">
        <thead>
            <tr>
                <th class="blue-cell" style="width: 40%;">FUNCIONARIO</th>
                <th class="blue-cell" style="width: 30%;">DOCUMENTO DE IDENTIDAD</th>
                <th class="blue-cell" style="width: 30%;">ESTATUS ACTUAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell">
                    {{ $info->primer_nombre }} {{ $info->segundo_nombre }} 
                    {{ $info->primer_apellido }} {{ $info->segundo_apellido }}
                </td>
                <td class="data-cell">{{ number_format($info->personales_cedula, 0, '', '.') }}</td>
                <td class="data-cell">{{ ($info->nestatus == 1) ? 'ACTIVO' : 'EGRESADO' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="header-table">
        <thead>
            <tr>
                <th class="blue-cell" style="width: 40%;">CARGO</th>
                <th class="blue-cell" style="width: 30%;">CÓDIGO DE NÓMINA</th>
                <th class="blue-cell" style="width: 30%;">CUENTA NÓMINA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell">{{ $info->nombre_cargo ?? 'N/A' }}</td>
                <td class="data-cell">{{ $info->ncodigo_nomina ?? 'N/A' }}</td>
                <td class="data-cell">{{ $info->scuenta_nomina ?? 'S/N' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="header-table">
        <thead>
            <tr>
                <th class="blue-cell" style="width: 60%;">UBICACIÓN ADMINISTRATIVA</th>
                <th class="blue-cell" style="width: 40%;">PERIODO DE PAGO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell">{{ $info->nombre_ubicacion ?? 'NO ASIGNADA' }}</td>
                <td class="data-cell">MES: {{ $mes }} - QUINCENA: {{ $quincena }}</td>
            </tr>
        </tbody>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="text-align: left; width: 50%;">CONCEPTOS SALARIALES</th>
                <th class="text-end" style="width: 25%;">ASIGNACIONES</th>
                <th class="text-end" style="width: 25%;">DEDUCCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos as $c)
                @if($c->categoria == 1 || $c->categoria == 2)
                <tr>
                    <td>{{ $c->descripcion_concepto }}</td>
                    <td class="text-end">{{ $c->categoria == 1 ? number_format($c->monto, 2, ',', '.') : '' }}</td>
                    <td class="text-end">{{ $c->categoria == 2 ? number_format($c->monto, 2, ',', '.') : '' }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTALES SALARIALES:</td>
                <td class="text-end">{{ number_format($totalAsignas, 2, ',', '.') }}</td>
                <td class="text-end">{{ number_format($totalDeduce, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="text-end">NETO NÓMINA (SALARIAL):</td>
                <td class="text-end">{{ number_format($totalAsignas - $totalDeduce, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($totalNoSalarial > 0)
    <table class="main-table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="text-align: left; width: 50%;">CONCEPTOS NO SALARIALES</th>
                <th class="text-end" style="width: 25%;">ASIGNACIONES</th>
                <th class="text-end" style="width: 25%;">DEDUCCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos->where('categoria', 3) as $c)
            <tr>
                <td>{{ $c->descripcion_concepto }}</td>
                <td class="text-end">{{ number_format($c->monto, 2, ',', '.') }}</td>
                <td class="text-end"> - </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTAL CONCEPTOS NO SALARIALES:</td>
                <td class="text-end">{{ number_format($totalNoSalarial, 2, ',', '.') }}</td>
                <td class="text-end">0,00</td>
            </tr>
        </tfoot>
    </table>
    @endif

   
</body>
</html>