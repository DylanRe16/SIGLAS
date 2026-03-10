@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Registro de Novedades')


@section('content')
<main class="p-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Siris > Registo de Subsanaciones</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Subsanaciones</h3>
            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!--  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <!-- This will cause the card to be removed when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="link-secondary">
                        Nro. Insolvencia
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-6">
                    <div class="link-secondary">
                        Fecha de Registro
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="link-secondary">
                        Origen
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-6">
                    <div class="link-secondary">
                        Razón
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <div class="link-secondary">
                        Entidad de Trabajo
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">
                        Expediente
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="link-secondary">
                        RIF
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-6">
                    <div class="link-secondary">
                        NIL
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="link-secondary">
                        IVSS
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">
                        INCES
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">
                        FAOV
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">
                        Catálogo de Subsanación
                    </div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row  justify-content-center mb-4">
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            <!-- <div class="col-md-1">
                <button class="btn btn-danger">Limpiar</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success">Imprimir</button>
            </div> -->
        </div>
    </div>
    </div>
</main>
@endsection

@section('footer')
@include('layouts.footer')
@endsection