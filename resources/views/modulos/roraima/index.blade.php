@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Gestión Proyectos - Roraima')

@section('content')

<main class="p-4">
    <div class="row">
        {{-- Box: Proyectos --}}
        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h4>Proyectos</h4>
                    <br><br>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="javascript:void(0)" id="btn-proyectos" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        {{-- Box: Asignar Usuarios --}}
        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Asignar Usuarios</h4>
                    <br><br>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="javascript:void(0)" id="btn-asignar-usuarios" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        {{-- Box: Solicitudes --}}
        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h4>Solicitudes</h4>
                    <br><br>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <a href="javascript:void(0)" id="btn-solicitudes" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>

        {{-- Box: Variables --}}
        <div class="col-md-4 col-sm-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Variables</h4>
                    <br><br>
                </div>
                <div class="icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <a href="javascript:void(0)" id="btn-variables" class="small-box-footer">
                    Más Información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- SECCIÓN: PROYECTOS --}}
    <div id="opciones-proyectos" class="mt-4" style="display: none;">
        <div class="card card-outline card-success shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold"><i class="fas fa-list-ul mr-2"></i> Seleccione</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-cerrar-seccion">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-success" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/proyectos') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Ver todos los proyectos">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-folder-open"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Proyectos</span>
                                <span class="info-box-number text-muted font-weight-normal">Gestión y visualización de proyectos activos e inactivos.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-success" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/acciones-centralizadas') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Acciones Centralizadas">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bullseye"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Acciones Centralizadas</span>
                                <span class="info-box-number text-muted font-weight-normal">Control y ejecución de tareas administrativas centrales.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN: ASIGNAR USUARIOS --}}
    <div id="opciones-asignar-usuarios" class="mt-4" style="display: none;">
        <div class="card card-outline card-info shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold"><i class="fas fa-list-ul mr-2"></i> Seleccione</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-cerrar-seccion">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-info" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/asignar-proyectos') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Asignar usuarios a proyectos">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Asignar a Proyectos</span>
                                <span class="info-box-number text-muted font-weight-normal">Vincular personal responsable a los proyectos registrados.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-info" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/asignar-acciones') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Asignar usuarios a acciones centralizadas">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Asignar a Acción Centralizada</span>
                                <span class="info-box-number text-muted font-weight-normal">Vincular personal a las tareas de administración central.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN: SOLICITUDES --}}
    <div id="opciones-solicitudes" class="mt-4" style="display: none;">
        <div class="card card-outline card-warning shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold"><i class="fas fa-list-ul mr-2"></i> Seleccione</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-cerrar-seccion">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-warning" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/proyectos-requerimientos') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Requerimientos de Proyectos">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Proyectos Requerimientos</span>
                                <span class="info-box-number text-muted font-weight-normal">Gestión de solicitudes y necesidades asociadas a proyectos.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-warning" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/acc-requerimientos') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Requerimientos de ACC">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">ACC Requerimientos</span>
                                <span class="info-box-number text-muted font-weight-normal">Gestión de solicitudes para Acciones Centralizadas.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN: VARIABLES --}}
    <div id="opciones-variables" class="mt-4" style="display: none;">
        <div class="card card-outline card-danger shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold"><i class="fas fa-list-ul mr-2"></i> Seleccione</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-cerrar-seccion">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-danger" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/variables/proyectos') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Variables de Proyecto">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-project-diagram"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Proyecto</span>
                                <span class="info-box-number text-muted font-weight-normal">Configuración de variables específicas para proyectos.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-danger" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/variables/acciones') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Variables de Acción Centralizada">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-bullseye"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Acción Centralizada</span>
                                <span class="info-box-number text-muted font-weight-normal">Parámetros de las Acciones Centralizadas del sistema.</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="info-box bg-gradient-light shadow-sm border-danger" style="cursor: pointer; min-height: 110px; transition: 0.3s;" onclick="window.location='{{ url('roraima/variables/reportes') }}'" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';" title="Reportes de Planificación">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem; font-weight: normal;">Reportes Planificación</span>
                                <span class="info-box-number text-muted font-weight-normal">Variables destinadas a los informes de planificación.</span>
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
    
    function cerrarTodo() {
        $('#opciones-proyectos, #opciones-asignar-usuarios, #opciones-solicitudes, #opciones-variables').slideUp('fast');
    }

    // Lógica genérica para botones de Small Box
    $('#btn-proyectos').click(function(e) {
        e.preventDefault();
        toggleSeccion('#opciones-proyectos');
    });

    $('#btn-asignar-usuarios').click(function(e) {
        e.preventDefault();
        toggleSeccion('#opciones-asignar-usuarios');
    });

    $('#btn-solicitudes').click(function(e) {
        e.preventDefault();
        toggleSeccion('#opciones-solicitudes');
    });

    $('#btn-variables').click(function(e) {
        e.preventDefault();
        toggleSeccion('#opciones-variables');
    });

    function toggleSeccion(id) {
        if ($(id).is(':visible')) {
            $(id).slideUp('fast');
        } else {
            cerrarTodo();
            $(id).slideDown('fast');
        }
    }

    // Botón de cerrar dentro de las cards
    $('.btn-cerrar-seccion').click(function() {
        cerrarTodo();
    });
});
</script>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection