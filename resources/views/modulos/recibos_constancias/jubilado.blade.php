@extends('adminlte::page')
@extends('layouts.extenciones')

@section('title', 'ConsTrabajo - Jubilado/Pensionado')

@section('css')
<style>
    /* Estilos de validación limpios */
    .form-control.is-invalid, .form-select.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
        border-color: #dc3545 !important;
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
                <h4 class="font-weight-bold">
                    <a href="{{ route('recibos.index') }}" class="link-secondary text-decoration-none">

                        Recibos y Constacias
                    </a>

                    > Constancia de Trabajo > Jubilado/Pensionado</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Buscar Trabajador</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalHelpJubilado">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form id="formBusquedaJubilado">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Tipo de Documento<span class="requerido">*</span></div>
                        <select name="snacionalidad" id="snacionalidad" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="V">Venezolano</option>
                            <option value="E">Extranjero</option>
                            <option value="P">Pasaporte</option>
                        </select>
                        <div class="invalid-feedback">El tipo de Documento es obligatorio.</div>
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Nro. de Documento<span class="requerido">*</span></div>
                        <input class="form-control" placeholder="Ingrese..." oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               name="ndocumento" id="ndocumento" maxlength="11" required>
                        <div class="invalid-feedback">El número de Documento es obligatorio.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-guardar " id="btnBuscar">
                            <span id="textoBoton">Buscar</span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="resultadoBusqueda" class="mt-4"></div>

   <div class="modal fade" id="modalHelpJubilado" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <p class="fs-5">
                    En esta sección, puedes generar una <strong>constancia simple con sueldo</strong> para empleados jubilados.
                </p>
                <hr>
                </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
</main>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // 1. Alerta de cuota mensual (Se mantiene tu lógica inicial)
    Swal.fire({
        title: '<strong>Información Importante</strong>',
        icon: 'info',
        html: 'Usted sólo puede solicitar <b>diez (10)</b> Constancias de Trabajo en el mes.',
        allowOutsideClick: false,
        confirmButtonText: 'He leído y acepto',
        confirmButtonColor: '#007bff'
    });

    // 2. Lógica AJAX con Modales del Layout
    $('#formBusquedaJubilado').on('submit', function(e) {
        e.preventDefault();
        let btn = $('#btnBuscar'), texto = $('#textoBoton'), spinner = $('#spinnerBoton');
        let contenedorResultado = $('#resultadoBusqueda'), contenedorAlertas = $('#contenedorAlertas');
        let tipoDoc = $('#snacionalidad'), nroDoc = $('#ndocumento');

        contenedorResultado.html('');
        contenedorAlertas.html('');
        $('.form-control, .form-select').removeClass('is-invalid');

        // Validación de campos vacíos (Alerta con sacudida)
        if (!tipoDoc.val() || !nroDoc.val().trim()) {
            if(!tipoDoc.val()) tipoDoc.addClass('is-invalid');
            if(!nroDoc.val().trim()) nroDoc.addClass('is-invalid');

            contenedorAlertas.html(`
                <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                        <div><strong>Atención:</strong> Debe completar los campos obligatorios.</div>
                    </div>
                </div>
            `);
            return;
        }

        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('recibos.buscarjubilado') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                contenedorResultado.html(response);
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            },
            error: function(xhr) {
                let mensajeError = "No se encontró registro activo como Jubilado o Pensionado.";
                if (xhr.status !== 404) mensajeError = "Error al procesar la solicitud.";

                // INYECCIÓN DEL MODAL SEGÚN LAYOUTS.ALERTAS (SI O SI)
                let modalHtml = `
                <div class="modal fade" id="ajaxErrorModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-lg border-0">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">¡Alerta!</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body fs-5 text-dark">
                                <i class="bi bi-exclamation-triangle-fill"></i> ${mensajeError}
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('#ajaxErrorModal').remove();
                $('body').append(modalHtml);
                var modal = new bootstrap.Modal(document.getElementById('ajaxErrorModal'));
                modal.show();

                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });

    $('#snacionalidad, #ndocumento').on('change input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop
