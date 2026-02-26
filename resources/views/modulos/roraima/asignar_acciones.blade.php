{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Roraima - Proyectos')


@section('content')

<main class="p-4">
     @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Asignar Usuario > Asignar a Acción Centralizada</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title font-weight-bold">Rol(es) de Usuario</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalInfo">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">

            <div class="row fs-6 d-flex align-items-end mb-3">
                <div class="col-md-5">
                    <div class="link-secondary">Cédula de Identidad<span class="requerido">*</span></div>
                    <div class="input-group">
                        <select id="nacionalidad" class="form-select border-right-0 rounded-search-left" style="max-width: 75px;">
                            <option value="1">V-</option>
                            <option value="2">E-</option>
                        </select>
                        <input type="text" id="txt_cedula" class="form-control" maxlength="8" placeholder="Ingrese número..." oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <button class="btn btn-primary px-3 rounded-search-right" id="btnBuscar" onclick="ejecutarAccion(1)">
                            <i class="fas fa-search" id="iconBuscar"></i>
                            <span id="spinnerBuscar" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="link-secondary">Nombre(s) y Apellido(s)</div>
                    <input type="text" id="nombres" class="form-control" style="background: #e9ecef; border-radius: 30px;" readonly placeholder="Esperando búsqueda...">
                </div>
            </div>

            <div class="row fs-6 d-flex align-items-end mb-4">
                <div class="col-md-5">
                    <div class="link-secondary">Nuevo Rol<span class="requerido">*</span></div>
                    <select id="rol" class="form-select select2" style="border-radius: 30px;">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="col-md-7 d-flex justify-content-center gap-2">
                    <button class="btn btn-guardar px-4" onclick="ejecutarAccion(2)">Asignar</button>
                </div>
            </div>

        </div>

        <div class="card card-light mt-4">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Tabla de Usuarios</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="miTabla2" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center">Nro</th>
                                <th class="text-center">Cédula</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Apellido</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection

@section('js')
<script>
    $(document).ready(function() {
    $('#miTabla2').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[0, "asc"]],
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" }
    });

    // Quitar alertas al escribir
    $('#txt_cedula').on('input', function() {
        $('#msg-error-cedula').addClass('d-none');
        $('#contenedorAlertas').html('');
    });
});

</script>
@endsection

@section('css')
<style>
     table.dataTable thead th {
        padding-right: 30px !important;
        position: relative;
    }

    .dataTables_length select {
        padding-right: 25px !important;
        min-width: 60px !important;
    }
    
    #miTabla2 td {
        vertical-align: middle;
    }

    .btn-guardar {
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff !important;
    }
    .btn-guardar:hover {
        background-color: #0056b3 !important;
        transform: scale(1.02);
    }

</style>
@endsection

@section('footer')
@include('layouts.footer')
@endsection