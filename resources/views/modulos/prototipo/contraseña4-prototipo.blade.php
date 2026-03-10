@extends('prototipoInterno')

@section('contenido')


<main>
@include('modulos.prototipo.menu-prototipo')
    <div class="content-todo row" id="content-todo">
        <div class="content-login" style="margin-top:0 !important;">
            <div class="card caja" style="margin-top:0 !important;">
                <div class="caja_trasera-register">
                    <center>
                        <h4 class="text-d balc">Defina una contraseña que cumpla las siguientes características</h4>
                    </center>
                    <div class="validaciones caja_trasera-register validaciones-mg" style="color: white; transition: 500ms; margin: 0;">
                        <div class="ul-seguridad validaciones caja_trasera-register validaciones-mg">
                            <ul>
                                <li id="t1" class="text-danger">Al Menos <strong>Una Letra Min&uacute;scula</strong></li>
                                <li id="t2" class="text-danger">Al Menos <strong>Una Letra May&uacute;scula</strong></li>
                                <li id="t3" class="text-danger">Al Menos <strong>Un N&uacute;mero</strong></li>
                                <li id="t4" class="text-danger">Debe Contener más de <strong>10 Caracteres</strong></li>
                                <li id="t5" class="text-danger">La Contrase&ntilde;a <strong>debe tener un Carácter especial Ej:(@, #, $, etc.)</strong></li>
                                <li id="t6" class="text-danger">La Contrase&ntilde;a <strong>debe Coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('clave-update') }}" method="post">
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
                                <input tabindex="19" type="submit" value="Guardar" class="btn btn-guardar rounded-pill" title="Cambiar Contraseña">
                            </div>
                        </div>
                    
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .content-todo {
            margin-top: 0 !important;
            margin-bottom: 0.5rem !important;
        }

        .content-login {
            margin-top: 0 !important;
        }

        .card.caja {
            margin-top: 0 !important;
            margin-bottom: 1rem !important;
            padding: 1.2rem 1.8rem;
        }

        .col-sm-6.caja2 {
            margin-top: 0 !important;
        }

        .caja_trasera-register {
            margin-left: 110px !important; /* MÁS a la derecha */
            padding: 18px 24px !important;
        }

        .ul-seguridad {
            background-color: #fff;
            box-shadow: 0 3px 6px #00000029;
            width: 420px !important;
            padding: 24px !important;
            border-radius: 18px !important;
            margin: 0 auto;
            color: black;
        }

        .ul-seguridad ul {
            padding-left: 22px;
            margin-bottom: 14px;
        }

        .ul-seguridad ul li {
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .caja-body {
            padding: 1.8rem !important;
        }

        h4, h6 {
            margin-bottom: 0.75rem !important;
        }

        .input-group {
            margin-top: 0.75rem !important;
            margin-bottom: 0.75rem !important;
        }

        .input-group input.form-control {
            flex-grow: 1;
        }

        .password-toggle, .password-toggle2 {
            cursor: pointer;
            align-self: center;
            padding-left: 10px;
        }

        .btn-guardar {
            padding: 0.5rem 2.5rem;
            font-size: 1.05rem;
        }

        .requerido {
            margin-bottom: 0.75rem !important;
        }

        img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .password-toggle img, .password-toggle2 img {
            width: 16px;
            height: 16px;
            object-fit: contain;
        }
    </style>

</main>

@endsection
