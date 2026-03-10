@extends('prototipoInterno')

@section('contenido')

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
                                <li id="t4" class="text-danger">Debe contener más de <strong>10 caracteres</strong></li>
                                <li id="t5" class="text-danger">La contrase&ntilde;a <strong>debe tener un carácter especial Ej:(@, #, $, etc.),</strong></li>
                                <li id="t6" class="text-danger">La contrase&ntilde;a <strong>debe coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 caja2">
                <div class="card card-body caja-body">
                    <div class="text-center h1 mb-5">
                        <div style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Cambia tu contraseña</b></h4>
                        </div>
                        <div class="requerido h6">Campos obligatorios (*)</div>
                    </div>

                    <div class="alert alert-danger fs-6" id="contenedor-errores-js" style="display: none;">
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger fs-6">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-12 d-flex flex-column align-items-center">
                            <h6 style="color: #004B9D;">Ingrese su nueva contraseña <span class="requerido">*</span></h6>
                            <div class="row">
                                <div class="input-group mt-2">
                                    <div class="col-sm-11">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Escribe tu nueva contraseña">
                                    </div>
                                    <div class="col-sm-1">
                                        <span class="password-toggle">
                                            <img src="img/ojo.png" width="16" height="16" alt="Mostrar Contraseña" id="ojoImagen">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 d-flex flex-column align-items-center mt-4">
                        <h6 style="color: #004B9D;">Confirme su nueva contraseña <span class="requerido">*</span></h6>
                        <div class="row">
                            <div class="input-group mt-2">
                                <div class="col-sm-11">
                                    <input type="password" id="password2" name="password" class="form-control" placeholder="Confirme tu nueva contraseña">
                                </div>
                                <div class="col-sm-1">
                                    <span class="password-toggle2">
                                        <img src="img/ojo.png" width="16" height="16" alt="Mostrar Contraseña" id="ojoImagen2">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 text-center mt-4">
                        <form action="{{ route('inicio-prototipo') }}" method="POST">
                            @csrf
                            <input type="submit" value="Guardar" class="buttom"
                                style="width: 100%; font-size: 16px; background-color: #46A2FD; border: 1px solid #46A2FD; color: #fff; font-weight: bold;"
                                onmouseout="this.style.color='#fff'; this.style.backgroundColor='#46A2FD'; this.style.border='1px solid #46A2FD'"
                                onmouseover="this.style.color='#46A2FD'; this.style.backgroundColor='#fff';"
                                data-bs-toggle="tooltip" data-bs-placement="right" title="Registrar Usuario">
                        </form>

                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        .password-toggle img, .password-toggle2 img {
            width: 16px; /* Tamaño fijo */
            height: 16px;
            object-fit: contain; /* Evita la distorsión */
        }


    </style>

    <script>
       document.addEventListener("DOMContentLoaded", function() {
            // Asegurar que las contraseñas estén ocultas inicialmente
            const ojoImagen = document.getElementById('ojoImagen');
            const ojoImagen2 = document.getElementById('ojoImagen2');

            ojoImagen.src = "img/ojo_cerrado.png";
            ojoImagen2.src = "img/ojo_cerrado.png";

            const passwordInput = document.getElementById('password');
            const passwordToggle = document.querySelector('.password-toggle');

            passwordToggle.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput, ojoImagen);
            });

            const passwordInput2 = document.getElementById('password2');
            const passwordToggle2 = document.querySelector('.password-toggle2');

            passwordToggle2.addEventListener('click', function() {
                togglePasswordVisibility(passwordInput2, ojoImagen2);
            });
        });

        // Función para alternar la visibilidad de la contraseña
        function togglePasswordVisibility(inputElement, imageElement) {
            if (inputElement.type === 'password') {
                inputElement.type = 'text';
                imageElement.src = "img/ojo.png"; // Mostrar ojo abierto
                imageElement.alt = "Ocultar Contraseña";
            } else {
                inputElement.type = 'password';
                imageElement.src = "img/ojo_cerrado.png"; // Mostrar ojo cerrado
                imageElement.alt = "Mostrar Contraseña";
            }
        }

        function alert() {
            // No hay elemento 'observacion' ahora
        }

        function cerrar_alert() {
            // No hay elemento 'observacion' ahora
        }

    </script>
    
</main>

@endsection