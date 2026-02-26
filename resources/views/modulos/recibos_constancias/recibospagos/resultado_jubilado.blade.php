<div class="card mt-4 border-left-primary shadow animate__animated animate__fadeIn">
    <div class="card-header bg-light">
        <h3 class="card-title text-primary font-weight-bold">
            <i class="fas fa-user-check mr-2"></i> Personal Jubilado Verificado
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <p>Se ha verificado que <strong>{{ $genero }}</strong> ostenta la condición de Jubilado.</p>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th style="width: 35%">Nombre completo:</th>
                        <td class="text-uppercase">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</td>
                    </tr>
                    <tr>
                        <th>Cédula:</th>
                        <td>{{ $persona->nacionalidad }}-{{ number_format($persona->cedula, 0, '', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Dependencia de Egreso:</th>
                        <td class="small">{{ $persona->nombre_dep }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Jubilación:</th>
                        <td class="text-primary font-weight-bold">
                            {{ \Carbon\Carbon::parse($persona->fecha_egreso)->format('d/m/Y') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                {{-- Formulario para generar el PDF que ya habíamos configurado anteriormente --}}
                <form action="{{ route('recibos.pdf.jubilado') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="id_personal" value="{{ $persona->id_personal }}">
                    <input type="hidden" name="figura" value="JUBILADO">
                    
                    {{-- Campos adicionales que pide tu PDF de jubilados --}}
                    <div class="form-group">
                        <label class="small">Monto del Sueldo:</label>
                        <input type="number" name="monto_sueldo" step="0.01" class="form-control form-control-sm mb-2" required placeholder="0.00">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block shadow">
                        <i class="fas fa-file-pdf mr-2"></i> Generar Constancia
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>