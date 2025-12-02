{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Ccombatiente Registrar')


@section('content')

<style>
    .disc_container {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;

    }

    .content-todo2 {
        padding-left: 2rem;
        padding-right: 2rem;
    }


    .form-select {
        /* width: 50px; */
        transition: all 0.4s ease;
        border: none;
        /* Elimina todos los bordes */
        border-bottom: 1px solid #007bff;
        /* Agrega un borde inferior sólido */
        border-radius: 12px;
    }

    .form-select:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }
</style>



<main class="p-4">

    @include('layouts.alertas')


    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Cuerpo Combatiente > Registrar</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Buscar Usuario</h3>

            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <!-- This will cause the card to be removed when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="{{ route('busqueda-siggefirh') }}" method="post">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-5">
                        <div class="link-secondary">Tipo de documento<span class="requerido">*</span></div>

                        <select name="snacionalidad" id="snacionalidad" class="form-select" required>

                            <option value="">Seleccione</option>
                            <option value="V">Venezolano</option>
                            <option value="E">Extranjero</option>
                            <option value="P">Pasaporte</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <div class="link-secondary">Nro. de documento<span class="requerido">*</span></div>
                        <input tabindex="9" class="form-control" placeholder="Nro. del documento" name="ndocumento" id="ndocumento" maxlength="11" onkeypress="return numbers(event);" pattern="[0-9]{6,11}" value="{{ old('ndocumento') }}">
                    </div>


                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="submit" class=" btn btn-guardar rounded-pill my-3">Buscar</button>
                    </div>

                </div>
                <input type="text" class="form-control" name="nusuario_actualizacion" hidden value="{{Auth::user()->ndocumento}}">
            </form>
        </div>
        <!-- /.card-body -->
    </div>

    @php
    $persona = $persona ?? null;

    @endphp


    @if(session('error') == 'Persona no encontrada en SIGEFIRHH.')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const campos = [
                'sprimer_nombre',
                'ssegundo_nombre',
                'sprimer_apellido',
                'ssegundo_apellido',
                'dfecha_nacimiento',
                'ssexo',
                'ubicacion',
                'cargo_titular',
                'ente_trabajador',
                'tipo_trabajador'

            ];



            campos.forEach(nombre => {
                // Campo visible pero disabled (con id)
                const campoDisabled = document.getElementById(nombre);
                // Campo oculto pero editable (con name)
                const campoHidden = document.querySelector(`[name="${nombre}"]`);

                if (campoDisabled) {
                    // Ocultamos el campo deshabilitado
                    campoDisabled.setAttribute('hidden', true);
                    campoDisabled.setAttribute('disabled', true);
                }

                if (campoHidden) {
                    // Mostramos el campo oculto
                    campoHidden.removeAttribute('hidden');
                    campoHidden.removeAttribute('disabled');
                }
            });
            const inputFechaNacimiento = document.querySelector('input[name="dfecha_nacimiento"]:not([hidden])');

            // Selecciona el input de edad por su 'name'
            const inputEdad = document.querySelector('input[name="edad"]');

            // El input oculto, para fines de sincronización de datos antes del envío
            const inputFechaNacimientoOculto = document.querySelector('input[name="dfecha_nacimiento"][hidden]');

            // Verificación de existencia de los elementos
            if (!inputFechaNacimiento || !inputEdad) {
                console.error("No se encontraron los inputs de Fecha de Nacimiento o Edad visibles.");
                return;
            }

            // Función principal para calcular y mostrar la edad
            function calcularEdad() {
                const fechaNacimientoStr = inputFechaNacimiento.value;

                if (!fechaNacimientoStr) {
                    inputEdad.value = '';
                    // Limpia el valor oculto si el principal se vacía
                    if (inputFechaNacimientoOculto) {
                        inputFechaNacimientoOculto.value = '';
                    }
                    return;
                }

                const fechaNacimiento = new Date(fechaNacimientoStr);
                const hoy = new Date();

                // Cálculo de la edad en años
                let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
                const mes = hoy.getMonth() - fechaNacimiento.getMonth();

                // Ajuste si aún no ha cumplido años
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                    edad--;
                }

                inputEdad.value = edad;

                // Sincroniza el valor con el input oculto (asumiendo que este es el que se envía)
                if (inputFechaNacimientoOculto) {
                    inputFechaNacimientoOculto.value = inputFechaNacimiento.value;
                }
            }

            // 1. Ejecutar al cargar la página (para valores prellenados)
            calcularEdad();

            // 2. Adjuntar los eventos al input visible para actualización "simultánea"
            // (Recuerda quitar el 'disabled' del input visible)
            inputFechaNacimiento.addEventListener('input', calcularEdad);
            inputFechaNacimiento.addEventListener('change', calcularEdad);
        });
    </script>

    @php
    $nacionalidad = session('nacionalidad');
    $cedula = session('cedula');
    @endphp

    @endif
    <form action="{{ route('dato-personal-crear') }}" method="post">
        @csrf


        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Básicos</h3>

                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
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
                        @php
                        if($persona->nacionalidad ?? '' == "1"){
                        $nacionalidad = 'V';
                        } elseif($persona->nacionalidad ?? '' == "2"){
                        $nacionalidad = 'E';
                        } elseif($persona->nacionalidad ?? '' == "3"){
                        $nacionalidad = 'P';
                        }
                        @endphp
                        @if(session('error') == 'Persona no encontrada en SIGEFIRHH.')

                        <input type="text" hidden name="snacionalidad2" value="{{ old('snacionalidad2', $nacionalidad ?? '') }}">
                        <input type="text" hidden name="ndocumento2" value="{{ old('ndocumento2', $cedula ?? '') }}">
                        @else
                        <input type="text" hidden name="snacionalidad2" value="{{ old('snacionalidad2', $nacionalidad ?? '') }}">
                        <input type="text" hidden name="ndocumento2" value="{{ old('ndocumento2', $persona->cedula ?? '') }}">
                        @endif

                        <div class="link-secondary">Primer nombre </div>

                        <input type="text" class="form-control" id="sprimer_nombre" disabled value="{{ old('sprimer_nombre', $persona->primer_nombre  ?? '') }}">
                        <input type="text" class="form-control" name="sprimer_nombre" value="{{ old('sprimer_nombre', $persona->primer_nombre  ?? '') ?? $persona->primer_nombre  ?? ''  }}" hidden>

                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Segundo nombre </div>
                        <input type="text" class="form-control" id="ssegundo_nombre" disabled value="{{old('ssegundo_nombre', $persona->segundo_nombre ?? '') ??  $persona->segundo_nombre  ?? ''  }}">
                        <input type="text" class="form-control" name="ssegundo_nombre" value="{{ old('ssegundo_nombre', $persona->segundo_nombre ?? '') ?? $persona->segundo_nombre  ?? ''  }}" hidden>
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Primer apellido </div>
                        <input type="text" class="form-control" id="sprimer_apellido" disabled value="{{ old('sprimer_apellido', $persona->primer_apellido  ?? '') }}">
                        <input type="text" class="form-control" name="sprimer_apellido" value="{{ old('sprimer_apellido', $persona->primer_apellido  ?? '') ?? $persona->primer_apellido  ?? ''  }}" hidden>
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Segundo apellido</div>
                        <input type="text" class="form-control" id="ssegundo_apellido" disabled value="{{ old('ssegundo_apellido', $persona->segundo_apellido  ?? '') }}">
                        <input type="text" class="form-control" name="ssegundo_apellido" value="{{ old('ssegundo_apellido', $persona->segundo_apellido  ?? '') }}" hidden>
                    </div>

                </div>


                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-2" style="min-width: 160px">
                        <div class="link-secondary">Fecha de nacimiento</div>
                        <input type="date" class="form-control" id="dfecha_nacimiento" disabled value="{{ old('dfecha_nacimiento', $persona->fecha_nacimiento  ?? '') }}">
                        <input type="date" class="form-control" name="dfecha_nacimiento" value="{{ old('dfecha_nacimiento', $persona->fecha_nacimiento  ?? '') }}" hidden>

                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // 1. Prioridad: Elemento visible por ID
                            let inputFechaNacimiento = document.getElementById('dfecha_nacimiento');

                            // 2. Respaldo: Elemento oculto por NAME, en caso de que el primero falle o esté vacío
                            const inputFechaNacimientoOculto = document.querySelector('input[name="dfecha_nacimiento"][hidden]');

                            // 3. Campo de Edad (Salida)
                            const inputEdad = document.querySelector('input[name="edad"]');

                            // Verificación
                            if (!inputFechaNacimiento || !inputEdad) {
                                // En caso de que el input principal falle, intentamos usar el oculto para el cálculo inicial
                                if (!inputFechaNacimiento && inputFechaNacimientoOculto) {
                                    inputFechaNacimiento = inputFechaNacimientoOculto;
                                } else {
                                    console.error("No se encontraron los inputs necesarios para el cálculo de edad.");
                                    return;
                                }
                            }

                            // Función principal para calcular y mostrar la edad
                            function calcularEdad() {
                                // Obtenemos el valor del input visible/principal
                                let fechaNacimientoStr = inputFechaNacimiento.value;

                                // Si el input visible no tiene valor, intentamos el valor del input oculto
                                if (!fechaNacimientoStr && inputFechaNacimientoOculto) {
                                    fechaNacimientoStr = inputFechaNacimientoOculto.value;
                                }

                                if (!fechaNacimientoStr) {
                                    inputEdad.value = '';
                                    return;
                                }

                                const fechaNacimiento = new Date(fechaNacimientoStr);
                                const hoy = new Date();

                                // Cálculo de la edad (en años)
                                let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
                                const mes = hoy.getMonth() - fechaNacimiento.getMonth();

                                // Ajuste si aún no ha cumplido años
                                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                                    edad--;
                                }

                                inputEdad.value = edad;

                                // **IMPORTANTE:** Actualizar el input oculto (si existe) cuando el visible cambia
                                // Esto asegura que ambos inputs tengan el mismo valor antes de enviar el formulario.
                                if (inputFechaNacimiento !== inputFechaNacimientoOculto && inputFechaNacimientoOculto) {
                                    inputFechaNacimientoOculto.value = inputFechaNacimiento.value;
                                }
                            }

                            // 1. Ejecutar al cargar la página (para valores prellenados de old() o $persona)
                            calcularEdad();

                            // 2. Adjuntar los eventos al input visible (que es el que el usuario usa para interactuar)
                            // Recuerda que debes quitar el 'disabled' del input visible.
                            inputFechaNacimiento.addEventListener('input', calcularEdad);
                            inputFechaNacimiento.addEventListener('change', calcularEdad);
                        });
                    </script>
                    <div class="col-md-1" style="min-width: 80px">
                        <div class="link-secondary">Edad</div>
                        <input type="text" class="form-control" name="edad" disabled value="">
                    </div>

                    <div class="col-md-2">
                        <div class="link-secondary">Sexo</div>

                        <select id="ssexo" name="ssexo" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1" @selected( old('ssexo', $persona->sexo ?? '') === '1' || isset($persona) && $persona->sexo === '1')>Femenino</option>
                            <option value="2" @selected( old('ssexo', $persona->sexo ?? '') === '2' || isset($persona) && $persona->sexo === '2')>Masculino</option>
                        </select>
                        <!-- <select name="ssexo" class="form-control" hidden>
                            <option value="">Seleccione</option>
                            <option value="1" @selected( old('ssexo', $persona->sexo ?? '') === '1' || isset($persona) && $persona->sexo === '1')>Femenino</option>
                            <option value="2" @selected( old('ssexo', $persona->sexo ?? '') === '2' || isset($persona) && $persona->sexo === '2')>Masculino</option>
                        </select> -->

                    </div>

                    <div id="contenedor-embarazo" class="col-md-2" style="display: none;">
                        <div class="link-secondary">¿Está embarazada? </div>
                        <select name="bembarazada" id="embarz" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1">SI</option>
                            <option value="0">NO</option>
                        </select>
                        @error('bembarazada')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // El valor de Femenino es '1'
                            const VALOR_FEMENINO = '1';

                            // Seleccionamos el select de sexo por su ID (el visible)
                            const selectorSexo = document.getElementById('ssexo');
                            // Seleccionamos el contenedor de embarazo por su nuevo ID
                            const contenedorEmbarazo = document.getElementById('contenedor-embarazo');

                            // Función para manejar la visibilidad
                            function actualizarVisibilidadEmbarazo() {
                                if (!selectorSexo || !contenedorEmbarazo) {
                                    // Salir si los elementos no se encontraron
                                    return;
                                }

                                // Si el valor seleccionado es '1' (Femenino)
                                if (selectorSexo.value === VALOR_FEMENINO) {
                                    contenedorEmbarazo.style.display = 'block'; // Mostrar
                                } else {
                                    contenedorEmbarazo.style.display = 'none'; // Ocultar

                                    // Opcional: Restablecer el valor de 'embarazada' a "Seleccione" al ocultar
                                    const selectEmbarazo = document.getElementById('embarz');
                                    if (selectEmbarazo) {
                                        selectEmbarazo.value = '';
                                    }
                                }
                            }

                            // 1. Ejecutar al cargar la página para manejar valores preseleccionados (old() o $persona->sexo)
                            actualizarVisibilidadEmbarazo();

                            // 2. Ejecutar la función cada vez que el valor del selector de sexo cambie
                            // Usamos 'change' para un select
                            selectorSexo.addEventListener('change', actualizarVisibilidadEmbarazo);
                        });
                    </script>
                    <div class="col-md-3" style="min-width: 200p">
                        <div class="link-secondary">Correo electrónico</div>
                        <input type="email" name="semail" class="form-control" placeholder="Ejemplo@mail.com" value="{{ old('semail', $persona->semail  ?? '' )  }}">
                        @error('semail')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                </div>



                <div class="row mb-4 fs-6 d-flex align-items-end mb-4">

                    <div class="col-md-4" style="min-width: 200p">
                        <div class="link-secondary">Estado Civil<span class="requerido">*</span></div>
                        <select name="ecivil" id="ecivil" class="form-select" data-selected="{{ old('ecivil') }}">
                            <option value="">Seleccione</option>

                            <option value="1" @selected(old('ecivil')==='1' || ($persona->estado_civil ?? '') === 'S')>Soltero(a)</option>

                            <option value="2" @selected(old('ecivil')==='2' || ($persona->estado_civil ?? '') === 'C')>Casado(a)</option>

                            <option value="3" @selected(old('ecivil')==='3' || ($persona->estado_civil ?? '') === 'V')>Viudo(a)</option>

                            <option value="4" @selected(old('ecivil')==='4' || ($persona->estado_civil ?? '') === 'D')>Divorciado(a)</option>
                        </select>
                        @error('ecivil')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Teléfono personal <span class="requerido">*</span></div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="ncodigo_telfmovil" id="ncodigo_telfmovil" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach($cod_moviles as $cod_movil)
                                    <option value="{{$cod_movil->ncodigo}}" @selected(old('ncodigo_telfmovil'))>
                                        0{{$cod_movil->ncodigo}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('ncodigo_telfmovil')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" maxlength="7" value="{{ old('nnumero_telfmovil' ?? '') }}">
                                @error('nnumero_telfmovil')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Teléfono de habitación</div>
                        <div class="row">
                            <div class="col-md-4">
                                <select name="ncodigo_telflocal" id="ncodigo_telflocal" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach($cod_locales as $cod_local)
                                    <option value="{{$cod_local->ncodigo}}" @selected( old('ncodigo_telflocal'))>
                                        0{{$cod_local->ncodigo}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" value="{{ old('nnumero_telflocal' ) }}" maxlength="7">
                                @error('nnumero_telflocal')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos de la Dirección de Habitación</h3>

                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
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

                        <div class="link-secondary">Estado<span class="requerido">*</span></div>

                        <select class="form-control" name="id_estado" id="estado" data-municipios-url="{{ url('municipios') }}">
                            <option value="-1" disabled {{ old('id_estado', $entidad->id ?? null) ? 'selected' : '' }}>
                                Seleccione el estado
                            </option>

                            @foreach ($estados as $estado)
                            <option value="{{ $estado->nentidad }}"
                                {{ old('id_estado', $persona->nentidad_entidad ?? null) == $estado->nentidad ? 'selected' : '' }}>
                                {{ $estado->sdescripcion }}
                            </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Municipio<span class="requerido">*</span></div>
                        <select class="form-control" name="id_municipio" id="municipio" data-parroquias-url="{{ url('parroquias') }}" data-selected="{{ old('id_municipio', $entidad->municipio ?? '') }}">
                            <option value="-1" disabled selected>Seleccione el muniSección III – Percepción sobre los temas tratados
                                cipio</option>

                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Parroquia<span class="requerido">*</span></div>
                        <select class="form-control" name="id_parroquia" id="parroquia" data-selected="{{ old('id_parroquia', $entidad->id_parroquia ?? '') }}">
                            <option value="-1" disabled selected>Seleccione la parroquia</option>
                        </select>
                    </div>
                </div>

                <div class="row fs-6 d-flex align-items-end mb-4">

                    <div class="col-md-6">
                        <div class="link-secondary">Dirección </div>
                        <textarea name="ndireccion" id="ndireccion" class="form-control">{{old('ndireccion')}}</textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary">Punto de referencia </div>
                        <textarea name="punto_referencia" id="punto_referencia" class="form-control">{{old('punto_referencia')}}</textarea>
                    </div>
                </div>

                <div class="row fs-6">




                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Comunas</h3>

                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 mb-4">
                    <div class="col-md-12">
                        <!--                         <div class="link-secondary"><span class="requerido">*</span></div> -->
                        <div class="link-secondary">Consejo Comunal</div>
                        <input type="text" name="consejo_comunal" id="consejo_comunal" class="form-control" value="{{ old('consejo_comunal') }}" placeholder="Nombre del Consejo Comunal">

                    </div>
                </div>
                <br>
                <div class="row fs-6">
                    <div class="col-md-3">
                        <div class="link-secondary" id="estado_text">Estado</div>

                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary" id="municipio_text">Municipio</div>

                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary" id="parroquia_text">Parroquia</div>
                    </div>

                    <div class="col-md-3">
                        <div class="link-secondary">Comuna o Circuito Comunal<span class="requerido">*</span></div>
                        <select name="comuna" id="comuna" class="form-select" data-selected="{{ old('comuna', $persona->id_comuna ?? '') }}">
                            <option value="">Seleccione</option>
                            @foreach($comunas as $comuna)
                            <option value="{{ $comuna->id_comuna_circuito }}" @selected(old('comuna')==$comuna->id_comuna_circuito)>{{ $comuna->sdescripcion }}</option>
                            @endforeach
                        </select>
                        @error('comuna')
                        <small class="text-danger">{{$message}}</small>
                        @enderror

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Adicionales</h3>

                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 ">
                    <div class="col-md-4">
                        <div class="link-secondary">¿Tiene discapacidad? <span class="requerido">*</span></div>
                        <select name="bdiscapacidad" id="bdiscapacidad" data-selected="{{ old('bdiscapacidad', $persona->sdiscapacidad ?? '') }}" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="0" @selected(old('bdiscapacidad', $persona->sdiscapacidad ?? '') == '0')>NO</option>
                            <option value="1" @selected(old('bdiscapacidad', $persona->sdiscapacidad ?? '') == '1')>SI</option>
                        </select>
                        @error('bdiscapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Lateralidad<span class="requerido">*</span></div>
                        <select name="lateralidad" id="lateralidad" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected(old('lateralidad', $persona->slateralidad ?? '') == '1')>Ambas</option>
                            <option value="2" @selected(old('lateralidad', $persona->slateralidad ?? '') == '2')>Diestro</option>
                            <option value="3" @selected(old('lateralidad', $persona->slateralidad ?? '') == '3')>Zurdo</option>
                        </select>
                        @error('lateralidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Tipo de Sangre<span class="requerido">*</span></div>
                        <select name="tsangre" id="tsangre" class="form-select">
                            <option value="">Seleccione</option>
                            @foreach($id_grupo_sanguineo as $tipo_sangre)
                            <option value="{{ $tipo_sangre->id }}" @selected(old('tsangre', $persona->id_tipo_sangre ?? '') == $tipo_sangre->id)>{{ $tipo_sangre->sdescripcion }}</option>
                            @endforeach
                        </select>
                        @error('tsangre')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 d-flex align-items-end" id="row_disc1" style="display=none;">
                    <div class="col-md-4 {{ old('bdiscapacidad', Auth::user()->bdiscapacidad) == 0 ? 'disc_container' : '' }}" id="tipo_discapacidad_container">
                        <div class="link-secondary">¿Tipo de discapacidad? <span class="requerido">*</span></div>
                        <select name="id_tdiscapacidad" id="id_tdiscapacidad" class="form-select">
                            <option value="">Seleccione</option>
                            @foreach ($t_discapacidad as $discapacidad)
                            <option value="{{ $discapacidad->id_tdiscapacidad }}" {{ old('id_tdiscapacidad', $persona->id_tipo_discapacidad ?? '') == $discapacidad->id_tdiscapacidad ? 'selected' : ''}}>
                                {{ $discapacidad->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_tdiscapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 {{ old('bdiscapacidad', Auth::user()->bdiscapacidad) == 0 ? 'disc_container' : '' }}" id="grado_discapacidad_container">
                        <div class="link-secondary">Grado de Discapacidad<span class="requerido">*</span></div>
                        <select name="grado_discapacidad" id="grado_discapacidad" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected(old('grado_discapacidad', $persona->grado_discapacidad ?? '') == '1')>Leve</option>
                            <option value="2" @selected(old('grado_discapacidad', $persona->grado_discapacidad ?? '') == '2')>Moderada</option>
                            <option value="3" @selected(old('grado_discapacidad', $persona->grado_discapacidad ?? '') == '3')>Severa</option>
                        </select>
                        @error('grado_discapacidad')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-5 {{ old('bdiscapacidad', Auth::user()->bdiscapacidad) == 0 ? 'disc_container' : '' }}" id="especifique_discapacidad_container">
                        <div class="link-secondary">Especifique</div>
                        <textarea name="sdicapacidad_especifica" id="sdicapacidad_especifica" class="form-control">{{ old('sdicapacidad_especifica', Auth::user()->sdicapacidad_especifica )}}</textarea>
                        @error('sdicapacidad_especifica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>


                <div class="row fs-6 d-flex align-items-end" id="row_disc2">



                    <div class="col-md-3 {{ old('bdiscapacidad', Auth::user()->bdiscapacidad) == 0 ? 'disc_container' : '' }}" id="tiene_conapdis_container">
                        <div class="link-secondary">¿Tiene Certificado CONAPDIS? <span class="requerido">*</span></div>
                        <select name="bcertificado_conapdis" id="bcertificado_conapdis" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('bcertificado_conapdis', Auth::user()->bcertificado_conapdis) == 1 ? 'selected' : '' }}>SI</option>
                            <option value="0" {{ old('bcertificado_conapdis', Auth::user()->bcertificado_conapdis) == 0 ? 'selected' : '' }}>NO</option>
                        </select>
                        @error('bcertificado_conapdis')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-5 {{ old('bcertificado_conapdis', Auth::user()->bcertificado_conapdis) == 0 ? 'disc_container' : '' }}" id="num_conapdis_container">
                        <div class="link-secondary">Indique el número de certificado</div>
                        <input type="text" class="form-control num_certif" id="nnum_certificado" name="nnum_certificado" maxlength="7" pattern="[0-9]{6,11}" value="{{ old('nnum_certificado', Auth::user()->nnum_certificado)}}">
                        @error('nnum_certificado')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 my-4">
                    <div class="col-md-3">
                        <div class="link-secondary">¿Tiene alguna condición de salud? <span class="requerido">*</span></div>
                        <select name="benfermedad_cronica" id="benfermedad_cronica" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="0" @selected(old('benfermedad_cronica'))>NO</option>
                            <option value="1" @selected(old('benfermedad_cronica'))>SI</option>
                        </select>
                        @error('benfermedad_cronica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-3" id="especifique_enfermedad_container">
                        <div class="link-secondary">Especifique <span class="requerido">*</span></div>
                        <input type="text" name="senfermedad_cronica_especifica" id="senfermedad_cronica_especifica" class="form-control" value="{{ old('senfermedad_cronica_especifica') }}">
                        @error('senfermedad_cronica_especifica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">¿Está bajo tratamiento médico? <span class="requerido">*</span></div>
                        <select name="btratamiento_medico" id="btratamiento_medico" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="0" @selected(old('btratamiento_medico'))>NO</option>
                            <option value="1" @selected(old('btratamiento_medico'))>SI</option>
                        </select>
                        @error('btratamiento_medico')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <div class="link-secondary">Indique cual <span class="requerido">*</span></div>
                        <input type="text" name="stratamiento_medico_especifico" id="stratamiento_medico_especifico" class="form-control" value="{{ old('stratamiento_medico_especifico') }}">
                        @error('stratamiento_medico_especifico')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="row fs-6 my-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Talla de Camisa <span class="requerido">*</span></div>
                        <select name="talla_camisa" id="talla_camisa" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '1')>XS</option>
                            <option value="2" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '2')>S</option>
                            <option value="3" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '3')>M</option>
                            <option value="4" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '4')>L</option>
                            <option value="5" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '5')>XL</option>
                            <option value="6" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '6')>XXL</option>
                            <option value="7" @selected (old('talla_camisa', $persona->stalla_camisa ?? '') === '7')>XXXL</option>

                        </select>
                        @error('talla_camisa')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Talla de Zapato<span class="requerido">*</span></div>
                        <select name="talla_zapato" id="talla_zapato" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '1')>36</option>
                            <option value="2" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '2')>37</option>
                            <option value="3" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '3')>38</option>
                            <option value="4" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '4')>39</option>
                            <option value="5" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '5')>40</option>
                            <option value="6" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '6')>41</option>
                            <option value="7" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '7')>42</option>
                            <option value="8" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '8')>43</option>
                            <option value="9" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '9')>44</option>
                            <option value="10" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '10')>45</option>
                            <option value="11" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '11')>46</option>
                            <option value="12" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '12')>47</option>
                            <option value="13" @selected (old('talla_zapato', $persona->ntalla_zapato ?? '') === '13')>48</option>
                        </select>
                        @error('talla_zapato')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Talla de Pantalón<span class="requerido">*</span></div>
                        <select name="talla_pantalon" id="talla_pantalon" class="form-select">
                            <option value="">Seleccione</option>

                            <option value="1" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '1')>26</option>
                            <option value="2" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '2')>28</option>
                            <option value="3" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '3')>30</option>
                            <option value="4" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '4')>32</option>
                            <option value="5" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '5')>34</option>
                            <option value="6" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '6')>36</option>
                            <option value="7" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '7')>38</option>
                            <option value="8" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '8')>40</option>
                            <option value="9" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '9')>42</option>
                            <option value="10" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '10')>44</option>
                            <option value="11" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '11')>46</option>
                            <option value="12" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '12')>48</option>
                            <option value="13" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '13')>50</option>
                            <option value="14" @selected (old('talla_camisa', $persona->stalla_pantalon ?? '') === '14')>54</option>
                        </select>
                        @error('talla_pantalon')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Inscripción militar <span class="requerido">*</span></div>
                        <select name="imilitar" id="imilitar" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected(old('imilitar', $persona->sinscripcion_militar ?? '') == '1')>Si</option>
                            <option value="0" @selected(old('imilitar', $persona->sinscripcion_militar ?? '') == '0')>No</option>
                        </select>
                        @error('imilitar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="link-secondary">Nro. Inscripción Militar</div>
                        <input type="number" class="form-control" name="nnum_inscripcion_militar" placeholder="Indique su nro. de inscripción militar" value="{{ old('nnum_inscripcion_militar', $persona->ncodigo_inscripcion_militar ?? '' )}}">
                        @error('nnum_inscripcion_militar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div> -->


                    <div class="col-md-4">
                        <div class="link-secondary">¿Se alisto como miliciano?<span class="requerido">*</span></div>
                        <select name="registro_mimilitar" id="registro_mimilitar" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected(old('registro_mimilitar', $persona->sregistro_mimilitar ?? '') == '1')>Si</option>
                            <option value="0" @selected(old('registro_mimilitar', $persona->sregistro_mimilitar ?? '') == '0')>No</option>
                        </select>
                        @error('registro_mimilitar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 mb-4">

                    <div class="col-md-6">
                        <div class="link-secondary">¿Prestaste servicio militar?<span class="requerido">*</span></div>
                        <select name="prestaste_servicio_militar" id="prestaste_servicio_militar" class="form-select">
                            <option value="">Seleccione</option>
                            <option value="1" @selected(old('prestaste_servicio_militar', $persona->prestaste_servicio_militar ?? '') == '1')>Si</option>
                            <option value="0" @selected(old('prestaste_servicio_militar', $persona->prestaste_servicio_militar ?? '') == '0')>No</option>
                        </select>
                        @error('prestaste_servicio_militar')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="link-secondary">Rango</div>
                       <!--  <input type="text" class="form-control" name="nrango_militancia" placeholder="Indique su rango de militancia" value="{{old('nrango_militancia')}}"> -->
                        <select name="nrango_militancia" id="nrango_militancia" class="form-select">
                            <option value="">Seleccione</option>
                            @foreach($rangos as $rango)
                            <option value="{{ $rango->id_rango }}" @selected(old('nrango_militancia'))>{{ $rango->sdescripcion }}</option>
                            @endforeach
                        </select>
                        @error('nrango_militancia')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                </div>

                <div class="row fs-6 mb-4">

                    <div class="col-md-3">
                        <div class="link-secondary">¿Tiene hijos?<span class="requerido">*</span></div>
                        <select name="hijos" id="hijos" class="form-select">
                            <option value="">Seleccione</option>

                            <option value="0" @selected(old('hijos', $persona->hijos ?? '') == '0')>No</option>

                            <option value="1" @selected(old('hijos', $persona->hijos ?? '') == '1')>Si</option>
                        </select>
                        @error('hijos')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="link-secondary">¿Cuánto menores de 18 años?</div>
                        <input type="number" class="form-control" name="nhijos" placeholder="Indique su número de hijos" value="  ">
                        @error('nhijos')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Laborales</h3>

                <div class="card-tools">
                    <!-- This will cause the card to maximize when clicked -->
                    <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                    <!-- This will cause the card to collapse when clicked -->
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <!-- This will cause the card to be removed when clicked -->
                    <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row fs-6 mb-3">
                    <div class="col-md-8">
                        <div class="link-secondary">Ubicación administrativa de adscripción </div>
                        <input type="text" class="form-control" id="ubicacion" placeholder="" value="{{ old('ubicacion', $persona->ubicacion ?? '' ) }}" disabled>
                        <input type="text" class="form-control" name="ubicacion" placeholder="" value="{{ old('ubicacion', $persona->ubicacion ?? '' ) }}" hidden>
                        @error('ubicacion')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">Estado<span class="requerido">*</span></div>
                        <select name="ubicacion_estado" id="ubicacion_estado" class="form-select">
                            <option value="">Seleccione</option>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado->nentidad }}"
                                {{old('ubicacion_estado', $persona->id_ciudad ?? 'null') == $estado->nentidad ? 'selected' : '' }}>
                                {{ $estado->sdescripcion }}
                            </option>
                            @endforeach
                        </select>
                        @error('ubicacion_estado')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 mb-4">
                    <div class="col-md-12">
                        <div class="link-secondary">Ubicación física</div>
                        <input type="text" class="form-control" name="ubicacion_fisica" placeholder="Indique su ubicación física" value="{{ old('ubicacion_fisica', $persona->subicacion_fisica ?? '') }}">
                        @error('ubicacion_fisica')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 mb-4">
                    <div class="col-md-6">
                        <div class="link-secondary">Cargo o puesto de trabajo titular</div>
                        <select id="cargo_titular" class="form-select" data-selected="{{ old('cargo_titular', $persona->scodigo ?? '') }}" disabled>
                            <option value=""></option>
                            @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->scodigo }}" @selected(old('cargo_titular', $persona->scodigo ?? '') == $cargo->scodigo)>{{ $cargo->sdescripcion }}</option>
                            @endforeach
                        </select>
                        <select name="cargo_titular" class="form-select" data-selected="{{ old('cargo_titular', $persona->scodigo ?? '') }}" hidden>
                            <option value=""></option>
                            @foreach ($cargos as $cargo)
                            <option value="{{ $cargo->scodigo }}" @selected(old('cargo_titular', $persona->scodigo ?? '') == $cargo->scodigo)>{{ $cargo->sdescripcion }}</option>
                            @endforeach
                        </select>
                        @error('cargo_titular')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="link-secondary">Cargo o puesto de trabajo que ejerce</div>
                        <input type="text" class="form-control" name="cargo_ejerce" placeholder="Indique su cargo o puesto de trabajo que ejerce" value="{{ old('cargo_ejerce', $persona->scargo_actual_ejerce ?? '' )}}">
                        @error('cargo_ejerce')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row fs-6 mb-4">
                    <div class="col-md-4">
                        <div class="link-secondary">Tipo de trabajador</div>
                        <select id="tipo_trabajador" class="form-select" disabled>
                            <option value="">Seleccione</option>
                            @foreach ($tipo_trabajo as $trabajador)
                            <option value="{{ $trabajador->ncodigo }}" @selected(old('tipo_trabajador', $persona->tipo_trabajador_ncodigo ?? '') == $trabajador->ncodigo)>{{ $trabajador->sdescripcion }}</option>
                            @endforeach
                        </select>
                        <select name="tipo_trabajador" class="form-select" data-selected="{{ old('tipo_trabajador', $persona->tipo_trabajador_ncodigo ?? '') }}" hidden>
                            <option value="">Seleccione</option>
                            @foreach ($tipo_trabajo as $trabajador)
                            <option value="{{ $trabajador->ncodigo }}" @selected(old('tipo_trabajador', $persona->tipo_trabajador_ncodigo ?? '') == $trabajador->ncodigo)>{{ $trabajador->sdescripcion }}</option>
                            @endforeach
                        </select>
                        @error('tipo_trabajador')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <div class="link-secondary">Ente de Procedencia</div>

                        <select id="ente_trabajador" class="form-select" data-selected="{{ old('ente_trabajador', $persona->ncodigo_nomina ?? '') }}" disabled>
                            <option value="">Seleccione</option>
                            <option value="MPPPST" @selected(old('ente_trabajador' , $persona->ncodigo_nomina ?? '')) >
                                MPPPST
                            </option>

                            <option value="INPSASEL">
                                INPSASEL
                            </option>
                            <option value="INCES">
                                INCES
                            </option>
                            <option value="TSS">
                                TSS
                            </option>
                        </select>

                        <select name="ente_trabajador" class="form-select" data-selected="{{ old('ente_trabajador', $persona->ncodigo_nomina ?? '') }}" hidden>
                            <option value="">Seleccione</option>

                            <option value="MPPPST" @selected(old('ente_trabajador', $persona ?? '' ) )>
                                MPPPST
                            </option>
                            <option value="INPSASEL">
                                INPSASEL
                            </option>
                            <option value="INCES">
                                INCES
                            </option>
                            <option value="TSS">
                                TSS
                            </option>
                            <option value="INCRET">INCRET</option>
                        </select>
                        @error('ente_trabajador')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>


                    @error('ntrabajador')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>


            <!-- Botón Guardar -->
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
    <script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/datos_personales.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los inputs y textareas
            const campos = document.querySelectorAll('input[type="text"], textarea');

            campos.forEach(campo => {
                campo.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            });
        });
    </script>
    @push('js')
    <script>
        $(document).ready(function() {
            const $selectHijos = $('#hijos');
            const $inputNHijos = $('input[name="nhijos"]');

            function actualizarCampoHijos() {
                const valor = $selectHijos.val();

                if (valor === '0') {
                    $inputNHijos.val(''); // limpia el campo
                    $inputNHijos.prop('disabled', true); // deshabilita
                } else if (valor === '1') {
                    $inputNHijos.prop('disabled', false); // habilita
                } else {
                    $inputNHijos.val(''); // limpia si se elige "Seleccione"
                    $inputNHijos.prop('disabled', true);
                }
            }

            // Ejecuta al cargar la página
            actualizarCampoHijos();

            // Ejecuta cada vez que cambie el select
            $selectHijos.on('change', actualizarCampoHijos);
        });
    </script>
    <script>
        $(document).ready(function() {
            const $selectsalud = $('#benfermedad_cronica');
            const $inputsalud = $('input[name="senfermedad_cronica_especifica"]');

            function actualizarCampoSalud() {
                const valor = $selectsalud.val();

                if (valor === '0') {
                    $inputsalud.val(''); // limpia el campo
                    $inputsalud.prop('disabled', true); // deshabilita
                } else if (valor === '1') {
                    $inputsalud.prop('disabled', false); // habilita
                } else {
                    $inputsalud.val(''); // limpia si se elige "Seleccione"
                    $inputsalud.prop('disabled', true);
                }
            }

            // Ejecuta al cargar la página
            actualizarCampoSalud();

            // Ejecuta cada vez que cambie el select
            $selectsalud.on('change', actualizarCampoSalud);
        });
    </script>
    <script>
        $(document).ready(function() {
            const $selecttratamiento = $('#btratamiento_medico');
            const $inputtratamiento = $('input[name="stratamiento_medico_especifico"]');

            function actualizarCampoTratamiento() {
                const valor = $selecttratamiento.val();

                if (valor === '0') {
                    $inputtratamiento.val(''); // limpia el campo
                    $inputtratamiento.prop('disabled', true); // deshabilita
                } else if (valor === '1') {
                    $inputtratamiento.prop('disabled', false); // habilita
                } else {
                    $inputtratamiento.val(''); // limpia si se elige "Seleccione"
                    $inputtratamiento.prop('disabled', true);
                }
            }
            // Ejecuta al cargar la página
            actualizarCampoTratamiento();

            // Ejecuta cada vez que cambie el select
            $selecttratamiento.on('change', actualizarCampoTratamiento);
        });
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function () {

    const selEstado = document.getElementById("estado");
    const selMunicipio = document.getElementById("municipio");
    const selParroquia = document.getElementById("parroquia");

    const txtEstado = document.getElementById("estado_text");
    const txtMunicipio = document.getElementById("municipio_text");
    const txtParroquia = document.getElementById("parroquia_text");

    // Estado → Div
    selEstado.addEventListener("change", function() {
        txtEstado.textContent = selEstado.options[selEstado.selectedIndex].text;
    });

    // Municipio → Div
    selMunicipio.addEventListener("change", function() {
        txtMunicipio.textContent = selMunicipio.options[selMunicipio.selectedIndex].text;
    });

    // Parroquia → Div
    selParroquia.addEventListener("change", function() {
        txtParroquia.textContent = selParroquia.options[selParroquia.selectedIndex].text;
    });

});
</script>

    @endpush

</main>


@endsection
@section('footer')
@include('layouts.footer')
@endsection