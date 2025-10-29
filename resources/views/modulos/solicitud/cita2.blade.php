@extends('welcomeInterno')

@section('contenido')

<main>

    @include('layouts.menu')


    <div class=" content-todo2 my-3" style="display: flex; flex-direction: column; width: 70%;">
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
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Agendar Solicitud</b></h4>
                    </div>
                    <div class="requerido fs-6 fw-normal mt-3">Campos obligatorios (*)</div>
                </div>
            </div>
            <hr class="mt-0">
            <form action="{{ route('cita-store') }}" method="POST">
                @csrf
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
                            {{-- en caso de que provenga de la ruta create 2, se guarda el valor true en from_create2 --}}
                            @if(Route::currentRouteName() === 'cita-create2')
                            <input type="hidden" name="from_create2" value="true">
                            @endif
                            <input type="text" id="ndocumento" name="ndocumento" value="{{ Auth::user()->ndocumento }}" hidden>
                            {{-- <input type="text" name="id_estatus" id="id_estatus" value="12" style="display:none"> f--}}
                            <input type="text" class="form-control num_rif2" name="srif" id="srif" placeholder="Ingrese el RIF (Ej: J123456789)" value="{{ $rif !== null ? $rif : old('srif', $entidad->srif  ?? '') }}"
                                {{ Route::currentRouteName() === 'cita-create2' ? 'disabled' : '' }} {{ $rif !== null ? 'disabled' : '' }} {{ ($entidad->srif ?? '') !== null ? 'disabled' : '' }}>
                            <input type="hidden" class="form-control num_rif2" name="srif" id="srif" placeholder="Ingrese el RIF (Ej: J123456789)" value="{{ $rif !== null ? $rif : old('srif', $entidad->srif  ?? '') }}">
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h6 class="type-titulo">Nombre o Razón Social <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="srazon_social" id="srazon_social" placeholder="Ingrese el nombre y razón social de la entidad de trabajo"
                                value="{{ old('srazon_social', $entidad->srazon_social ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <div class="sep"></div>

                <div class="row d-flex align-items-end">
                    <div class="col-sm-3">
                        <h6 class="type-titulo">Estado <span class="requerido">*</span></h6>
                        <div class="input-group">
                            {{-- <input type="text" id="" name="id_estado" class="form-control" value="{{ old('id_estado', $entidad->estado ?? '') }}" > --}}
                            <select class="form-control" name="id_estado" id="estado" data-municipios-url="{{ url('solicitud/municipios') }}">
                                <option value="-1" disabled {{ old('id_estado', '-1') == '-1' ? 'selected' : '' }}>Seleccione el estado</option>
                                @foreach ($estados as $estado)
                                <option value="{{ $estado->id_estado }}" {{ old('id_estado') == $estado->id_estado ? 'selected' : '' }}>
                                    {{ $estado->sdescripcion }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <h6 class="type-titulo">Municipio <span class="requerido">*</span></h6>
                        <div class="input-group">
                            {{-- <input type="text" id="" name="id_municipio" class="form-control" value="{{ old('id_municipio', $entidad->municipio ?? '') }}" > --}}
                            <select class="form-control" name="id_municipio" id="municipio" data-parroquias-url="{{ url('solicitud/parroquias') }}" data-selected="{{ old('id_municipio', $entidad->municipio ?? '') }}" disabled>
                                <option value="-1" disabled selected>Seleccione el municipio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="type-titulo">Parroquia <span class="requerido">*</span></h6>
                        <div class="input-group">
                            {{-- <input type="text" id="id_parroquia" name="" class="form-control" value="{{ old('id_parroquia', $entidad->parroquia ?? '') }}" > --}}
                            <select class="form-control" name="id_parroquia" id="parroquia" data-selected="{{ old('id_parroquia', $entidad->parroquia ?? '') }}" disabled>
                                <option value="-1" disabled selected>Seleccione la parroquia</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="sep"></div>

                <div class="row d-flex align-items-end">

                    <div class="col-sm-4">
                        <h6 class="type-titulo">Sector al cual pertenece <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <select class="form-control" name="id_sectoremp" id="sector">
                                <option value="-1" disabled selected>Seleccione el sector</option>
                                @foreach ($sectores as $sector)
                                <option value="{{ $sector->id_sectoremp }}" {{ old('id_sectoremp') == $sector->id_sectoremp ? 'selected' : '' }}>{{ $sector->sdescripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h6 class="type-titulo">Dirección <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sdireccion_fiscal" id="sdireccion_fiscal" placeholder="Ingrese la dirección de la entidad de trabajo" value="{{ old('sdireccion_fiscal', $entidad->sdireccion_fiscal ?? '') }}" required>
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
                            <select class="form-control" name="solicitud" id="solicitud" data-tiposolicitud-url="{{ url('solicitud/tiposolicitud') }}" data-selected="{{ old('solicitud') }}">
                                <option value="-1" disabled selected>Seleccione la solicitud</option>
                                @foreach ($solicitud as $solicitu)
                                <option value="{{ $solicitu->id_solicitud }}" {{ old('solicitud') == $solicitu->id_solicitud ? 'selected' : '' }}>
                                    {{ $solicitu->sdescripcion }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <h6 class="type-titulo">Tipo de Solicitud <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <select class="form-control" name="tipo_solicitud" id="tipo_solicitud" data-selected="{{ old('tipo_solicitud') }}" disabled>
                                <option value="-1" disabled selected>Seleccione el tipo de solicitud</option>
                            </select>
                        </div>
                    </div>
                    <div class="sep"></div>
                    <div class="col-sm-6">
                        <h6 class="type-titulo">¿Su cargo es de dirección? <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <select class="form-control" name="bcargo_direccion" id="cargo_direccion">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="1" {{old('bcargo_direccion') == 1 ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{old('bcargo_direccion') == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="type-titulo">Último cargo que desempeñó <span class="requerido">*</span></h6>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sult_cargo_desempenado" id="cargo" placeholder="Ingrese el último cargo" value="{{ old('sult_cargo_desempenado') }}" required>
                        </div>
                    </div>
                    <div class="sep"></div>

                    <!-- Botón Guardar -->
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4 text-center">

                        <button type="submit" tabindex="19" value="Guardar" class="btn btn-guardar rounded-pill" data-bs-toggle="tooltip" data-bs-placement="right" title="Registrar Cita">Guardar</button>

                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </form>
        </div>
    </div>

</main>


<script src="{{ asset('js/ubicaciones.js')}}"></script>
<script src="{{ asset('js/solicitud.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/datos_personales.js')}}"></script>

@endsection