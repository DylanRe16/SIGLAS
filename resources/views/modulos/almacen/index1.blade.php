{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@include('layouts.extenciones')
@section('body_class', 'page-inventario')

@section('title', 'Almacen')


@section('content')

<main class="p-4">




    <div class="card collapsed-card">
        <div class="card-header link-secondary">
            <h3 class="card-title font-weight-bold">Inventario</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body row fs-6">
            <div class="col-md-6">

                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Registro de Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Consulta de Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="card collapsed-card">
        <div class="card-header link-secondary">
            <h3 class="card-title font-weight-bold">Nota de Entrega</h3>
            <div class="card-tools">
                <!-- Collapse Button -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <div class="card-body row fs-6">
            <div class="col-md-6">

                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>150</h3>
                        <p>Registro de Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>44</h3>
                        <p>Consulta de Inventario</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-pie-chart-fill"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>


</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection