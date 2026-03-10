@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Registro de Novedades')


@section('content')
<main class="p-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Siris > Subsanaciones</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Subsanaciones</h3>
            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <!-- This will cause the card to be removed when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row mb-3 justify-content-center">
                <div class="col-md-6 ">
                    <div class="link-secondary">
                        RIF
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <select name="" id="" class="form-select"></select>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="rif" id="rif" placeholder="RIF">
                        </div>
                        <div class="col-sm-2">
                            <select name="" id="" class="form-select"></select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  justify-content-center mb-4">
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
            <!-- <div class="col-md-1">
                <button class="btn btn-danger">Limpiar</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success">Imprimir</button>
            </div> -->
        </div>
    </div>
    <div class="card card-light">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Listado de Insolvencias</h3>
            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <!-- This will cause the card to be removed when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">

                    <table id="miTabla" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Registro</th>
                                <th>Entidad de Trabajo</th>
                                <th>Rif</th>
                                <th>Origen</th>
                                <th>Razón</th>
                                <th>Fecha</th>
                                <th>Registro Subsanación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Empresa</td>
                                <td>J123456789</td>
                                <td>Origen</td>
                                <td>Razón</td>
                                <td>Fecha</td>
                                <td>Registro Subsanación</td>
                                <td>
                                    <a href="#" class="btn btn-primary">Ver</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</main>
@endsection

@section('footer')
@include('layouts.footer')
@endsection