<div class="card shadow-sm animate__animated animate__fadeIn">
    <div class="card-header bg-light">
        <h5 class="text-primary mb-0">Detalle del Pago: Quincena {{ $quincena }} - Mes {{ $mes }}</h5>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr class="bg-secondary text-white">
                    <th>Concepto</th>
                    <th class="text-right">Asignaciones</th>
                    <th class="text-right">Deducciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Asignaciones --}}
                @foreach($asignaciones as $item)
                <tr>
                    <td>{{ $item->descripcion_concepto }}</td>
                    <td class="text-right">{{ number_format($item->monto, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach

                {{-- Deducciones --}}
                @foreach($deducciones as $item)
                <tr>
                    <td>{{ $item->descripcion_concepto }}</td>
                    <td></td>
                    <td class="text-right text-danger">{{ number_format($item->monto, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td>TOTALES SALARIALES</td>
                    <td class="text-right">{{ number_format($totalAsignas, 2, ',', '.') }}</td>
                    <td class="text-right text-danger">{{ number_format($totalDeduce, 2, ',', '.') }}</td>
                </tr>
                <tr class="bg-primary text-white">
                    <td colspan="2">NETO A COBRAR</td>
                    <td class="text-right">{{ number_format($neto, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        @if($noSalariales->count() > 0)
            <h6 class="mt-4 text-info font-weight-bold">Conceptos No Salariales</h6>
            <table class="table table-sm table-borderless">
                @foreach($noSalariales as $ns)
                <tr>
                    <td width="70%">{{ $ns->descripcion_concepto }}</td>
                    <td class="text-right">{{ number_format($ns->monto, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
        @endif
        
        <div class="mt-3 text-center">
            <button class="btn btn-danger btn-sm">
                <a href="{{ route('recibos.pago.imprimir', ['mes' => $mes, 'quincena' => $quincena]) }}" 
                    target="_blank" 
                    class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf mr-2"></i> Imprimir Recibo
                </a>
            </button>
        </div>
    </div>
</div>