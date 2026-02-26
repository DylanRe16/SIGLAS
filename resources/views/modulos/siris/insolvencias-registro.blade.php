@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Siris - Insolvencias / Registro')
@section('body_class', 'page-siris-insolvencias')

@section('content')



    @include('layouts.alertas')

    <div class="container-fluid p-4">
        <!-- Breadcrumb mejorado -->
        <div class="row mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('siris') }}" class="text-decoration-none text-secondary">Siris</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Insolvencias</li>
                    </ol>
                </nav>
                <h4 class="font-weight-bold text-dark mt-2">
                    <i class="fas fa-balance-scale mr-2 text-primary"></i>Registrar Insolvencias
                </h4>
            </div>
        </div>

        <!-- Card principal con sombra mejorada -->
        <div class="card card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    Registro de Insolvencia
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Formulario de búsqueda mejorado -->
                <form action="" method="get" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                <i class="fas fa-hashtag text-primary"></i> N° Insolvencia
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..."
                                name="rif" 
                                id="rif" 
                                value="">
                        </div>

                        <div class="col-md-6">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Registro
                            </label>
                            <input class="form-control border-start-0" 
                                type="datetime"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>


                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-4">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Nombre o Razón Social
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..."
                                name="rif" 
                                id="rif" 
                                value="">
                        </div>

                        <div class="col-md-4">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Registro de Información Fiscal (R.I.F)
                            </label>
                            <input class="form-control border-start-0" 
                                type="datetime"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-4">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Número de Información Laboral (N.I.L)
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>


                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Origen
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..."
                                name="rif" 
                                id="rif" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Razón 
                            </label>
                            <input class="form-control border-start-0" 
                                type="datetime"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Zona
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Unidad Sustantiva
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>


                    
                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Documento Soporte
                            </label>
                            <select name="rif" id="rif"  class="form-select border-start-0">
                                <option value="" selected>Seleccione...</option>
                                <option value="">Documento 1</option>
                                <option value="">Documento 2</option>
                                <option value="">Documento 3</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Número de Expediente
                            </label>
                            <input class="form-control border-start-0" 
                                type="datetime"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Número de Fólio
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Número de Providencia Administrativa
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>


                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Resolución
                            </label>
                            <select name="rif" id="rif"  class="form-select border-start-0">
                                <option value="" selected>Seleccione...</option>
                                <option value="">Documento 1</option>
                                <option value="">Documento 2</option>
                                <option value="">Documento 3</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Tipo de Fuero
                            </label>
                            <select name="rif" id="rif"  class="form-select border-start-0">
                                <option value="" selected>Seleccione...</option>
                                <option value="">Fuero 1</option>
                                <option value="">Fuero 2</option>
                                <option value="">Fuero 3</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Despido
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Ejecución Forzosa
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>



                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Fecha de Medida Cautelar
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Acta de Desacato
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Providencia Administrativa
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Nro. Orden de Servicio de Inspección
                            </label>
                            <input class="form-control border-start-0" 
                                type="text"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>



                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Fecha de Inspección
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Nro. Orden de Servicio de Reinspección
                            </label>
                            <input class="form-control border-start-0" 
                                type="text"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Reinspección
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Causal de la Multa
                            </label>
                            <select name="" id="" class="form-select border-start-0">
                                <option value="">Seleccione...</option>
                                <option value="">Causal 2</option>
                                <option value="">Causal 3</option>
                                <option value="">Causal 4</option>
                            </select>
                        </div>
                    </div>



                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-4">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Fecha de Notificación
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-4">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Monto de la Multa
                            </label>
                            <input class="form-control border-start-0" 
                                type="text"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-4">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Fecha de Sentencia
                            </label>
                            <input class="form-control border-start-0" 
                                type="date"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>
                    </div>


                    
                    <div class="row g-3 align-items-end mt-3">
                        <div class="col-md-3">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                Número de Oficio
                            </label>
                            <input class="form-control border-start-0" 
                                type="text"
                                placeholder="Ingrese..." 
                                name="srazon_social" 
                                id="srazon_social" 
                                value="">
                        </div>

                        <div class="col-md-9">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                Tribunal:
                            </label>
                            <textarea name="" id="" cols="10" rows="2"
                                placeholder="Ingrese..." 
                                class="form-control border-start-0"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-user"></i> Listado de Personas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            

            <div class="card-body">
                <!-- Formulario de búsqueda mejorado -->
                <form action="" method="get" class="mb-4">
                    <div class="row g-3 align-items-end d-flex justify-content-center">
                        <div class="col-md-4">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                <i class="fas fa-id-card mr-1"></i>Documento de Identidad <span class="text-danger">*</span>
                            </label>
                            <input class="form-control border-start-0" 
                                placeholder="Ingrese..." 
                                name="rif" 
                                id="rif" 
                                value="">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fas fa-search mr-1"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                        <table class="table table-hover table-bordered shadow-sm" id="myTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="align-middle">Documento de Identidad</th>
                                    <th class="align-middle">Nombre(s) y Apellido(s)</th>
                                    <th class="align-middle">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle fw-bold">12345678</td>
                                    <td class="align-middle">
                                        <span class=" text-dark p-2">Jose Antonio Perez</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Anular">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Fila adicional para demostración (opcional) -->
                                <tr>
                                    <td class="align-middle fw-bold">87654321</td>
                                    <td class="align-middle">
                                        <span class=" text-dark p-2">Juan Garcia</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-warning btn-sm" data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Anular">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div>

    <script src="{{asset('js/loadDatatable.js')}}"></script>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection