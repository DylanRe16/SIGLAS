{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Roraima - Acción Centralizada')


@section('content')

<main class="p-4">
    @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Roraima > Acción Centralizada</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Listado de Acciones Centralizadas </h3>
            <div class="card-tools">
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
            </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <form id="accionCentralizada"> 
                @csrf
                <div class="row fs-6 d-flex align-items-end mb-4">
                        {{-- Fila 1: Códigos y Nombre --}}
                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Código Acción<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Ingrese..." oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="accióncentralizada" id="accióncentralizada" onkeypress="return numbers(event);">
                        </div> 

                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Código Acción SNE<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Ingrese..." oninput="this.value = this.value.replace(/[^0-9]/g, '');" name="codigosne" id="codigosne" onkeypress="return numbers(event);">
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Nombre Acción<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Ingrese..." name="nombreaccion" id="nombreaccion">
                        </div>

                        {{-- Fila 2: Fechas y Estatus --}}
                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Fecha de Inicio<span class="requerido">*</span></div>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio">
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Fecha de Fin<span class="requerido">*</span></div>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="link-secondary">Estatus<span class="requerido">*</span></div>
                            <select class="form-control" name="estatus" id="estatus">
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="sep" style="border-top: 1px solid #dee2e6; margin-bottom: 20px;"></div>
                        </div>

                        {{-- Fila 3: Acciones --}}
                        <!-- <div class="col-md-12 d-flex justify-content-start gap-2">
                            <button type="button" class="btn btn-success mr-2" id="btn-activar">
                                <i class="fas fa-check-circle mr-1"></i> Activar
                            </button>
                            <button type="button" class="btn btn-secondary mr-2" id="btn-desactivar">
                                <i class="fas fa-ban mr-1"></i> Desactivar
                            </button>
                            <button type="button" class="btn btn-danger" id="btn-eliminar">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </button>
                        </div> -->

                </div>
            </form>
        </div>








    </div>

</main>

@endsection

@section('footer')
@include('layouts.footer')
@endsection