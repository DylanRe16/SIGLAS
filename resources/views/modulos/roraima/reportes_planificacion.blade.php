{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Roraima - Proyectos')


@section('content')

<main class="p-4">
     @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Variables > Reportes Planificación</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h3 class="card-title font-weight-bold">Reportes</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalInfo">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <form id="reportesPlanificación">
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-3">

                    {{-- BLOQUE 1: DATOS DE IDENTIFICACIÓN --}}

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Año <span class="requerido">*</span></div>
                       <input type="text" class="form-control" placeholder="Seleccione un año..." id="anio_reporte">
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Acción Centralizada<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="accion_centralizada">
                                <option selected disabled>Seleccione el Año ...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Proyectos<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="proyectos">
                                <option selected disabled>Seleccione el Año...</option>
                            </select>
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Acción Centralizada Acciones Específicas<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="especifica_central">
                                <option selected disabled>Seleccione Acción Central...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Proyectos Acciones Específicas<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="especifica_proyecto">
                                <option selected disabled>Seleccione un Proyecto...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="link-secondary">Variables Central<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="vars_central">
                                <option selected disabled>Seleccione una accion específica...</option>
                            </select>
                        </div>
                    </div>

                    <div class="sep"></div>

                    <div class="col-md-3 mb-3">
                        <div class="link-secondary">Variables Proyecto<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="vars_proyecto">
                                <option selected disabled>Seleccione una accion específica...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="link-secondary">Unidades Ejecutoras<span class="requerido">*</span></div>
                        <div class="input-group">
                            <select class="form-control select2" name="unidad_ejecutora">
                                <option>Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="link-secondary">Mes Inicial<span class="requerido">*</span></div>
                        <select class="form-control select2" name="mes_inicio">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>



                    <div class="col-md-3 mb-3">
                        <div class="link-secondary">Mes Final<span class="requerido">*</span></div>
                        <select class="form-control select2" name="mes_final">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12" selected>Diciembre</option>
                        </select>
                    </div>

                    

                </div>
            </form>
        </div>


    </div>


</main>

@endsection

@section('footer')
@include('layouts.footer')
@endsection