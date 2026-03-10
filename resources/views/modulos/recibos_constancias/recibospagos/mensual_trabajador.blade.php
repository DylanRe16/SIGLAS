@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Histórico Mensual')

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
                <h4 class="font-weight-bold">
                    <a href="{{ route('recibos.index') }}" class="link-secondary text-decoration-none">
                        Recibos de Pagos

                    </a>
                    > Consulta de Recibo de Pago Mensual por Trabajador  
                </h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Consulta Histórica Individual</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <form id="formHistorico">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Nro. de Documento<span class="requerido">*</span></div>
                        <input type="text" name="ndocumento" id="ndocumento" class="form-control" placeholder="Ingrese..."
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="11" required>
                        <div class="invalid-feedback">El número de documento es requerido.</div>
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Año<span class="requerido">*</span></div>
                        <select name="anio" id="anio" class="form-select select2" required>
                            <option value="" disabled>Seleccione...</option>
                            @foreach($anios as $a)
                                <option value="{{ $a }}" {{ $a == $anio_actual ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Debe seleccionar un año.</div>
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Mes<span class="requerido">*</span></div>
                        <select name="mes" id="mes" class="form-select select2" required>
                            <option value="" disabled>Seleccione...</option>
                            @foreach($meses as $num => $nombre)
                                <option value="{{ $num }}" {{ $num == $mes_actual ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Debe seleccionar un mes.</div>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary  my-3" id="btnCargar">
                            <span id="textBtn">Buscar</span>
                            <span id="spinBtn" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="resultadoHistorico" class="mt-4"></div>

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
                    <p>Esta sección permite recuperar <strong>recibos de pago de años anteriores</strong> y del año actual de forma individual.</p>
                    <p><strong>Pasos para la consulta:</strong></p>
                    <ul>
                        <li>Ingresa el <strong>Número de Documento</strong> del trabajador.</li>
                        <li>Selecciona el <strong>Año</strong> fiscal que deseas revisar.</li>
                        <li>Escoge el <strong>Mes</strong> específico.</li>
                        <li>Presiona el botón <strong>Buscar</strong> para generar el listado de pagos encontrados.</li>
                    </ul>
                    <p><small class="text-muted">Nota: Si los datos son correctos pero no aparece información, es posible que no existan registros de nómina para ese periodo específico.</small></p>
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
    // 1. Alerta Inicial SweetAlert2
    Swal.fire({
        title: '<strong>Consulta Histórica</strong>',
        icon: 'info',
        html: 'Seleccione el <b>Año y Mes</b> para obtener el detalle de sus conceptos salariales.',
        allowOutsideClick: true,
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#163A7F'
    });

    // 2. Lógica AJAX de Búsqueda
    $('#formHistorico').on('submit', function(e) {
        e.preventDefault();

        // Referencias de UI
        let btn = $('#btnCargar'), 
            texto = $('#textBtn'), 
            spinner = $('#spinBtn'), 
            res = $('#resultadoHistorico');

        // Limpieza de estados previos
        res.html('');
        $('.form-control, .form-select').removeClass('is-invalid');

        // Validación básica antes de enviar
        if (!$('#ndocumento').val() || !$('#anio').val() || !$('#mes').val()) {
            if(!$('#ndocumento').val()) $('#ndocumento').addClass('is-invalid');
            if(!$('#anio').val()) $('#anio').addClass('is-invalid');
            if(!$('#mes').val()) $('#mes').addClass('is-invalid');
            return;
        }

        // UI de carga (Bloquear botón)
        btn.prop('disabled', true);
        texto.addClass('d-none');
        spinner.removeClass('d-none');

        $.ajax({
            url: "{{ route('recibos.historico.buscar') }}",
            type: "POST",
            data: $(this).serialize(),
            dataType: 'json', // Cambiado a JSON para manejar éxito y error bajo el mismo formato
            success: function(response) {
                // Si el controlador mandó status success, inyectamos el HTML
                if (response.status === 'success') {
                    res.html(response.html);
                }

                // Restaurar botón
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            },
            error: function(xhr) {
                console.error("Error capturado:", xhr);
                
                let mensajeError = "No se encontraron registros para el periodo seleccionado.";

                // Si el servidor mandó un mensaje específico (como el 404 del controlador)
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    mensajeError = xhr.responseJSON.message;
                } else if (xhr.status === 404) {
                    mensajeError = "La cédula ingresada no posee registros de nómina en la fecha indicada.";
                }

                // INYECCIÓN DINÁMICA DEL MODAL DE ERROR
                let modalHtml = `
                <div class="modal fade" id="ajaxErrorModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-lg border-0">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> ¡Aviso del Sistema!</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body fs-5 text-dark text-center py-4">
                                ${mensajeError}
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>`;

                // Eliminar modal anterior si existe, agregar nuevo y mostrarlo
                $('#ajaxErrorModal').remove();
                $('body').append(modalHtml);
                var modal = new bootstrap.Modal(document.getElementById('ajaxErrorModal'));
                modal.show();
                
                // Restaurar botón
                btn.prop('disabled', false);
                texto.removeClass('d-none');
                spinner.addClass('d-none');
            }
        });
    });

    // Limpiar clases de error al escribir/cambiar
    $('#ndocumento, #anio, #mes').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection
