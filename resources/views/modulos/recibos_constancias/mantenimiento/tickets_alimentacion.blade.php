@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Mantenimiento Tickets')

@section('css')
<style>
    /* Estilos de validación y limpieza visual */
    .form-control.is-invalid, .form-select.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
        border-color: #dc3545 !important;
    }

    /* Mejora para el select de DataTables */
    .dataTables_length select {
        padding-right: 1.5rem !important;
        line-height: 1.2 !important;
    }

    .btn-guardar {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff !important;
        transition: all 0.3s ease;
    }

    .btn-guardar:hover {
        background-color: #0056b3 !important;
        transform: scale(1.02);
    }

    .modal-content { border-radius: 12px; }
    .modal-header { border-radius: 12px 12px 0 0; }
</style>
@stop

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Tickets Alimentación</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Configuración de Tickets</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalHelpTickets">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('mantenimiento.tickets.guardar') }}" method="POST" id="formTickets">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-3">
                    <div class="col-md-5">
                        <div class="link-secondary">Año Vigencia<span class="requerido">*</span></div>
                        <input class="form-control" type="text" readonly value="{{ $anio_actual }}">
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Mes de Vigencia<span class="requerido">*</span></div>
                        <select name="mes_vigencia" id="mes_vigencia" class="form-select" required>
                            <option value="">Seleccione...</option>
                            @foreach($meses as $val => $nombre)
                                <option value="{{ $val }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Debe seleccionar el mes de vigencia.</div>
                    </div>
                </div>

                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Monto Unidad Tributaria<span class="requerido">*</span></div>
                        <input type="number" step="0.01" name="txt_monto_unidad" id="ut" class="form-control" placeholder="0.00" required>
                        <div class="invalid-feedback">Ingrese el monto de la U.T.</div>
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Porcentaje (%)<span class="requerido">*</span></div>
                        <input type="number" step="0.01" name="txt_porcentaje" id="porcentaje" class="form-control" placeholder="0.00" required>
                        <div class="invalid-feedback">Ingrese el porcentaje correspondiente.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-guardar my-3" id="btnGuardar">
                            <span id="textoBoton">Guardar</span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>

                <div class="row justify-content-center border-top pt-3">
                    <div class="col-md-4 text-center">
                        <div class="link-secondary font-weight-bold">Monto a Cancelar Estimado (30 días)</div>
                        <input type="text" id="monto_total_display" class="form-control text-center font-weight-bold text-primary" style="font-size: 1.25rem; border: none; background: transparent;" readonly value="0,00">
                        <input type="hidden" name="txt_monto_cancelar" id="monto_total_val">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-light mt-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Historial de Registros</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblTickets" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th class="text-center">Año</th>
                            <th class="text-center">Mes</th>
                            <th class="text-center">U.T.</th>
                            <th class="text-center">%</th>
                            <th class="text-center">Monto Total</th>
                            <th class="text-center">Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historico as $h)
                        <tr>
                            <td class="text-center">{{ $h->nanio_vigencia }}</td>
                            <td class="text-center">{{ $meses[$h->smes] ?? $h->smes }}</td>
                            <td class="text-center">{{ number_format($h->nunidad_tributaria, 2) }}</td>
                            <td class="text-center">{{ $h->nporcentaje }}%</td>
                            <td class="text-center font-weight-bold">{{ number_format($h->nmonto, 2, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $h->nenabled == '1' ? 'success' : 'secondary' }} p-2" style="font-size: 0.95rem; min-width: 100px;">
                                    {{ $h->nenabled == '1' ? 'Habilitado' : 'Inhabilitado' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHelpTickets" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> 
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        Ayuda 
                    </h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" style="text-align: justify;">
                    <p>
                        Permite configurar el monto a cancelar por concepto de <strong>Tickets de alimentación</strong>.
                    </p>
                    <p>Además de visualizar el historial, y habilitar o inhabilitar el registro.</p>
                    <hr>
                    <small class="text-muted">Recuerde completar todos los campos obligatorios, identificados con un asterisco (*).</small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

</main>
@stop

@section('js')
<script>
$(document).ready(function() {
    // 1. Configuración de DataTable
    $('#tblTickets').DataTable({
        "order": [[0, "desc"], [1, "desc"]],
        "pageLength": 5,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });

    // 2. Cálculo en tiempo real
    $('#ut, #porcentaje').on('input change', function() {
        $(this).removeClass('is-invalid');
        let ut = parseFloat($('#ut').val()) || 0;
        let porc = parseFloat($('#porcentaje').val()) || 0;
        let total = (ut * porc) * 30;

        $('#monto_total_val').val(total.toFixed(2));
        $('#monto_total_display').val(new Intl.NumberFormat('es-VE', { minimumFractionDigits: 2 }).format(total));
    });

    // 3. Validación al guardar
    $('#formTickets').on('submit', function(e) {
        let mes = $('#mes_vigencia'), ut = $('#ut'), porc = $('#porcentaje');
        let contenedorAlertas = $('#contenedorAlertas');
        
        $('.form-control, .form-select').removeClass('is-invalid');

        if (!mes.val() || !ut.val() || !porc.val()) {
            e.preventDefault();
            if(!mes.val()) mes.addClass('is-invalid');
            if(!ut.val()) ut.addClass('is-invalid');
            if(!porc.val()) porc.addClass('is-invalid');

            contenedorAlertas.html(`
                <div class="alert alert-danger shadow-sm animate__animated animate__shakeX">
                    <i class="fas fa-exclamation-circle mr-2"></i> <strong>Atención:</strong> Debe completar los campos obligatorios (*).
                </div>
            `);
            return;
        }

        $('#textoBoton').addClass('d-none');
        $('#spinnerBoton').removeClass('d-none');
        $('#btnGuardar').prop('disabled', true);
    });
});
</script>
@stop