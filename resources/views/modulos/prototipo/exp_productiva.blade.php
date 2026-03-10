@extends('prototipoInterno')

@section('contenido')
<main>
    @include('modulos.prototipo.menu-prototipo')
    <div class="content-todo2 row my-3" style="width: 70%;">
        <div class="content-login-2">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Reportes</b></h4>
                    </div>
                    <div class="requerido h6 mt-3">Campos obligatorios (*)</div>
                </div>
            </div>
            <hr class="mt-0">

            <form action="" method="POST">
            @csrf
                <div class="row">
                    <div class="font-weight-bold text-primary">
                        <h4 style="font-size: calc(1.500rem + 0.3vw);">Reseña Experiencia Cientifíca Productiva</h4>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reportType" class="text-primary" style="font-size: large;">Tipo <span class="requerido">*</span></label>
                            <select class="form-control" id="reportType" name="report_type">
                                <option value="">Seleccione</option>
                                <option value="">Inversión</option>
                                <option value="">Innovación</option>
                                <option value="">Mejoras</option>
                            </select>
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reportSpecification" class="text-primary" style="font-size: large;">Especifique <span class="requerido">*</span></label>
                            <textarea class="form-control" id="reportSpecification" name="report_specification" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="sep"></div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reportOrigin" class="text-primary" style="font-size: large;">Origen <span class="requerido">*</span></label>
                            <select class="form-control" id="reportOrigin" name="report_origin">
                                <option value="">Seleccione</option>
                                <option value="Propia">Propia</option>
                                <option value="Ajena">Ajena</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="actorIdentificationCol" style="display: none;">
                        <div class="form-group">
                            <label for="actorIdentification" class="text-primary" style="font-size: large;">Identifique el Autor <span class="requerido">*</span></label>
                            <input type="text" class="form-control" id="actorIdentification" name="actor_identification" placeholder="Ingrese el nombre o entidad">
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const reportOriginSelect = document.getElementById('reportOrigin');
                            const actorIdentificationCol = document.getElementById('actorIdentificationCol');
                            const actorIdentificationInput = document.getElementById('actorIdentification');

                            reportOriginSelect.addEventListener('change', function() {
                                if (this.value === 'Ajena') {
                                    actorIdentificationCol.style.display = 'block'; 
                                    actorIdentificationInput.setAttribute('required', 'required');
                                } else {
                                    actorIdentificationCol.style.display = 'none';
                                    actorIdentificationInput.removeAttribute('required');
                                    actorIdentificationInput.value = ''; 
                                }
                            });
                        });
                    </script>

                    <hr class="my-4"> 

                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="font-weight-bold text-primary" style="font-size: calc(1.3rem + 0.3vw);">Gestión Participativa</h4>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpttMeetings" class="text-primary" style="font-size: large;">¿Cuántas reuniones mensuales del CPTT?</label>
                            <input type="number" class="form-control" id="cpttMeetings" name="cptt_meetings" placeholder="Ingrese el número de CPTT">
                        </div>
                    </div>

                    <div class="col-md-6" style="margin-top: -25px;">
                        <div class="form-group">
                            <label for="cpttPatronMeetings" class="text-primary" style="font-size: large;">¿Cuántas reuniones mensuales del CPTT con el Patrono(a) o Representantes?</label>
                            <input type="number" class="form-control" id="cpttPatronMeetings" name="cptt_patron_meetings" placeholder="Ingrese el número de reuniones">
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpttDirectorMeetings" class="text-primary" style="font-size: large;">¿Cuántas reuniones del CPTT con Director(a) Estadal del MPPPST?</label>
                            <input type="number" class="form-control" id="cpttDirectorMeetings" name="cptt_director_meetings" placeholder="Ingrese el número de reuniones">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="workersAssembly" class="text-primary" style="font-size: large;">¿Cuántas Asambleas de Trabajadores realizadas en el año?</label>
                            <input type="number" class="form-control" id="workersAssembly" name="workers_assembly" placeholder="Ingrese el número de asambleas">
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="communeMeetings" class="text-primary" style="font-size: large;">¿Cuántas reuniones de articulación con la Comuna?</label>
                            <input type="number" class="form-control" id="communeMeetings" name="commune_meetings" placeholder="Ingrese el número de reuniones">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ministerios" class="text-primary" style="font-size: large;">¿Cuántas reuniones de articulación con los Ministerios del Poder Popular?</label>
                            <input type="number" class="form-control" id="ministerios" name="ministerios" placeholder="Ingrese el número de reuniones">
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="otherSpecification" class="text-primary" style="font-size: large;">Otros</label>
                            <input type="text" class="form-control" placeholder="Especifique" id="otherSpecification" name="other_specification">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center"> 
                            <button type="submit"  class="btn btn-primary btn-block" style="border-radius: 30px;">Guardar</button> 
                        </div>
                    </div>

                
                </div>

            </form>

        </div>
    </div>

</main>
@endsection