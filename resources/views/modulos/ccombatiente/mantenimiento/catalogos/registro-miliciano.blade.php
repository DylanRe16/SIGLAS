@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Catalogos')

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Catalogos > Registro Miliciano</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Registrar Comuna</h3>

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