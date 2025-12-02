@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Ccombatiente')
@section('body_class', 'page-ccombatiente')

@section('content')
<main class="p-4">




    <div class="row fs-6">
        <div class="col-md-4">

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
        <div class="col-md-4">
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
        <div class="col-md-4">

            <div class="small-box bg-info">
                <div class="inner">
                    <h4>Usuarios</h4>
                    <br>
                    <br>
                </div>
                <div class="icon">
                    <i class="fas bi-person"></i>
                </div>
                <a href="{{ route('ccombatiente-mantenimiento-usuarios') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
       
    </div>
    <div class="link-secondary">
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
    </div>



</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection