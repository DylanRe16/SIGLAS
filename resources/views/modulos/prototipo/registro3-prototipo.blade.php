@extends('prototipoExterno')

@section('culminar-registro')

<style>
    /* Ocultar inicialmente los contenedores de discapacidad.
       El JavaScript controlará su visualización. */
    .disc_container_hidden {
        display: none;
        opacity: 0;
        transition: opacity 0.5s ease;
        font-weight: 450;
    }

    /* Eliminar flechas en todos los navegadores modernos para input type="number" */
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

            @if ($errors->any())
                <div class="alert alert-danger fs-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 

            @if (session('error'))
                <div class="alert alert-danger fs-6">{{ session('error') }}</div>
            @endif

            <form action="{{ route('clave-index2') }}" method="get"> 

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
                    <h4 style="font-size: calc(1.500rem + 0.3vw);">Datos Personales</h4>
                </div>

                <div class="sep"></div>

                <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
                    <div class="col-sm-3">
                        <div style="color: #004B9D; text-align:center">Tipo de Documento </div>
                    </div>

                    <div class="col-sm-3">
                   
                        <select name="snacionalidad" id="snacionalidad" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="V" {{ old('snacionalidad') == 'V' ? 'selected' : '' }}>Venezolano</option>
                            <option value="E" {{ old('snacionalidad') == 'E' ? 'selected' : '' }}>Extranjero</option>
                            <option value="P" {{ old('snacionalidad') == 'P' ? 'selected' : '' }}>Pasaporte</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <div style="color: #004B9D; text-align:center">Nro de Documento </div>
                    </div>

                    <div class="col-sm-3">
                        <input
                            tabindex="9"
                            class="form-control"
                            aria-label="Es obligatorio indicar su Nro. del documento"
                            type="number"
                            placeholder="Nro. del documento"
                            name="ndocumento"
                            id="ndocumento"
                            maxlength="11"
                            onkeypress="return numbers(event);"
                            required pattern="[0-9]{6,11}" 
                            value="{{ old('ndocumento') }}">
                    </div>
                </div>
       
                <input type="hidden" name="nusuario_creacion" value="{{ old('nusuario_creacion') }}">


                <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
                    <div class="col-sm-3">
                        <div style="color: #004B9D;">Primer nombre </div>
                        <input type="text" class="form-control" name="sprimer_nombre" value="{{ old('sprimer_nombre') }}">
                    </div>

                    <div class="col-sm-3">
                        <div style="color: #004B9D; ">Segundo nombre </div>
                        <input type="text" class="form-control" name="ssegundo_nombre" value="{{ old('ssegundo_nombre') }}">
                    </div>

                    <div class="col-sm-3">
                        <div style="color: #004B9D; ">Primer apellido </div>
                        <input type="text" class="form-control" name="sprimer_apellido" value="{{ old('sprimer_apellido') }}">
                    </div>

                    <div class="col-sm-3">
                        <div style="color: #004B9D; ">Segundo apellido</div>
                        <input type="text" class="form-control" name="ssegundo_apellido" value="{{ old('ssegundo_apellido') }}">
                    </div>
                </div>


                <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
                    <div class="col-sm-2">
                        <div style="color: #004B9D; ">Fecha de nacimiento</div>
                        <input type="date" class="form-control" name="dfecha_nacimiento" value="{{ old('dfecha_nacimiento') }}">
                    </div>

                    <div class="col-sm-1">
                        <div style="color: #004B9D; ">Edad</div>
                        <input type="text" class="form-control" name="edad" value="{{ old('edad') }}" readonly> {{-- Usually age is calculated by JS/backend --}}
                    </div>

                    <div class="col-sm-2">
                        <div style="color: #004B9D; ">Sexo</div>

                        <select name="ssexo" id="ssexo" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="F" {{ old('ssexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                            <option value="M" {{ old('ssexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label for="nnumero_telfmovil" class="form-label" style="color: #004B9D;">Teléfono personal <span class="requerido">*</span></label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="ncodigo_telfmovil" id="ncodigo_telfmovil" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="412" {{ old('ncodigo_telfmovil') == '412' ? 'selected' : '' }}>0412</option>
                                    <option value="414" {{ old('ncodigo_telfmovil') == '414' ? 'selected' : '' }}>0414</option>
                                    <option value="416" {{ old('ncodigo_telfmovil') == '416' ? 'selected' : '' }}>0416</option>
                                    <option value="424" {{ old('ncodigo_telfmovil') == '424' ? 'selected' : '' }}>0424</option>
                                    <option value="426" {{ old('ncodigo_telfmovil') == '426' ? 'selected' : '' }}>0426</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" maxlength="7" value="{{ old('nnumero_telfmovil') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="nnumero_telflocal" class="form-label" style="color: #004B9D;">Teléfono local</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="ncodigo_telflocal" id="ncodigo_telflocal" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="212" {{ old('ncodigo_telflocal') == '212' ? 'selected' : '' }}>0212</option>
                                    <option value="241" {{ old('ncodigo_telflocal') == '241' ? 'selected' : '' }}>0241</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                              
                                <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" maxlength="7" pattern="[0-9]{7}" value="{{ old('nnumero_telflocal') }}">
                            </div>
                        </div>
                    </div>

                    <div class="sep"></div>


                    <div class="col-sm-4">
                        <div style="color: #004B9D; ">Correo electrónico</div>
                        <input type="email" name="semail" class="form-control" placeholder="Ejemplo@mail.com" value="{{ old('semail') }}">
                    </div>


                    <div class="col-sm-3">
                        <div style="color: #004B9D; ">Dirección de Habitación</div>
                        <input type="text" name="habitacion" class="form-control" placeholder="Ejemplo@mail.com" value="{{ old('habitacion') }}">
                    </div>

                    <div class="col-sm-4">
                        <div style="color: #004B9D;">¿Tiene discapacidad? <span class="requerido">*</span></div>
                        <select name="bdiscapacidad" id="bdiscapacidad" class="form-control">
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('bdiscapacidad') == '1' ? 'selected' : '' }}>SI</option>
                            <option value="0" {{ old('bdiscapacidad') == '0' ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>

                    <div class="row mb-4 fs-6 d-flex align-items-end disc_container_hidden" id="tipo_discapacidad_container" style="font-weight: 450;">
                        <div class="col-sm-3">
                            <div style="color: #004B9D;">¿Tipo de discapacidad? <span class="requerido">*</span></div>
                            <select name="id_tdiscapacidad" id="id_tdiscapacidad" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1" {{ old('id_tdiscapacidad') == '1' ? 'selected' : '' }}>Discapacidad Visual</option>
                                <option value="2" {{ old('id_tdiscapacidad') == '2' ? 'selected' : '' }}>Discapacidad Auditiva</option>
                                <option value="3" {{ old('id_tdiscapacidad') == '3' ? 'selected' : '' }}>Discapacidad Motora</option>
                            </select>
                        </div>

                        <div class="col-sm-4 disc_container_hidden" id="especifica_container">
                            <div style="color: #004B9D;">Especifique <span class="requerido">*</span></div>
                            <input type="text" name="sdicapacidad_especifica" id="sdicapacidad_especifica" class="form-control" value="{{ old('sdicapacidad_especifica') }}">
                        </div>

                        <div class="col-sm-3 disc_container_hidden" id="grado_container">
                            <div style="color: #004B9D;">Grado de Discapacidad <span class="requerido">*</span></div>
                            <select name="id_grado_discapacidad" id="id_grado_discapacidad" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1" {{ old('id_grado_discapacidad') == '1' ? 'selected' : '' }}>Bajo/Leve</option>
                                <option value="2" {{ old('id_grado_discapacidad') == '2' ? 'selected' : '' }}>Moderado</option>
                                <option value="3" {{ old('id_grado_discapacidad') == '3' ? 'selected' : '' }}>Extremo</option>
                            </select>
                        </div>

                        <div class="col-sm-2 disc_container_hidden" id="tiene_conapdis_container">
                            <div style="color: #004B9D;">¿Tiene Certificado CONAPDIS? <span class="requerido">*</span></div>
                            <select name="bcertificado_conapdis" id="bcertificado_conapdis" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1" {{ old('bcertificado_conapdis') == '1' ? 'selected' : '' }}>SI</option>
                                <option value="0" {{ old('bcertificado_conapdis') == '0' ? 'selected' : '' }}>NO</option>
                            </select>
                        </div>

                        <div class="col-sm-3 disc_container_hidden" id="num_conapdis_container">
                            <div style="color: #004B9D;">Indique el número de certificado</div>
                            <input type="text" class="form-control num_certif" id="nnum_certificado" name="nnum_certificado" maxlength="11" pattern="[0-9]{6,11}" value="{{ old('nnum_certificado') }}">
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const discapacidadSelect = document.getElementById("id_tdiscapacidad");
                            const tieneConapdisSelect = document.getElementById("bcertificado_conapdis");
                            const tieneDiscapacidadSelect = document.getElementById("bdiscapacidad");
                            const tipoDiscapacidadContainer = document.getElementById("tipo_discapacidad_container");
                            const especificaContainer = document.getElementById("especifica_container");
                            const gradoContainer = document.getElementById("grado_container");
                            const conapdisContainer = document.getElementById("tiene_conapdis_container");
                            const numConapdisContainer = document.getElementById("num_conapdis_container");

                            function toggleDiscapacidadFields() {
                                const hasDiscapacidad = tieneDiscapacidadSelect.value === "1";
                                tipoDiscapacidadContainer.classList.toggle("disc_container_hidden", !hasDiscapacidad);
                                especificaContainer.classList.toggle("disc_container_hidden", !hasDiscapacidad);
                                gradoContainer.classList.toggle("disc_container_hidden", !hasDiscapacidad);
                                conapdisContainer.classList.toggle("disc_container_hidden", !hasDiscapacidad);
                                toggleNumCertificado();
                            }

                            function toggleNumCertificado() {
                                const hasConapdis = tieneConapdisSelect.value === "1";
                                numConapdisContainer.classList.toggle("disc_container_hidden", !hasConapdis);
                            }

                            tieneDiscapacidadSelect.addEventListener("change", toggleDiscapacidadFields);
                            tieneConapdisSelect.addEventListener("change", toggleNumCertificado);

                            toggleDiscapacidadFields();
                        });
                    </script>



                <div class="row mb-4 fs-6" style="font-weight: 450;">
                   <!--  <div class="col-sm-4">
                        <label for="nnumero_telfmovil" class="form-label" style="color: #004B9D;">Teléfono personal <span class="requerido">*</span></label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="ncodigo_telfmovil" id="ncodigo_telfmovil" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="412" {{ old('ncodigo_telfmovil') == '412' ? 'selected' : '' }}>0412</option>
                                    <option value="414" {{ old('ncodigo_telfmovil') == '414' ? 'selected' : '' }}>0414</option>
                                    <option value="416" {{ old('ncodigo_telfmovil') == '416' ? 'selected' : '' }}>0416</option>
                                    <option value="424" {{ old('ncodigo_telfmovil') == '424' ? 'selected' : '' }}>0424</option>
                                    <option value="426" {{ old('ncodigo_telfmovil') == '426' ? 'selected' : '' }}>0426</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" maxlength="7" value="{{ old('nnumero_telfmovil') }}">
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-sm-4">
                        <label for="nnumero_telflocal" class="form-label" style="color: #004B9D;">Teléfono local</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select name="ncodigo_telflocal" id="ncodigo_telflocal" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="212" {{ old('ncodigo_telflocal') == '212' ? 'selected' : '' }}>0212</option>
                                    <option value="241" {{ old('ncodigo_telflocal') == '241' ? 'selected' : '' }}>0241</option>
                                </select>
                            </div>
                            <div class="col-sm-8">
                              
                                <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" maxlength="7" pattern="[0-9]{7}" value="{{ old('nnumero_telflocal') }}">
                            </div>
                        </div>
                    </div> -->

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
                        {{-- Removed 'disabled' --}}
                        <select name="pregunta_1" id="pregunta_1" class="form-control select-preg">
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('pregunta_1') == '1' ? 'selected' : '' }}>¿Cuál es el nombre de tu primera mascota?</option>
                            <option value="2" {{ old('pregunta_1') == '2' ? 'selected' : '' }}>¿En qué ciudad naciste?</option>
                            <option value="3" {{ old('pregunta_1') == '3' ? 'selected' : '' }}>¿Cuál es el segundo nombre de tu madre?</option>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-label" style="color: #004B9D; ">Respuesta 1 <span class="requerido">*</span></div>
                        {{-- Removed 'disabled' --}}
                        <input type="text" name="respuesta_1" class="form-control" value="{{ old('respuesta_1') }}">
                    </div>
                </div>

                <div class="row mb-4 fs-6" style="font-weight: 450;">
                    <div class="col-sm-6">
                        <div class="form-label" style="color: #004B9D; ">Pregunta 2 <span class="requerido">*</span></div>
                        {{-- Removed 'disabled' --}}
                        <select name="pregunta_2" id="pregunta_2" class="form-control select-preg">
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('pregunta_2') == '1' ? 'selected' : '' }}>¿Cuál es el nombre de tu primera mascota?</option>
                            <option value="2" {{ old('pregunta_2') == '2' ? 'selected' : '' }}>¿En qué ciudad naciste?</option>
                            <option value="3" {{ old('pregunta_2') == '3' ? 'selected' : '' }}>¿Cuál es el segundo nombre de tu madre?</option>
                        </select>
                    </div>

                    <div class="col-sm-6 fs-6">
                        <div class="form-label" style="color: #004B9D; ">Respuesta 2 <span class="requerido">*</span></div>
                        {{-- Removed 'disabled' --}}
                        <input type="text" name="respuesta_2" class="form-control" value="{{ old('respuesta_2') }}">
                    </div>
                </div>

                <div class="row mb-4 fs-6" style="font-weight: 450;">
                    <div class="col-sm-6">
                        <div class="form-label" style="color: #004B9D; ">Pregunta 3 <span class="requerido">*</span></div>
                        {{-- Removed 'disabled' --}}
                        <select name="pregunta_3" id="pregunta_3" class="form-control select-preg">
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('pregunta_3') == '1' ? 'selected' : '' }}>¿Cuál es el nombre de tu primera mascota?</option>
                            <option value="2" {{ old('pregunta_3') == '2' ? 'selected' : '' }}>¿En qué ciudad naciste?</option>
                            <option value="3" {{ old('pregunta_3') == '3' ? 'selected' : '' }}>¿Cuál es el segundo nombre de tu madre?</option>
                        </select>
                    </div>

                    <div class="col-sm-6 fs-6">
                        <div class="form-label" style="color: #004B9D; ">Respuesta 3 <span class="requerido">*</span></div>
                        {{-- Removed 'disabled' --}}
                        <input type="text" name="respuesta_3" class="form-control" value="{{ old('respuesta_3') }}">
                    </div>
                </div>

                <div class="sep"></div>

                <input type="password" name="sclave" value="{{ old('sclave') }}" class="form-control" hidden>

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
</main>

@endsection