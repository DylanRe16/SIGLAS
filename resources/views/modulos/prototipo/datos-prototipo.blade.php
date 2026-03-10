@extends('prototipoInterno')

@section('contenido')

<style>
    .disc_container {
        display: none; 
        opacity: 0;
        transition: opacity 0.5s ease; 
        font-weight: 450;
    }
    .content-todo2 {
        padding-left: 2rem;
        padding-right: 2rem;
    }
</style>

<main>
@include('modulos.prototipo.menu-prototipo')
    <div class="content-todo2 row my-3" style="width: 70%;">
        <div class="content-login-2">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <div style="color: #004B9D;">
                        <h4 class="font-weight-bold" style="font-size: calc(2.150rem + 0.3vw);">Mi Perfil</h4>
                    </div>
                    <div class="requerido fs-6 fw-normal mt-3">Campos obligatorios (*)</div>
                </div>
            </div>
            <hr class="mt-0">
            
            <div class="font-weight-bold text-primary">
                <h4 style="font-size: calc(1.500rem + 0.3vw);">Datos Personales</h4>
            </div>

            <form action="" method="post">
            @method('PUT')
            @csrf
            
            <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">

                <div class="col-sm-3">
                    <div style="color: #004B9D; text-align:center">Tipo de Documento </div>
                </div>
                <div class="col-sm-3">
                    <select name="snacionalidad" id="snacionalidad" class="form-control" disabled>
                        <option value="">Seleccione</option>
                        <option value="F">Venezolano</option>
                        <option value="M">Extranjero</option>
                        <option value="P">Pasaporte</option>
                    </select>
                    <input type="hidden" name="snacionalidad" value="">
                </div>
                <div class="col-sm-3">
                    <div style="color: #004B9D; text-align:center">Nro. de Documento </div>
                </div>
                <div class="col-sm-3">
                    <input tabindex="9" class="form-control" placeholder="Nro. del documento" name="ndocumento" id="ndocumento" maxlength="11" onkeypress="return numbers(event);" required pattern="[0-9]{6,11}" value="" disabled>
                </div>
            </div>
            <input type="text" class="form-control" name="nusuario_actualizacion" hidden value="">

            <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
                <div class="col-sm-3">
                    <div style="color: #004B9D;">Primer nombre </div>
                    <input type="text" class="form-control" name="sprimer_nombre" disabled value="">
                </div>
                <div class="col-sm-3">
                    <div class="text-blue">Segundo nombre </div>
                    <input type="text" class="form-control" name="ssegundo_nombre" disabled value="">
                </div>
                <div class="col-sm-3">
                    <div class="text-blue">Primer apellido </div>
                    <input type="text" class="form-control" name="sprimer_apellido" disabled value="">
                </div>
                <div class="col-sm-3">
                    <div class="text-blue">Segundo apellido</div>
                    <input type="text" class="form-control" name="ssegundo_apellido" disabled value="">
                </div>
            </div>

            <div class="row fs-6 d-flex align-items-end mb-4" style="font-weight: 450;">
                <div class="col-sm-2">
                    <div style="color: #004B9D; ">Fecha de nacimiento</div>
                    <input type="date" class="form-control" name="dfecha_nacimiento" disabled value="">
                </div>
                <div class="col-sm-1">
                    <div style="color: #004B9D; ">Edad</div>
                    <input type="text" class="form-control" name="edad" disabled value="">
                </div>
                <div class="col-sm-2">
                    <div style="color: #004B9D; ">Sexo</div>
                    <select name="ssexo" id="ssexo" class="form-control" disabled>
                        <option value="">Seleccione</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div style="color: #004B9D; ">¿Está embarazada? <span class="requerido">*</span></div>
                    <select name="bembarazada" id="embarz" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="1">SI</option>
                        <option value="0" >NO</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <div style="color: #004B9D; ">Correo electrónico</div>
                    <input type="email" name="semail" class="form-control" placeholder="Ejemplo@mail.com" value="">
                </div>
                <div class="col-sm-2 ">
                    <div style="color: #004B9D; ">¿Tiene discapacidad? <span class="requerido">*</span></div>
                    <select name="bdiscapacidad" id="bdiscapacidad" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>
                </div>
            </div>

            <div class="row mb-4 fs-6 d-flex align-items-end" style="font-weight: 450;">
                <div class="col-sm-3" id="tipo_discapacidad_container">
                    <div style="color: #004B9D; ">¿Tipo de discapacidad? <span class="requerido">*</span></div>
                    <select name="id_tdiscapacidad" id="id_tdiscapacidad" class="form-control">
                        <option value="">Seleccione</option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-4" id="especifique_discapacidad_container">
                    <div style="color: #004B9D; ">Especifique <span class="requerido">*</span></div>
                    <input type="text" name="sdicapacidad_especifica" id="sdicapacidad_especifica" class="form-control" value="">
                    @error('sdicapacidad_especifica')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="col-sm-2" id="tiene_conapdis_container">
                    <div style="color: #004B9D; ">¿Tiene Certificado CONAPDIS? <span class="requerido">*</span></div>
                    <select name="bcertificado_conapdis" id="bcertificado_conapdis" class="form-control" >
                        <option value="">Seleccione</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>
                    @error('bcertificado_conapdis')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="col-sm-3" id="num_conapdis_container">
                    <div style="color: #004B9D; ">Indique el número de certificado</div>
                    <input type="text" class="form-control num_certif" id="nnum_certificado" name="nnum_certificado" maxlength="7" pattern="[0-9]{6,11}" value="">
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
                                <option value="">0</option>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="nnumero_telfmovil" id="nnumero_telfmovil" class="form-control num_tlf" maxlength="7" value="">
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
                                <option value="">0</option>
                            </select>
                            @error('nnumero_telflocal')
                            <small class="text-danger">{{$message}}</small>
                            @enderror                
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="nnumero_telflocal" id="nnumero_telflocal" class="form-control num_tlf" maxlength="7" pattern="[0-9]{7}" value="">
                            @error('nnumero_telflocal')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="sep"></div>
                <div class="col-sm-6">
                    <div style="color: #004B9D;">¿Cuál es su Nivel de Instrucción?</div>
                    <input type="text" class="form-control" name="sprimer_nombre" disabled value="">
                </div>
                <div class="col-sm-6">
                    <div class="text-blue">¿Cuál es su Titulo Obtenido? </div>
                    <input type="text" class="form-control" name="ssegundo_nombre" disabled value="">
                </div>
                <div class="sep"></div>
                <div class="col-sm-12" style="display: flex; align-items: center; gap: 10px;">
                    <div class="text-blue">¿Ha recibido recientemente formación o capacitación por parte de MPPPST?</div>
                    <div>
                        <input type="radio" id="mppst_si" name="formacionMPPST" value="si">
                        <label for="mppst_si">Sí</label>
                        <input type="radio" id="mppst_no" name="formacionMPPST" value="no">
                        <label for="mppst_no">No</label>
                    </div>
                </div>
            </div>
            <div class="sep"></div>

            <!-- Botón Guardar -->
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
