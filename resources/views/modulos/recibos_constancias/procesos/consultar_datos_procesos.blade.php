@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Consultar Datos')

@section('css')
<style>
    /* Mantiene el borde rojo pero elimina el icono/símbolo de Bootstrap */
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
                <h4 class="font-weight-bold">PROCESOS > Consultar Datos</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Buscador de Personal</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalAyudaConsulta">
    <i class="bi bi-info-circle"></i>
</button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form id="formBusquedaPersona"> 
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Tipo de Documento<span class="requerido">*</span></div>
                        <select name="snacionalidad" id="snacionalidad" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="V">Venezolano</option>
                            <option value="E">Extranjero</option>
                            <option value="P">Pasaporte</option>
                        </select>
                        <div class="invalid-feedback">Debe seleccionar el tipo de documento.</div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="link-secondary">Nro. de Documento<span class="requerido">*</span></div>
                        <input class="form-control" placeholder="Ingrese..." name="ndocumento" id="ndocumento" 
                               maxlength="10" onkeypress="return numbers(event);">
                        <div class="invalid-feedback">Debe ingresar el número de documento.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-guardar my-3" id="btnBuscar">
                            <span id="textoBoton">Buscar</span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="resultadoBusqueda" class="mt-4"></div>

    <div class="modal fade" id="modalAyudaConsulta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> 
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
                        En esta sección, podrá <strong>consultar los datos del trabajador(a)</strong>. Ingrese los datos que se le solicitan.
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

</main>
@stop

@section('js')
<script>
    // Función para validar solo números
    function numbers(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
    }

    $(document).ready(function() {
        $('#formBusquedaPersona').on('submit', function(e) {
            e.preventDefault();
            
            let btn = $('#btnBuscar');
            let texto = $('#textoBoton');
            let spinner = $('#spinnerBoton');
            let contenedorRes = $('#resultadoBusqueda');
            let contenedorAlt = $('#contenedorAlertas');
            
            let nac = $('#snacionalidad');
            let doc = $('#ndocumento');
            let camposVacios = [];

            // Limpiar estados
            contenedorRes.html('');
            contenedorAlt.html('');
            nac.removeClass('is-invalid');
            doc.removeClass('is-invalid');

            // VALIDACIÓN FRONT-END
            if (!nac.val()) { 
                nac.addClass('is-invalid'); 
                camposVacios.push("Tipo de Documento"); 
            }
            if (!doc.val().trim()) { 
                doc.addClass('is-invalid'); 
                camposVacios.push("Nro. de Documento"); 
            }

            if (camposVacios.length > 0) {
                contenedorAlt.html(`
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                            <div><strong>Atención:</strong> Debe completar: <strong>${camposVacios.join(' y ')}</strong>.</div>
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
                url: "{{ route('procesos.consultar.buscar') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if(response.html) {
                        contenedorRes.html(response.html);
                    } else {
                        contenedorRes.html(response);
                    }
                },
                error: function(xhr) {
                    let msg = "Ocurrió un error inesperado al consultar los datos."; 

                    if (xhr.status === 404) {
                        msg = "No se encontró ningún trabajador registrado con el número de documento ingresado.";
                    } else if (xhr.status === 422) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            msg = xhr.responseJSON.error;
                        } else {
                            let errores = xhr.responseJSON.errors;
                            msg = Object.values(errores).flat().join('<br>');
                        }
                    }

                    // INYECCIÓN DINÁMICA DEL MODAL DE ERROR/AVISO
                    let modalHtml = `
                    <div class="modal fade" id="ajaxErrorModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-warning text-dark">
                                    <h5 class="modal-title font-weight-bold"><i class="fas fa-search"></i> Resultado de Búsqueda</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body fs-5 text-dark">
                                    ${msg}
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
                    texto.removeClass('d-none');
                    spinner.addClass('d-none');
                }
            });
        });

        // Limpiar errores al escribir
        $('#snacionalidad, #ndocumento').on('change input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection