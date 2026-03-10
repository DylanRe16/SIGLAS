@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Ccombatiente')
@section('body_class', 'page-ccombatiente')

@section('content')
<main class="p-4">




    <div class="row fs-6">
        <div class="@if($rol_usuario == 99) col-md-4 @else col-md-6 @endif ">

            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h4>Registrar</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-card-checklist"></i>
                </div>
                <a href="{{ route('ccombatiente-registrar') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
                <!--  <div class="collapse" id="collapseExample">
                    <button class="btn btn-primary" onclick="location.href='{{ route('ccombatiente-registrar') }}'">Registrar</button>
                </div> -->
            </div>
        </div>
        @if($rol_usuario == 99)

        <div class="@if($rol_usuario == 99) col-md-4 @else col-md-6 @endif ">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Reportes</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-pie-chart-fill"></i>
                </div>
                <a href="{{ route('ccombatiente-reportes') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- </div>
            <div class="row fs-6"> -->
        <div class="col-md-4 ">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Mantenimiento</h4>
                    <br><br>
                </div>
                <div class="icon"><i class="fas fa-file-signature"></i></div>
                <a href="javascript:void(0)" id="btn-mantenimiento" class="small-box-footer">
                    Más información <i class="fas fa-plus-circle"></i>
                </a>
            </div>
        </div>
        @endif

    </div>
    @if($rol_usuario == 99)

    <!--     <div class="link-secondary">
        <h4 class="font-weight-bold">Catalogos <i class="bi bi-caret-down"></i></h4>
    </div>
    <div class="row fs-6">
        <div class="col-md-4">

            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Comunas</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-house"></i>
                </div>
                <a href="{{ route('ccombatiente-mantenimiento-catalogos-comunas') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h4>Registro Rango</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-person-arms-up"></i>
                </div>
                <a href="{{ route('ccombatiente-mantenimiento-catalogos-registro-rango') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div> -->
    @endif
    <div id="opcion-mantenimiento" class="mt-4" style="display: none;">
        <div class="card card-outline card-info shadow-lg">
            <div class="card-header">
                <h3 class="card-title bold"><i class="fas fa-list-ul mr-2"></i> Seleccione </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="btn-cerrar-constancias">
                        <i class="fas fa-times fa-lg text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-5">
                        <div class="info-box bg-gradient-light shadow-sm border-success"
                            style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                            onclick="window.location='{{ route('ccombatiente-mantenimiento-usuarios') }}'"

                            onmouseover="this.style.transform='scale(1.02)';"
                            onmouseout="this.style.transform='scale(1)';">

                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas bi-person"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold" style="font-size: 1.1rem;font-weight: normal;">Usuarios</span>
                                <span class="info-box-number text-muted font-weight-normal">
                                    Control de accesos, roles y permisos del sistema.
                                </span>

                            </div>
                        </div>
                    </div>
                    <div class="link-secondary">
                        <h4 class="font-weight-bold">Catalogos</h4>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-5">
                            <div class="info-box bg-gradient-light shadow-sm border-success"
                                style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                                onclick="window.location='{{ route('ccombatiente-mantenimiento-catalogos-registro-rango') }}'"

                                onmouseover="this.style.transform='scale(1.02)';"
                                onmouseout="this.style.transform='scale(1)';">

                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas bi-person-arms-up"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-bold" style="font-size: 1.1rem;font-weight: normal;">Registro Rango</span>
                                    <span class="info-box-number text-muted font-weight-normal">
                                        Administración de registros militares: permite crear, editar y consultar el escalafón
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div class="info-box bg-gradient-light shadow-sm border-success"
                                style="cursor: pointer; min-height: 110px; transition: 0.3s;"
                                onclick="window.location='{{ route('ccombatiente-mantenimiento-catalogos-comunas') }}'"

                                onmouseover="this.style.transform='scale(1.02)';"
                                onmouseout="this.style.transform='scale(1)';">

                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas bi-house"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text text-bold" style="font-size: 1.1rem;font-weight: normal;">Comunas</span>
                                    <span class="info-box-number text-muted font-weight-normal">
                                        Permite gestionar la creación, edición y consulta de las comunas registradas en el sistema.
                                    </span>

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
            $('#opcion-mantenimiento').slideUp('fast');
        }

        // --- LÓGICA PARA CONSTANCIAS ---
        $('#btn-mantenimiento').click(function(e) {
            e.preventDefault();
            if ($('#opcion-mantenimiento').is(':visible')) {
                $('#opcion-mantenimiento').slideUp('fast');
            } else {
                cerrarTodo();
                $('#opcion-mantenimiento').slideToggle('fast');
            }
        });

        $('#btn-cerrar-constancias').click(function() {
            $('#opcion-mantenimiento').slideUp('fast');
        });



    });
</script>
@endsection
@section('footer')
@include('layouts.footer')
@endsection