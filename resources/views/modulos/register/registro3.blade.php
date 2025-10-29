@extends('welcomeExterno')

@section('culminar-registro')

<style>
    #conten-disc {
      display: none; !important /* Ocultarlo inicialmente */
      opacity: 0;    /* Sin opacidad inicial */
      transition: opacity 0.5s ease; /* Suavizar la opacidad */
  }

  .disc_container {
    display: none; 
    opacity: 0;
    transition: opacity 0.5s ease; 
    font-weight: 450;
  }


  /* Eliminar flechas en todos los navegadores modernos */
  input[type="number"] {
    -moz-appearance: textfield; /* Firefox */
    -webkit-appearance: none; /* Chrome, Safari, Edge */
    appearance: none; /* Estándar */
    margin: 0; /* Opcional: eliminar márgenes adicionales */
  }

</style>

<main>
  <div class="content-todo row my-3">
    <div class="content-login-2">
    
      {{-- @if ($errors->any())
          <div class="alert alert-danger fs-6">
              <ul> 
                  @foreach ($errors->all() as $error)
                      <li>{{$error}}</li>
                  @endforeach
              </ul>
          </div>
      @endif --}}

      @if (session('error'))
          <div class="alert alert-danger fs-6">{{session('error')}}</div>
      @endif

      <form action="{{route('registro-store')}}" method="post">

      @csrf
      <div class="row">
        <div class="col-sm-12" style="display: flex;justify-content: space-between;">
          <div class="" style="color: #004B9D; ">
            <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Regístrate</b></h4>
          </div>
          <div class="requerido fs-6 fw-normal" style="margin-top:20px">Campos obligatorios (*)</div>
        </div>
      </div>

      <hr style="margin-top:0">

      
        <div class="font-weight-bold" style="color: #007BFF;">
          <h4 style="font-size: calc(1.500rem + 0.3vw);;">Datos Personales</h4>
        </div>

        <div class="sep"></div>

        <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">

          <div class="col-sm-3">
            <div style="color: #004B9D; text-align:center">Tipo de Documento </div>
          </div>
  
          <div class="col-sm-3">

            <select name="snacionalidad" id="snacionalidad" class="form-control" disabled>
              <option value="">Seleccione</option>
              <option value="V" {{ (data_get($persona, 'letra') !== null ? trim(data_get($persona, 'letra')) : data_get($persona, 'snacionalidad')) == 'V' ? 'selected' : '' }}>Venezolano</option>
              <option value="E" {{ (data_get($persona, 'letra') !== null ? trim(data_get($persona, 'letra')) : data_get($persona, 'snacionalidad')) == 'E' ? 'selected' : '' }}>Extranjero</option>
              <option value="P" {{ (data_get($persona, 'letra') !== null ? trim(data_get($persona, 'letra')) : data_get($persona, 'snacionalidad')) == 'p' ? 'selected' : '' }}>Pasaporte</option>
            </select>
            <input type="hidden" name="snacionalidad" value="{{ (data_get($persona, 'letra') !== null ? trim(data_get($persona, 'letra')) : data_get($persona, 'snacionalidad')) ?? '' }}">
          </div>

          
          <div class="col-sm-3">
            
              <div style="color: #004B9D; text-align:center">Nro de Documento </div>
          </div>

          <div class="col-sm-3">
              <input 
                tabindex="9" 
                class="form-control" 
                aria-label="Es obligatorio indicar su Nro. del documento" 
                type="number" class="form-control" 
                placeholder="Nro. del documento" 
                name="ndocumento" 
                id="ndocumento" 
                maxlength="11" 
                onkeypress="return numbers(event);" 
                required pattern="[0-9]{6,11}" disabled
                value="{{ isset($persona) ? data_get($persona ,'numcedula') ?? data_get($persona, 'ndocumento') : '' }}">
              </div>
        </div>
        <input type="text" class="form-control" name="ndocumento" hidden value="{{ isset($persona) ? $persona->numcedula ?? data_get($persona, 'ndocumento') : '' }}">
        <input type="text" class="form-control" name="nusuario_creacion" hidden value="{{ isset($persona) ? $persona->numcedula ?? data_get($persona, 'ndocumento') : '' }}">

        
        <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
          <div class="col-sm-3">
              <div style="color: #004B9D;">Primer nombre </div>
              <input type="text" class="form-control" name="sprimer_nombre" disabled value="{{ isset($persona) ? data_get($persona, 'primer_nombre') ?? data_get($persona, 'sprimer_nombre') : '' }}">
              <input type="text" class="form-control" name="sprimer_nombre" hidden value="{{ isset($persona) ? data_get($persona, 'primer_nombre') ?? data_get($persona, 'sprimer_nombre') : '' }}">
          </div>

          <div class="col-sm-3">
              <div style="color: #004B9D; ">Segundo nombre </div>
              <input type="text" class="form-control" name="ssegundo_nombre" disabled value="{{ isset($persona) ? data_get($persona, 'segundo_nombre') ?? data_get($persona, 'ssegundo_nombre') : '' }}">
              <input type="text" class="form-control" name="ssegundo_nombre" hidden value="{{ isset($persona) ? data_get($persona, 'segundo_nombre') ?? data_get($persona, 'ssegundo_nombre') : '' }}">
          </div>

          <div class="col-sm-3">
              <div style="color: #004B9D; ">Primer apellido </div>
              <input type="text" class="form-control" name="sprimer_apellido" disabled value="{{ isset($persona) ? data_get($persona, 'primer_apellido') ?? data_get($persona, 'sprimer_apellido') : '' }}">
              <input type="text" class="form-control" name="sprimer_apellido" hidden value="{{ isset($persona) ? data_get($persona, 'primer_apellido') ?? data_get($persona, 'sprimer_apellido') : '' }}">
          </div>
          
          <div class="col-sm-3">
              <div style="color: #004B9D; ">Segundo apellido</div>
              <input type="text" class="form-control" name="ssegundo_apellido" disabled value="{{ isset($persona) ? data_get($persona, 'segundo_apellido') ?? data_get($persona, 'ssegundo_apellido') : '' }}">
              <input type="text" class="form-control" name="ssegundo_apellido" hidden value="{{ isset($persona) ? data_get($persona, 'segundo_apellido') ?? data_get($persona, 'ssegundo_apellido') : '' }}">
          </div>
        </div>

        
        <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">

          <div class="col-sm-2">
              <div style="color: #004B9D; ">Fecha de nacimiento</div>
              <input type="date" class="form-control" name="dfecha_nacimiento" disabled value="{{ isset($persona) ? data_get($persona ,'fechanac') ?? data_get($persona, 'dfecha_nacimiento') : '' }}">
              <input type="date" class="form-control" name="dfecha_nacimiento" hidden value="{{ isset($persona) ? data_get($persona ,'fechanac') ?? data_get($persona, 'dfecha_nacimiento') : '' }}">
          </div>

          <div class="col-sm-1">
              <div style="color: #004B9D; ">Edad</div>
              <input type="text" class="form-control" name="edad" disabled value="{{$edad}}">
              <input type="number" class="form-control" name="edad" hidden value="{{$edad}}">
          </div>

          <div class="col-sm-2">
              <div style="color: #004B9D; ">Sexo</div>

              <select name="ssexo" id="ssexo" class="form-control" disabled>
                <option value="">Seleccione</option>
                <option value="F" {{ (data_get($persona, 'sexo') !== null ? trim(data_get($persona, 'sexo')) : data_get($persona, 'ssexo')) == 'F' ? 'selected' : '' }}>Femenino</option>
                <option value="M" {{ (data_get($persona, 'sexo') !== null ? trim(data_get($persona, 'sexo')) : data_get($persona, 'ssexo')) == 'M' ? 'selected' : '' }}>Masculino</option>
            </select>
              <input hidden name="ssexo" value="{{ (data_get($persona, 'sexo') !== null ? trim(data_get($persona, 'sexo')) : data_get($persona, 'ssexo')) ?? '' }}">
              
          </div>
  
          @if( isset($persona) && (data_get($persona, 'sexo') !== null ? trim(data_get($persona, 'sexo')) : data_get($persona, 'ssexo')) == 'F' )
            <div class="col-sm-2">
                <div style="color: #004B9D; ">¿Está embarazada? <span class="requerido">*</span></div>
                <select name="bembarazada" id="embarz" class="form-control">
                  <option value="">Seleccione</option>
                  <option value="1" {{ old('bembarazada') == 1 ? 'selected' : '' }}>SI</option>
                  <option value="0" {{ old('bembarazada') == 0 ? 'selected' : '' }}>NO</option>
                </select>
            </div>
          @endif
  
          <div class="col-sm-3">
              <div style="color: #004B9D; ">Correo electrónico</div>
              <input type="email" name="semail" class="form-control" placeholder="Ejemplo@mail.com" value="{{ old('semail')}}">
            @error('semail')
              <small class="text-danger">{{$message}}</small>
            @enderror  
          </div>

          <div class="col-sm-2 ">
              <div style="color: #004B9D; ">¿Tiene discapacidad? <span class="requerido">*</span></div>
              <select name="bdiscapacidad" id="bdiscapacidad" class="form-control">
                <option value="">Seleccione</option>
                <option value="1" {{ old('bdiscapacidad') == 1 ? 'selected' : '' }}>SI</option>
                <option value="0" {{ old('bdiscapacidad') == 0 ? 'selected' : '' }}>NO</option>
              </select>
              @error('bdiscapacidad')
                <small class="text-danger">{{$message}}</small>
              @enderror
          </div>
        </div>


        <div class="row mb-4 fs-6 d-flex align-items-end" style="font-weight: 450;">
            <div class="col-sm-3 {{ old('bdiscapacidad') == 0 ? 'disc_container' : '' }}" id="tipo_discapacidad_container">
                <div style="color: #004B9D; ">¿Tipo de discapacidad? <span class="requerido">*</span></div>
                <select name="id_tdiscapacidad" id="id_tdiscapacidad" class="form-control">
                  <option value="">Seleccione</option>
                  @foreach ($t_discapacidad as $discapacidad)
                    <option value="{{ $discapacidad->id_tdiscapacidad }}" {{ old('id_tdiscapacidad') == $discapacidad->id_tdiscapacidad ? 'selected' : ''}}>
                      {{ $discapacidad->sdescripcion }}
                    </option>
                  @endforeach
                </select>
            </div>

            <div class="col-sm-4 {{ old('bdiscapacidad') == 0 ? 'disc_container' : '' }}" id="especifique_discapacidad_container">
                <div style="color: #004B9D; ">Especifique <span class="requerido">*</span></div>
                <input type="text" name="sdicapacidad_especifica" id="sdicapacidad_especifica" class="form-control" value="{{ old('sdicapacidad_especifica')}}">
            </div>

            <div class="col-sm-2 {{ old('bdiscapacidad') == 0 ? 'disc_container' : '' }}" id="tiene_conapdis_container">
                <div style="color: #004B9D; ">¿Tiene Certificado CONAPDIS? <span class="requerido">*</span></div>
                <select name="bcertificado_conapdis" id="bcertificado_conapdis" class="form-control" >
                  <option value="">Seleccione</option>
                  <option value="1" {{ old('bcertificado_conapdis') == 1 ? 'selected' : '' }}>SI</option>
                  <option value="0" {{ old('bcertificado_conapdis') == 0 ? 'selected' : '' }}>NO</option>
                </select>
            </div>

            <div class="col-sm-3 {{ old('bcertificado_conapdis') == 0 ? 'disc_container' : '' }}" id="num_conapdis_container">
                <div style="color: #004B9D; ">Indique el número de certificado</div>
                <input type="text" class="form-control num_certif" id="nnum_certificado" name="nnum_certificado" maxlength="11" pattern="[0-9]{6,11}" value="{{ old('nnum_certificado')}}">
                @error('nnum_certificado')
                  <small class="text-danger">{{$message}}</small>
                @enderror
            </div>
          </div>
        
        
        <div class="row mb-4 fs-6" style="font-weight: 450;">
          
          <div class="col-sm-4">
              <label for="nnumero_telfmovil" class="form-label" style="color: #004B9D;">Teléfono personal <span class="requerido">*</span></label>
              <div class="row">
                <div class="col-sm-4">
                  <select name="ncodigo_telfmovil" id="ncodigo_telfmovil" class="form-control" >
                    <option value="">Seleccione</option>
                    @foreach($cod_moviles as $cod_movil)
                        <option value="{{$cod_movil->ncodigo}}" {{ old('ncodigo_telfmovil') == $cod_movil->ncodigo ? 'selected' : ''}}>
                          0{{$cod_movil->ncodigo}}
                        </option>
                    @endforeach
                  </select>
                  @error('ncodigo_telfmovil')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
                <div class="col-sm-8">
                  <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" maxlength="7" value="{{ old('nnumero_telfmovil')}}">
                  @error('nnumero_telfmovil')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
                </div>
              </div>
          </div>

          <div class="col-sm-4">
            <label for="nnumero_telflocal" class="form-label" style="color: #004B9D;">Teléfono local</label>
            <div class="row">
              <div class="col-sm-4">
                <select name="ncodigo_telflocal" id="ncodigo_telflocal" class="form-control">
                  <option value="">Seleccione</option>
                  @foreach($cod_locales as $cod_local)
                      <option value="{{$cod_local->ncodigo}}" {{ old('ncodigo_telflocal')  == $cod_local->ncodigo ? 'selected' : '' }}>
                        0{{$cod_local->ncodigo}}
                      </option>
                  @endforeach
                </select>
                @error('nnumero_telflocal')
                  <small class="text-danger">{{$message}}</small>
                @enderror                
              </div>
              <div class="col-sm-8">
                <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" maxlength="7" pattern="[0-9]{7}" value="{{ old('nnumero_telflocal')}}">
                @error('nnumero_telflocal')
                  <small class="text-danger">{{$message}}</small>
                @enderror
              </div>
            </div>
        </div>
      </div>


      <div class="sep"></div>
      <div class="sep"></div>
      
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
</main>

@endsection