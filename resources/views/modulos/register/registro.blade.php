@extends('welcomeExterno')

@section('registro')

<main>
    <div class="content-todo row my-3" id="content-todo">
        <div class="content-login">
            <div class="card caja">
                <div class="sep"></div>
                <div class="caja_trasera-register" style="display: flex;justify-content: center;flex-direction: column;">
                    <h3 tabindex="16" class="balc">¿Ya te encuentras registrado?</h3><br>
                    <a href="{{ route('ingresar') }}">
                        <button tabindex="18" id="btn_registrarse" class="buttom" style="font-size: 16px; background-color: rgb(255, 255, 255); color: rgb(70, 162, 253); font-weight: bold;" onmouseover="this.style.color=&quot;#fff&quot;; this.style.backgroundColor=&quot;rgba(0, 128, 255, 0.5)&quot;;" onmouseout="this.style.color=&quot;#46A2FD&quot;; this.style.backgroundColor=&quot;#fff&quot;;">Iniciar Sesión</button>
                    </a>
                </div>
            </div>

            <div class="col-sm-6 caja2">
                <div class="card card-body caja-body">
                    <div class="text-center h1 mb-5">
                        <div class="" style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Regístrate</b></h4>
                        </div>
                        <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
                    </div>

                    <div class="alert alert-danger fs-6" id="contenedor-errores-js" style="display: none;">
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
                            <i class="bi bi-exclamation-triangle-fill"></i> {{session('error')}}
                        </div>
                    @endif

                    <form action="{{route('registro-show')}}" method="get">
                        
                        <div class="row">
                            <div style="margin-left:5px">
                                <h6 style="color: #004B9D;">Documento de identidad <span class="requerido">*</span></h6>
                            </div>
                            <div class="col-sm-12" style="display: flex;justify-content: center;flex-direction: column;">
                                <center>
                                    <div class="input-group">
                                        <select tabindex="8" class="form-control" aria-label="Es obligatorio indicar su nacionalidad" style="width: 100%" name="nacionalidad" id="nacionalidad" data-bs-toggle="tooltip" data-bs-placement="left" title="Nacionalidad">
                                            <option value="">Tipo de Documento</option>
                                            <option value="V">Venezolano</option>
                                            <option value="E">Extranjero</option>
                                            <option value="P">Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="sep"></div>
                                    <div class="input-group">
                                    
                                        <input maxlength="8" tabindex="9" class="form-control num_certif" aria-label="Es obligatorio indicar su Nro. de documento" type="text" style="width: 80%; max-width: 210px" placeholder="Nro. de documento" name="ced_afiliado" id="ced_afiliado"  value="{{ old('ced_afiliado') }}">
                                        <span style="width: 10px; background-color: #fff"></span>
                                        <button tabindex="10" id="busca" type="submit" class="buttom " data-bs-toggle="tooltip" data-bs-placement="right" title="Buscar" style="width:auto; border-radius:0 30px 30px 0" onmouseover='this.style.color="#46A2FD"; this.style.backgroundColor="#fff";' onmouseout='this.style.color="#fff"; this.style.backgroundColor="#46A2FD"; this.style.border="1px Solid #46A2FD"'>Buscar</button>
                                    </div>

                                
                                </center>
                                </div>
                            </div>
                        </form>
                                

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
                    <script>
                        function alert() {
                            document.getElementById('observacion').style.display = 'block';
                        }

                        function cerrar_alert() {
                            document.getElementById('observacion').style.display = 'none';
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <!--   <div class="col-sm-3"></div>
   -->
    <script type="text/javascript" src="{{ asset('js/datos_personales.js')}}"></script>

</main>

@endsection
