@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Actualización de Datos')

@section('body_class', 'page-act_datos')

@section('content')
<div class="modal fade" id="modalValidacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="exampleModalLabel text-white">
                    <i class="bi bi-exclamation-triangle-fill"></i> Campos Incompletos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="mensajeModal">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>
<main class="p-4">
    @include('layouts.alertas')
    @include('layouts.modals.ccombatiente.modal')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mi Perfil > Actualización de Datos</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    @php
    $user = $user ?? null;
    @endphp
    <form action="{{ route('actualizar-datos-store') }}" method="post">
        @csrf
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Básicos</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-6">
                        <div class="link-secondary">Tipo de documento</div>

                        <select name="snacionalidad" id="snacionalidad" class="form-control" required disabled>


                            <option value=""></option>
                            <option value="V" @selected(old('snacionalidad', $user->nacionalidad ?? '') === '1')>Venezolano</option>
                            <option value="E" @selected(old('snacionalidad', $user->nacionalidad ?? '') === '2')>Extranjero</option>
                            <option value="P" @selected(old('snacionalidad', $user->nacionalidad ?? '') === '3')>Pasaporte</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary">Nro. de documento</div>
                        <input tabindex="9" class="form-control" id="ndocumento" maxlength="11" onkeypress="return numbers(event);" pattern="[0-9]{6,11}" value="{{ old('ndocumento', $user->cedula ?? '') }}" disabled>
                        <input tabindex="9" class="form-control" name="ndocumento" maxlength="11" onkeypress="return numbers(event);" pattern="[0-9]{6,11}" value="{{ old('ndocumento', $user->cedula ?? '') }}" hidden>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Primer nombre</div>
                        <input type="text" class="form-control" value="{{ old('primer_nombres', $user->primer_nombre ?? '') }}" name="primer_nombres" id="primer_nombres" disabled>
                        <input type="text" class="form-control" value="{{ old('primer_nombres', $user->primer_nombre ?? '') }}" name="primer_nombres" hidden>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Segundo nombre</div>
                        <input type="text" class="form-control" id="segundo_nombres" value="{{ old('segundo_nombres', $user->segundo_nombre ?? '') }}" disabled>
                        <input type="text" class="form-control" name="segundo_nombres" value="{{ old('segundo_nombres', $user->segundo_nombre ?? '') }}" hidden>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Primer apellido</div>
                        <input type="text" class="form-control" id="primer_apellido" value="{{ old('primer_apellido', $user->primer_apellido ?? '') }}" disabled>
                        <input type="text" class="form-control" name="primer_apellido" value="{{ old('primer_apellido', $user->primer_apellido ?? '') }}" hidden>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Segundo apellido</div>
                        <input type="text" class="form-control" value="{{ old('segundo_apellido', $user->segundo_apellido ?? '') }}" id="segundo_apellido" disabled>
                        <input type="text" class="form-control" value="{{ old('segundo_apellido', $user->segundo_apellido ?? '') }}" name="segundo_apellido" hidden>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Lugar de nacimiento</div>
                        <input type="text" class="form-control" id="lugar_nacimiento" value="{{ old('lugar_nacimiento', $user->ciudad ?? '') }}" disabled>
                        <input type="text" class="form-control" name="lugar_nacimiento" value="{{ old('lugar_nacimiento', $user->ciudad ?? '') }}" hidden>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Fecha de nacimiento</div>
                        <input type="input" class="form-control" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ?? '') }}" disabled>
                        <input type="input" class="form-control" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $user->fecha_nacimiento ?? '') }}" hidden>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Sexo</div>
                        <select id="sexo" class="form-select" disabled>
                            <option value="">Seleccione...</option>
                            <option value="1" @selected( old('sexo', $user->sexo ?? '') === '1' || isset($user) && $user->sexo === '1')>Femenino</option>
                            <option value="2" @selected( old('sexo', $user->sexo ?? '') === '2' || isset($user) && $user->sexo === '2')>Masculino</option>
                        </select>
                        <select name="sexo" class="form-select" hidden>
                            <option value="">Seleccione...</option>
                            <option value="1" @selected( old('sexo', $user->sexo ?? '') === '1' || isset($user) && $user->sexo === '1')>Femenino</option>
                            <option value="2" @selected( old('sexo', $user->sexo ?? '') === '2' || isset($user) && $user->sexo === '2')>Masculino</option>
                        </select>

                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Estado Civil <span class="requerido">*</span></div>
                        <select name="estado_civil" id="estado_civil" class="form-select" data-selected="{{ old('estado_civil', $user->estado_civil ?? null) }}">
                            <option value="">Seleccione...</option>
                            @foreach ($estado_civiles as $estado_civil)
                            <option value="{{ $estado_civil->nentidad }}" @selected(old('estado_civil', $user->estado_civil ?? null)==$estado_civil->sdescripcion ? 'selected' : '' )>
                                {{ $estado_civil->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('estado_civil')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-6">
                        <div class="link-secondary">Teléfono personal <span class="requerido">*</span></div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="ncodigo_telfmovil" id="ncodigo_telfmovil" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($codigos_telefonicos_personal as $codigo_telefonico)
                                    <option value="{{$codigo_telefonico->codigo}}" @selected(old('ncodigo_telfmovil', $user->ncodigo_telfmovil )==$codigo_telefonico->ncodigo ? 'selected' : '')>0{{$codigo_telefonico->ncodigo}}</option>
                                    @endforeach
                                </select>
                                @error('ncodigo_telfmovil')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" placeholder="Ingrese..." maxlength="7" value="{{ old('nnumero_telfmovil', $user->nnumero_telfmovil ?? '') }}">
                                @error('nnumero_telfmovil')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="link-secondary">Teléfono de habitación</div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="ncodigo_telflocal" id="ncodigo_telflocal" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($codigos_telefonicos_local as $codigo_telefonico)
                                    <option value="{{$codigo_telefonico->codigo}}" @selected(old('ncodigo_telflocal', $user->ncodigo_telflocal )==$codigo_telefonico->ncodigo ? 'selected' : '' )>0{{$codigo_telefonico->ncodigo}}</option>
                                    @endforeach
                                </select>
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" placeholder="Ingrese..." value="{{ old('nnumero_telflocal', $user->nnumero_telflocal ?? '') }}" maxlength="7">
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">

                    <div class="col-md-6">
                        <div class="link-secondary">Correo electrónica personal <span class="requerido">*</span></div>
                        <input type="email" class="form-control" placeholder="Ingrese..." name="correo_electronico" id="correo_electronico" value="{{ old('correo_electronico', $user->semail ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary">N° de rif</div>
                        <input type="text" class="form-control" placeholder="Ingrese..." name="rif" id="rif" value="{{ old('rif', $user->srif ?? '') }}">
                        @error('rif')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Dirección de Habitación</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Estado <span class="requerido">*</span></div>
                        <select class="form-select" name="id_estado" id="estado" data-municipios-url="{{ url('municipios') }}" data-selected="{{ old('id_estado', $user->nentidad_entidad ?? '') }}">
                            <option value="-1">
                                Seleccione...
                            </option>

                            @foreach ($estados as $estado)
                            <option value="{{ $estado->nentidad }}"
                                @selected(old('id_estado', $persona->nentidad_entidad ?? null) == $estado->nentidad ? 'selected' : '')>
                                {{ $estado->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_estado')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Municipio<span class="requerido">*</span></div>
                        <select class="form-select" name="id_municipio" id="municipio" data-parroquias-url="{{ url('parroquias') }}" data-selected="{{ old('id_municipio', $user->nmunicipio_municipio ?? '') }}">
                            <option value="-1" disabled selected>Seleccione...</option>

                        </select>
                        @error('id_municipio')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Parroquia<span class="requerido">*</span></div>
                        <select class="form-select" name="id_parroquia" id="parroquia" data-selected="{{ old('id_parroquia', $user->nparroquia_parroquia ?? '') }}">
                            <option value="-1" disabled selected>Seleccione...</option>
                        </select>
                        @error('id_parroquia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-6">
                        <div class="link-secondary">Tipo de Dirección <span class="requerido">*</span></div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_direccion" id="tipo_direccion" value="1" {{ old('tipo_direccion', $user->ndireccion1 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_direccion">Avenida</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_direccion" id="tipo_direccion" value="2" {{ old('tipo_direccion', $user->ndireccion1 ?? '') == '2' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_direccion">Calle</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_direccion" id="tipo_direccion" value="4" {{ old('tipo_direccion', $user->ndireccion1 ?? '') == '4' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_direccion">Carretera</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_direccion" id="tipo_direccion" value="5" {{ old('tipo_direccion', $user->ndireccion1 ?? '') == '5' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_direccion">Esquina</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_direccion" id="tipo_direccion" value="6" {{ old('tipo_direccion', $user->ndireccion1 ?? '') == '6' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_direccion">Vereda</label>
                        </div>
                        @error('tipo_direccion')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <!-- <div class="link-secondary">Dirección Exacta</div> -->
                        <input type="text" class="form-control" placeholder="Detalles de la dirección" name="detalles_direccion" id="detalles_direccion" value="{{ old('detalles_direccion', $user->sdireccion1_2 ?? '') }}">
                        @error('detalles_direccion')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary"></div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_vivienda" id="tipo_vivienda" value="1" {{ old('tipo_vivienda', $user->ndireccion2 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_vivienda">Casa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_vivienda" id="tipo_vivienda" value="3" {{ old('tipo_vivienda', $user->ndireccion2 ?? '') == '3' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_vivienda">Edificio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_vivienda" id="tipo_vivienda" value="5" {{ old('tipo_vivienda', $user->ndireccion2 ?? '') == '5' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="tipo_vivienda">Quinta</label>
                        </div>
                        @error('tipo_vivienda')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <input type="text" class="form-control" placeholder="Detalles de la vivienda" name="detalles_vivienda" id="detalles_vivienda" value="{{ old('detalles_vivienda', $user->sdireccion2_2 ?? '') }}">
                        @error('detalles_vivienda')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="vivienda" id="" value="1" {{ old('vivienda', $user->ndireccion3 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="vivienda">Apt</label>

                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="vivienda" id="" value="2" {{ old('vivienda', $user->ndireccion3 ?? '') == '2' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="vivienda">Local</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="vivienda" id="" value="3" {{ old('vivienda', $user->ndireccion3 ?? '') == '3' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="vivienda">Oficina</label>
                        </div>
                        @error('vivienda')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <input type="text" class="form-control" placeholder="Detalles de la vivienda" name="nro_vivienda" id="nro_vivienda" value="{{ old('nro_vivienda', $user->sdireccion3_2 ?? '') }}">
                        @error('nro_vivienda')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="1" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Barrio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="2" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '2' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Caserio</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="3" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '3' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Conjunto Residencial</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="4" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '4' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Sector</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="5" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '5' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Urbanización</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="zona_vivienda" id="" value="6" {{ old('zona_vivienda', $user->ndireccion4 ?? '') == '6' ? 'checked' : '' }}>
                            <label class="form-check-label link-secondary" for="zona_vivienda">Zona</label>
                        </div>
                        @error('zona_vivienda')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                        <input type="text" class="form-control" placeholder="Detalles de la vivienda" name="detalles_zona" id="detalles_zona" value="{{ old('detalles_zona', $user->sdireccion4_2 ?? '') }}">
                        @error('detalles_zona')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-12">
                        <div class="link-secondary">Punto de referencias <span class="requerido">*</span></div>
                        <input type="text" class="form-control" placeholder="Ingrese..." name="punto_referencia" id="punto_referencia" value="{{ old('punto_referencia', $user->spunto_referencia ?? '') }}">
                        @error('punto_referencia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">En Caso de Emergencia</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Nombre(s) y Apellido(s) <span class="requerido">*</span></div>
                        <input type="text" class="form-control" placeholder="Ingrese..." name="nombre_emergencia" id="nombre_emergencia" value="{{ old('nombre_emergencia', $user->snombre_emerg_familiar, $user->sapellido_emerg_familiar ?? '') }}">
                        @error('nombre_emergencia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Parentesco <span class="requerido">*</span></div>
                        <select name="parentesco_emergencia" id="parentesco_emergencia" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='1' ? 'selected' : '' )>Padre</option>
                            <option value="2" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='2' ? 'selected' : '' )>Madre</option>
                            <option value="3" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='3' ? 'selected' : '' )>Hermano(a)</option>
                            <option value="4" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='4' ? 'selected' : '' )>Tío(a)</option>
                            <option value="5" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='5' ? 'selected' : '' )>Primo(a)</option>
                            <option value="6" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='6' ? 'selected' : '' )>Abuelo(a)</option>
                            <option value="7" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='7' ? 'selected' : '' )>Otro familiar</option>
                            <option value="8" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='8' ? 'selected' : '' )>Conyuge</option>
                            <option value="9" @selected(old('parentesco_emergencia', $user->sparentesco_emerg_familiar)=='9' ? 'selected' : '' )>Nieto(a)</option>
                        </select>
                        @error('parentesco_emergencia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Teléfono personal <span class="requerido">*</span></div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="codigo_emergencia" id="codigo_emergencia" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($codigos_telefonicos_personal as $codigo_telefonico)
                                    <option value="{{$codigo_telefonico->codigo}}" @selected(old('codigo_emergencia', $user->ncodigo_telfmovil_emerg1)==$codigo_telefonico->codigo ? 'selected' : '' )>0{{$codigo_telefonico->ncodigo}}</option>
                                    @endforeach
                                </select>
                                @error('codigo_emergencia')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="numero_emergencia" id="numero_emergencia" class="form-control num_tlf" placeholder="Ingrese..." value="{{ old('numero_emergencia',$user->nnumero_telfmovil_emerg1 ) }}" maxlength="7">
                                @error('numero_emergencia')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Nombre(s) y Apellido(s) <span class="requerido">*</span></div>
                        <input type="text" class="form-control" placeholder="Ingrese..." name="nombre_emergencia2" id="nombre_emergencia2" value="{{ old('nombre_emergencia2', $user->snombre_emerg_contacto, $user->sapellido_emerg_contacto ?? '') }}">
                        @error('nombre_emergencia2')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Parentesco <span class="requerido">*</span></div>
                        <select name="parentesco_emergencia2" id="parentesco_emergencia2" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='1' ? 'selected' : '' )>Padre</option>
                            <option value="2" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='2' ? 'selected' : '' )>Madre</option>
                            <option value="3" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='3' ? 'selected' : '' )>Hermano(a)</option>
                            <option value="4" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='4' ? 'selected' : '' )>Tío(a)</option>
                            <option value="5" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='5' ? 'selected' : '' )>Primo(a)</option>
                            <option value="6" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='6' ? 'selected' : '' )>Abuelo(a)</option>
                            <option value="7" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='7' ? 'selected' : '' )>Otro familiar</option>
                            <option value="8" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='8' ? 'selected' : '' )>Conyuge</option>
                            <option value="9" @selected(old('parentesco_emergencia2', $user->sparentesco_emerg_contacto)=='9' ? 'selected' : '' )>Nieto(a)</option>
                        </select>
                        @error('parentesco_emergencia2')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Teléfono personal <span class="requerido">*</span></div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="codigo_emergencia2" id="codigo_emergencia2" class="form-control">
                                    <option value="">Seleccione...</option>
                                    @foreach($codigos_telefonicos_personal as $codigo_telefonico)
                                    <option value="{{$codigo_telefonico->codigo}}" @selected(old('codigo_emergencia2', $user->ncodigo_telfmovil_emerg2)==$codigo_telefonico->codigo ? 'selected' : '' )>0{{$codigo_telefonico->ncodigo}}</option>
                                    @endforeach
                                </select>
                                @error('codigo_emergencia2')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="numero_emergencia2" id="numero_emergencia2" class="form-control num_tlf" placeholder="Ingrese..." value="{{ old('numero_emergencia2', $user->nnumero_telfmovil_emerg2) }}" maxlength="7">
                                @error('numero_emergencia2')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Adicionales</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">¿Tiene alguna discapacidad? <span class="requerido">*</span></div>
                        <select name="discapacidad" id="discapacidad" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="SI" @selected(old('discapacidad', $user->sdiscapacidad)=='SI' ? 'selected' : '' )>Sí</option>
                            <option value="NO" @selected(old('discapacidad', $user->sdiscapacidad)=='NO' ? 'selected' : '' )>No</option>
                        </select>
                        @error('discapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Tipo de discapacidad</div>
                        <select name="tipo_discapacidad" id="tipo_discapacidad" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($discapacidades as $discapacidad)
                            <option value="{{$discapacidad->id}}" @selected(old('discapacidad', $user->id_tipo_discapacidad ?? '') == $discapacidad->id ? 'selected' : '' )>{{$discapacidad->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('tipo_discapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Grado de discapacidad</div>
                        <select name="grado_discapacidad" id="grado_discapacidad" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($grado_discapacidades as $grado_discapacidad)
                            <option value="{{$grado_discapacidad->id}}" @selected(old('grado_discapacidad', $user->id_grado_discapacidad ?? '') == $grado_discapacidad->id ? 'selected' : '' )>{{$grado_discapacidad->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('grado_discapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Código CONAPDIS</div>
                        <input type="text" name="codigo_conapdis" id="codigo_conapdis" class="form-control" placeholder="Ingrese..." value="{{ old('codigo_conapdis', $user->scodigo_conapdis ?? '') }}">
                        @error('codigo_conapdis')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Lateralidad <span class="requerido">*</span></div>
                        <select name="lateralidad" id="lateralidad" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="D" @selected(old('lateralidad', $user->slateralidad ?? '')=='D' ? 'selected' : '' )>Diestro</option>
                            <option value="Z" @selected(old('lateralidad', $user->slateralidad ?? '')=='Z' ? 'selected' : '' )>Zurdo</option>
                            <option value="A" @selected(old('lateralidad', $user->slateralidad ?? '')=='A' ? 'selected' : '' )>Ambidiestro</option>
                        </select>
                        @error('lateralidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Tipo de sangre</div>
                        <select name="tipo_sangre" id="tipo_sangre" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($grupo_sanguineos as $grupo_sanguineo)
                            <option value="{{$grupo_sanguineo->id}}" @selected(old('tipo_sangre', $user->id_grupo_sanguineo ?? '') == $grupo_sanguineo->id ? 'selected' : '' )>{{$grupo_sanguineo->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('tipo_sangre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Inscripción militar <span class="requerido">*</span></div>
                        <select name="inscripcion_militar" id="inscripcion_militar" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="SI" @selected(old('inscripcion_militar', $user->sinscripcion_militar)=='SI' ? 'selected' : '' )>Sí</option>
                            <option value="NO" @selected(old('inscripcion_militar', $user->sinscripcion_militar)=='NO' ? 'selected' : '' )>No</option>
                        </select>
                        @error('inscripcion_militar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">N°. de inscripción militar</div>
                        <input type="text" name="numero_inscripcion_militar" id="numero_inscripcion_militar" class="form-control" placeholder="Ingrese..." value="{{ old('numero_inscripcion_militar', $user->ncodigo_inscripcion_militar ?? '') }}">
                        @error('numero_inscripcion_militar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Cantidad de hijos <span class="requerido">*</span></div>
                        <select name="cantidad_hijos" id="cantidad_hijos" class="form-select">
                            <option value="">Seleccione...</option>
                            @for ($i = 0; $i <= 10; $i++)
                            <option value="{{$i}}" @selected(old('cantidad_hijos', $user->ncant_hijos ?? '') == $i ? 'selected' : '' )>{{$i}}</option>
                            @endfor
                        </select>
                        @error('cantidad_hijos')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-9">
                        <div class="link-secondary">Si su cónyuge trabaja en el MPPPST, específique en que dependencia labora</div>
                        <input type="text" name="dependencia_conyuge" id="dependencia_conyuge" class="form-control" placeholder="Ingrese..." value="{{ old('dependencia_conyuge', $user->sconyuge_trabajo ?? '') }}">
                        @error('dependencia_conyuge')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <h5 class="link-secondary">Tallas
                        <hr>
                    </h5>
                    <div class="col-md-3">
                        <div class="link-secondary">Blusa o camisa</div>
                        <select name="talla_blusa_camisa" id="talla_blusa_camisa" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='1' ? 'selected' : '' )>XS</option>
                            <option value="2" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='2' ? 'selected' : '' )>S</option>
                            <option value="3" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='3' ? 'selected' : '' )>M</option>
                            <option value="4" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='4' ? 'selected' : '' )>L</option>
                            <option value="5" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='5' ? 'selected' : '' )>XL</option>
                            <option value="6" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='6' ? 'selected' : '' )>XXL</option>
                            <option value="7" @selected(old('talla_blusa_camisa', $user->stalla_camisa ?? '')=='7' ? 'selected' : '' )>XXXL</option>
                        </select>
                        @error('talla_blusa_camisa')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Pantalón</div>
                        <select name="talla_pantalon" id="talla_pantalon" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='1' ? 'selected' : '' )>26</option>
                            <option value="2" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='2' ? 'selected' : '' )>28</option>
                            <option value="3" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='3' ? 'selected' : '' )>30</option>
                            <option value="4" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='4' ? 'selected' : '' )>32</option>
                            <option value="5" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='5' ? 'selected' : '' )>34</option>
                            <option value="6" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='6' ? 'selected' : '' )>36</option>
                            <option value="7" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='7' ? 'selected' : '' )>38</option>
                            <option value="8" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='8' ? 'selected' : '' )>40</option>
                            <option value="9" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='9' ? 'selected' : '' )>42</option>
                            <option value="10" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='10' ? 'selected' : '' )>44</option>
                            <option value="11" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='11' ? 'selected' : '' )>46</option>
                            <option value="12" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='12' ? 'selected' : '' )>48</option>
                            <option value="13" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='13' ? 'selected' : '' )>50</option>
                            <option value="14" @selected(old('talla_pantalon', $user->stalla_pantalon ?? '')=='14' ? 'selected' : '' )>54</option>
                        </select>
                        @error('talla_pantalon')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Zapato</div>
                        <select name="talla_zapato" id="talla_zapato" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='1' ? 'selected' : '' )>35</option>
                            <option value="2" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='2' ? 'selected' : '' )>36</option>
                            <option value="3" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='3' ? 'selected' : '' )>37</option>
                            <option value="4" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='4' ? 'selected' : '' )>38</option>
                            <option value="5" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='5' ? 'selected' : '' )>39</option>
                            <option value="6" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='6' ? 'selected' : '' )>40</option>
                            <option value="7" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='7' ? 'selected' : '' )>42</option>
                            <option value="8" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='8' ? 'selected' : '' )>43</option>
                            <option value="9" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='9' ? 'selected' : '' )>44</option>
                            <option value="10" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='10' ? 'selected' : '' )>45</option>
                            <option value="11" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='11' ? 'selected' : '' )>46</option>
                            <option value="12" @selected(old('talla_zapato', $user->stalla_zapato ?? '')=='12' ? 'selected' : '' )>47</option>

                        </select>
                        @error('talla_zapato')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Chaqueta</div>
                        <select name="talla_chaqueta" id="talla_chaqueta" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="1" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='1' ? 'selected' : '' )>S</option>
                            <option value="2" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='2' ? 'selected' : '' )>SS</option>
                            <option value="3" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='3' ? 'selected' : '' )>L</option>
                            <option value="4" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='4' ? 'selected' : '' )>M</option>
                            <option value="5" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='5' ? 'selected' : '' )>XL</option>
                            <option value="6" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='6' ? 'selected' : '' )>XXL</option>
                            <option value="7" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='7' ? 'selected' : '' )>XXXL</option>
                            <option value="8" @selected(old('talla_chaqueta', $user->stalla_chaqueta ?? '')=='8' ? 'selected' : '' )>XXXXL</option>
                        </select>
                        @error('talla_chaqueta')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Patología(s) Crónica(s)</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">
                            Patología
                        </div>
                        <select name="patologia" id="patologia" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($patologias as $patologia)
                            <option value="{{$patologia->sdescripcion}}" @selected(old('patologia', $persona->patologia ?? '') == $patologia->id ? 'selected' : '' )>{{$patologia->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('patologia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">continuar_estudios
                            Tratamiento
                        </div>
                        <select name="tratamiento" id="tratamiento" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($tratamiento_medicos as $tratamiento_medico)
                            <option value="{{$tratamiento_medico->id}}" @selected(old('tratamiento', $persona->tratamiento ?? '') == $tratamiento_medico->id ? 'selected' : '' )>{{$tratamiento_medico->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('tratamiento')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">
                            Observación(es)
                        </div>
                        <input type="text" name="observacion_patologia" id="observacion_patologia" class="form-control" placeholder="Ingrese...">
                        @error('observacion_patologia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="agregarALista()" class="btn btn-guardar rounded-pill">Agregar</button>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Patología</th>
                                    <th scope="col">Tratamiento</th>
                                    <th scope="col">Observación(es)</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaTemporal">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="items_detalles" id="items_detalles" value="{{ old('items_detalles', '[]') }}">
                    </div>
                </div>
            </div>

            <!-- /.card-body -->
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Académicos</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Nivel Académico</div>
                        <select name="nivel_academico" id="nivel_academico" class="form-select">
                            <option value="">Seleccione...</option>
                            @foreach($nivel_academicos as $nivel_academico)
                            <option value="{{$nivel_academico->id}}" @selected(old('nivel_academico', $persona->nivel_academico ?? '') == $nivel_academico->id ? 'selected' : '' )>{{$nivel_academico->sdescripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Especialidad</div>
                        <input type="text" id="especialidad" class="form-control" placeholder="Ingrese...">
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary text-center">¿Graduado(a)?</div>
                        <div class="form-check text-center" style="margin-top: 10px;">
                            <input type="checkbox" id="graduado" class="form-check-input">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" onclick="agregarAcademico()" class="btn btn-guardar rounded-pill">Agregar</button>
                    </div>
                </div>

                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nivel Académico</th>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">¿Graduado(a)?</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tablaAcademica">
                            </tbody>
                        </table>
                        <input type="hidden" name="formacion_academica" id="formacion_academica" value="{{ old('formacion_academica', '[]') }}"> @error('formacion_academica')
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 d-flex align-items-end mb-4">
                    <h5 class="link-secondary">Datos Académicos Adicionales
                        <hr>
                    </h5>
                    <div class="col-md-4">
                        <div class="link-secondary">¿Desea continuar sus estudios? <span class="requerido">*</span></div>
                        <select name="continuar_estudios" id="continuar_estudios" class="form-select" data-selected="{{ old('continuar_estudios', $persona->id_opc_educativas ?? '') }}">
                            <option value="0">Seleccione...</option>
                            <option value="1" @selected(old('continuar_estudios')=='Sí' ? 'selected' : '' )>Sí</option>
                            <option value="2" @selected(old('continuar_estudios')=='No' ? 'selected' : '' )>No</option>
                        </select>
                        @error('continuar_estudios')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Opciones de estudio</div>
                        <select name="opciones_estudio" id="opciones_estudio" class="form-select" data-selected="{{ old('opciones_estudio', $persona->id_opc_educativas ?? '') }}">
                            <option value="0">Seleccione...</option>
                        @foreach($nivel_academicos as $nivel_academico)
                            <option value="{{$nivel_academico->id}}" @selected(old('nivel_academico', $persona->nivel_academico ?? '') == $nivel_academico->id ? 'selected' : '' )>{{$nivel_academico->sdescripcion}}</option>
                            @endforeach
                        </select>
                        @error('opciones_estudio')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">¿Le gustaría participar como facilitador?</div>
                        <select name="participar_facilitador" id="participar_facilitador" class="form-select" data-selected="{{ old('participar_facilitador', $user->nparticipar_facilitador ?? '') }}">
                            <option value="0">Seleccione...</option>
                            <option value="1" @selected(old('participar_facilitador')=='Sí' ? 'selected' : '' )>Sí</option>
                            <option value="2" @selected(old('participar_facilitador')=='No' ? 'selected' : '' )>No</option>
                        </select>
                        @error('participar_facilitador')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Laborales</h3>
                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2">
                        <i class="bi bi-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-8">
                        <div class="link-secondary">Ubicación administrativa de adscripción</div>
                        <input type="text" id="ubicacion_administrativa" class="form-control" value="{{ old('ubicacion_administrativa', $user->ubicacion ) }}" disabled>
                        <input type="text" name="ubicacion_administrativa" class="form-control" value="{{ old('ubicacion_administrativa', $user->ubicacion ) }}" hidden>
                        @error('ubicacion_administrativa')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Estado <span class="requerido">*</span></div>
                        <select name="estado_laboral" id="estado_laboral" class="form-select" data-selected="{{ old('estado_laboral', $user->nentidad_trab ?? '') }}">
                            <option value="">Seleccione...</option>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->nentidad }}"
                                @selected(old('estado_laboral', $user->nentidad_trab ?? null) == $estado->nentidad ? 'selected' : '' )>
                                {{ $estado->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('estado_laboral')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-7">
                        <div class="link-secondary">Ubicación física <span class="requerido">*</span></div>
                        <input type="text" name="ubicacion_fisica" id="ubicacion_fisica" class="form-control" placeholder="Ingrese..." value="{{ old('ubicacion_fisica', $user->subicacion_fisica ?? '') }}">
                        @error('ubicacion_fisica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <div class="link-secondary">Teléfono de oficina <span class="requerido">*</span></div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="codigo_oficina" id="codigo_oficina" class="form-control" data-selected="{{ old('codigo_oficina') }}">
                                    <option value="">Seleccione...</option>
                                    @foreach($codigos_telefonicos_local as $codigo_telefonico)
                                    <option value="{{$codigo_telefonico->codigo}}" @selected(old('codigo_oficina')==$codigo_telefonico->ncodigo)>0{{$codigo_telefonico->ncodigo}}</option>
                                    @endforeach
                                </select>
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="numero_oficina" id="numero_oficina" class="form-control num_tlf" placeholder="Ingrese..." value="{{ old('nnumero_telflocal',$user->ntelefono_oficina ) }}" maxlength="7">
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-6">
                        <div class="link-secondary">Cargo o puesto de trabajo titular</div>
                        <input type="text" id="cargo_titular" class="form-control" value="{{ old('cargo_titular', $user->scargo_actual_ejerce ?? '') }}" disabled>
                        <input type="text" name="cargo_titular" class="form-control" value="{{ old('cargo_titular', $user->scargo_actual_ejerce ?? '') }}" hidden>
                        @error('cargo_titular')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary">Cargo o puesto de trabajo que ejerce <span class="requerido">*</span></div>
                        <input type="text" name="cargo_ejerce" id="cargo_ejerce" class="form-control" placeholder="Ingrese..." value="{{ old('cargo_ejerce', $user->cargo ?? '') }}">
                        @error('cargo_ejerce')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-3">
                        <div class="link-secondary">Tipo de trabajador</div>
                        <input type="text" id="tipo_trabajador" class="form-control" value="{{ old('tipo_trabajador', $user->sdescripcion_anterior_al10102013 ?? '') }}" disabled>
                        <input type="text" name="tipo_trabajador" class="form-control" value="{{ old('tipo_trabajador', $user->sdescripcion_anterior_al10102013 ?? '') }}" hidden>
                        @error('tipo_trabajador')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Código de nómina</div>
                        <input type="text" id="codigo_nomina" class="form-control" value="{{ old('codigo_nomina', $user->ncodigo_nomina ?? '') }}" disabled>
                        <input type="text" name="codigo_nomina" class="form-control" value="{{ old('codigo_nomina', $user->ncodigo_nomina ?? '') }}" hidden>
                        @error('codigo_nomina')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Fecha de ingreso al MPPPST</div>
                        <input type="text" id="fecha_ingreso_mppp" class="form-control" value="{{ old('fecha_ingreso_mppp', $user->fecha_ingreso ?? '') }}" disabled>
                        <input type="text" name="fecha_ingreso_mppp" class="form-control" value="{{ old('fecha_ingreso_mppp', $user->fecha_ingreso ?? '') }}" hidden>
                        @error('fecha_ingreso_mppp')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Fecha de ingreso a la adm. pública</div>
                        <input type="text" id="fecha_ingreso_adm_publica" class="form-control" value="{{ old('fecha_ingreso_adm_publica', $user->fecha_ingreso_adm ?? '') }}" disabled>
                        <input type="text" name="fecha_ingreso_adm_publica" class="form-control" value="{{ old('fecha_ingreso_adm_publica', $user->fecha_ingreso_adm ?? '') }}" hidden>
                        @error('fecha_ingreso_adm_publica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-12">
                        <div class="link-secondary">Observación(es)</div>
                        <input type="text" name="observaciones_laborales" id="observaciones_laborales" class="form-control" placeholder="Ingrese..." value="{{ old('observaciones_laborales', $user->sobservacion ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="w-25 text-center">
                            <button type="submit" class="btn btn-guardar rounded-pill my-3">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </form>

</main>
<script>
    // 1. INICIALIZACIÓN: Cargar datos previos de Laravel (old) o iniciar vacíos
    let listaPatologias = {!!old('items_detalles', '[]') !!};
    let listaAcademica = {!!old('formacion_academica', '[]') !!};

    // 2. EJECUCIÓN AL CARGAR LA PÁGINA
    document.addEventListener("DOMContentLoaded", function() {
        renderizarTablaPatologias();
        renderizarTablaAcademica();
    });

    // --- SECCIÓN: PATOLOGÍAS ---

    function agregarALista() {
    const pat = document.getElementById('patologia');
    const tra = document.getElementById('tratamiento');
    const obs = document.getElementById('observacion_patologia');

    if (pat.value === "" || tra.value === "") {
        mostrarModalError("Debe seleccionar <b>Patología</b> y <b>Tratamiento</b>.");
        return;
    }

    // CAPTURA: El value es el ID, el text es el nombre visible
    const idPatologia = pat.value;
    const nombrePatologia = pat.options[pat.selectedIndex].text;

    // CAPTURA: Lo mismo para tratamiento si es un select (si es input usa tra.value)
    const idTratamiento = tra.value;
    const nombreTratamiento = (tra.tagName === "SELECT") ? tra.options[tra.selectedIndex].text : tra.value;

    listaPatologias.push({
        id_patologia: idPatologia,      // Para la DB
        nombre_patologia: nombrePatologia, // Para la Tabla visual
        id_tratamiento: idTratamiento,  // Para la DB
        nombre_tratamiento: nombreTratamiento, // Para la Tabla visual
        observacion: obs.value
    });

    renderizarTablaPatologias();
    
    // Limpiar campos
    pat.value = ""; 
    tra.value = ""; 
    obs.value = "";
}

function renderizarTablaPatologias() {
    const tbody = document.getElementById('tablaTemporal');
    const hidden = document.getElementById('items_detalles');
    tbody.innerHTML = "";

    listaPatologias.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${item.nombre_patologia}</td>
                <td>${item.nombre_tratamiento}</td>
                <td>${item.observacion}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill" onclick="eliminarPatologia(${index})">
                        X
                    </button>
                </td>
            </tr>`;
    });
    
    // Guardamos todo el objeto JSON en el input oculto
    hidden.value = JSON.stringify(listaPatologias);
}

    function eliminarPatologia(index) {
        listaPatologias.splice(index, 1);
        renderizarTablaPatologias();
    }

    // --- SECCIÓN: FORMACIÓN ACADÉMICA ---

    function agregarAcademico() {
    const niv = document.getElementById('nivel_academico');
    const esp = document.getElementById('especialidad');
    const gra = document.getElementById('graduado');

    if (niv.value === "" || esp.value === "") {
        mostrarModalError("Debe completar <b>Nivel Académico</b> y <b>Especialidad</b>.");
        return;
    }

    // CAPTURAMOS AMBOS: El ID para el controlador y el Texto para la tabla
    const idSeleccionado = niv.value;
    const textoSeleccionado = niv.options[niv.selectedIndex].text;

    listaAcademica.push({
        id_nivel: idSeleccionado,      // Esto irá a la base de datos
        descripcion_nivel: textoSeleccionado, // Esto es solo para mostrar en la tabla
        especialidad: esp.value,
        graduado: gra.checked ? "Sí" : "No"
    });

    renderizarTablaAcademica();
    niv.value = ""; esp.value = ""; gra.checked = false;
}

function renderizarTablaAcademica() {
    const tbody = document.getElementById('tablaAcademica');
    const hidden = document.getElementById('formacion_academica');
    tbody.innerHTML = "";

    listaAcademica.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${item.descripcion_nivel}</td> <td>${item.especialidad}</td>
                <td><span class="badge ${item.graduado === 'Sí' ? 'bg-success' : 'bg-secondary'}">${item.graduado}</span></td>
                <td><button type="button" class="btn btn-danger btn-sm rounded-pill" onclick="eliminarAcademico(${index})">X</button></td>
            </tr>`;
    });
    
    // El input hidden sigue llevando todo el objeto, incluyendo el id_nivel
    hidden.value = JSON.stringify(listaAcademica);
}

    function eliminarAcademico(index) {
        listaAcademica.splice(index, 1);
        renderizarTablaAcademica();
    }

    // --- UTILIDADES ---

    function mostrarModalError(mensaje) {
        document.getElementById('mensajeModal').innerHTML = mensaje;
        const myModal = new bootstrap.Modal(document.getElementById('modalValidacion'));
        myModal.show();
    }
</script>
@endsection
@section('footer')
@include('layouts.footer')
@endsection