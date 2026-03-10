@php
$asignaciones = $historial->where('categoria', 1);
$deducciones = $historial->where('categoria', 2);
$noSalariales = $historial->where('categoria', 3);

$totalAsignaciones = $asignaciones->sum('monto');
$totalDeducciones = $deducciones->sum('monto');
$totalNoSalarial = $noSalariales->sum('monto');

$meses = [1=>'ENERO', 2=>'FEBRERO', 3=>'MARZO', 4=>'ABRIL', 5=>'MAYO', 6=>'JUNIO',
7=>'JULIO', 8=>'AGOSTO', 9=>'SEPTIEMBRE', 10=>'OCTUBRE', 11=>'NOVIEMBRE', 12=>'DICIEMBRE'];
$info = $historial->first();
@endphp

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="text-center fw-bold mb-4">{{ $meses[(int)$info->nmes] }} DEL AÑO {{ $info->nanio }}</h5>

        <table class="table table-sm table-bordered">
            <thead class="bg-light">
                <tr>
                    <th style="width: 50%;">CONCEPTOS SALARIALES</th>
                    <th class="text-end" style="width: 25%;">ASIGNACIONES</th>
                    <th class="text-end" style="width: 25%;">DEDUCCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $item)
                <tr>
                    <td>{{ $item->descripcion_concepto }}</td>
                    <td class="text-end">{{ number_format($item->monto, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach

                @foreach($deducciones as $item)
                <tr>
                    <td>{{ $item->descripcion_concepto }}</td>
                    <td></td>
                    <td class="text-end">{{ number_format($item->monto, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="fw-bold bg-light">
                    <td class="text-end">TOTALES CONCEPTOS SALARIALES:</td>
                    <td class="text-end">{{ number_format($totalAsignaciones, 2, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($totalDeducciones, 2, ',', '.') }}</td>
                </tr>
                <tr class="fw-bold">
                    <td colspan="2" class="text-end">NETO NÓMINA:</td>
                    <td class="text-end text-primary" style="font-size: 1.2rem;">
                        {{ number_format($totalAsignaciones - $totalDeducciones, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

        @if($noSalariales->count() > 0)
        <table class="table table-sm table-bordered mt-4">
            <thead class="bg-light">
                <tr>
                    <th style="width: 50%;">CONCEPTOS NO SALARIALES</th>
                    <th class="text-end" style="width: 25%;">ASIGNACIONES</th>
                    <th style="width: 25%;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($noSalariales as $item)
                <tr>
                    <td>{{ $item->descripcion_concepto }}</td>
                    <td class="text-end">{{ number_format($item->monto, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="fw-bold bg-light">
                <tr>
                    <td class="text-end">TOTAL CONCEPTOS NO SALARIALES:</td>
                    <td class="text-end">{{ number_format($totalNoSalarial, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        @endif

        <div class="text-center mt-4">
            <form action="{{ route('recibos.historico.pdf') }}" method="POST" target="_blank">
                @csrf
                <input type="hidden" name="ndocumento" value="{{ $info->personales_cedula }}">
                <input type="hidden" name="anio" value="{{ $info->nanio }}">
                <input type="hidden" name="mes" value="{{ $info->nmes }}">

                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> Imprimir Recibo
                </button>
            </form>
        </div>
    </div>
</div>