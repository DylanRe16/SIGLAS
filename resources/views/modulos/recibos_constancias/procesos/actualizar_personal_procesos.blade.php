@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Procesos - Actualizar Personal')

@section('css')
<style>
    /* Estilo para los separadores */
    .sep { border-bottom: 1px solid #e9ecef; margin: 15px 0; width: 100%; }

    /* Adaptación de btn-guardar al color institucional del módulo */
    .btn-institucional {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        transition: 0.3s;
    }
    .btn-institucional:hover {
        background-color: #fff;
        color: #007bff;
        border: 1px solid #007bff;
    }

    .btn-guardar {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff !important;
    }

    /* Evita el cambio a blanco o colores claros al pasar el mouse */
    .btn-guardar:hover,
    .btn-guardar:active,
    .btn-guardar:focus {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: #ffffff !important;
        transform: scale(1.02);
    }

    /* Estilos para el modal de ayuda */
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
                    PROCESOS
                </a>
                    > Actualizar Personal</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Gestión de Información de Personal</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalAyudaProcesos">
    <i class="bi bi-info-circle"></i>
</button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="row fs-6 d-flex align-items-center mb-4 bg-light p-4 rounded shadow-sm">
                <div class="col-md-8">
                    <h5 class="font-weight-bold text-secondary">Cargar y Actualizar Trabajadores</h5>
                    <p class="text-muted">
                        Al presionar el botón, el sistema verificará el listado de trabajadores con estatus <b>Activo</b> o <b>Egresado</b> para actualizar automáticamente la información en el sistema (Datos Personales, Perfiles y Accesos).
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <button type="button" id="btnCargar" class="btn btn-institucional px-4 shadow-sm">
                        <span id="textoBoton">Actualizar Datos</span>
                        <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </div>

            {{-- ESPACIO PARA FEEDBACK VISUAL DETALLADO --}}
            <div id="resultadoSincronizacion" class="mt-4"></div>

            <div id="loaderSection" class="text-center py-4 d-none animate__animated animate__fadeIn">
                <div class="spinner-border text-primary" role="status" style="color: #007bff !important; width: 3rem; height: 3rem;"></div>
                <p class="mt-3 font-weight-bold text-secondary">Actualizando registros de nómina...</p>
                <p class="text-muted small">Por favor, no cierre esta ventana ni recargue la página hasta finalizar el proceso.</p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAyudaProcesos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                        Ayuda
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="text-align: justify;">
                    <p>
                        Esta herramienta permite realizar una <strong>sincronización masiva</strong> de la base de datos de trabajadores.
                    </p>
                    <p>
                        El proceso actualiza la información de aquellos con estatus <strong>Activo</strong> o <strong>Egresado</strong>, asegurando que los datos personales y perfiles de acceso estén al día con la nómina institucional.
                    </p>
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
    $('#btnCargar').click(function() {
        let btn = $(this);
        let texto = $('#textoBoton');
        let spinner = $('#spinnerBoton');
        let loader = $('#loaderSection');
        let resultado = $('#resultadoSincronizacion');
        let alertas = $('#contenedorAlertas');

        // Limpiar estados previos
        resultado.empty();
        alertas.empty();

        // Confirmación masiva
        if(!confirm('¿Desea iniciar la actualización masiva de trabajadores?')) return;

        // UI de carga
        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');
        loader.removeClass('d-none');

        $.ajax({
            url: "{{ route('procesos.actualizar.ejecutar') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function(res) {
                alertas.html(`
                    <div class="alert alert-success border-left-success shadow-sm mt-2 mb-3 animate__animated animate__backInDown">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle mr-3" style="font-size: 1.5rem;"></i>
                            <div><strong>¡Éxito!</strong> ${res.message || 'Sincronización completada correctamente.'}</div>
                        </div>
                    </div>
                `);
            },
            error: function(xhr) {
                let msj = "Error al intentar actualizar los registros.";
                if(xhr.responseJSON && xhr.responseJSON.message) msj = xhr.responseJSON.message;

                alertas.html(`
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle mr-3" style="font-size: 1.5rem;"></i>
                            <div><strong>Error:</strong> ${msj}</div>
                        </div>
                    </div>
                `);
            },
            complete: function() {
                // Restaurar UI
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
                loader.addClass('d-none');
            }
        });
    });
});
</script>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
