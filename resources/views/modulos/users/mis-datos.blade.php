@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Ccombatiente')
@section('body_class', 'page-ccombatiente')

@section('content')
<main class="p-4">
    <div class="row fs-6">
        <div class="col-md-6">

            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h4>Preguntas de Seguridad</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-card-checklist"></i>
                </div>
                <a href="{{ route('preguntaSeg-edit') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
                <!--  <div class="collapse" id="collapseExample">
                    <button class="btn btn-primary" onclick="location.href='{{ route('ccombatiente-registrar') }}'">Registrar</button>
                </div> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>Cambiar Contraseña</h4>
                    <br>
                    <br>

                </div>
                <div class="icon">
                    <i class="fas bi-pie-chart-fill"></i>
                </div>
                <a href="{{ route('contrasena-3') }}" class="small-box-footer">
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