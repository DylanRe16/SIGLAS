@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Siris - Insolvencias')
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
                    <i class="fas fa-balance-scale mr-2 text-primary"></i>Gestión de Insolvencias
                </h4>
            </div>
        </div>

        <!-- Card principal con sombra mejorada -->
        <div class="card card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-search mr-2"></i>Buscar Entidad de Trabajo
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Nota informativa mejorada -->
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <i class="fas fa-info-circle fa-2x mr-3 text-primary"></i>
                    <div>
                        <strong class="text-dark">Nota:</strong> Usted podrá realizar esta búsqueda utilizando una de las siguientes opciones:
                        <ul class="mb-0 mt-1">
                            <li>Registro de Información Fiscal (R.I.F)</li>
                            <li>Nombre o Razón Social</li>
                        </ul>
                    </div>
                </div>

                <!-- Formulario de búsqueda mejorado -->
                <form action="" method="get" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="rif" class="form-label fw-bold text-secondary">
                                <i class="fas fa-id-card mr-1"></i>RIF <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-hashtag text-primary"></i>
                                </span>
                                <input class="form-control border-start-0" 
                                       placeholder="Ingrese RIF (ej: J-12345678-9)" 
                                       name="rif" 
                                       id="rif" 
                                       value="">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label for="srazon_social" class="form-label fw-bold text-secondary">
                                <i class="fas fa-building mr-1"></i>Nombre o Razón Social
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="fas fa-font text-primary"></i>
                                </span>
                                <input class="form-control border-start-0" 
                                       placeholder="Ingrese nombre o razón social" 
                                       name="srazon_social" 
                                       id="srazon_social" 
                                       value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fas fa-search mr-1"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Listado de Entidades mejorado -->
                <div class="mt-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-list mr-2 text-primary"></i>Listado de Entidades de Trabajo
                        </h5>
                        <span class="badge badge-primary p-2">
                            <i class="fas fa-building mr-1"></i> Total: 1 entidad(es)
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered shadow-sm" id="myTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="align-middle">Nombre o Razón Social</th>
                                    <th class="align-middle">RIF</th>
                                    <th class="align-middle">Registrada en RNET</th>
                                    <th class="align-middle">Ubicación</th>
                                    <th class="align-middle text-center">Registrar Insolvencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle fw-bold">Empresa Caracas C.A.</td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark p-2">J-12345678-9</span>
                                    </td>
                                    <td class="align-middle">
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i>01-01-2000
                                    </td>
                                    <td class="align-middle">
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>Av. Caracas, Calle Caracas
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-success btn-sm" 
                                           href="{{ route('siris.insolvencias-datos') }}"
                                           data-toggle="tooltip" 
                                           title="Registrar insolvencia">
                                            <i class="fas fa-pen mr-1"></i> Registrar
                                        </a>
                                    </td>
                                </tr>
                                
                                <!-- Fila adicional para demostración (opcional) -->
                                <tr>
                                    <td class="align-middle fw-bold">Empresa Miranda S.A.</td>
                                    <td class="align-middle">
                                        <span class="badge bg-light text-dark p-2">J-87654321-0</span>
                                    </td>
                                    <td class="align-middle">
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i>15-03-2015
                                    </td>
                                    <td class="align-middle">
                                        <i class="fas fa-map-marker-alt text-danger mr-1"></i>Av. Miranda, Edif. Centro
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-success btn-sm" 
                                           href="{{ route('siris.insolvencias-datos') }}"
                                           data-toggle="tooltip" 
                                           title="Registrar insolvencia">
                                            <i class="fas fa-pen mr-1"></i> Registrar
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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