@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'C. N. Constituyente - Registrar')
@section('body_class', 'page-cnconstituyente')

{{-- @section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true) opcional: Buttons/Responsive/etc. --}}



@section('content')

    @include('layouts.alertas')

    

    <div class="container d-flex justify-content-center align-items-stretch flex-column p-4">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <div class="link-secondary">
                    <h4 class="font-weight-bold">C. N Constituyente > Registrar</h4>
                </div>
                <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
            </div>
        </div>

        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos Centro de Trabajo</h3>
    
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
                <form action="" method="post">
                    @csrf
                    <div class="row fs-6 d-flex align-items-end mb-4">
                        <div class="col-md-4"> 
                            <div class="link-secondary">RIF<span class="requerido">*</span></div>
                            <div class="input-group">
                                <input type="text" name="rif" id="rif" class="form-control" placeholder="Escriba el numero de RIF" required/>
                                <button type="submit" class="input-group-text btn btn-guardar w-25">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="link-secondary">Nombre o Razon Social<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Nombre o Razon Social" name="rsocial" id="rsocial" value="">
                        </div>

                        <div class="col-md-4">
                            <div class="link-secondary">Denominación Comercial<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Denominación Comercial" name="dcomercial" id="dcomercial" value="">
                        </div>
                    </div>

                    <div class="row d-flex align-items-end mb-5 fs-6">
                        <div class="col-md-3">

                            <div class="link-secondary">Estado<span class="requerido">*</span></div>
    
                            <select class="form-control" name="id_estado" id="estado" data-municipios-url="{{ url('municipios') }}">
                                <option value="-1" disabled {{ old('id_estado', $entidad->id ?? null) ? 'selected' : '' }}>
                                    Seleccione el estado
                                </option>
    
                                @foreach ($estados as $estado)
                                <option value="{{ $estado->nentidad }}"
                                    {{ old('id_estado', $persona->nentidad_entidad ?? null) == $estado->nentidad ? 'selected' : '' }}>
                                    {{ $estado->sdescripcion }}
                                </option>
                                @endforeach
                            </select>
    
                        </div>
    
                        <div class="col-md-3">
                            <div class="link-secondary">Municipio<span class="requerido">*</span></div>
                            <select class="form-control" name="id_municipio" id="municipio" data-parroquias-url="{{ url('parroquias') }}" data-selected="{{ old('id_municipio', $entidad->municipio ?? '') }}">
                                <option value="-1" disabled selected>Seleccione el municipio</option>

                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Parroquia<span class="requerido">*</span></div>
                            <select class="form-control" name="id_parroquia" id="parroquia" data-selected="{{ old('id_parroquia', $entidad->id_parroquia ?? '') }}">
                                <option value="-1" disabled selected>Seleccione la parroquia</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Motor <span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Motor" name="motor" id="motor" value="">
                        </div>
                    </div>


                    <div class="row d-flex align-items-end mb-5 fs-6">
                        

                        <div class="col-md-6 d-flex">
                            <div class="link-secondary" style="width: 300px;">Total trabajadores<span class="requerido">*</span></div>
                            <input type="number" class="form-control" placeholder="Total trabajadores" name="ttrabajadores" id="ttrabajadores" value="">
                        </div>

                        <div class="col-md-6 d-flex">
                            <div class="link-secondary" style="width: 300px;">Total Trabajadores Asamblea <span class="requerido">*</span></div>
                            <input type="number" class="form-control" placeholder="Total Trabajadores Asamblea" name="ttrabajadoresA" id="ttrabajadoresA" value="">
                        </div>
                    </div>


                    <div class="text-center">
                        <button type="submit" class=" btn btn-guardar rounded-pill my-3">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>


        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Datos de Voceros y Voceras</h3>
    
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
                <form action="" method="post">
                    @csrf
                    <form action="" method="get">
                        <div class="row fs-6 d-flex align-items-end mb-4">
                            <div class="col-md-6 d-flex">
                                <div class="link-secondary" style="width: 300px;">Tipo de documento<span class="requerido">*</span></div>
                                <select name="snacionalidad" id="snacionalidad" class="form-select">
                                    <option value="V">Venezolano</option>
                                    <option value="E">Extranjero</option>
                                    <option value="P">Pasaporte</option>
                                </select>
                            </div>
    
                            <div class="col-md-6 d-flex">
                                <div class="link-secondary" style="width: 300px;">Nro. de documento <span class="requerido">*</span></div>
                                <input type="number" class="form-control" placeholder="Nro. de documento" name="ndocumento" id="ndocumento" value="">
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <button type="button" class=" btn btn-guardar rounded-pill">Buscar</button>
                        </div>
                    </form>

                    <hr>

                    <div class="row d-flex align-items-end mb-5 fs-6">
                        <div class="col-md-3">
                            <div class="link-secondary">Primer Nombre<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="sprimer_nombre" id="sprimer_nombre" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Segundo Nombre<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="ssegundo_nombre" id="ssegundo_nombre" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Primer Apellido<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="sprimer_apellido" id="sprimer_apellido" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Segundo Apellido<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="ssegundo_apellido" id="ssegundo_apellido" value="">
                        </div>
                    </div>

                    <div class="row d-flex align-items-end mb-5 fs-6">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="link-secondary" style="width: 300px;">¿Pertenece a alguna Organización Social?</div>
                            <select name="osocial" id="osocial" class="form-select" style="width: auto;">
                                <option value="">Seleccione</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>


                        <div class="col-md-6" id="tosocial" style="display: none;">
                            <div class="link-secondary">Tipo de Organización Social<span class="requerido">*</span></div>
                            <select name="tosocialSelect" id="tosocialSelect" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="Si">CPT</option>
                                <option value="No">Delegado Prevención</option>
                                <option value="No">Consejo de Trabajo</option>
                                <option value="No">Emprendedor</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="row d-flex align-items-end mb-3 fs-6">
                        <div class="col-md-4">
                            <div class="link-secondary">¿Nro. de votos con los que gano?<span class="requerido">*</span></div>
                            <input type="number" class="form-control" placeholder="¿Nro. de votos con los que gano?" name="nvotos" id="nvotos" value="">
                        </div>
                    </div>


                    <div class="text-center">
                        <button type="submit" class=" btn btn-guardar rounded-pill">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>


        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Registros</h3>
    
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
                <div class="table-responsive" style="min-width: 325px;">
                    <table class="table table-bordered table-striped table-hover p-2" id="myTable">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>RIF</th>
                                <th>Razón Social</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>J123456789</td>
                                <td>Empresa 1</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-danger btn-editar">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-secondary">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>


    <script>
        // todo: para mostrar el campo tipo de Organización Social
        const selectOsocial = document.getElementById('osocial');
        const selectTOsocial = document.getElementById('tosocial');

        selectOsocial.addEventListener('change', function(){
                if (selectOsocial.value == 'Si') {
                    selectTOsocial.style.display = 'block';
                } else {
                    selectTOsocial.style.display = 'none';
                }
                // console.log("osocial -> ", selectOsocial.value);
        })
        // fin todo: para mostrar el campo tipo de Organización Social

    </script>

    <script>
    window.addEventListener('load', function () {
        const configDataTable = {
            responsive: true,
            language: {
                decimal: ",",
                thousands: ".",
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ entradas",
                info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                infoFiltered: "(filtrado de _MAX_ entradas totales)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: { first: "«", previous: "‹", next: "›", last: "»" },
                aria: { sortAscending: ": activar para ordenar ascendente", sortDescending: ": activar para ordenar descendente" }
            }
        };

        const tableEl = document.querySelector('#myTable');
        if (window.DataTable && tableEl) {
            new DataTable(tableEl, configDataTable);
        } else {
            console.warn('DataTable no disponible o #myTable no encontrado.');
        }
    });
    </script>
    
@endsection