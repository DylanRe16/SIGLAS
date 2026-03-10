@extends('adminlte::page')
@include('layouts.extenciones')
@section('body_class', 'page-inventario')

@section('title', 'Almacen')

@section('content')
<main class="p-4">
    {{--@include('layouts.menu')--}}



    <div class="row fs-6">
        <div class="col-md-3">

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
        <div class="col-md-3">
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

        <!-- </div>
            <div class="row fs-6"> -->
        <div class="col-md-3">

            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Mantenimiento</h4>
                    <br>
                    <br>
                </div>
                <div class="icon">
                    <i class="fas bi-nut"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h4>Ayuda</h4>
                    <br>
                    <br>
                </div>
                <div class="icon">
                    <i class="fas bi-info-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>



</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection