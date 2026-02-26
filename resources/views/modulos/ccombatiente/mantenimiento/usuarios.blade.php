@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
<main class="p-4">
    @include('layouts.modals.ccombatiente.modal_usuarios')


    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Mantenimiento > Usuarios</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>
    @include('layouts.alertas')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Usuarios</h3>

            <div class="card-tools">
                <!-- This will cause the card to collapse when clicked -->
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('ccombatiente.usuarios.asignar') }}">
    @csrf
    <div class="row fs-6 d-flex align-items-end mb-3">
        <div class="col-md-5">
            <div class="link-secondary">Nro. de Documento<span class="requerido">*</span></div>
            <div class="input-group">
                <input type="text" 
                       name="documento_usuario" 
                       id="documento_usuario" 
                       class="form-control rounded-search-input" 
                       value="{{ old('documento_usuario', $persona_buscada->cedula ?? '') }}"
                       required>
                
                {{-- Agregamos name="accion" y value="buscar" --}}
                <button class="btn btn-primary px-3 rounded-search-right" type="submit" name="accion" value="buscar">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <div class="col-md-5">
            <div class="link-secondary">Nombre(s) y Apellido(s)</div>
            <input type="text" 
                   class="form-control" 
                   style="background: #e9ecef; border-radius: 30px;" 
                   readonly 
                   value="{{ $persona_buscada->nombre_completo ?? '' }}"
                   placeholder="Se completará al buscar...">
        </div>
    </div>

    <div class="row fs-6 d-flex align-items-end mb-4">
        <div class="col-md-5">
            <div class="link-secondary">Rol<span class="requerido">*</span></div>
            <select name="id_rol" class="form-select select2" style="border-radius: 30px;">
                <option value="">Seleccione...</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->sdescripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-7 d-flex justify-content-center gap-2">
            {{-- Agregamos name="accion" y value="guardar" --}}
            <button class="btn btn-guardar px-4" type="submit" name="accion" value="guardar">Habilitar</button>
        </div>
    </div>
</form>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="card card-succes">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Tabla de Usuarios</h3>

            <div class="card-tools">
                <!-- This will cause the card to collapse when clicked -->
                <!-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2">
                    <i class="bi bi-info-circle"></i>
                </button> -->
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="miTabla" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Nro Documento</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Apellido</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $dato)
                            <tr>

                                <td class="text-center">{{ $dato->cedula }}</td> 
                                <td class="text-center">{{ $dato->primer_nombre }}</td>
                                <td class="text-center">{{ $dato->primer_apellido }}</td>
                                <td class="text-center">{{ $dato->rol_nombre }}</td>
                                <td class="text-center">
                                    <a href="{{ route('ccombatiente.usuarios.desasignar', $dato->cedula) }}" class="btn btn-danger">Inhabilitar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
</main>
@endsection
@include('layouts.extenciones')
@section('footer')
@include('layouts.footer')
@endsection