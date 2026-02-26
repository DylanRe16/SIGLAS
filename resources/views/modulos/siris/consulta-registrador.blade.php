@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Siris - Consulta Registrador')
@section('body_class', 'page-siris-consulta-registrador')

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
                                Siris
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-secondary">
                                Consultas
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Consulta Registrador
                        </li>
                    </ol>
                </nav>
                <h4 class="font-weight-bold text-dark mt-2">
                    <i class="fas fa-gavel text-primary mr-2"></i>Consulta de Insolvencias por Registrador
                </h4>
            </div>
        </div>

        <!-- Card principal mejorado -->
        <div class="card card-outline card-primary shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-list mr-2"></i>Listado de Insolvencias Registradas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Información del Registrador en tarjeta destacada -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-gradient-light border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-user-circle mr-2"></i>Datos del Registrador
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-primary text-white p-3 mr-3">
                                                <i class="fas fa-user fa-2x"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Nombre Completo</small>
                                                <strong class="h5">{{Auth::user()->primer_nombre}} {{Auth::user()->primer_apellido}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-info text-white p-3 mr-3">
                                                <i class="fas fa-id-card fa-2x"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Cédula de Identidad</small>
                                                <strong class="h5">{{ number_format(Auth::user()->cedula, 0, '', '.') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rounded-circle bg-success text-white p-3 mr-3">
                                                <i class="fas fa-clipboard-list fa-2x"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Insolvencias Registradas</small>
                                                <strong class="h5">1</strong>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="alert alert-info mb-0 py-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <strong>Zona:</strong> 
                                            <span class="ml-1">{{ Auth::user()->zona ?? 'No asignada' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-success mb-0 py-2">
                                            <i class="fas fa-calendar-alt mr-2"></i>
                                            <strong>Insolvencias Registradas:</strong> 
                                            <span class="ml-1">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros de búsqueda -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card card-outline card-secondary shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-filter mr-2"></i>Filtros de Búsqueda
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="" method="get" class="form-inline justify-content-center flex-wrap">
                                    <div class="form-group mx-2 mb-2">
                                        <label class="mr-2">Fecha Desde:</label>
                                        <input type="date" class="form-control form-control-sm" name="fecha_desde">
                                    </div>
                                    <div class="form-group mx-2 mb-2">
                                        <label class="mr-2">Fecha Hasta:</label>
                                        <input type="date" class="form-control form-control-sm" name="fecha_hasta">
                                    </div>
                                    <div class="form-group mx-2 mb-2">
                                        <label class="mr-2">Origen:</label>
                                        <select class="form-control form-control-sm" name="origen">
                                            <option value="">Todos</option>
                                            <option value="sala">Sala de fueros</option>
                                            <option value="tribunal">Tribunal</option>
                                            <option value="juzgado">Juzgado</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm mx-2 mb-2">
                                        <i class="fas fa-search mr-1"></i>Filtrar
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-sm mx-2 mb-2">
                                        <i class="fas fa-undo mr-1"></i>Limpiar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas rápidas -->
                {{-- <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-gradient-primary shadow-sm">
                            <span class="info-box-icon"><i class="fas fa-balance-scale"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Insolvencias</span>
                                <span class="info-box-number">1</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-gradient-success shadow-sm">
                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Activas</span>
                                <span class="info-box-number">1</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-gradient-warning shadow-sm">
                            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">En Proceso</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box bg-gradient-danger shadow-sm">
                            <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cerradas</span>
                                <span class="info-box-number">0</span>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Tabla de Insolvencias -->
                <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-list-alt text-primary mr-2"></i>Registros de Insolvencias
                        </h5>
                        {{-- <div>
                            <button class="btn btn-success btn-sm" onclick="exportarExcel()">
                                <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="exportarPDF()">
                                <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
                            </button>
                        </div> --}}
                    </div>

                    <table class="table table-hover table-bordered shadow-sm" id="myTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center align-middle">N° Insolvencia</th>
                                <th class="text-center align-middle">Entidad</th>
                                <th class="text-center align-middle">Origen</th>
                                <th class="text-center align-middle">Razón</th>
                                <th class="text-center align-middle">Fecha de Registro</th>
                                <th class="text-center align-middle">Estado</th>
                                <th class="text-center align-middle">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle">
                                    <span class="badge badge-primary p-2">INS-001-12345</span>
                                </td>
                                <td class="align-middle fw-bold">Empresa Caracas C.A.</td>
                                <td class="align-middle">
                                    <i class="fas fa-gavel text-secondary mr-1"></i>Sala de fueros
                                </td>
                                <td class="align-middle">Desacato a Providencia Administrativa de Reenganche</td>
                                <td class="align-middle">
                                    <i class="fas fa-calendar-alt text-primary mr-1"></i>01/01/2000
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge badge-success p-2">Activa</span>
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
    
    @push('js')
    <script>
        // $(function() {
        //     // Inicializar tooltips
        //     $('[data-toggle="tooltip"]').tooltip();
            
        //     // Inicializar DataTable con opciones mejoradas
        //     $('#myTable').DataTable({
        //         language: {
        //             url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        //         },
        //         pageLength: 10,
        //         lengthMenu: [5, 10, 25, 50],
        //         order: [[4, 'desc']], // Ordenar por fecha descendente
        //         responsive: true,
        //         dom: 'Bfrtip',
        //         buttons: [
        //             {
        //                 extend: 'excel',
        //                 text: '<i class="fas fa-file-excel mr-1"></i> Excel',
        //                 className: 'btn btn-success btn-sm'
        //             },
        //             {
        //                 extend: 'pdf',
        //                 text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
        //                 className: 'btn btn-danger btn-sm'
        //             }
        //         ]
        //     });

        //     // Mostrar toast de bienvenida
        //     const toast = `
        //         <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        //             <div class="toast-header bg-primary text-white">
        //                 <strong class="mr-auto">
        //                     <i class="fas fa-info-circle mr-1"></i>Información
        //                 </strong>
        //                 <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
        //                     <span aria-hidden="true">&times;</span>
        //                 </button>
        //             </div>
        //             <div class="toast-body">
        //                 Bienvenido {{Auth::user()->primer_nombre}}. Tienes 1 insolvencia registrada.
        //             </div>
        //         </div>
        //     `;
        //     $('#toast-container').html(toast);
            
        //     setTimeout(function() {
        //         $('.toast').toast('hide');
        //     }, 5000);
        // });

        // Funciones de exportación manuales
        function exportarExcel() {
            // Implementar lógica de exportación a Excel
            alert('Exportando a Excel...');
        }

        function exportarPDF() {
            // Implementar lógica de exportación a PDF
            alert('Exportando a PDF...');
        }
    </script>
    @endpush

@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@push('css')
{{-- <style>
    /* Estilos específicos para esta vista */
    .page-siris-consulta-registrador .info-box {
        min-height: 100px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .page-siris-consulta-registrador .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.15) !important;
    }
    
    .page-siris-consulta-registrador .info-box-icon {
        border-radius: 10px 0 0 10px;
    }
    
    .page-siris-consulta-registrador .rounded-circle {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .page-siris-consulta-registrador .badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
    
    .page-siris-consulta-registrador .btn-group .btn {
        margin: 0 2px;
        border-radius: 4px !important;
    }
    
    .page-siris-consulta-registrador .table th {
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
    }
    
    .page-siris-consulta-registrador .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    
    /* Animaciones */
    .page-siris-consulta-registrador .card {
        transition: all 0.3s ease;
    }
    
    .page-siris-consulta-registrador .btn {
        transition: all 0.2s ease;
    }
    
    .page-siris-consulta-registrador .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-siris-consulta-registrador .rounded-circle {
            width: 50px;
            height: 50px;
        }
        
        .page-siris-consulta-registrador .rounded-circle i {
            font-size: 1.5rem;
        }
        
        .page-siris-consulta-registrador .btn-group {
            display: flex;
            flex-direction: column;
        }
        
        .page-siris-consulta-registrador .btn-group .btn {
            margin: 2px 0;
        }
    }
</style> --}}
@endpush