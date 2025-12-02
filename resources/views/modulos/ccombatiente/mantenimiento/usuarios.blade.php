@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Usuarios</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Usuarios Ccombatiente</h3>

            <div class="card-tools">
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('ccombatiente.usuarios.asignar') }}">
                @csrf
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="link-secondary">Nro Documento del Usuario</div>
                    <input type="text" tabindex="1" class="form-control mb-4" placeholder="Ingrese el documento del usuario" name="documento_usuario" id="documento_usuario" value="" required>
                </div>
                <div class="col-md-4">
                    <div class="link-secondary">Rol</div>
                    <select name="id_rol" id="id_rol" class="form-control mb-4" required>
                        <option value="">Seleccione</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->sdescripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2"></div>
                <div class="row md-2">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button id="btnBuscarUsuario" class="btn btn-primary mr-2" type="submit">Asignar</button>
                        <button id="btnLimpiar" class="btn btn-danger mr-2" type="submit">Desasignar</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
</main>
@endsection
@include('layouts.extenciones')
@section('footer')
@include('layouts.footer')
@endsection