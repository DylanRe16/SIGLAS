@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Siris - Insolvencias Grilla')
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
                    <i class="fas fa-balance-scale mr-2 text-primary"></i>Insolvencias - Grilla
                </h4>
            </div>
        </div>

        <!-- Card principal con sombra mejorada -->
        <div class="card card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-list mr-2"></i>Listado de Empresas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">

                <!-- Listado de Entidades mejorado -->
                <div class="mt-2">
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