@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Preguntas de Seguridad')
@section('body_class', 'page-preguntas-seguridad')

@section('content')

<main class="p-4">
    @include('layouts.modals.perfil.modal_preguntas_seguridad')



    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Perfil > Preguntas de Seguridad</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Preguntas de Seguridad</h3>
            <div class="card-tools">
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <form action="{{ route('preguntaSeg-update') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- <div class="font-weight-bold text-primary">
                        <h4 style="font-size: calc(1.500rem + 0.3vw);">Tus Preguntas y Respuestas</h4>
                    </div> -->

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger fs-6" id="alert">
                            @foreach ($errors->all() as $error)
                                <i class="bi bi-exclamation-triangle-fill"></i> {{$error}} <br>
                    @endforeach
                    <!--  </div> -->
                    @endif --}}

                    @if (session('error'))
                    <div class="alert alert-danger fs-6" id="alert">
                        {{session('error')}}
                    </div>
                    @elseif (session('warning'))
                    <div class="alert alert-warning fs-6" id="alert">
                        <i class="bi bi-info-circle-fill"></i> {{session('warning')}}
                    </div>
                    @elseif (session('success'))
                    <div class="alert alert-success fs-6" id="alert">
                        <i class="bi bi-shield-fill-check"></i> {{session('success')}}
                    </div>
                    @endif

                    @if ($preguntaSeg_user->isEmpty())
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="row mb-4 fs-6" style="font-weight: 450;">
                        <div class="col-sm-6">
                            <div class="form-label link-secondary">Pregunta {{ $i }} <span class="requerido">*</span></div>
                            <select name="pregunta_{{ $i }}" class="form-control select-preg">
                                <option value="">Seleccione</option>
                                @foreach($preguntaSeg as $opcion)
                                <option value="{{ old('pregunta_' . $i) ?? $opcion->id_preguntaseg }}"
                                    {{ old('pregunta_' . $i) == $opcion->id_preguntaseg ? 'selected' : '' }}>
                                    {{ $opcion->sdescripcion }}
                                </option>
                                @endforeach
                            </select>
                            @error('pregunta_' . $i)
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <div class="form-label link-secondary">Respuesta {{ $i }}<span class="requerido">*</span></div>
                            <input type="text" name="respuesta_{{ $i }}" class="form-control"
                                value="{{ old('respuesta_'.$i) }}">
                            @error('respuesta_' . $i)
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                </div>
                @endfor
                @else
                @foreach($preguntaSeg_user as $preg)
                <div class="row mb-4 fs-6" style="font-weight: 450;">
                    <div class="col-sm-6">
                        <div class="form-label link-secondary">Pregunta {{ $loop->iteration }} <span class="requerido">*</span></div>
                        <select name="pregunta_{{ $loop->iteration }}" class="form-control select-preg">
                            <option value="">Seleccione</option>
                            @foreach($preguntaSeg as $opcion)
                            <option value="{{ old('pregunta_' . $loop->iteration) ?? $opcion->id_preguntaseg }}"
                                {{ $preg->id_preguntaseg == $opcion->id_preguntaseg ? 'selected' : '' }}>
                                {{ $opcion->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('pregunta_' . $loop->iteration)
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-label link-secondary">Respuesta {{ $loop->iteration }}<span class="requerido">*</span></div>
                        <input type="text" name="respuesta_{{ $loop->iteration }}" class="form-control"
                            value="{{ old('respuesta_'.$loop->iteration, $preg->srespuesta) }}">
                        @error('respuesta_' . $loop->iteration)
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @endforeach
                @endif



                <div class="col-sm-4"></div>
                <div class="col-sm-4 text-center mt-3">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip">Guardar</button>
                </div>
                <div class="col-sm-4"></div>
                <div class="sep"></div>
        </div>
        </form>
    </div>
    </div>

</main>


<script type="text/javascript" src="{{ asset('js/preguntas_seguridad.js')}}"></script>

@endsection
@section('footer')
@include('layouts.footer')
@endsection