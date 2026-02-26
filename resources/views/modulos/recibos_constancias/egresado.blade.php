{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'ConsTrabajo - Egresado')

@section('content')
<main class="p-4">

     @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Constancia de Trabajo > Egresados</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Buscar Egresado </h3>
            <div class="card-tools">
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
            </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        
        <!-- /.card-header -->
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
                <button type="submit" class="btn btn-guardar  " id="btnBuscar">
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
                        <p>En esta sección, puedes generar una <strong>constancia de egreso</strong> para un empleado.</p>
                        <p>Asegúrate de proporcionar los datos requeridos correctamente para evitar errores en la consulta.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                    </div>
                
            </div>
        </div>
  </div>
</main>

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
        
        let tipoDoc = $('#snacionalidad');
        let nroDoc = $('#ndocumento');

        // Limpiar estados previos
        contenedorResultado.html('');
        contenedorAlertas.html('');
        tipoDoc.removeClass('is-invalid');
        nroDoc.removeClass('is-invalid');

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

        // Si hay errores, mostrar alerta superior y no enviar
        if (camposVacios.length > 0) {
            let mensajeAlerta = "Los campos obligatorios no pueden quedar vacíos: <strong>" + camposVacios.join(' y ') + "</strong>.";
            
            contenedorAlertas.html(`
                <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong>Atención:</strong> ${mensajeAlerta}
                        </div>
                    </div>
                </div>
            `);
            return; 
        }

        // Si pasa la validación, activar spinner y enviar AJAX
        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('recibos.buscar') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                contenedorResultado.html(response);
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            },
            error: function(xhr) {
                let mensajeError = "No se pudo procesar la solicitud.";
                let icono = "fas fa-exclamation-triangle"; 
                let titulo = "Aviso:";

                if (xhr.status === 404) {
                    mensajeError = "El número de Documento consultado no se encuentra egresado.";
                    titulo = "Atención:";
                } 
                else if (xhr.status === 422) {
                    let errores = xhr.responseJSON.errors;
                    mensajeError = Object.values(errores).flat().join(', ');
                } 
                else if (xhr.status === 500) {
                    mensajeError = "El Nro. de Documento no se encuentra en la base de datos, por favor intente otra vez.";
                }

                contenedorAlertas.html(`
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="${icono} mr-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>${titulo}</strong> ${mensajeError}
                            </div>
                        </div>
                    </div>
                `);

                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });

    // Quitar marcas de error al escribir o cambiar selección
    $('#snacionalidad, #ndocumento').on('change input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop

@section('css')
<style>
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

@endsection
@section('footer')
@include('layouts.footer')
@endsection