@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Registro de Novedades')


@section('content')
<main class="p-4">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold"> Siris > Registrar</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Registro de Novedades</h3>
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
        <form action="" method="POST">
            <div class="card-body">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="link-secondary">
                            N° de Novedad
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="novedad" name="novedad" placeholder="N° de Novedad">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">
                            Fecha de Registro
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha de Registro">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="link-seconday">
                            Unidad Sustantiva
                        </div>
                        <div class="form-floating mb-3">
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="link-secondary">
                            Tipo de Novedad
                        </div>
                        <div class="form-floating mb-3">
                            <select name="" id="" class="form-select">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="link-secondary">
                            Descripción de la Novedad
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Descripción" id="descripcion" name="descripcion" style="height: 100px"></textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
            <br>
        </form>
    </div>
</main>
@endsection

@section('footer')
@include('layouts.footer')
@endsection