@extends('adminlte::master')
@section('title', 'Cambiar Contraseña')

@section('adminlte_css')
@include('layouts.extenciones')

@stop

@section('content_header')
include('welcomeExterno')
@stop

@section('body')
<link rel="stylesheet" href="{{ asset('css/estilos2.css') }}">
<main class="p-4">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title font-weight-bold">Cambiar Contraseña</h4>
        </div>
        <!-- <hr class="mt-0"> -->
        <!-- <center>
            <h4 class="font-weight-bold link-secondary">Defina una contraseña que cumpla las siguientes características</h4>
        </center> -->
        <div class="card-body" style="display: flex;justify-content: space-evenly;flex-direction: row-reverse;">
            <div class="caja">
                <div class="caja_trasera-register">
                    <div class="validaciones caja_trasera-register validaciones-mg" style="color: white; transition: 500ms; margin: 0;">
                        <div class="ul-seguridad validaciones caja_trasera-register validaciones-mg">
                            <ul>
                                <li id="t1" class="text-danger">Al Menos <strong>Una Letra Min&uacute;scula</strong></li>
                                <li id="t2" class="text-danger">Al Menos <strong>Una Letra May&uacute;scula</strong></li>
                                <li id="t3" class="text-danger">Al Menos <strong>Un N&uacute;mero</strong></li>
                                <li id="t4" class="text-danger">Debe Contener más de <strong>8 Caracteres</strong></li>
                                <li id="t5" class="text-danger">La Contrase&ntilde;a <strong>debe tener un Carácter especial Ej:(@, #, $, etc.)</strong></li>
                                <li id="t6" class="text-danger">La Contrase&ntilde;a <strong>debe Coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>





            <form action="{{route('registro-create')}}" method="get">
                @csrf
                <div class="col-sm-10" style="margin-top:0 !important;">
                    <div class="card-body caja-body">
                        <!--  <div class="text-center h1 mb-4">
                            <div style="color: #004B9D;">
                                <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Cambia tu contraseña</b></h4>
                            </div>
                            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
                        </div> -->

                        @if ($errors->any())
                        <div class="alert alert-danger fs-6" id="alert">
                            @foreach ($errors->all() as $error)
                            <i class="bi bi-exclamation-triangle-fill"></i> {{ $error }} <br>
                            @endforeach
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger fs-6" id="alert">
                            {{session('error')}}
                        </div>
                        @elseif (session('success'))
                        <div class="alert alert-success fs-6" id="alert">
                            {{session('success')}}
                        </div>
                        @endif

                        <div class="row">
                            <div class="form-label fs-6 link-secondary">Ingrese su nueva Contraseña <span class="requerido">*</span></div>
                            <div class="input-group">
                                <input
                                    alt="Es obligatorio indicar su contraseña"
                                    type="password"
                                    class="form-control"
                                    title="Contraseña"
                                    placeholder="Ingrese su Contraseña *"
                                    name="password"
                                    id="password"
                                    value="{{ old('password') }}"
                                    required>
                                <span>
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="sep"></div>

                        <div class="row">
                            <div class="form-label fs-6 link-secondary">Confirme su nueva Contraseña <span class="requerido">*</span></div>
                            <div class="input-group">
                                <input
                                    alt="debe confirmar su contraseña"
                                    type="password"
                                    class="form-control"
                                    title="Confirmar Contraseña"
                                    placeholder="Confirme su Contraseña *"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    value="{{ old('password_confirmation') }}"
                                    required>
                                <span>
                                    <i class="bi bi-eye-slash"></i>
                                </span>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-center">
                                <input tabindex="19" type="submit" value="Guardar" class="btn btn-guardar rounded-pill" title="Cambiar Contraseña">
                            </div>
                        </div>

                    </div>
                </div>
            </form>



        </div>
    </div>


    <div class="sep"></div>
    <div class="row ">

    </div>
    <div id="observacion" style="display: none;">
        <div class="alert" id="alert">
            <div id="titulo" class="titulo">
            </div>
            <div id="texto">
            </div>
            <div id="cerrar">
                <a href="#" onclick="cerrar_alert();">Cerrar</a>
            </div>
        </div>
    </div>

    </div>

    </div>
    <script type="text/javascript" src="{{ asset('js/requisitos_contraseña.js') }}"></script>

</main>

@include('layouts.footer')
@stop