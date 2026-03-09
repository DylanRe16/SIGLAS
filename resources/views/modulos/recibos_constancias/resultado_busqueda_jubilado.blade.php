<div class="card animate__animated animate__fadeIn">
    <div class="card-header bg-success">
        <h3 class="card-title"><i class="fas fa-check-circle mr-2"></i> Registro Localizado</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered table-sm">
                    <tr>
    <th class="bg-light" style="width: 30%">Nombre(s) y Apellido(s):</th>
    <td>
        {{ strtoupper($persona->primer_nombre) }} {{ strtoupper($persona->segundo_nombre) }} 
        {{ strtoupper($persona->primer_apellido) }} {{ strtoupper($persona->segundo_apellido) }}
    </td>
</tr>
                    <tr>
                        <th class="bg-light">Tipo y Nro. de Documento:</th>
                        <td>{{ $persona->nacionalidad }}-{{ number_format($persona->cedula, 0, '', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tipo de Personal:</th>
                        <td><span>{{ $figura }}</span></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Ubicación Administrativa:</th>
                        <td>{{ strtoupper($persona->nombre_dep) }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                {{-- Ruta específica para Jubilados --}}
                <form action="{{ route('recibos.pdf.jubilado') }}" method="POST" target="_blank">
                    @csrf
                    <input type="hidden" name="id_personal" value="{{ $persona->id_personal }}">
                    <input type="hidden" name="monto_sueldo" value="{{ $monto_sueldo }}">
                    <input type="hidden" name="figura" value="{{ $figura }}">
                    <input type="hidden" name="tipo_asignacion" value="{{ $tipo_asignacion }}">

                    <div class="text-center">
                        <p class="text-muted small mb-2">Presione para descargar el documento</p>
                        <button type="submit" class="btn btn-danger btn-lg shadow">
                            <i class="fas fa-file-pdf mr-2"></i> Generar Constancia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted small">
        <i class="fas fa-info-circle mr-1"></i> Esta constancia tendrá una validez de treinta (30) días.
    </div>
</div>