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
                    <div class="row fs-6 d-flex align-items-end mb-4">
                        <div class="col-md-4"> 
                            <div class="link-secondary">RIF<span class="requerido">*</span></div>
                            <div class="input-group">
                                <input type="text" name="srif" id="srif" class="form-control" placeholder="Ejemplo: J123456789" required/>
                                <button type="button" class="input-group-text btn btn-guardar w-25" id="btnGetCompany">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="link-secondary">Nombre o Razon Social<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Nombre o Razon Social" name="srazon_social" id="srazon_social" value="">
                        </div>

                        <div class="col-md-4">
                            <div class="link-secondary">Denominación Comercial<span class="requerido">*</span></div>
                            <input class="form-control" placeholder="Denominación Comercial" name="sdenominacion_comercial" id="sdenominacion_comercial" value="">
                        </div>
                    </div>

                    <div class="row d-flex align-items-end mb-5 fs-6">
                        <div class="col-md-3">

                            <div class="link-secondary">Estado<span class="requerido">*</span></div>
    
                            <select name="entidad_nentidad" id="entidad_nentidad" class="form-control" disabled>
                                <option value="">Seleccione</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->nentidad }}">{{ $estado->sdescripcion }}</option>
                                @endforeach
                            </select>

                            
    
                        </div>
    
                        <div class="col-md-3">
                            <div class="link-secondary">Municipio<span class="requerido">*</span></div>

                            <select name="municipio_nmunicipio" id="municipio_nmunicipio" class="form-control" disabled>
                                <option value="">Seleccione</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->nmunicipio }}">{{ $municipio->sdescripcion }}</option>
                                @endforeach
                            </select>

                            {{-- <input type="text" name="municipio" id="municipio" class="form-control" placeholder="Municipio" value=""> --}}
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Parroquia<span class="requerido">*</span></div>

                            <select name="parroquia_nparroquia" id="parroquia_nparroquia" class="form-control" disabled>
                                <option value="">Seleccione</option>
                                @foreach ($parroquias as $parroquia)
                                    <option value="{{ $parroquia->nparroquia }}">{{ $parroquia->sdescripcion }}</option>
                                @endforeach
                            </select>
                            
                            {{-- <input type="text" name="parroquia" id="parroquia" class="form-control" placeholder="Parroquia" value=""> --}}
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