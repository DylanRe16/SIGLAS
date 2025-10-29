@extends('prototipoExterno')

@section('registro')

<main>
    <div class="content-todo row my-3" id="content-todo" style="min-height: 700px;">
        <div class="content-login" style="min-height: 650px;">
            {{-- Lado izquierdo: Requisitos de Contraseña --}}
            <div class="card1 caja">
                <div class="caja_trasera-register" style="display: flex;justify-content: center;flex-direction: column;">
                    <div class="text-center fs-4 mb-5">
                        <div class="text-d balc">Defina una contraseña que cumpla las siguientes características</div>
                    </div>
                    <div class="validaciones caja_trasera-register validaciones-mg d-flex justify-content-center" style="color: white; transition: 500ms; margin: 0;">
                        <div class="ul-seguridad validaciones caja_trasera-register validaciones-mg" style="background-color: #fff; box-shadow: 0 3px 6px #00000029; width: 500px; height: auto; margin: 0; padding: 30px; border-radius: 20px;">
                            <ul>
                                <li id="t1" class="text-danger">Al menos <strong>una letra min&uacute;scula</strong></li>
                                <li id="t2" class="text-danger">Al menos <strong>una letra may&uacute;scula</strong></li>
                                <li id="t3" class="text-danger">Al menos <strong>un n&uacute;mero</strong></li>
                                <li id="t4" class="text-danger">Debe contener más de <strong>10 caracteres</strong></li>
                                <li id="t5" class="text-danger">La contrase&ntilde;a <strong>debe tener un carácter especial Ej:(@, #, $, etc.).</strong></li>
                                <li id="t6" class="text-danger">La contrase&ntilde;a <strong>debe coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lado derecho: Formulario de Registro --}}
            <div class="col-sm-6 caja2">
                <div class="card card-body caja-body pt-3 pb-3" style="padding-bottom: 2.5rem; min-height: 600px;">
                    <div class="text-center h1 mb-5">
                        <div class="font-weight-bold" style="color: #007BFF;">
                            <h4 style="font-size: calc(1.500rem + 0.3vw);">Bienvenido</h4>
                        </div>
                        <div class="" style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Regístrate</b></h4>
                        </div>
                        <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
                    </div>

                    {{-- Mensajes de validación y sesión --}}
                    @if ($errors->any())
                        <div class="alert alert-danger fs-6 mb-3" id="registro-alert-errors">
                            @foreach ($errors->all() as $error)
                                <i class="bi bi-exclamation-triangle-fill"></i> {{$error}} <br>
                            @endforeach
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger fs-6 mb-3" id="registro-alert-error-session">
                            {{session('error')}}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning fs-6 mb-3" id="registro-alert-warning">
                            <i class="bi bi-info-circle-fill"></i> {{session('warning')}}
                        </div>
                    @endif
                    
      
                    <form onsubmit="window.location.href = '{{ route('registro-proto-culminar') }}'; return false;">
                        @csrf {{-- Aunque no se envía, lo mantengo por si acaso lo usas para otra cosa en el futuro --}}
                        <div class="row">
                            <div id="grup2">
                                <div class="text-center">
                                    {{-- Entradas Ocultas --}}
                                    <input type="text" hidden name="snacionalidad" value="{{$persona->letra ?? $nacionalidad ?? ''}}">
                                    <input type="text" hidden name="ndocumento" value="{{$persona->numcedula ?? $cedula ?? ''}}">

                                    {{-- Primer Nombre y Segundo Nombre --}}
                                    <div class="input-group mb-3" style="margin-top: -10px">
                                        <input type="text" class="form-control" placeholder="Primer Nombre *" name="sprimer_nombre" id="sprimer_nombre" required value="{{ old('sprimer_nombre', $persona->primer_nombre ?? '') }}">
                                        <input type="text" class="form-control" placeholder="Segundo Nombre" name="ssegundo_nombre" id="ssegundo_nombre" value="{{ old('ssegundo_nombre', $persona->segundo_nombre ?? '') }}">
                                    </div>

                                    {{-- Primer Apellido y Segundo Apellido --}}
                                    <div class="input-group mb-3">
                                        <input style="height:45px;" class="form-control" type="text" placeholder="Primer Apellido *" name="sprimer_apellido" id="sprimer_apellido" required value="{{ old('apellido_afiliado1', $persona->primer_apellido ?? '') }}">
                                        <input style="height:45px;" class="form-control" type="text" placeholder="Segundo Apellido" name="ssegundo_apellido" id="ssegundo_apellido" value="{{ old('apellido_afiliado2', $persona->segundo_apellido ?? '') }}">
                                    </div>
                                </div> {{-- Fin text-center --}}

                                {{-- Sexo y Fecha de Nacimiento --}}
                                <div class="input-group mb-3">
                                    <select name="ssexo" id="ssexo" class="form-control me-2" required>
                                        <option value="">Seleccione Sexo *</option>
                                        <option value="F" {{ isset($persona) && old('ssexo', trim($persona->sexo)) == 'F' ? 'selected' : '' }}>Femenino</option>
                                        <option value="M" {{ isset($persona) && old('ssexo', trim($persona->sexo)) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    </select>
                                    <input 
                                        alt="Es obligatorio indicar su fecha de nacimiento" 
                                        type="date" 
                                        style="text-align: center; color: rgb(104, 103, 103); width: 48.75%; display: inline;" 
                                        class="form-control" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="left" 
                                        title="Fecha de Nacimiento *" 
                                        name="dfecha_nacimiento" 
                                        id="dfecha_nacimiento" required 
                                        value="{{ old('dfecha_nacimiento', $persona->fechanac ?? '') }}">
                                </div>

                                {{-- Nuevos campos: Número de Boleta y Nombre de Empresa --}}
                                <div class="input-group mb-3">
                                    <input 
                                        alt="Es obligatorio indicar su número de boleta" 
                                        type="text" 
                                        class="form-control" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="left" 
                                        title="Número de Boleta" 
                                        placeholder="Número de Boleta *" 
                                        name="nro_boleta" 
                                        id="nro_boleta"
                                        value="{{ old('nro_boleta') }}"
                                        required>
                                </div>

                                <div class="input-group mb-3">
                                    <input 
                                        alt="Es obligatorio indicar el nombre de la empresa" 
                                        type="text" 
                                        class="form-control" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="left" 
                                        title="Nombre de Empresa" 
                                        placeholder="Nombre de Empresa *" 
                                        name="nombre_empresa" 
                                        id="nombre_empresa"
                                        value="{{ old('nombre_empresa') }}"
                                        required>
                                </div>
                                
                                {{-- Campo de Contraseña --}}
                                <div class="input-group mb-3">
                                    <input 
                                        alt="Es obligatorio indicar su contraseña" 
                                        type="password" 
                                        class="form-control" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="left" 
                                        title="Contraseña" 
                                        placeholder="Ingrese su Contraseña *" 
                                        name="password" 
                                        id="password"
                                        value="{{ old('password') }}"
                                        required>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>

                                {{-- Campo de Confirmar Contraseña --}}
                                <div class="input-group mb-3"> 
                                    <input 
                                        alt="debe confirmar su contraseña" 
                                        type="password" 
                                        class="form-control" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-placement="left" 
                                        title="Confirmar Contraseña" 
                                        placeholder="Confirme su Contraseña *" 
                                        name="password_confirmation" 
                                        id="password_confirmation" 
                                        value="{{ old('password_confirmation') }}"
                                        required>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                
                                {{-- Botón de Registrarse --}}
                                <button id="registrar" type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" title="Registrarse" style="width: 100%; font-size: 16px; background-color: #46A2FD; border: 1px Solid #46A2FD; color: #fff; font-weight: bold;" onmouseover='this.style.color="#46A2FD"; this.style.backgroundColor="#fff";' onmouseout='this.style.color="#fff"; this.style.backgroundColor="#46A2FD"; this.style.border="1px Solid #46A2FD"'>Registrarse</button>

                            </div> {{-- Fin grup2 --}}
                        </div> {{-- Fin row --}}
                    </form>

                    {{-- Alerta local 'observacion' --}}
                    <div id="registro-observacion" style="display: none; margin-top: 20px;">
                        <div class="alert" id="registro-alert">
                            <div id="registro-titulo" class="titulo"></div>
                            <div id="registro-texto"></div>
                            <div id="registro-cerrar">
                                <a href="#" onclick="cerrar_registro_alert();">Cerrar</a>
                            </div>
                        </div>
                    </div>
                </div> {{-- Fin card-body --}}
            </div> {{-- Fin col-sm-6 caja2 --}}
        </div> {{-- Fin content-login --}}
    </div> {{-- Fin content-todo --}}

    {{-- Script JavaScript específico para esta vista --}}
    <script type="text/javascript" src="{{ asset('js/requisitos_contraseña.js') }}"></script>
    <script>
        function cerrar_registro_alert() {
            const observacionElement = document.getElementById('registro-observacion');
            if (observacionElement) {
                observacionElement.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.input-group-text i').forEach(icon => {
                icon.style.cursor = 'pointer';
                icon.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('input');
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.remove('bi-eye-slash');
                        this.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        this.classList.remove('bi-eye');
                        this.classList.add('bi-eye-slash');
                    }
                });
            });

            if (typeof soloNumerosEnInput === 'function') {
                soloNumerosEnInput('nro_boleta');
            }
        });
    </script>
</main>

@endsection