@extends('welcomeExterno')

@section('contrasena')

<main>
    <div class="content-todo row my-3" id="content-todo">
        <div class="content-login">
            <div class="card caja">
                <div class="sep"></div>
                <div class="caja_trasera-register" style="display: flex;justify-content: center;flex-direction: column;">
                    <h3 tabindex="16" class="balc">¿Ya te encuentras registrado en el sistema Gestión de Solicitudes?</h3><br>
                    <a href="{{ route('ingresar') }}">
                        <button tabindex="18" id="btn_registrarse" class="buttom" style="font-size: 16px; background-color: rgb(255, 255, 255); color: rgb(70, 162, 253); font-weight: bold;" onmouseover="this.style.color='#fff'; this.style.backgroundColor='rgba(0, 128, 255, 0.5)';" onmouseout="this.style.color='#46A2FD'; this.style.backgroundColor='#fff';">Iniciar Sesión</button>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 caja2">
                <div class="card card-body caja-body">
                    <div class="text-center h1 mb-5">
                        <div style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Cambia tu contraseña</b></h4>
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

                    @if(session('success'))
                    <div
                        class="alert alert-success fs-6"
                        id="alert">
                        <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
                    </div>
                    @elseif(session('error'))
                    <div
                        class="alert alert-danger fs-6"
                        id="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    </div>
                    @elseif(session('warning'))
                    <div
                        class="alert alert-warning fs-6"
                        id="alert">
                        <i class="bi bi-info-circle-fill"></i> {{ session('warning') }}
                    </div>
                    @endif


                    <form action="{{ route('clave-create') }}" method="get">
                        <div class="row">
                            <div id="grup2">
                                <center>
                                    <div style="margin-left:5px;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6 style="color: #004B9D;">Nombre(s)</h6>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6 style="color: #004B9D;">Apellido(s)</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $persona->id_persona ?? '' }}" hidden name="id_persona" id="id_persona">
                                        <input tabindex="11" type="text" class="form-control" placeholder="Primer Nombre *" name="nombre_afiliado1" id="nombre_afiliado1" maxlength="15" required pattern="[A-Za-zÑ-ñÁ-Éó-úÍ ]{3,15}" value="{{ $persona->sprimer_nombre ?? '' }} {{ $persona->ssegundo_nombre ?? '' }}" disabled>
                                        <span><i class="" style="padding:5px; color: gray"></i></span>
                                        <input tabindex="13" class="form-control" type="text" placeholder="Primer Apellido *" name="apellido_afiliado1" id="apellido_afiliado1" maxlength="15" required pattern="[A-Za-zÑ-ñÁ-Éó-úÍ ]{3,15}" value="{{ $persona->sprimer_apellido ?? '' }} {{ $persona->ssegundo_apellido ?? '' }}" disabled>
                                    </div>
                                </center>

                                <div class="sep"></div>
                                <center>
                                    @if(isset($preguntas) && count($preguntas) >= 2)

                                    @foreach ($preguntas as $pregunta)
                                    <div style="margin-left:5px">
                                        <h6 style="color: #004B9D;">Pregunta {{ $loop->iteration }} <span class="requerido">*</span></h6>
                                    </div>
                                    <div class="input-group" style="margin-top: -10px">
                                        <input type="hidden" name="pregunta_id_{{$loop->iteration}}" value="{{ $pregunta->preguntas->id_preguntaseg }}">
                                        <input tabindex="17" type="text" class="form-control respuesta-pregunta" name="respuesta_{{$loop->iteration}}" data-pregunta-id="{{ $pregunta->preguntas->id_preguntaseg }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $pregunta->preguntas->sdescripcion }}" placeholder="{{ $pregunta->preguntas->sdescripcion }}" style="margin: 5px 0" required>
                                    </div>

                                    @endforeach

                                    {{-- <div style="margin-left:5px">
                                            <h6 style="color: #004B9D;">Pregunta 1 <span class="requerido">*</span></h6>
                                        </div>
                                        <div class="input-group" style="margin-top: -10px">
                                            <input tabindex="17" type="text" class="form-control respuesta-pregunta" data-pregunta-id="{{ $preguntas_seguridad[0]->id_preguntaseg ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $preguntas_seguridad[0]->sdescripcion ?? '' }}" placeholder="{{ $preguntas_seguridad[0]->sdescripcion ?? 'Pregunta 1' }}" style="margin: 5px 0" required>
                            </div>
                            <div class="sep"></div>
                            <div style="margin-left:5px">
                                <h6 style="color: #004B9D;">Pregunta 2 <span class="requerido">*</span></h6>
                            </div>
                            <div class="input-group" style="margin-top: -10px">
                                <input tabindex="17" type="text" class="form-control respuesta-pregunta" data-pregunta-id="{{ $preguntas_seguridad[1]->id_preguntaseg ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $preguntas_seguridad[1]->sdescripcion ?? '' }}" placeholder="{{ $preguntas_seguridad[1]->sdescripcion ?? 'Pregunta 2' }}" style="margin: 5px 0" required>
                            </div> --}}
                            @elseif(isset($preguntas) && count($preguntas) === 1)
                            <div style="margin-left:5px">
                                <h6 style="color: #004B9D;">Pregunta 1 <span class="requerido">*</span></h6>
                            </div>
                            <div class="input-group" style="margin-top: -10px">
                                <input tabindex="17" type="text" class="form-control respuesta-pregunta" data-pregunta-id="{{ $pregunta->preguntas->id_preguntaseg ?? '' }}" data-bs-toggle="tooltip" data-bs-placement="left" title="{{ $preguntas_seguridad[0]->sdescripcion ?? '' }}" placeholder="{{ $pregunta->preguntas->sdescripcion ?? 'Pregunta 1' }}" style="margin: 5px 0" required>
                            </div>
                            <div class="sep"></div>
                            <p>Solo se encontró una pregunta de seguridad.</p>
                            @else
                            <p>No hay preguntas de seguridad disponibles.</p>
                            @endif
                            </center>

                            <div class="sep"></div>

                            <div class="row ">
                                <div class="col-sm-6 d-flex justify-content-end">
                                    <a href="{{ route('ingresar') }}" class="btn btn-limpiar rounded-pill me-3" title="Regresar">Regresar</a>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-guardar rounded-pill" title="Validar Respuestas">Siguiente</button>
                                </div>
                            </div>


                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>


@endsection