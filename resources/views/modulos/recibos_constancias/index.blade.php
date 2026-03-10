@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'recibosconstancias')

@section('content')

<main class="p-4">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h4>Constancias de Trabajo</h4>
                    <br><br>
                </div>
                <div class="icon"><i class="fas fa-file-signature"></i></div>
                <a href="javascript:void(0)" id="btn-constancias" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

       <div class="col-md-4 col-sm-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Recibos de Pago</h4>
                    <br><br>
                </div>
                <div class="icon"><i class="fas fa-money-check-alt"></i></div>
                <a href="javascript:void(0)" id="btn-recibos" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4>Mantenimiento</h4>
                   <br><br>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="javascript:void(0)" id="btn-mantenimiento" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Procesos</h4>
                    <br><br>
                </div>
                <div class="icon"><i class="fas fa-cogs"></i></div>
                <a href="javascript:void(0)" id="btn-procesos" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- SECCIÓN DE OPCIONES: CONSTANCIAS --}}

    <div id="opciones-constancias" class="mt-4" style="display: none;">
    <div class="card card-outline card-success shadow-lg">
        <div class="card-header">
            <h3 class="card-title bold">
                <i class="fas fa-list-ul mr-2"></i> Constancias de Trabajo
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" id="btn-cerrar-constancias">
                    <i class="fas fa-times fa-lg text-danger"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row d-flex align-items-stretch">
                
                {{-- Constancia Simple con Sueldo --}}
                <div class="col-md-6 mb-4">
                    <div class="info-box bg-gradient-light shadow-sm border-success h-100"
                        style="cursor: pointer; transition: 0.3s; display: flex;"
                        onclick="window.open('{{ route('recibos.simple-sueldo') }}', '_blank')"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para generar">

                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>

                        <div class="info-box-content d-flex flex-column justify-content-between">
                            <div>
                                <span class="info-box-text" style="font-size: 1.1rem;">Constancia de Trabajo</span>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.2;">
                                    Documento formal emitido por la institución donde se certifica que un trabajador mantiene actualmente una relación laboral vigente.
                                </p>
                            </div>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Constancia de Egreso --}}
                <div class="col-md-6 mb-4">
                    <div class="info-box bg-gradient-light shadow-sm border-danger h-100"
                        style="cursor: pointer; transition: 0.3s; display: flex;"
                        onclick="window.location='{{ route('recibos.egresado') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para ir a Egresados">

                        <span class="info-box-icon bg-danger elevation-1">
                            <i class="fas fa-user-minus"></i>
                        </span>

                        <div class="info-box-content d-flex flex-column justify-content-between">
                            <div>
                                <span class="info-box-text " style="font-size: 1.1rem;">Constancia de Egreso</span>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.2;">
                                    Documento que certifica que una persona culminó satisfactoriamente su relación laboral o período de servicio en la institución.
                                </p>
                            </div>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-danger" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Referencia FAOV --}}
                <div class="col-md-6 mb-4">
                    <div class="info-box bg-gradient-light shadow-sm border-info h-100"
                        style="cursor: pointer; transition: 0.3s; display: flex;"
                        onclick="window.location='{{ route('recibos.faov') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para generar FAOV">

                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-home"></i>
                        </span>

                        <div class="info-box-content d-flex flex-column justify-content-between">
                            <div>
                                <span class="info-box-text " style="font-size: 1.1rem;">FAOV</span>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.2;">
                                    Certifica la afiliación y el estatus de aportes del trabajador al régimen de ahorro habitacional obligatorio.
                                </p>
                            </div>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Consulta por Trabajador --}}
                <div class="col-md-6 mb-4">
                    <div class="info-box bg-gradient-light shadow-sm border-success h-100"
                        style="cursor: pointer; transition: 0.3s; display: flex;"
                        onclick="window.location='{{ route('recibos.buscarsueldo.index') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para buscar trabajador">

                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-search"></i>
                        </span>

                        <div class="info-box-content d-flex flex-column justify-content-between">
                            <div>
                                <span class="info-box-text " style="font-size: 1.1rem;">Consulta por Trabajador</span>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.2;">
                                    Búsqueda personalizada y generación de documento oficial con desglose para trabajadores activos.
                                </p>
                            </div>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jubilados --}}
                <div class="col-md-6 mb-4">
                    <div class="info-box bg-gradient-light shadow-sm border-info h-100"
                        style="cursor: pointer; transition: 0.3s; display: flex;"
                        onclick="window.location='{{ route('recibos.jubilados') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para buscar jubilado o pensionado">

                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-blind"></i>
                        </span>

                        <div class="info-box-content d-flex flex-column justify-content-between">
                            <div>
                                <span class="info-box-text " style="font-size: 1.1rem;">Jubilados</span>
                                <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.2;">
                                    Documento oficial que certifica la condición de jubilado(a) o pensionado(a) y su beneficio económico.
                                </p>
                            </div>
                            <div class="progress mt-2" style="height: 3px;">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

   {{-- SECCIÓN DE OPCIONES: RECIBOS --}}
<div id="opciones-recibos" class="mt-4" style="display: none;">
    <div class="card card-outline card-info shadow-lg">
        <div class="card-header">
            <h3 class="card-title bold">
                <i class="fas fa-list-ul mr-2"></i> Recibos de Pago
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool d-none" id="btn-volver-recibos" title="Volver atrás">
                    <i class="fas fa-arrow-left fa-lg text-info"></i>
                </button>
                <button type="button" class="btn btn-tool" id="btn-cerrar-recibos">
                    <i class="fas fa-times fa-lg text-danger"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- NIVEL 1: OPCIONES PRINCIPALES --}}
            <div class="row" id="recibos-nivel-1">
                {{-- Opción: Año Actual --}}
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="info-box bg-gradient-light shadow-sm border-info"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        id="btn-submenu-año"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para ver desglose">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Año Actual</span>
                            <span class="info-box-number text-muted font-weight-normal">Desglose de nóminas del presente ejercicio fiscal.</span>
                        </div>
                    </div>
                </div>

                {{-- Opción: Jubilados --}}
                <div class="col-md-6 col-lg-6 mb-3">
                    <div class="info-box bg-gradient-light shadow-sm border-primary"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('recibos.jubilados.index') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Recibos de Jubilados">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-blind"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Jubilados</span>
                            <span class="info-box-number text-muted font-weight-normal">Recibos para personal en condición de jubilación.</span>
                        </div>
                    </div>
                </div>

                {{-- Opción: Mensual por Trabajador --}}
                <div class="col-md-8 col-lg-6 mb-3">
                    <div class="info-box bg-gradient-light shadow-sm border-success"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location.href='{{ route('recibos.mensual.trabajador') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Búsqueda Histórica">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-tag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Mensual por Trabajador</span>
                            <span class="info-box-number text-muted font-weight-normal">Búsqueda histórica individualizada.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NIVEL 2: SUB-MENÚ AÑO ACTUAL --}}
            <div class="row d-none" id="recibos-nivel-2-año">
                <div class="col-md-6 col-lg-5 mb-3">
                    <div class="info-box bg-gradient-light shadow-sm border-secondary"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('recibos.pago.ordinarios') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Pagos Ordinarios</span>
                            <span class="info-box-number text-muted font-weight-normal">Sueldos, salarios y bonos fijos mensuales.</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 mb-3">
                    <div class="info-box bg-gradient-light shadow-sm border-warning"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('recibos.pago.especiales') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Pagos Especiales</span>
                            <span class="info-box-number text-muted font-weight-normal">Vacaciones, aguinaldos y bonos únicos.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- SECCIÓN DE OPCIONES: PROCESOS --}}
<div id="opciones-procesos" class="mt-4" style="display: none;">
    <div class="card card-outline card-danger shadow-lg">
        <div class="card-header">
            <h3 class="card-title bold">
                <i class="fas fa-list-ul mr-2"></i> Seleccione
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" id="btn-cerrar-procesos">
                    <i class="fas fa-times fa-lg text-danger"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- SECCIÓN 1: ACCIONES GENERALES --}}
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div class="info-box bg-gradient-light shadow-sm border-success"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('procesos.actualizar') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para actualizar datos del personal">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-user-edit"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Actualizar Personal</span>
                            <span class="info-box-number text-muted font-weight-normal">
                                Modificar datos básicos y cargos.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="info-box bg-gradient-light shadow-sm border-success"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('procesos.consultar') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Haga clic para consultar expedientes">
                        <span class="info-box-icon bg-success elevation-1">
                            <i class="fas fa-search"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Consultar Datos</span>
                            <span class="info-box-number text-muted font-weight-normal">
                                Búsqueda detallada por trabajador.
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN SUBTITULO EXACTO A MANTENIMIENTO --}}
            <div class="link-secondary mt-3">
                <h4 class="font-weight-bold">Opciones de Nóminas <!-- <i class="bi bi-caret-down"></i> --></h4>
                <hr>
            </div>

            {{-- SECCIÓN 2: PROCESAMIENTO DIRECTO --}}
            <div class="row">
                {{-- FUNCIONARIOS --}}
                <div class="col-md-6 col-lg-5">
                    <div class="info-box bg-gradient-light shadow-sm border-success"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('procesos.funcionarios.index') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Procesar Nómina Funcionarios">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Nómina Funcionarios</span>
                            <span class="info-box-number text-muted font-weight-normal">
                                Ejecutar cálculo para personal administrativo.
                            </span>
                        </div>
                    </div>
                </div>

                {{-- OBREROS --}}
                <div class="col-md-6 col-lg-5">
                    <div class="info-box bg-gradient-light shadow-sm border-success"
                        style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                        onclick="window.location='{{ route('procesos.obreros.index') }}'"
                        onmouseover="this.style.transform='scale(1.02)';"
                        onmouseout="this.style.transform='scale(1)';"
                        title="Procesar Nómina Obreros">
                        <span class="info-box-icon bg-info elevation-1">
                            <i class="fas fa-hard-hat"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Nómina Obreros</span>
                            <span class="info-box-number text-muted font-weight-normal">
                                Ejecutar cálculo para personal obrero.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- SECCIÓN DE OPCIONES: MANTENIMIENTO --}}
    <div id="opciones-mantenimiento" class="mt-4" style="display: none;">
        <div class="card card-outline card-warning shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold">
                    <i class="fas fa-list-ul mr-2"></i> Seleccione
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="btn-cerrar-mantenimiento">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Tickets de Alimentación --}}
                    <div class="col-md-6 col-lg-5">
                        <div class="info-box bg-gradient-light shadow-sm border-warning"
                            style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                            onclick="window.location='{{ route('mantenimiento.tickets.index') }}'"
                            onmouseover="this.style.transform='scale(1.02)';"
                            onmouseout="this.style.transform='scale(1)';"
                            title="Gestionar Tickets">

                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-utensils"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Tickets de Alimentación</span>
                                <span class="info-box-number text-muted font-weight-normal">
                                    Configuración de montos y carga de tickets.
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Usuarios --}}
                    <div class="col-md-6 col-lg-5">
                        <div class="info-box bg-gradient-light shadow-sm border-primary"
                            style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                            onclick="window.location='{{ route('recibos_constancias.mantenimiento.usuarios.index') }}'"
                            onmouseover="this.style.transform='scale(1.02)';"
                            onmouseout="this.style.transform='scale(1)';"
                            title="Gestionar Usuarios">

                            <span class="info-box-icon bg-primary elevation-1">
                                <i class="fas fa-users-cog"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Gestión de Usuarios</span>
                                <span class="info-box-number text-muted font-weight-normal">
                                    Control de accesos, roles y permisos del sistema.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    </div>
</div>

</div>

</main>

@endsection

@section('js')
<script>
$(document).ready(function() {

    // Función auxiliar para cerrar todos los paneles abiertos
    function cerrarTodo() {
        $('#opciones-constancias, #opciones-recibos, #opciones-procesos, #opciones-mantenimiento').slideUp('fast');
    }

    // --- LÓGICA PARA CONSTANCIAS ---
    $('#btn-constancias').click(function(e) {
        e.preventDefault();
        if ($('#opciones-constancias').is(':visible')) {
            $('#opciones-constancias').slideUp('fast');
        } else {
            cerrarTodo();
            $('#opciones-constancias').slideToggle('fast');
        }
    });

    $('#btn-cerrar-constancias').click(function() {
        $('#opciones-constancias').slideUp('fast');
    });

    // --- LÓGICA PARA MANTENIMIENTO ---
    $('#btn-mantenimiento').click(function(e) {
        e.preventDefault();
        if ($('#opciones-mantenimiento').is(':visible')) {
            $('#opciones-mantenimiento').slideUp('fast');
        } else {
            cerrarTodo();
            $('#opciones-mantenimiento').slideToggle('fast');
        }
    });

    $('#btn-cerrar-mantenimiento').click(function() {
        $('#opciones-mantenimiento').slideUp('fast');
    });


    // --- LÓGICA PARA RECIBOS ---
    $('#btn-recibos').click(function(e) {
        e.preventDefault();
        if ($('#opciones-recibos').is(':visible')) {
            $('#opciones-recibos').slideUp('fast');
        } else {
            cerrarTodo();
            $('#opciones-recibos').slideToggle('fast');
            resetRecibosMenu();
        }
    });

    $('#btn-submenu-año').click(function() {
        $('#recibos-nivel-1').addClass('d-none');
        $('#recibos-nivel-2-año').removeClass('d-none').addClass('animate__animated animate__fadeInLeft');
        $('#btn-volver-recibos').removeClass('d-none');
        $('#titulo-recibos').html('<i class="fas fa-calendar-check mr-2"></i> Recibos: Año Actual');
    });

    $('#btn-volver-recibos').click(function() {
        resetRecibosMenu();
    });

    $('#btn-cerrar-recibos').click(function() {
        $('#opciones-recibos').slideUp('fast');
        resetRecibosMenu();
    });

    function resetRecibosMenu() {
        $('#recibos-nivel-2-año').addClass('d-none');
        $('#recibos-nivel-1').removeClass('d-none');
        $('#btn-volver-recibos').addClass('d-none');
        $('#titulo-recibos').html('<i class="fas fa-list-ul mr-2"></i> Seleccione');
    }


    // --- LÓGICA PARA PROCESOS ---
    $('#btn-procesos').click(function(e) {
        e.preventDefault();
        if ($('#opciones-procesos').is(':visible')) {
            $('#opciones-procesos').slideUp('fast');
        } else {
            cerrarTodo();
            $('#opciones-procesos').slideToggle('fast');
        }
    });

    $('#btn-cerrar-procesos').click(function() {
        $('#opciones-procesos').slideUp('fast');
    });

});
</script>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
