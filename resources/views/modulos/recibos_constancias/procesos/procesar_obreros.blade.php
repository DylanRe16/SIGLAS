@extends('adminlte::page')
@extends('layouts.extenciones')

@section('title', 'Cargar Nómina Obreros')

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
                <h4 class="font-weight-bold">Procesos > Cargar Nómina Obreros</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    {{-- Contenedor para alertas dinámicas de JS --}}
    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Carga de Datos: Obreros</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalInfoObreros">
    <i class="bi bi-info-circle"></i>
</button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('procesos.obreros.store') }}" method="POST" id="formCargaObreros">
                @csrf
                {{-- Fila 1: Año y Mes --}}
                <div class="row fs-6 d-flex align-items-end mb-3">
                    <div class="col-md-5">
                        <div class="link-secondary">Año de la Nómina<span class="requerido">*</span></div>
                        <select name="anio" id="anio" class="form-select">
                            <option value="">Seleccione...</option>
                            @for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">Debe seleccionar el año.</div>
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Mes de la Nómina<span class="requerido">*</span></div>
                        <select name="mes" id="mes" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $mes)
                                <option value="{{ $index + 1 }}">{{ $mes }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Debe seleccionar el mes.</div>
                    </div>
                </div>

                {{-- Fila 2: Semana y Ticket --}}
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Semana de la Nómina<span class="requerido">*</span></div>
                        <select name="semana" id="semana" class="form-select">
                            <option value="">Seleccione...</option>
                            @for ($i = 1; $i <= 52; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="invalid-feedback">Debe seleccionar la semana.</div>
                    </div>

                    <div class="col-md-5">
                        <div class="link-secondary">Monto Ticket (BD4)</div>
                        <input type="hidden" name="ticket" value="{{ $ticket->ncodigo }}">
                        <input type="text" class="form-control" readonly value="{{ number_format($ticket->nmonto, 2, ',', '.') }}">
                    </div>

                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class="btn btn-guardar my-3" id="btnCargar">
                            <span id="textoBoton">Cargar </span>
                            <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalInfoObreros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> 
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
                    Deberá ingresar los datos solicitados para cargar la <strong>Nómina de los trabajadores en su condición de Obreros</strong>.
                </p>
                <p>
                    Este proceso extraerá los datos históricos de <strong>SIGEFIRRHH</strong> y los migrará al sistema de recibos de forma segura.
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
        $('#formCargaObreros').on('submit', function(e) {
            let anio = $('#anio');
            let mes = $('#mes');
            let semana = $('#semana');
            let contenedorAlertas = $('#contenedorAlertas');
            let camposVacios = [];

            // Limpiar estados previos
            contenedorAlertas.html('');
            $('.form-select').removeClass('is-invalid');

            // Validación de campos
            if (!anio.val()) { anio.addClass('is-invalid'); camposVacios.push("Año"); }
            if (!mes.val()) { mes.addClass('is-invalid'); camposVacios.push("Mes"); }
            if (!semana.val()) { semana.addClass('is-invalid'); camposVacios.push("Semana"); }

            if (camposVacios.length > 0) {
                e.preventDefault();
                let mensaje = "Debe completar los campos obligatorios: <strong>" + camposVacios.join(', ') + "</strong>.";
                
                contenedorAlertas.html(`
                    <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                            <div><strong>Atención:</strong> ${mensaje}</div>
                        </div>
                    </div>
                `);
                return;
            }

            // Confirmación de seguridad
            if(!confirm('¿Desea proceder con la carga de nómina de obreros para el periodo seleccionado?')) {
                e.preventDefault();
                return;
            }

            // UI de carga
            let btn = $('#btnCargar');
            btn.prop('disabled', true);
            $('#textoBoton').text('Procesando...');
            $('#spinnerBoton').removeClass('d-none');
        });

        // Limpiar validación al interactuar
        $('#anio, #mes, #semana').on('change', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@stop

@section('footer')
    @include('layouts.footer')
@endsection