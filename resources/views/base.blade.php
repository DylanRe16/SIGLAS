<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MPPPST - SIGLA</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Bootstrap 5.3.3 ACTIVO -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- css para datatables --}}
    <link href="https://cdn.datatables.net/v/bs5/dt-2.3.2/r-3.0.5/sc-2.4.3/datatables.min.css" rel="stylesheet" integrity="sha384-bZE4JyWE1H9Mg7tKCMOiiHfWLd+A9CQfpDFLBSMIlGG14j0n0ScnXuGUnoBY01cA" crossorigin="anonymous">
 
    
    <!-- Select2 base styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
    <!-- icheck bootstrap -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}

    {{-- Chart js para graficos --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menus.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerta.css') }}">
    <link rel="stylesheet" href="{{ asset('iconos/bootstrap-icons.min.css')}}">
    {{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}

    {{-- script para select2 --}}
    <script>
        // $(document).ready(function() {
        //     $('.select2').select2({
        //         theme: 'default', // No uses bootstrap4 — no encaja 100% con Bootstrap 5
        //         dropdownCssClass: 'select2-danger', // puedes definirla tú mismo
        //         placeholder: 'Selecciona una opción',
        //         width: '100%',
        //     });
        // });
    </script>

</head>

    <body>

        <main class="container-body">
            @include('layouts.header')
            
            <article>
                @yield('content')
            </article>

            @include('layouts.footer')
        </main>

        {{-- Toast Alert --}}
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div id="toastAlerta" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastAlertaMensaje">Mensaje</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>
        {{-- Toast Alert --}}


        <!-- Para inicializar los tooltips (para usar dentro de datatables, es otra lógica) -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
        <!-- Para inicializar los tooltips (para usar dentro de datatables, es otra lógica) -->

        
        {{-- todo: Para ver las imagenes ampliadas --}}
        <div class="modal fade" id="modalImagenAmpliada" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: transparent; border: none;">
                    <div class="modal-body p-0 text-center">
                        <img id="imagenAmpliada" src="" alt="Vista ampliada" class="img-fluid rounded-3 bg-white">
                    </div>
                </div>
            </div>
        </div>
        

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = new bootstrap.Modal(document.getElementById('modalImagenAmpliada'));
                const imagenAmpliada = document.getElementById('imagenAmpliada');

                // Selecciona todas las imágenes con clase img-todo
                document.querySelectorAll('.img-todo').forEach(img => {
                    img.addEventListener('click', function () {
                        if (img.src) {
                            imagenAmpliada.src = img.src;
                            modal.show();
                        }
                    });
                });
                imagenAmpliada.addEventListener('click', () => modal.hide());
            });

        </script>
        {{-- todo: Para ver las imagenes ampliadas --}}


        
        <script src="{{ asset ('js/mayusculas.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

    {{-- script para datatables --}}
    {{-- <script src="https://cdn.datatables.t/v/bs5/dt-2.3.2/r-3.0.5/sc-2.4.3/datatables.min.js" integrity="sha384-UNX77zw0v7/UFFzyIlGm/EOVnp6kdZSvJ6/H1FPQUCsZ5/D1x9R7Q9Vch88gZi0R" crossorigin="anonymous"></script> --}}
    
    {{-- <script>
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
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "«",
                    previous: "‹",
                    next: "›",
                    last: "»"
                },
                aria: {
                    sortAscending: ": activar para ordenar ascendente",
                    sortDescending: ": activar para ordenar descendente"
                }
            }
        };

        const configDataTableBoletin = {
            responsive: true,
            order: [[0, "desc"]],
            language: {
                decimal: ",",
                thousands: ".",
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ entradas",
                info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                infoEmpty: "Mostrando 0 a 0 de 0 entradas",
                infoFiltered: "(filtrado de _MAX_ entradas totales)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros coincidentes",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: "«",
                    previous: "‹",
                    next: "›",
                    last: "»"
                },
                aria: {
                    sortAscending: ": activar para ordenar ascendente",
                    sortDescending: ": activar para ordenar descendente"
                }
            }
        };

        new DataTable('#myTable', configDataTable);
        new DataTable('#myTable1', configDataTable);
        new DataTable('#myTable2', configDataTable);
        new DataTable('#myTable3', configDataTable);
        new DataTable('#myTableBoletin', configDataTableBoletin);


    </script> --}}

    <!-- Select2 JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    </body>

</html>