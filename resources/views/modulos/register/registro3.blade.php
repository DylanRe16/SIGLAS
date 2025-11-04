@extends('base')

@section('content')

<div class="container d-flex align-items-center">

  <div class="card p-4 rounded-4 shadow-sm">
    @if (session('error'))
    <div class="alert alert-danger fs-6">{{session('error')}}</div>
    @endif

    <form action="{{route('registro-store')}}" method="post">

      @csrf
      <div class="card-header">

        <div class="row">
          <div class="col-sm-12" style="display: flex;justify-content: space-between;">
            <div class="" style="color: #004B9D; ">
              <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Regístrate</b></h4>
            </div>
            <div class="requerido fs-6 fw-normal" style="margin-top:20px">Campos obligatorios (*)</div>
          </div>
        </div>
      </div>


      <hr style="margin-top:0">


      <input type="text" hidden name="ndocumento" value="{{ old('ndocumento', $persona) }}">

      <div class="font-weight-bold" style="color: #007BFF;">
        <h4 style="font-size: calc(1.500rem + 0.3vw);">Preguntas de seguridad</h4>
      </div>
      <div class="sep"></div>

      <div class="row mb-4 fs-6" style="font-weight: 450;">
        <div class="col-sm-6">
          <div class="form-label" style="color: #004B9D; ">Pregunta 1 <span class="requerido">*</span></div>
          <select name="pregunta_1" id="pregunta_1" class="form-control select-preg">
            <option value="">Seleccione</option>
            @foreach ($preguntas_seg as $pregunta)
            <option value="{{ $pregunta->id_preguntaseg }}" {{ old('pregunta_1') == $pregunta->id_preguntaseg ? 'selected' : '' }}>
              {{ $pregunta->sdescripcion }}
            </option>
            @endforeach
          </select>
          @error('pregunta_1')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

        <div class="col-sm-6">
          <div class="form-label" style="color: #004B9D; ">Respuesta 1 <span class="requerido">*</span></div>
          <input type="text" name="respuesta_1" class="form-control" value="{{ old('respuesta_1')}}">
          @error('respuesta_1')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>



      <div class="row mb-4 fs-6" style="font-weight: 450;">
        <div class="col-sm-6">
          <div class="form-label" style="color: #004B9D; ">Pregunta 2 <span class="requerido">*</span></div>
          <select name="pregunta_2" id="pregunta_2" class="form-control select-preg">
            <option value="">Seleccione</option>
            @foreach ($preguntas_seg as $pregunta)
            <option value="{{ $pregunta->id_preguntaseg }}" {{ old('pregunta_2') == $pregunta->id_preguntaseg ? 'selected' : '' }}>
              {{ $pregunta->sdescripcion }}
            </option>
            @endforeach
          </select>
          @error('pregunta_2')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>

        <div class="col-sm-6 fs-6">
          <div class="form-label" style="color: #004B9D; ">Respuesta 2 <span class="requerido">*</span></div>
          <input type="text" name="respuesta_2" class="form-control" value="{{ old('respuesta_2')}}">
          @error('respuesta_2')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>

      <div class="row mb-4 fs-6" style="font-weight: 450;">
        <div class="col-sm-6">
          <div class="form-label" style="color: #004B9D; ">Pregunta 3 <span class="requerido">*</span></div>
          <select name="pregunta_3" id="pregunta_3" class="form-control select-preg">
            <option value="">Seleccione</option>
            @foreach ($preguntas_seg as $pregunta)
            <option value="{{ $pregunta->id_preguntaseg }}" {{ old('pregunta_3') == $pregunta->id_preguntaseg ? 'selected' : '' }}>
              {{ $pregunta->sdescripcion }}
            </option>
            @endforeach
          </select>
          @error('pregunta_3')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>


        <div class="col-sm-6 fs-6">
          <div class="form-label" style="color: #004B9D; ">Respuesta 3 <span class="requerido">*</span></div>
          <input type="text" name="respuesta_3" class="form-control" value="{{ old('respuesta_3')}}">
          @error('respuesta_3')
          <small class="text-danger">{{$message}}</small>
          @enderror
        </div>
      </div>

      <div class="sep"></div>

      <input type="password" name="sclave" id="" value="{{ $clave }}" class="form-control" hidden>



      <div class="row">
        <div class="col-md-12 d-flex justify-content-center ">
          <div class="w-25 text-center">
            <button type="submit" class="btn btn-guardar rounded-pill">Guardar</button>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>

<script type="text/javascript" src="{{ asset('js/datos_personales.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/preguntas_seguridad.js')}}"></script>
@endsection