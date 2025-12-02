@extends('adminlte::page')

@section('title', 'Catalogos')

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Catálogos > Rango</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Rango</h3>

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
            <form action="{{ isset($editRegistro) ? route('registro-rango-editar', $editRegistro->id_rango) : route('registro-rango-crear') }}" method="POST">
                @csrf
                @if(isset($editRegistro))
                @method('PUT')
                @endif
                <div class="row fs-6 d-flex align-items-end mb-4">
                    <div class="col-md-10">
                        <div class="link-secodary">
                            Información del Rango <span class="requerido">*</span>
                        </div>
                        <input type="text" tabindex="9" class="form-control" placeholder="Ingrese la información del Rango" name="rango" id="rango" value="{{ old('rango', isset($editRegistro) ? $editRegistro->sdescripcion : '') }}" required>
                    </div>
                    <div class="col-md-2  d-flex justify-content-center">
                        <button id="btnRegistrarComuna" class="btn btn-primary" type="submit"> {{ isset($editRegistro) ? 'Actualizar' : 'Agregar' }}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-light">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Tabla de Rango</h3>

            <div class="card-tools">
                <!-- This will cause the card to maximize when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>-->
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <!-- This will cause the card to be removed when clicked -->
                <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table id="miTabla" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th class="text-left">Descripción</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registros as $registro)
                        <tr>
                            <td class="text-center" style="width: 5%;">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $registro->sdescripcion }}</td>
                            <td class="text-center" style="width: 15%;">
                                <a href="{{ route('registro-rango-editar', ['id' => $registro->id_rango]) }}" class="btn btn-sm btn-primary">Editar</a>
                                <a href="{{ route('registro-rango-eliminar', ['id' => $registro->id_rango]) }}" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selecciona todos los inputs y textareas
        const campos = document.querySelectorAll('input[type="text"], textarea');

        campos.forEach(campo => {
            campo.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    });
</script>
@stop
@include('layouts.extenciones')
@section('footer')
@include('layouts.footer')
@endsection