@extends('prototipoInterno')

@section('contenido')
<main>
    @include('modulos.prototipo.menu-prototipo')
    <div class="content-todo2 row my-3" style="width: 70%; height: 300px; overflow-y: auto;">
        <div class="content-login-2" style="height: 85%;">
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
                        <h4 style="font-size: calc(1.500rem + 0.3vw);">Informes</h4>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="reportType" class="text-primary" style="font-size: large;">Tipo <span class="requerido">*</span></label>
                            <select class="form-control" id="reportType" name="report_type">
                                <option value="">Seleccione</option>
                                <option value="Novedades">Novedades</option>
                                <option value="Dificultades">Dificultades</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="newsTypeCol" style="display: none;">
                        <div class="form-group">
                            <label for="newsType" class="text-primary" style="font-size: large;">Tipo de Novedades <span class="requerido">*</span></label>
                            <select class="form-control" id="newsType" name="news_type">
                                <option value="">Seleccione</option>
                                <option value="Informativos">Informativos</option>
                                <option value="Lineamientos">Lineamientos</option>
                                <option value="Planes">Planes</option>
                                <option value="Proyectos">Proyectos</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="difficultyTypeCol" style="display: none;">
                        <div class="form-group">
                            <label for="difficultyType" class="text-primary" style="font-size: large;">Tipo de Dificultades <span class="requerido">*</span></label>
                            <select class="form-control" id="difficultyType" name="difficulty_type">
                                <option value=""> Seleccione</option>
                                <option value="Logistica">Logística</option>
                                <option value="Destitucion">Destitución</option>
                                <option value="Desmoralizacion">Desmoralización</option>
                                <option value="Tecnicas">Técnicas</option>
                                <option value="Administrativas">Administrativas</option>
                                <option value="Numerico">Numérico</option>
                                <option value="Talento Humano">Talento Humano</option>
                                <option value="Otras">Otras</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3" id="specificationRow" style="display: none;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reportSpecification" class="text-primary" style="font-size: large;">Especifíque <span class="requerido">*</span></label>
                            <textarea class="form-control" id="reportSpecification" name="report_specification"  rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="sep"></div>

                <div class="row mt-3" style="text-align: center;">
                    <div class="col-md-12 text-right"> <button type="submit" class="btn btn-primary" style="border-radius: 30px;">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reportTypeSelect = document.getElementById('reportType');
        const newsTypeCol = document.getElementById('newsTypeCol');
        const difficultyTypeCol = document.getElementById('difficultyTypeCol');
        const specificationRow = document.getElementById('specificationRow');
        const newsTypeSelect = document.getElementById('newsType');
        const difficultyTypeSelect = document.getElementById('difficultyType');

        reportTypeSelect.addEventListener('change', function() {
            if (this.value === 'Novedades') {
                newsTypeCol.style.display = 'block';
                difficultyTypeCol.style.display = 'none';
                difficultyTypeSelect.value = ''; 
                specificationRow.style.display = 'block';
            } else if (this.value === 'Dificultades') {
                difficultyTypeCol.style.display = 'block';
                newsTypeCol.style.display = 'none';
                newsTypeSelect.value = ''; 
                specificationRow.style.display = 'block';
            } else {
                newsTypeCol.style.display = 'none';
                difficultyTypeCol.style.display = 'none';
                newsTypeSelect.value = '';
                difficultyTypeSelect.value = '';
                specificationRow.style.display = 'none';
            }
        });
    });
</script>
@endsection
