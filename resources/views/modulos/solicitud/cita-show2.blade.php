@extends('welcomeInterno')

@section('contenido')

<main>

    @include('layouts.menu')

    <div style="
        display: flex;
        flex-direction: column; ">



        <div class=" content-todo2 my-3">
            <div class="content-login-2" id="contenedor">
                <!-- Botón Minimizar -->
                <div class="row" style="margin-top: -15px;">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                </div>
                <div class="sep"></div>

                <!-- Título -->
                <div class="row">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div style="color: #004B9D;">
                            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Solicitudes > Consultas > </b></h4>
                        </div>
                    </div>
                </div>
                <hr class="mt-0">

                @if ($cita)

                <!-- Datos de la Entidad de Trabajo -->

                <div class="font-weight-bold text-primary">
                    <h4 style="font-size: calc(1.500rem + 0.3vw);">Datos de la Entidad de Trabajo</h4>
                </div>
                <div class="sep"></div>

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



                <div class="row d-flex align-items-end">
                    <div class="col-sm-4">
                        <h6 class="type-titulo">Registro de Información Fiscal (RIF)</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="srif" id="srif" placeholder="Ingrese el RIF de la entidad de trabajo" value="{{ old('srif', $cita->empresa->srif  ?? '') }}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h6 class="type-titulo">Nombre o Razón Social <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="srazon_social" id="srazon_social" placeholder="Ingrese el nombre y razón social de la entidad de trabajo"
                                value="{{ old('srazon_social', $cita->empresa->srazon_social ?? '') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="sep"></div>

                <div class="row d-flex align-items-end">

                    <div class="col-sm-3">
                        <h6 class="type-titulo">Estado <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_estado" id="estado" value="{{ $cita->empresa->estado->sdescripcion ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <h6 class="type-titulo">Municipio <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_municipio" id="municipio" value="{{ $cita->empresa->municipio->sdescripcion ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="type-titulo">Parroquia <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_parroquia" id="parroquia" value="{{ $cita->empresa->parroquia->sdescripcion ?? '' }}" disabled>
                        </div>
                    </div>
                </div>


                <div class="sep"></div>

                <div class="row d-flex align-items-end">

                    <div class="col-sm-4">
                        <h6 class="type-titulo">Sector al cual pertenece <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_sectoremp" id="sector" value="{{ old('id_sectoremp', $cita->empresa->sector->sdescripcion ?? '') }}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h6 class="type-titulo">Dirección <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sdireccion_fiscal" id="sdireccion_fiscal" placeholder="Ingrese la dirección de la entidad de trabajo" value="{{ old('sdireccion_fiscal', $cita->empresa->sdireccion_fiscal ?? '') }}" disabled>
                        </div>
                    </div>

                </div>

                <div class="sep"></div>


                <!-- Trámite -->
                <div class="row">
                    <div class="font-weight-bold text-primary">
                        <h4 style="font-size: calc(1.500rem + 0.3vw);">Trámite</h4>
                    </div>
                    <div class="sep"></div>

                    <div class="col-sm-4">
                        <h6 class="type-titulo">Solicitud <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="solicitud" id="solicitud" value="{{ old('solicitud', $cita->tipoSolicitud->solicitud->first()->sdescripcion) }}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h6 class="type-titulo">Tipo de Solicitud <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="tipo_solicitud" id="tipo_solicitud" value="{{ old('tipo_solicitud', $cita->tipoSolicitud->sdescripcion) }}" disabled>
                        </div>
                    </div>
                    <div class="sep"></div>
                    <div class="col-sm-6">
                        <h6 class="type-titulo">¿Su cargo es de dirección? <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="bcargo_direccion" id="cargo_direccion" value="{{ old('bcargo_direccion', $cita->bcargo_direccion == 1 ? 'SI' : 'NO') }}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="type-titulo">Último cargo que desempeñó <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sult_cargo_desempenado" id="cargo" placeholder="Ingrese el último cargo" value="{{ old('sult_cargo_desempenado', $cita->sult_cargo_desempenado) }}" disabled>
                        </div>
                    </div>
                    <div class="sep"></div>

                    <!-- Botón Guardar -->
                    <div class="col-sm-4"></div>


                    <a href="{{ route('cita-show') }}" class="btn btn-limpiar rounded-pill me-3" title="Regresar">Regresar</a>
                    <button type="submit" value="Guardar" class="btn btn-guardar rounded-pill" title="Imprimir Solicitud">Imprimir</button>


                    <div class="col-sm-4"></div>
                </div>

                @else
                <div class="alert alert-danger fs-6" id="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> No se encontró la cita solicitada.
                </div>
                @endif
            </div>
        </div>

    </div>
</main>





<script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

@endsection