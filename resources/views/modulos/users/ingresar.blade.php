@extends('base')

@section('content')
{{-- <img src="{{ url('dist/img/atencion-primaria3.jpg')}}" alt="Atención Primaria" width="90%" class="img-primaria"> --}}


<style>
    #contact {
        cursor: pointer;
        transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    #contact:hover {
        /* text-decoration: underline; */
        text-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
    }

    .select {
        width: 50px;
        transition: all 0.4s ease;
        border: none;
        /* Elimina todos los bordes */
        border-bottom: 1px solid #007bff;
        /* Agrega un borde inferior sólido */
        border-radius: 12px;
    }

    .select:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }
</style>

<div class="container d-flex align-items-center">
    <div class="card p-4 rounded-4 shadow-sm" style="max-width: 400px; min-width: 300px; margin-top: 30px;">
        <!-- <div class="card caja">
                <div class="caja_trasera-register d-flex justify-content-center flex-column">
                    <h3 tabindex="16" class="balc">¿Aún no te encuentras registrado?</h3><br>
                    <a href="{{ route('registro-index') }}">
                        <button tabindex="18" id="btn_registrarse" class="buttom" style="font-size: 16px; background-color: #fff; color: #46A2FD; font-weight: bold;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='rgba(0, 128, 255, 0.5)';" onmouseout="this.style.color='#46A2FD'; this.style.backgroundColor='#fff';">Regístrate</button>
                    </a>
                </div>
            </div> -->

        <div class="col-sm-6 caja2">
            <div class="card-body">
                <div class="text-center h1 mb-4">
                    <img src="{{ url('img/Sigla_logo.png') }}" alt="Logo CPTT" width="60%" style="margin-bottom: 15px;" class="img-logo">
                    <!--  <div class="font-weight-bold text-primary">
                        <h4 style="font-size: calc(1.300rem + 0.3vw);">Bienvenido</h4>
                    </div> -->
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(1.650rem + 0.3vw);"><b>Inicia tu Sesión</b></h4>
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

                @if(session('success'))
                <div class="alert alert-success fs-6" id="alert">
                    <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger fs-6" id="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
                @endif

                <form method="POST" action="{{ route('ingresar') }}">
                    @csrf
                    <div class="row fs-6 px-3">
                        <div class="form-label" style="color: #004B9D;">Documento de Identidad <span class="requerido">*</span></div>
                        <div class="input-group mb-3">
                            <select class="select" id="nacionalidad" name="nacionalidad">
                                <option value="V" {{ old('nacionalidad') == 'V' ? 'selected' : '' }}>V</option>
                                <option value="E" {{ old('nacionalidad') == 'E' ? 'selected' : '' }}>E</option>
                                <option value="P" {{ old('nacionalidad') == 'P' ? 'selected' : '' }}>P</option>
                            </select>
                            <span style="width: 10px; "></span>
                            <input type="text" class="form-control" id="num_cedula" name="ced_afiliado" placeholder="Nro. del documento" maxlength="8" value="{{ old('ced_afiliado') }}" required>
                        </div>
                    </div>



                    <div class="row fs-6 px-3">
                        <div class="fs-6 form-label" style="color: #004B9D;">Contraseña <span class="requerido">*</span></div>
                        <div class="input-group">
                            <input
                                alt="Es obligatorio indicar su contraseña"
                                type="password"
                                class="form-control"
                                title="Contraseña"
                                placeholder="Ingrese su Contraseña *"
                                name="password"
                                id="password"

                                required>
                            <span>
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8 text-center">
                            <button type="submit" class="btn btn-guardar fw-bold rounded-pill">Iniciar</button>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </form>
                <div class="sep"></div>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="{{ route('clave-index') }}" class="text-decoration-none" style="font-size: 1rem;">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center link-secondary" style="font-size: 13px;">
                        <p>Para mayor información o asesoría contáctanos <i>soporte.sigla@mpppst.gob.ve</i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal de contacto -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #163A7F;">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Contáctanos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-decoration-none link-secondary">
                <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos a través del siguiente medio:</p>
                <ul>
                    <li>Email: requerimientos.analisis@mpppst.gob.ve</li>
                    <!-- <li>Teléfono: +123 456 7890</li> -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordIcons = document.querySelectorAll('.bi-eye-slash, .bi-eye');

        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.parentElement.previousElementSibling; // Obtiene el input asociado
                const isPasswordVisible = input.type === 'text';

                // Alternar el tipo de input entre 'password' y 'text'
                input.type = isPasswordVisible ? 'password' : 'text';

                // Alternar la clase del ícono
                this.classList.toggle('bi-eye-slash');
                this.classList.toggle('bi-eye');
            });
        });
    });

    function soloNumerosEnInput(inputId) {
        const inputElement = document.getElementById(inputId);

        if (inputElement && inputElement.type === 'text') {
            inputElement.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        } else {
            console.error(`El elemento con ID "${inputId}" no se encontró o no es un input de tipo texto.`);
        }
    }
</script>

<script src="{{ asset('js/login2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/datos_personales.js')}}"></script>
@endsection