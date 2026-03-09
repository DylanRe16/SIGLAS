<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago - Especial</title>
    <style>
        @page {
            margin: 0.5cm 1.5cm 1cm 1.5cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header-image {
            text-align: center;
            margin-bottom: 10px;
            width: 100%;
        }

        .header-image img {
            width: 100%;
            height: auto;
            max-height: 85px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .blue-cell {
            background-color: #1F497D;
            color: white;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #1F497D;
            text-align: center;
            font-size: 10px;
        }

        .data-cell {
            background-color: #F2F2F2;
            padding: 5px;
            border: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #1F497D;
        }

        .main-table thead th {
            background-color: #1F497D;
            color: white;
            padding: 8px;
            font-size: 11px;
            border: 1px solid #1F497D;
        }

        .main-table tbody td {
            border: 1px solid #DCE6F1;
            padding: 6px;
            font-size: 10px;
        }

        .text-end {
            text-align: right;
        }

        .total-row {
            background-color: #DCE6F1;
            font-weight: bold;
        }

        .title-main {
            color: #1F497D;
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="header-image">
        @if($cintillo)
        <img src="{{ $cintillo }}" alt="Cintillo">
        @endif
    </div>

    <h2 class="title-main">PAGOS ESPECIALES - MES: {{ $mes }} / {{ date('Y') }}</h2>

    {{-- BLOQUE DE INFORMACIÓN DEL FUNCIONARIO (MANTENIENDO TU DISEÑO) --}}
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
                    {{ Str::upper($info->primer_nombre) }} {{ Str::upper($info->segundo_nombre) }}
                    {{ Str::upper($info->primer_apellido) }} {{ Str::upper($info->segundo_apellido) }}
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

    {{-- TABLA DE CONCEPTOS SALARIALES --}}
    <table class="main-table">
        <thead>
            <tr>
                <th style="text-align: left; width: 50%;">Descripción</th>
                <th class="text-end" style="width: 25%;">Asignaciones</th>
                <th class="text-end" style="width: 25%;">Deducciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $asig)
            <tr>
                <td>{{ Str::upper($asig->descripcion_concepto) }}</td>
                <td class="text-end">{{ number_format($asig->monto, 2, ',', '.') }}</td>
                <td></td>
            </tr>
            @endforeach

            @foreach($deducciones as $ded)
            <tr>
                <td>{{ Str::upper($ded->descripcion_concepto) }}</td>
                <td></td>
                <td class="text-end">{{ number_format($ded->monto, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTAL CONCEPTOS SALARIALES</td>
                <td class="text-end">{{ number_format($totalAsigna, 2, ',', '.') }}</td>
                <td class="text-end">{{ number_format($totalDeduce, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="text-end">NETO NÓMINA (SALARIAL):</td>
                <td class="text-end">{{ number_format($totalAsigna - $totalDeduce, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- TABLA 2: CONCEPTOS NO SALARIALES --}}
    @if($noSalariales->count() > 0)
    <table class="main-table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="text-align: left; width: 75%;">Descripción</th>
                <th class="text-end" style="width: 25%;">Asignaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($noSalariales as $ns)
            <tr>
                <td>{{ Str::upper($ns->descripcion_concepto) }}</td>
                <td class="text-end">{{ number_format($ns->monto, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTAL NO SALARIAL</td>
                <td class="text-end">{{ number_format($totalNoSalarial, 2, ',', '.') }}</td>
            </tr>
            {{-- AQUÍ NO DEBE HABER NINGUNA FILA DE "NETO NÓMINA" --}}
        </tfoot>
    </table>
    @endif
</body>

</html>