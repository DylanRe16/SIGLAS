<div class="card shadow-sm mt-4">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0">PAGOS ESPECIALES - MES: {{ $mes }} / {{ date('Y') }}</h5>
    </div>
    <div class="card-body">
        <h6 class="text-primary font-weight-bold">Conceptos Salariales</h6>
        <table class="table table-sm table-hover border">
            <thead class="bg-light">
                <tr>
                    <th>Descripción</th>
                    <th class="text-right">Asignaciones</th>
                    <th class="text-right">Deducciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaciones as $asig)
                <tr>
                    <td>{{ Str::upper($asig->descripcion_concepto) }}</td>
                    <td class="text-right">{{ number_format($asig->monto, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach

                @foreach($deducciones as $ded)
                <tr>
                    <td>{{ Str::upper($ded->descripcion_concepto) }}</td>
                    <td></td>
                    <td class="text-right text-danger">{{ number_format($ded->monto, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td>TOTAL CONCEPTOS SALARIALES</td>
                    <td class="text-right">{{ number_format($totalAsigna, 2, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($totalDeduce, 2, ',', '.') }}</td>
                </tr>
                <tr class="table-info">
                    <td colspan="2" class="text-right">NETO NÓMINA:</td>
                    <td class="text-right">{{ number_format($totalAsigna - $totalDeduce, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        @if($noSalariales->count() > 0)
        <h6 class="text-success font-weight-bold mt-4">Conceptos No Salariales</h6>
        <table class="table table-sm border">
            <thead class="bg-light">
                <tr>
                    <th>Descripción</th>
                    <th class="text-right">Asignaciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($noSalariales as $ns)
                <tr>
                    <td>{{ Str::upper($ns->descripcion_concepto) }}</td>
                    <td class="text-right">{{ number_format($ns->monto, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-light font-weight-bold">
                <tr>
                    <td>TOTAL NO SALARIAL</td>
                    <td class="text-right text-success">{{ number_format($totalNoSalarial, 2, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        @endif

        <div class="text-center mt-4">
            <a href="#" class="btn btn-danger">
                <i class="fas fa-file-pdf mr-2"></i> Imprimir Recibo Especial
            </a>
        </div>
    </div>
</div>