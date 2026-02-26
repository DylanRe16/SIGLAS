{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Recbpagos - Ordinary')

@section('css')
<style>
    /* Mantiene el borde rojo pero elimina el icono/símbolo de Bootstrap */
    .form-control.is-invalid, 
    .form-select.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
    }
    .sep { border-bottom: 1px solid #e9ecef; margin: 15px 0; width: 100%; }

    .is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
        border-color: #80bdff !important; 
        box-shadow: none !important;
    }

    .form-control.is-invalid:focus {
        border-color: #80bdff !important; /* Color azul estándar de focus */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }
</style>
@stop

@section('content')
<main class="p-4">

    @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Recibos de Pagos > Año Actual > Ordinario</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Perfil Laboral </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        
        <div class="card-body">
            <form id="formBusquedaEgresado"> @csrf
                {{-- SECCIÓN 1: PERFIL LABORAL --}}
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Estatus</div>
                        <input class="form-control" value="{{ $perfil->estatus == 1 ? 'ACTIVO' : 'INACTIVO' }}" disabled >
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Fecha de Ingreso</div>
                        <input class="form-control" value="{{ $perfil->fecha_ingreso ? \Carbon\Carbon::parse($perfil->fecha_ingreso)->format('d/m/Y') : 'N/A' }}" disabled >
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Tipo de Trabajador</div>
                        <input class="form-control" value="{{ $perfil->tipo_trabajador }}" disabled >
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Código de Nómina</div>
                        <input class="form-control" value="{{ $perfil->cod_nomina }}" disabled >
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-6">
                        <div class="link-secondary">Cuenta Nómina</div>
                        <input class="form-control" value="{{ $perfil->cuenta_nomina }}" disabled >
                    </div>

                    <div class="col-md-6">
                        <div class="link-secondary">Cargo</div>
                        <input class="form-control" value="{{ $perfil->cargo }}" disabled >
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-6">
                        <div class="link-secondary">Ubicación Administrativa</div>
                        <input class="form-control" value="{{ $perfil->ubicacion_admin }}" disabled >
                    </div>

                    <div class="col-md-6">
                        <div class="link-secondary">Ubicación Fisica</div>
                        <input class="form-control" value="{{ $perfil->ubicacion_fisica }}" disabled >
                    </div>
                </div>

                {{-- SECCIÓN 2: PERIODO A CONSULTAR --}}
                <div class="card-header p-0 mb-3" style="background: transparent; border-bottom: 1px solid rgba(0,0,0,.125);">
                    <h3 class="card-title font-weight-bold text-primary">Periodo a Consultar </h3>
                </div>

                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Mes<span class="requerido">*</span></div>
                        <select class="form-select" name="mes" id="mes" required> 
                            <option value="" selected disabled>Seleccione un mes</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <div class="invalid-feedback">Debe seleccionar un mes.</div>
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Quincena o semana<span class="requerido">*</span></div>
                        <select class="form-select" name="tipo_nomina" id="tipo_nomina" required>
                            <option value="" selected disabled>Seleccione</option>
                            <option value="1">Primera Quincena</option>
                            <option value="2">Segunda Quincena</option>
                        </select>
                        <div class="invalid-feedback">Debe seleccionar la quincena o semana.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3" id="btnBuscar">
                            <span id="textoBoton">Buscar</span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="resultadoBusqueda" class="mt-4"></div>

    <div class="modal fade" id="modal1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> 
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog modal-dialog-scrollable" style="height: auto;">    
            <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                            Ayuda 
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <!-- <span aria-hidden="true">&times;</span> -->
                        </button>
                    </div>

                    <div class="modal-body" style="text-align: justify;">
                    <p>En esta sección puedes consultar tus <strong>recibos de pago correspondientes al año en curso</strong>.</p>
                    <p>Para ver un recibo, simplemente:</p>
                    <ol>
                        <li>Selecciona el <strong>Mes</strong> que deseas consultar.</li>
                        <li>Elige la <strong>Quincena o Semana</strong> específica.</li>
                        <li>Haz clic en el botón <strong>Buscar</strong>.</li>
                    </ol>
                    <p>Si el recibo existe, aparecerá detallado debajo del formulario.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('js')
<script>
$(document).ready(function() {
    $('#formBusquedaEgresado').on('submit', function(e) {
        e.preventDefault();

        let btn = $('#btnBuscar');
        let texto = $('#textoBoton');
        let spinner = $('#spinnerBoton');
        let contenedorResultado = $('#resultadoBusqueda');
        let contenedorAlertas = $('#contenedorAlertas');
        
        let mes = $('#mes');
        let tipoNomina = $('#tipo_nomina');

        // Limpiar estados previos
        contenedorResultado.html('');
        contenedorAlertas.html('');
        mes.removeClass('is-invalid');
        tipoNomina.removeClass('is-invalid');

        // VALIDACIÓN DE CAMPOS
        let camposVacios = [];
        if (!mes.val()) {
            camposVacios.push("Mes");
            mes.addClass('is-invalid');
        }
        if (!tipoNomina.val()) {
            camposVacios.push("Quincena o Semana");
            tipoNomina.addClass('is-invalid');
        }

        if (camposVacios.length > 0) {
            contenedorAlertas.html(`
                <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Atención:</strong> Debe completar los campos: <strong>${camposVacios.join(' y ')}</strong>.
                        </div>
                    </div>
                </div>
            `);
            return; 
        }

        // UI de carga
        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('recibos.pago.buscar') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                contenedorResultado.html(response);
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            },
            error: function(xhr) {
                let mensajeError = "No se pudo procesar la solicitud de consulta.";

                if (xhr.status === 404) {
                    mensajeError = "No se encontró un recibo de pago generado para el periodo seleccionado (" + mes.find('option:selected').text() + ").";
                } else if (xhr.status === 422) {
                    let errores = xhr.responseJSON.errors;
                    mensajeError = Object.values(errores).flat().join('<br>');
                } else if (xhr.status === 500) {
                    mensajeError = "Error interno del servidor. Por favor, intente más tarde.";
                }

                // INYECCIÓN DINÁMICA DEL MODAL DE ERROR
                let modalHtml = `
                <div class="modal fade" id="ajaxErrorModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-lg border-0">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">¡Información!</h5>
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

    // Limpiar error al cambiar selección
    $('#mes, #tipo_nomina').on('change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection