@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Catalogos')

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Catalogos > Comunas</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Registrar Comunas</h3>

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
                <div class="col-md-10">
                    <div class="link-secodary">
                        Información de la Comuna <span class="requerido">*</span>
                    </div>
                    <input type="text" tabindex="9" class="form-control" placeholder="Ingrese la información de la Comuna" name="comuna" id="comuna" value="{{ old('comuna') }}">
                </div>
                <div class="col-md-2  d-flex justify-content-center">
                    <button id="btnRegistrarComuna" class="btn btn-primary" type="button">Registrar</button>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-light">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Tabla de Comunas</h3>

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
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection