@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Formatos')
@section('body_class', 'page-Formatos')

@section('content')
<main class="p-4">

<div class="row">

            <div class="col-md-4">

                <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h4>Notificación de Ausencia</h4>
                    <br>
                    <br>
                </div>
                        <div class="icon">
                        <i class="fas bi-card-checklist"></i>
                        </div>

                            <a href="{{ route('formatos-notificacion-ausencia') }}" class="small-box-footer">
                                Más información <i class="fas fa-arrow-circle-right"></i>
                            </a>

                    </div>
                </div>


                <div class="col-md-4 ">
                        <div class="small-box bg-danger">
                                <div class="inner">
                                    <h4>Solicitud de Permiso</h4>
                                    <br>
                                    <br>

                                </div>

                                <div class="icon">
                                    <i class="fas bi-pie-chart-fill"></i>
                                </div>

                                <a href="{{ route('formatos-solicitud-permiso') }}" class="small-box-footer">
                                    Más información <i class="fas fa-arrow-circle-right"></i>
                                </a>
                    </div>
                </div>



                <div class="col-md-4 ">
                     <div class="small-box bg-info">
                        <div class="inner">
                            <h4>Solicitud de Vacaciones</h4>
                            <br>
                            <br>
                        </div>
                        <div class="icon">
                            <i class="fas bi-person"></i>
                        </div>
                        <a href="{{ route('formatos-solicitud-vacaciones') }}" class="small-box-footer">
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
