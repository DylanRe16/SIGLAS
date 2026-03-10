@extends('adminlte::page')
@extends('layouts.extenciones')

@section('title', 'Mantenimiento de Usuarios')

@section('css')
<style>
    /* Ajustes estructurales de DataTables */
    table.dataTable thead th {
        padding-right: 30px !important;
        position: relative;
    }

    /* Ajuste del selector de cantidad de registros */
    .dataTables_length select {
        padding-right: 25px !important;
        min-width: 60px !important;
    }

    /* Alineación vertical del contenido de las celdas */
    #miTabla2 td {
        vertical-align: middle;
    }

    /* Espaciado para elementos con clase gap-2 (usados en la tabla o formularios) */
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@stop

@section('content')
<main class="p-4">
    @include('layouts.alertas')

    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">
                    <a href="{{ route('recibos.index') }}" class="link-secondary text-decoration-none">

                         Mantenimiento

                    </a>
                     > Usuarios</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div id="contenedorAlertas"></div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Usuarios</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalInfo">
                    <i class="bi bi-info-circle"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="row fs-6 d-flex align-items-end mb-3">
                <div class="col-md-5">
                    <div class="link-secondary">Nro. de Documento<span class="requerido">*</span></div>
                    <div class="input-group">
                        {{-- Se eliminó el select de nacionalidad --}}
                        <input type="text" id="txt_cedula" class="form-control rounded-search-input" maxlength="10" placeholder="Ingrese número..." oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        <button class="btn btn-primary px-3 rounded-search-right" id="btnBuscar" onclick="ejecutarAccion(1)">
                            <i class="fas fa-search" id="iconBuscar"></i>
                            <span id="spinnerBuscar" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                    <div id="msg-error-cedula" class="text-danger small d-none">El Campo de Cédula de Identidad es obligatorio.</div>
                </div>

                <div class="col-md-5">
                    <div class="link-secondary">Nombre(s) y Apellido(s)</div>
                    <input type="text" id="nombres" class="form-control" style="background: #e9ecef; border-radius: 30px;" readonly placeholder="Esperando búsqueda...">
                </div>
            </div>

            <div class="row fs-6 d-flex align-items-end mb-4">
                <div class="col-md-5">
                    <div class="link-secondary"> Rol<span class="requerido">*</span></div>
                    <select id="rol" class="form-select select2" style="border-radius: 30px;" required>
                        <option value="-1">Seleccione</option>
                        <option value="38">Director/ Jefe registro y Control</option>
                        <option value="29">Secretaria</option>
                    </select>
                </div>

                <div class="col-md-7 d-flex justify-content-center gap-2">
                    <button class="btn btn-guardar px-4" onclick="ejecutarAccion(2)">Habilitar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Usuarios --}}
    <div class="card card-light mt-4">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Tabla de Usuarios</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="miTabla2" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">Nro</th> -->
                            <th class="text-center">Nro Documento</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $u)
                        <tr>
                            <!-- <td class="text-center">{{ $loop->iteration }}</td> -->
                            <td class="text-center">{{ $u->cedula }}</td>
                            <td class="text-center">{{ $u->primer_nombre }}</td>
                            <td class="text-center">{{ $u->primer_apellido }}</td>
                            <td class="text-center">{{ $u->rol_nombre }}</td>
                            <td class="text-center">
                                @if($u->estatus_rol == '1')
                                    <form action="{{ route('recibos_constancias.mantenimiento.usuarios.gestionar') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="cedula" value="{{ $u->cedula }}">
                                        <input type="hidden" name="accion" value="3">
                                        <button type="submit" class="btn btn-danger">Inhabilitar</button>
                                    </form>
                                @else
                                    <span class="badge badge-secondary">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>modalInfo
        </div>
    </div>

    <div class="modal fade" id="modalInfo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    Ayuda
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" style="text-align: justify;">
                <p>Permite asignar/inhabilitar el rol del usuario autorizado para el uso del módulo. Recuerde completar todos los campos obligatorios, identificados con un asterisco (*).</p>
            </div>
            <hr>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
            </div>
        </div>
    </div>
</div>

</main>
@stop

@section('js')
<script>
function ejecutarAccion(accion) {
    const cedula = $('#txt_cedula').val();
    const rol = $('#rol').val();
    const contenedorAlertas = $('#contenedorAlertas');
    const msgError = $('#msg-error-cedula');

    contenedorAlertas.html('');
    msgError.addClass('d-none');

    if (!cedula) {
        msgError.removeClass('d-none');
        contenedorAlertas.html(`
            <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3 animate__animated animate__shakeX">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle mr-3" style="font-size: 1.5rem;"></i>
                    <div><strong>Atención:</strong> El Campo de Cédula de Identidad es obligatorio.</div>
                </div>
            </div>
        `);
        return;
    }

    if(accion === 1) {
        $('#iconBuscar').addClass('d-none');
        $('#spinnerBuscar').removeClass('d-none');
    }

    $.ajax({
        url: "{{ route('recibos_constancias.mantenimiento.usuarios.gestionar') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            accion: accion,
            cedula: cedula,
            rol: rol
        },
        success: function(res) {
            if (accion == 1) {
                if (res.status == 1) {
                    $('#nombres').val(res.nombre);
                    $('#rol').val(res.rol).trigger('change');
                } else {
                    $('#nombres').val("");
                    contenedorAlertas.html(`
                        <div class="alert alert-danger border-left-danger shadow-sm mt-2 mb-3">
                            <i class="fas fa-times-circle mr-2"></i> ${res.mensaje}
                        </div>
                    `);
                }
            } else {
                if (res.status == 1) location.reload();
                else alert(res.mensaje);
            }
        },
        complete: function() {
            $('#iconBuscar').removeClass('d-none');
            $('#spinnerBuscar').addClass('d-none');
        }
    });
}

$(document).ready(function() {
    $('#miTabla2').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" }
    });
});
</script>
@stop
