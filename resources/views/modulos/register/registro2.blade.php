@extends('welcomeExterno')

@section('registro')

<main>
    <div class="content-todo row my-3" id="content-todo">
        <div class="content-login">
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
                                <li id="t4" class="text-danger">Debe contener más de <strong>8 caracteres</strong></li>
                                <li id="t5" class="text-danger">La contrase&ntilde;a <strong>debe tener un carácter especial Ej:(@, #, $, etc.).</strong></li>
                                <li id="t6" class="text-danger">La contrase&ntilde;a <strong>debe coincidir</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 caja2">
                <div class="card card-body caja-body">
                    <div class="text-center h1 mb-5">
                        <div class="font-weight-bold" style="color: #007BFF;">
                            <h4 style="font-size: calc(1.500rem + 0.3vw);">Bienvenido</h4>
                        </div>
                        <div class="" style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Regístrate</b></h4>
                        </div>
                        <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger fs-6" id="alert">
                            @foreach ($errors->all() as $error)
                                <i class="bi bi-exclamation-triangle-fill"></i> {{$error}} <br>
                            @endforeach
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger fs-6" id="alert">
                            {{session('error')}}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning fs-6" id="alert"> 
                            <i class="bi bi-info-circle-fill"></i> {{session('warning')}}
                        </div>
                    @endif
                    
                    

                    <form action="{{route('registro-create')}}" method="get">
                        @csrf
                        <div class="row">
                            <div id="grup2" >

                                        <center>
                                            <div class="input-group" style="margin-top: -10px">
                                                <input type="text" hidden name="snacionalidad" value="{{$persona->letra ?? $nacionalidad ?? ''}}">                                                        
                                                <input type="text" hidden name="ndocumento" value="{{$persona->numcedula ?? $cedula ?? ''}}">

                                                <input type="text" class="form-control" placeholder="Primer Nombre *" name="sprimer_nombre" id="sprimer_nombre" required value="{{ old('sprimer_nombre', $persona->primer_nombre ?? '') }}">
                                                <span><i class="" style="padding:5px; color: gray"></i></span>
                                                <input type="text" class="form-control" placeholder="Segundo Nombre" name="ssegundo_nombre" id="ssegundo_nombre" value="{{ old('ssegundo_nombre', $persona->segundo_nombre ?? '') }}">
                                            </div>
                                            <div class="sep"></div>

                                            <div class="input-group">
                                                <input style="height:45px;" class="form-control" type="text" placeholder="Primer Apellido *" name="sprimer_apellido" id="sprimer_apellido" required value="{{ old('apellido_afiliado1', $persona->primer_apellido ?? '') }}">
                                                <span><i class="" style="padding:5px; color: gray"></i></span>
                                                <input style="height:45px;" class="form-control" type="text" placeholder="Segundo Apellido" name="ssegundo_apellido" id="ssegundo_apellido" value="{{ old('apellido_afiliado2', $persona->segundo_apellido ?? '') }}">
                                            </div>
                                        </center>
                                        <div class="sep"></div>
                                        <div class="input-group">
                                            <select name="ssexo" id="ssexo" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="F" {{ isset($persona) && old('ssexo', trim($persona->sexo)) == 'F' ? 'selected' : '' }}>Femenino</option>
                                                <option value="M" {{ isset($persona) && old('ssexo', trim($persona->sexo)) == 'M' ? 'selected' : '' }}>Masculino</option>
                                            </select>


                                            <input 
                                                
                                                alt="Es obligatorio indicar su fecha de nacimineto" 
                                                type="date" 
                                                style="text-align: center; color: rgb(104, 103, 103); width: 48.75%; display: inline; border-top-left-radius: 0; border-bottom-left-radius: 0" 
                                                class="form-control" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="left" 
                                                title="Fecha de Nacimiento" 
                                                name="dfecha_nacimiento" 
                                                id="dfecha_nacimiento" required 
                                                value="{{ old('dfecha_nacimiento', $persona->fechanac ?? '') }}">
                                            
                                        </div>

                                        <div class="sep"></div>
                                        <div class="input-group">
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
                                                <span>
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                        </div>

                                        <div class="sep"></div>

                                        <div class="input-group">
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
                                                <span>
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>

                                        </div>

                                        <div class="sep"></div>
                                        
                                        <button id="registrar" type="submit" class="buttom " data-bs-toggle="tooltip" data-bs-placement="right" title="Registrarse" style="width: 100%; font-size: 16px; background-color: #46A2FD; border: 1px Solid #46A2FD; color: #fff; font-weight: bold;" onmouseover='this.style.color="#46A2FD"; this.style.backgroundColor="#fff";' onmouseout='this.style.color="#fff"; this.style.backgroundColor="#46A2FD"; this.style.border="1px Solid #46A2FD"'>Registrarse</button>

                                    </div>  
                                </center>
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
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('js/requisitos_contraseña.js') }}"></script>

</main>

@endsection
