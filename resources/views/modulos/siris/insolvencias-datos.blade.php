@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Siris - Insolvencias | Datos de la Entidad')
@section('body_class', 'page-siris-insolvencias-datos')

@section('content')

    @include('layouts.alertas')

    <div class="container-fluid p-4">
        <!-- Breadcrumb mejorado -->
        <div class="row mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('siris') }}" class="text-decoration-none text-secondary">
                                {{-- <i class="fas fa-home mr-1"></i> --}}Siris
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('siris.insolvencias') }}" class="text-decoration-none text-secondary">
                                Insolvencias
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Datos de la Entidad</li>
                    </ol>
                </nav>
                <h4 class="font-weight-bold text-dark mt-2">
                    <i class="fas fa-building text-primary mr-2"></i>Datos de la Entidad de Trabajo
                </h4>
            </div>
        </div>

        <!-- Card principal mejorado -->
        <div class="card card-outline card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-info-circle mr-2"></i>Información Detallada de la Empresa
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Badge de estado (opcional) -->
                {{-- <div class="d-flex justify-content-end mb-3">
                    <span class="badge badge-success p-2">
                        <i class="fas fa-check-circle mr-1"></i> Empresa Activa en RNET
                    </span>
                </div> --}}

                <!-- Grid de tarjetas mejorado -->
                <div class="row g-4">
                    <!-- Tarjeta 1: Identificación -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-building mr-2"></i>Identificación de la Empresa
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <th class="bg-light" style="width: 25%;">
                                            <i class="fas fa-tag text-primary mr-1"></i>Nombre o Razón Social
                                        </th>
                                        <td style="width: 25%;" class="font-weight-bold">Empresa Caracas C.A.</td>
                                        <th class="bg-light" style="width: 25%;">
                                            <i class="fas fa-store text-primary mr-1"></i>Denominación Comercial
                                        </th>
                                        <td style="width: 25%;">Empresa Caracas C.A.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Registros -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-id-card mr-2"></i>Registros Oficiales
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">R.I.F</th>
                                            <th class="text-center">N.I.L.</th>
                                            <th class="text-center">IVSS</th>
                                            <th class="text-center">FAOV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center font-weight-bold">
                                                <span class="badge badge-light p-2 text-secondary-emphasis">J123456789</span>
                                            </td>
                                            <td class="text-center">1234567890</td>
                                            <td class="text-center">A12345678</td>
                                            <td class="text-center">123456</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Ubicación -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Ubicación Geográfica
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 25%;">
                                                <i class="fas fa-globe text-primary mr-1"></i>Entidad
                                            </th>
                                            <th class="text-center" style="width: 25%;">
                                                <i class="fas fa-city text-primary mr-1"></i>Municipio
                                            </th>
                                            <th class="text-center" style="width: 50%;" colspan="2">
                                                <i class="fas fa-map-pin text-primary mr-1"></i>Parroquia
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center font-weight-bold">Distrito Capital</td>
                                            <td class="text-center">Libertador</td>
                                            <td class="text-center" colspan="2">Altagracia</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Contacto -->
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3">
                                <h6 class="mb-0">
                                    <i class="fas fa-phone-alt mr-2"></i>Información de Contacto
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center" style="width: 25%;">
                                                <i class="fas fa-phone text-primary mr-1"></i>Teléfono
                                            </th>
                                            <th class="text-center" style="width: 25%;">
                                                <i class="fas fa-fax text-primary mr-1"></i>Fax
                                            </th>
                                            <th class="text-center" style="width: 50%;" colspan="2">
                                                <i class="fas fa-envelope text-primary mr-1"></i>Correo Electrónico
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <a href="tel:02121231212" class="text-decoration-none">
                                                    <i class="fas fa-phone-alt text-success mr-1"></i>0212-1231212
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-muted">No registrado</span>
                                            </td>
                                            <td class="text-center" colspan="2">
                                                <a href="mailto:empresacaracas.ca@gmail.com" class="text-decoration-none">
                                                    <i class="fas fa-envelope text-primary mr-1"></i>empresacaracas.ca@gmail.com
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de acciones -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{-- {{ route('siris.insolvencias.registrar', ['id' => 1]) }} --}}" 
                                       class="btn btn-success mx-1">
                                        <i class="fas fa-pen mr-2"></i>Registrar Insolvencia
                                    </a>
                                    <a href="{{ url()->previous() }}" 
                                       class="btn btn-secondary mx-1">
                                        <i class="fas fa-arrow-left mr-2"></i>Regresar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div>

    <script src="{{asset('js/loadDatatable.js')}}"></script>
    
    @push('js')
    {{-- <script>
        $(function() {
            // Inicializar tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Mostrar toast de bienvenida (opcional)
            const toast = `
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-primary text-white">
                        <strong class="mr-auto">Información</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Visualizando datos de la Empresa Caracas C.A.
                    </div>
                </div>
            `;
            $('#toast-container').html(toast);
            
            // Auto-cerrar toast después de 5 segundos
            setTimeout(function() {
                $('.toast').toast('hide');
            }, 5000);
        });
    </script> --}}
    @endpush
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
