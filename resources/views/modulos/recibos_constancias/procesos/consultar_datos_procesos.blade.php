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
                <h4 class="font-weight-bold">
                    <a href="{{ route('recibos.index') }}" class="link-secondary text-decoration-none">

                    PROCESOS
                </a>
                    > Consultar Datos</h4>
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
            <form id="formBusquedaPersona" method="POST">
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
                        <button type="submit" class="btn btn-guardar btn-primary" id="btnBuscar">
                            Buscar
                            {{-- <span id="textoBoton">Buscar</span> --}}
                            {{-- <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span> --}}
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
    $(document).ready(function() {
        // 1. Alerta SweetAlert2 de cuota
        Swal.fire({
            title: '<strong>Información Importante</strong>',
            icon: 'info',
            html: 'Usted sólo puede solicitar <b>diez (10)</b> Constancias de Trabajo en el mes.',
            allowOutsideClick: false,
            confirmButtonText: 'He leído y acepto',
            confirmButtonColor: '#007bff'
        });

        // Variable para el botón
        const btnBuscar = document.getElementById('btnBuscar');
        const originalText = btnBuscar.innerHTML;

        // Evento submit del formulario
        document.getElementById('formBusquedaPersona').addEventListener('submit', buscarPersona);

        async function buscarPersona(e) {
            e.preventDefault();

            const tipoDoc = document.getElementById('snacionalidad');
            const nroDoc = document.getElementById('ndocumento');
            const contenedorResultado = document.getElementById('resultadoBusqueda');
            const contenedorAlertas = document.getElementById('contenedorAlertas');
            
            // Limpiar resultados anteriores
            contenedorResultado.innerHTML = '';
            contenedorAlertas.innerHTML = '';
            
            // Validación visual de campos vacíos
            let tieneError = false;
            if (!tipoDoc.value) {
                tipoDoc.classList.add('is-invalid');
                tieneError = true;
            } else {
                tipoDoc.classList.remove('is-invalid');
            }
            
            if (!nroDoc.value.trim()) {
                nroDoc.classList.add('is-invalid');
                tieneError = true;
            } else {
                nroDoc.classList.remove('is-invalid');
            }
            
            if (tieneError) {
                contenedorAlertas.innerHTML = `
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                            <div><strong>Atención:</strong> Debe completar los campos obligatorios.</div>
                        </div>
                    </div>
                `;
                return;
            }
            
            try {
                // Deshabilitar botón y mostrar indicador de carga
                btnBuscar.disabled = true;
                btnBuscar.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Buscando...'
                
                // Preparar datos para enviar
                const formData = new FormData();
                formData.append('snacionalidad', tipoDoc.value);
                formData.append('ndocumento', nroDoc.value.trim());
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                const response = await fetch("{{ route('procesos.consultar.buscar') }}", {
                    method: 'POST', // Cambiado a POST
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });

                const json = await response.json();

                console.log(json);

                if (!response.ok) {
                    // Manejar errores según el código de estado
                    if (response.status === 404) {
                        // Persona no encontrada
                        contenedorAlertas.innerHTML = `
                            <div class="alert alert-warning border-left-warning shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle mr-3" style="font-size: 1.5rem; color: #856404;"></i>
                                    <div>
                                        <strong>Persona No Encontrada:</strong> ${json.error || 'No se encontraron resultados'}
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        contenedorResultado.innerHTML = `
                            <div class="card card-warning mt-3 border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h3 class="card-title">
                                        <i class="fas fa-search mr-2"></i> Resultado de la Búsqueda
                                    </h3>
                                </div>
                                <div class="card-body text-center py-5">
                                    <div class="mb-4">
                                        <i class="fas fa-user-slash fa-5x text-muted"></i>
                                    </div>
                                    <h4 class="text-muted mb-3">No se encontraron datos del trabajador</h4>
                                    <div class="alert alert-light border d-inline-block mx-auto px-4 py-2 mb-3">
                                        <strong>Documento consultado:</strong> 
                                        <span class="badge bg-secondary fs-6 p-2">
                                            ${tipoDoc.value}-${nroDoc.value}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        La cédula ingresada no está registrada en el sistema.
                                    </p>
                                </div>
                            </div>
                        `;
                        
                    } else if (response.status === 422) {
                        // Errores de validación
                        let errores = json.errors ? Object.values(json.errors).flat().join(', ') : json.error;
                        contenedorAlertas.innerHTML = `
                            <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>Error de validación:</strong> ${errores}
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        // Otros errores
                        throw new Error(json.error || `Error HTTP: ${response.status}`);
                    }
                    
                    return;
                }

                // Si la respuesta es exitosa, mostrar los resultados
                if (json.html) {
                    contenedorResultado.innerHTML = json.html;
                    contenedorAlertas.innerHTML = ''; // Limpiar alertas
                }

            } catch (error) {
                console.error('Error:', error);
                
                contenedorAlertas.innerHTML = `
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Error:</strong> ${error.message || 'Error al procesar la solicitud'}
                            </div>
                        </div>
                    </div>
                `;
                
            } finally {
                // Rehabilitar botón
                btnBuscar.disabled = false;
                btnBuscar.innerHTML = 'Buscar';
            }
        }

        // Limpiar validaciones cuando el usuario interactúa con los campos
        $('#snacionalidad, #ndocumento').on('change input', function() {
            $(this).removeClass('is-invalid');
            $('#contenedorAlertas').html('');
        });



        // 2. Lógica AJAX idéntica a Jubilados
        // $('#formBusquedaPersona').on('submit', function(e) {
        //     e.preventDefault();
        //     let btn = $('#btnBuscar'), texto = $('#textoBoton'), spinner = $('#spinnerBoton');
        //     let contenedorResultado = $('#resultadoBusqueda'), contenedorAlertas = $('#contenedorAlertas');
        //     let tipoDoc = $('#snacionalidad'), nroDoc = $('#ndocumento');

        //     contenedorResultado.html('');
        //     contenedorAlertas.html('');
        //     $('.form-control, .form-select').removeClass('is-invalid');

        //     // Validación visual de campos vacíos
        //     if (!tipoDoc.val() || !nroDoc.val().trim()) {
        //         if(!tipoDoc.val()) tipoDoc.addClass('is-invalid');
        //         if(!nroDoc.val().trim()) nroDoc.addClass('is-invalid');

        //         contenedorAlertas.html(`
        //             <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
        //                 <div class="d-flex align-items-center">
        //                     <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
        //                     <div><strong>Atención:</strong> Debe completar los campos obligatorios.</div>
        //                 </div>
        //             </div>
        //         `);
        //         return;
        //     }

        //     btn.prop('disabled', true);
        //     texto.addClass('d-none');
        //     spinner.removeClass('d-none');

        //     $.ajax({
        //         url: "{{ route('procesos.consultar.buscar') }}",
        //         method: "POST",
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             // Se maneja la respuesta igual que el ejemplo
        //             if(response.html) {
        //                 contenedorResultado.html(response.html);
        //             } else {
        //                 contenedorResultado.html(response);
        //             }
        //             btn.prop('disabled', false);
        //             texto.removeClass('d-none');
        //             spinner.addClass('d-none');
        //         },
        //         error: function(xhr) {
        //             let mensajeError = "No se pudo procesar la solicitud.";

        //             if (xhr.status === 404 || xhr.status === 500) {
        //                 mensajeError = "Persona no encontrada en SIGEFIRRHH.";
        //             } else if (xhr.status === 422) {
        //                 let errores = xhr.responseJSON.errors;
        //                 mensajeError = Object.values(errores).flat().join(', ');
        //             }

        //             // INYECCIÓN DINÁMICA DEL MODAL DE ERROR
        //             let modalHtml = `
        //             <div class="modal fade" id="ajaxErrorModal" tabindex="-1">
        //                 <div class="modal-dialog">
        //                     <div class="modal-content shadow-lg border-0">
        //                         <div class="modal-header bg-danger text-white">
        //                             <h5 class="modal-title">¡Alerta!</h5>
        //                             <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        //                         </div>
        //                         <div class="modal-body fs-5 text-dark">
        //                             <i class="bi bi-exclamation-triangle-fill"></i> ${mensajeError}
        //                         </div>
        //                         <div class="modal-footer border-0">
        //                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        //                         </div>
        //                     </div>
        //                 </div>
        //             </div>`;

        //             $('#ajaxErrorModal').remove();
        //             $('body').append(modalHtml);
        //             var modal = new bootstrap.Modal(document.getElementById('ajaxErrorModal'));
        //             modal.show();

        //             btn.prop('disabled', false);
        //             texto.removeClass('d-none');
        //             spinner.addClass('d-none');
        //         }
        //     });
        // });

        // $('#snacionalidad, #ndocumento').on('change input', function() {
        //     $(this).removeClass('is-invalid');
        // });
    });
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection
