{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')

@section('title', 'Recbpagos - Especiality')

@section('css')
<style>
    .form-control.is-invalid, 
    .form-select.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
    }
    /* Estilo para los separadores */
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
                <h4 class="font-weight-bold">Recibos de Pagos > Año Actual > Pagos Especiales</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    {{-- SECCIÓN 1: PERFIL LABORAL --}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Perfil Laboral</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row fs-6 d-flex align-items-end mb-4  p-3 rounded">
                <div class="col-md-3">
                    <div class="link-secondary font-weight-bold">Estatus</div>
                    <input class="form-control bg-white" value="{{ ($perfil->nestatus ?? '') == 1 ? 'ACTIVO' : 'EGRESADO' }}" disabled>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary font-weight-bold">Fecha de Ingreso</div>
                    <input class="form-control bg-white" value="{{ isset($perfil->fecha_ingreso) ? date('d/m/Y', strtotime($perfil->fecha_ingreso)) : '' }}" disabled>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary font-weight-bold">Tipo de Trabajador</div>
                    <input class="form-control bg-white" value="{{ $perfil->tipo_trabajador ?? 'N/A' }}" disabled>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary font-weight-bold">Código de Nómina</div>
                    <input class="form-control bg-white" value="{{ $perfil->ncodigo_nomina ?? 'N/A' }}" disabled>
                </div>
                
                <div class="sep"></div>

                <div class="col-md-6">
                    <div class="link-secondary font-weight-bold">Ubicación Administrativa</div>
                    <input class="form-control bg-white" value="{{ $perfil->ubicacion_adm ?? 'N/A' }}" disabled>
                </div>
                <div class="col-md-6">
                    <div class="link-secondary font-weight-bold">Ubicación Física</div>
                    <input class="form-control bg-white" value="{{ $perfil->ubicacion_fisica ?? 'N/A' }}" disabled>
                </div>
            </div>

            <hr class="my-4">

            {{-- SECCIÓN 2: FORMULARIO DE BÚSQUEDA --}}
            <form id="frm_especiales_consulta">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary font-weight-bold">Mes a Consultar <span class="requerido">*</span></div>
                        <select class="form-select" name="mes" id="mes" required>
                            <option value="" selected disabled>Seleccione un mes</option>
                            @foreach(['01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'] as $val => $nombre)
                                <option value="{{ $val }}">{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Debe seleccionar un mes para la consulta.</div>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary my-3" id="btnBuscar">
                            <span id="textoBoton">Buscar Pagos</span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>

            <div id="resultadoBusquedaEspecial" class="mt-4"></div>

        </div>
    </div>

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
                    <p>En esta sección puedes consultar <strong>recibos de pagos extraordinarios</strong> que no corresponden a la quincena regular.</p>
                    <p><strong>Ejemplos de estos pagos:</strong></p>
                    <ul>
                        <li>Bonificaciones especiales.</li>
                        <li>Retroactivos.</li>
                        <li>Pagos de incentivos únicos.</li>
                    </ul>
                    <p>Solo selecciona el mes de ejecución y haz clic en <strong>"Buscar Pagos"</strong> para ver los detalles.</p>
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
    $('#frm_especiales_consulta').on('submit', function(e) {
        e.preventDefault();
        
        let btn = $('#btnBuscar');
        let texto = $('#textoBoton');
        let spinner = $('#spinnerBoton');
        let contenedorResultado = $('#resultadoBusquedaEspecial');
        let contenedorAlertas = $('#contenedorAlertas');
        let mes = $('#mes');

        // Limpiar estados previos
        contenedorResultado.html('');
        contenedorAlertas.html('');
        mes.removeClass('is-invalid');

        // VALIDACIÓN: Mes obligatorio
        if (!mes.val()) {
            mes.addClass('is-invalid');
            contenedorAlertas.html(`
                <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Atención:</strong> Debe seleccionar un mes para realizar la consulta.
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
            url: "{{ route('recibos.pago.buscarEspecial') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.html) {
                    contenedorResultado.html(response.html);
                } else {
                    contenedorAlertas.html(`
                        <div class="alert alert-info border-left-info shadow-sm mt-2 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle mr-3" style="font-size: 1.5rem;"></i>
                                <div><strong>Sin datos:</strong> No se encontraron registros de pagos especiales para el mes seleccionado.</div>
                            </div>
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                let mensajeError = "Ocurrió un error al procesar la consulta.";
                
                if (xhr.status === 404) {
                    mensajeError = "No se encontraron pagos especiales registrados para este periodo.";
                } else if (xhr.status === 422) {
                    let errores = xhr.responseJSON.errors;
                    mensajeError = Object.values(errores).flat().join('<br>');
                } else if (xhr.status === 500) {
                    mensajeError = "Error interno del servidor al obtener los pagos.";
                }

                // INYECCIÓN DINÁMICA DEL MODAL DE ERROR (Layouts.alertas)
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
            },
            complete: function() {
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                texto.removeClass('d-none');
            }
        });
    });

    $('#mes').on('change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection