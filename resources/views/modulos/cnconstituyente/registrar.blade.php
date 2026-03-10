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
                <form action="{{ route('cnc-store') }}" method="get">
                    @csrf

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
                                <option value="-1" disabled selected>Seleccione el muniSección III – Percepción sobre los temas tratados
                                    cipio</option>

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
                <form action="" method="get">
                    @csrf
                    <div>
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
                            <button type="button" class=" btn btn-guardar rounded-pill" id="btnGetPerson">Buscar</button>
                        </div>
                    </div>

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

                    <div class="text-center">
                        <button type="button" class=" btn btn-guardar rounded-pill">Guardar</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>


        <div class="card card-primary">
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


    <script src="{{asset('js/loadDatatable.js')}}"></script>
    
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3 fw-bold" style="z-index: 1100"></div>

    <script>
        const urlBaseEmpresa = "{{ url('cnconstituyente/getCompany') }}";
        const urlBasePersona = "{{ url('cnconstituyente/getPerson') }}";
    </script>
    <script src="{{ asset('js/cnc/main.js') }}"></script>
@endsection



@section('footer')
    @include('layouts.footer')
@endsection