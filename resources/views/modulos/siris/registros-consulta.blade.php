@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Registro de Novedades')


@section('content')
<main class="p-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Siris > Consulta</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"></h3>
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
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-3 ">
                    <div class="link-secondary">
                        Opción
                    </div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                        <option value="1">Opción 1</option>
                        <option value="2">Opción 2</option>
                        <option value="3">Opción 3</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="link-secondary">
                        Nombre o Razón Social
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">RIF</div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">NIL</div>
                    <input type="text" class="form-control" placeholder="Ingrese...">

                </div>
            </div>
            <div class="row mb-4">


                <div class="col-md-3">
                    <div class="link-secondary">Zona</div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">Nro. de Insolvencia</div>
                    <div class="row">
                        <div class="col-sm-3"><input type="text" class="form-control"></div>-
                        <div class="col-sm-4"><input type="text" class="form-control"></div>-
                        <div class="col-sm-3"><input type="text" class="form-control"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">Nro. Documento del Funcionario Regristrador</div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">Estatus</div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>
            <div class="row mb-4 justify-content-center">
                <div class="col-md-3">
                    <div class="link-secondary">Fecha de incio</div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">Fecha final</div>
                    <input type="text" class="form-control" placeholder="Ingrese...">
                </div>

                <div class="col-md-3">
                    <div class="link-secondary">Origen</div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="link-secondary">Razón</div>
                    <select name="" id="" class="form-select">
                        <option value="">Seleccione...</option>
                    </select>
                </div>
            </div>


        </div>
        <div class="row  justify-content-center mb-4">
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-danger">Limpiar</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success">Imprimir</button>
            </div>
        </div>

    </div>


</main>
@endsection

@section('footer')
@include('layouts.footer')
@endsection