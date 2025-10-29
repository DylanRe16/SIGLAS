@extends('welcomeExterno')

@section('contrasena')



<main>
    <div class="content-todo row my-3" id="content-todo">
        <div class="content-login">
            <div class="card caja">
                <div class="caja_trasera-register">
                    <center>
                        <h4 class="text-d balc">Defina una contraseña que cumpla las siguientes características</h4>
                    </center>
                    <div class="validaciones caja_trasera-register validaciones-mg" style="color: white; transition: 500ms; margin: 0;">
                        <div class="ul-seguridad validaciones caja_trasera-register validaciones-mg" style="background-color: #fff; box-shadow: 0 3px 6px #00000029; width: 500px; height: auto; margin: 0; padding: 30px; border-radius: 20px;">
                            <ul>
                                <li id="t1" class="text-danger">Al menos <strong>una letra min&uacute;scula</strong></li>
                                <li id="t2" class="text-danger">Al menos <strong>una letra may&uacute;scula</strong></li>
                                <li id="t3" class="text-danger">Al menos <strong>un n&uacute;mero</strong></li>
                                <li id="t4" class="text-danger">Debe contener más de <strong>8 caracteres</strong></li>
                                <li id="t5" class="text-danger">La contrase&ntilde;a <strong>debe tener un carácter especial Ej:(@, #, $, etc.),</strong></li>
                                <li id="t6" class="text-danger">La contrase&ntilde;a <strong>debe coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('clave-store') }}" method="post">
                @csrf
                <div class="col-sm-6 caja2" style="margin-top:0 !important;">
                    <div class="card card-body caja-body">
                        <div class="text-center h1 mb-4">
                            <div style="color: #004B9D;">
                                <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Cambia tu contraseña</b></h4>
                            </div>
                            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
                        </div>

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
                            <div class="form-label fs-6 text-blue">Ingrese su nueva Contraseña <span class="requerido">*</span></div>
                            <div class="input-group">
                                <input type="text" class="form-control" hidden name="id_persona" id="id_persona" value="{{ $id_persona ?? '' }}">
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
                            <div class="form-label fs-6 text-blue">Confirme su nueva Contraseña <span class="requerido">*</span></div>
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
                                <input tabindex="19" type="submit" value="Restablecer" class="btn btn-guardar rounded-pill" title="Restablecer Contraseña">
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/requisitos_contraseña.js') }}"></script>
</main>

@endsection
@section('footer')
@include('layouts.footer')
@endsection