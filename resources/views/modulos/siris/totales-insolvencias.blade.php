@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Registro de Novedades')


@section('content')
<main class="p-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Siris > Consultas de Insolvencias</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Total de Insolvencias</h3>
            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
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
                                <th>Inspectoria</th>
                                <th>Ultimo Fecha de carga</th>
                                <th>Total de Insolvencias</th>
                                <th>Fecha Última Novedad Reportada</th>
                                <th>Días Habiles sin Reportar Novedad</th>
                                <th>Días Habiles sin Cargar</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CABIMAS</td>
                                <td>01/01/2023</td>
                                <td>1</td>
                                <td>01/01/2023</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('footer')
@include('layouts.footer')
@endsection