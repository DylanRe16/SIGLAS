{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'ConsTrabajo - Egresado')

@section('css')
<style>
    /* Mantiene el borde rojo de error pero elimina el icono/símbolo de Bootstrap */
    .form-control.is-invalid,
    .form-select.is-invalid {
        background-image: none !important;
        padding-right: 0.75rem !important;
    }

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

    .btn-guardar {
        background-color: #007bff; /* Ajusta a tu color verde exacto si es otro */
        border-color: #007bff;
        color: #ffffff !important;
    }

    /* Evita el cambio a blanco o colores claros al pasar el mouse */
    .btn-guardar:hover,
    .btn-guardar:active,
    .btn-guardar:focus {
        background-color: #007bff !important; /* Un verde ligeramente más oscuro para feedback visual */
        border-color: #007bff !important;
        color: #ffffff !important; /* Mantiene el texto blanco */
        transform: scale(1.02); /* Pequeño efecto de escala opcional */
    }
</style>
@stop

@section('content')
<main class="p-4">

    @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h5 class="font-weight-bold">
                    <a href="{{ route('recibos.index') }}" class="link-secondary text-decoration-none">
                    Recibos y Constacias
                    </a>

                    > Constancias de Trabajo > Consulta por Trabajador</h5>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Buscar Trabajador </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <form id="formBusquedaEgresado"> @csrf
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
                        <input class="form-control" placeholder="Ingrese..." oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="ndocumento" id="ndocumento" maxlength="11" onkeypress="return numbers(event);" required>
                        <div class="invalid-feedback">El número de Documento es obligatorio.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-guardar btn-primary" id="btnBuscar">
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
                    <p>En esta sección, puedes generar una <strong>constancia de trabajo con sueldo</strong> para un trabajador activo.</p>
                    <p>Asegúrate de proporcionar los datos requeridos correctamente para obtener el desglose salarial actualizado.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-modal="modal" data-bs-dismiss="modal">Entendido</button>
                </div>

            </div>
        </div>
    </div>

</main>

@section('js')
<script>
$(document).ready(function() {
    // 1. Alerta de cuota mensual al cargar la página
    Swal.fire({
        title: '<strong>Información Importante</strong>',
        icon: 'info',
        html: 'Usted sólo puede solicitar <b>diez (10)</b> Constancias de Trabajo en el mes.',
        allowOutsideClick: false,
        confirmButtonText: 'He leído y acepto',
        confirmButtonColor: '#007bff'
    });

    // 2. Lógica de Envío de Formulario
    $('#formBusquedaEgresado').on('submit', function(e) {
        e.preventDefault();

        // Variables de UI
        const btn = $('#btnBuscar');
        const texto = $('#textoBoton');
        const spinner = $('#spinnerBoton');
        const contenedorResultado = $('#resultadoBusqueda');
        const contenedorAlertas = $('#contenedorAlertas');
        const tipoDoc = $('#snacionalidad');
        const nroDoc = $('#ndocumento');

        // Limpiar estados previos
        contenedorResultado.html('');
        contenedorAlertas.html('');
        $('.form-control, .form-select').removeClass('is-invalid');

        // VALIDACIÓN DE CAMPOS
        let camposVacios = [];
        if (!tipoDoc.val()) {
            camposVacios.push("Tipo de Documento");
            tipoDoc.addClass('is-invalid');
        }
        if (!nroDoc.val().trim()) {
            camposVacios.push("Nro. de Documento");
            nroDoc.addClass('is-invalid');
        }

        if (camposVacios.length > 0) {
            let mensajeAlerta = "Los campos obligatorios no pueden quedar vacíos: <strong>" + camposVacios.join(' y ') + "</strong>.";
            contenedorAlertas.html(`
                <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                        <div><strong>Atención:</strong> ${mensajeAlerta}</div>
                    </div>
                </div>
            `);
            return;
        }

        // UI en estado de carga
        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('recibos.buscarsueldo.post') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                contenedorResultado.html(response);
            },
            error: function(xhr) {
                let mensajeError = "No se pudo procesar la solicitud.";

                if (xhr.status === 404) {
                    mensajeError = "Persona no encontrada en SIGEFIRRHH.";
                } else if (xhr.status === 422) {
                    let errores = xhr.responseJSON.errors;
                    mensajeError = Object.values(errores).flat().join('<br>');
                } else if (xhr.status === 500) {
                    mensajeError = "Persona no encontrada en SIGEFIRRHH.";
                }

                // Gestión del Modal de Error
                $('#ajaxErrorModal').remove();
                let modalHtml = `
                <div class="modal fade" id="ajaxErrorModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-lg border-0">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title">¡Alerta!</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body fs-5 text-dark">
                                <i class="fas fa-exclamation-triangle mr-2"></i> ${mensajeError}
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('body').append(modalHtml);
                const modalElement = document.getElementById('ajaxErrorModal');
                const modalInstance = new bootstrap.Modal(modalElement);
                modalInstance.show();
            },
            complete: function() {
                // Restaurar botón siempre, sea éxito o error
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });

    // Limpiar errores visuales al escribir
    $('#snacionalidad, #ndocumento').on('change input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop

@endsection
@section('footer')
@include('layouts.footer')
@endsection
