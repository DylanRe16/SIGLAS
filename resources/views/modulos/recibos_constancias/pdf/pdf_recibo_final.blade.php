<!DOCTYPE html>
<html lang="es">   
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.5cm 1.5cm 1cm 1.5cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 0; }
        
        .header-image { text-align: center; margin-bottom: 10px; width: 100%; }
        .header-image img { width: 100%; height: auto; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .blue-cell { background-color: #1F497D; color: white; font-weight: bold; padding: 5px; border: 1px solid #1F497D; }
        .data-cell { background-color: #F2F2F2; padding: 5px; border: 1px solid #ccc; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #1F497D; }
        .main-table thead th { background-color: #1F497D; color: white; padding: 8px; font-size: 11px; border: 1px solid #1F497D; }
        .main-table tbody td { border: 1px solid #DCE6F1; padding: 6px; font-size: 10px; }
        .main-table tbody tr:nth-child(even) { background-color: #F9FBFF; }
        
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .total-row { background-color: #DCE6F1; font-weight: bold; }
        
        .title-section { text-align: center; margin-bottom: 15px; }
        .title-main { color: #1F497D; margin-bottom: 5px; font-size: 16px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header-image">
        <img src="{{ $cintillo }}" alt="Cintillo">
    </div>

    <div class="title-section">
        <h2 class="title-main">RECIBO DE PAGO HISTÓRICO</h2>
        <h4 style="margin-top: 0;">{{ $mes_letras }} {{ $anio }}</h4>
    </div>

    <table class="header-table">
        <thead>
            <tr>
                <th class="blue-cell" style="text-align: center; width: 40%;">FUNCIONARIO</th>
                <th class="blue-cell" style="text-align: center; width: 30%;">DOCUMENTO DE IDENTIDAD</th>
                <th class="blue-cell" style="text-align: center; width: 30%;">ESTATUS ACTUAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell" style="text-align: center;">
                    {{ $info->primer_nombre }} {{ $info->segundo_nombre }} 
                    {{ $info->primer_apellido }} {{ $info->segundo_apellido }}
                </td>
                <td class="data-cell" style="text-align: center;">
                    {{ number_format($info->personales_cedula, 0, '', '.') }}
                </td>
                <td class="data-cell" style="text-align: center;">
                    {{ ($info->nestatus == 1) ? 'ACTIVO' : 'EGRESADO' }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="header-table" style="margin-top: -15px;">
        <thead>
            <tr>
                <th class="blue-cell" style="text-align: center; width: 40%;">CARGO</th>
                <th class="blue-cell" style="text-align: center; width: 30%;">CÓDIGO DE NÓMINA</th>
                <th class="blue-cell" style="text-align: center; width: 30%;">CUENTA NÓMINA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell" style="text-align: center;">{{ $info->nombre_cargo ?? 'N/A' }}</td>
                <td class="data-cell" style="text-align: center;">{{ $info->ncodigo_nomina ?? 'N/A' }}</td>
                <td class="data-cell" style="text-align: center;">{{ $info->scuenta_nomina ?? 'S/N' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="header-table" style="margin-top: -15px;">
        <thead>
            <tr>
                <th class="blue-cell" style="text-align: center; width: 60%;">UBICACIÓN ADMINISTRATIVA</th>
                <th class="blue-cell" style="text-align: center; width: 40%;">PERIODO DE PAGO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="data-cell" style="text-align: center;">{{ $info->nombre_ubicacion ?? 'NO ASIGNADA' }}</td>
                <td class="data-cell" style="text-align: center;">{{ $mes_letras }} - {{ $anio }}</td>
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
            @php $t_asig = 0; $t_dedu = 0; @endphp
            @foreach($historial as $item)
                @if($item->ncategoria == 1 || $item->ncategoria == 2)
                <tr>
                    <td>{{ $item->concepto }}</td>
                    <td class="text-end">
                        @if($item->ncategoria == 1) 
                            {{ number_format($item->nmonto, 2, ',', '.') }} 
                            @php $t_asig += $item->nmonto; @endphp
                        @endif
                    </td>
                    <td class="text-end">
                        @if($item->ncategoria == 2) 
                            {{ number_format($item->nmonto, 2, ',', '.') }} 
                            @php $t_dedu += $item->nmonto; @endphp
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTALES CONCEPTOS SALARIALES:</td>
                <td class="text-end">{{ number_format($t_asig, 2, ',', '.') }}</td>
                <td class="text-end">{{ number_format($t_dedu, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="text-end">NETO NÓMINA:</td>
                <td class="text-end">{{ number_format($t_asig - $t_dedu, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @php 
        $noSal = $historial->where('ncategoria', 3); 
        $t_noSal = $noSal->sum('nmonto');
    @endphp

    @if($noSal->count() > 0)
    <table class="main-table" style="margin-top: 20px;">
        <thead>
            <tr>
                <th style="text-align: left; width: 50%;">CONCEPTOS NO SALARIALES</th>
                <th class="text-end" style="width: 25%;">ASIGNACIONES</th>
                <th class="text-end" style="width: 25%;">DEDUCCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($noSal as $item)
            <tr>
                <td>{{ $item->concepto }}</td>
                <td class="text-end">{{ number_format($item->nmonto, 2, ',', '.') }}</td>
                <td class="text-end">-</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td class="text-end">TOTAL CONCEPTOS NO SALARIALES:</td>
                <td class="text-end">{{ number_format($t_noSal, 2, ',', '.') }}</td>
                <td class="text-end">0,00</td>
            </tr>
        </tfoot>
    </table>
    @endif

    

</body>
</html>