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
                <form action="" method="get">
                    @csrf
                    <div class="row fs-6 d-flex align-items-end mb-4">
                        <div class="col-md-4"> 
                            <div class="link-secondary">RIF<span class="requerido">*</span></div>
                            <div class="input-group">
                                <input type="text" name="srif" id="srif" class="form-control" placeholder="Escriba el numero de RIF" required/>
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
    
                            

                            <input type="text" name="estado" id="estado" class="form-control" placeholder="Estado" value="" >
    
                        </div>
    
                        <div class="col-md-3">
                            <div class="link-secondary">Municipio<span class="requerido">*</span></div>
                            

                            <input type="text" name="municipio" id="municipio" class="form-control" placeholder="Municipio" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Parroquia<span class="requerido">*</span></div>
                            
                            
                            <input type="text" name="parroquia" id="parroquia" class="form-control" placeholder="Parroquia" value="">
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
                        <button type="button" class=" btn btn-guardar rounded-pill my-3">Guardar</button>
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
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="primer_nombre" id="primer_nombre" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Segundo Nombre<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="segundo_nombre" id="segundo_nombre" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Primer Apellido<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="primer_apellido" id="primer_apellido" value="">
                        </div>

                        <div class="col-md-3">
                            <div class="link-secondary">Segundo Apellido<span class="requerido">*</span></div>
                            <input type="text" class="form-control" placeholder="Primer Nombre" name="segundo_apellido" id="segundo_apellido" value="">
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

    {{-- todo: para obtener los datos de una persona y empresa --}}
     <script>
        document.addEventListener('DOMContentLoaded', () => {

            const urlBasePersona = '{{ url('cnconstituyente/getPerson') }}';
            const btnBuscarPersona = document.getElementById('btnGetPerson');
            const inputNacionalidad = document.getElementById('snacionalidad');
            const inputDocumento = document.getElementById('ndocumento');

            const urlBaseEmpresa = '{{ url('cnconstituyente/getCompany') }}';
            const btnBuscarEmpresa = document.getElementById('btnGetCompany');
            const inputRif = document.getElementById('srif');

            const camposPersona = [
                'primer_nombre',
                'segundo_nombre',
                'primer_apellido',
                'segundo_apellido'
            ];

            const camposEmpresa = [
                'srazon_social',
                'sdenominacion_comercial',
                'estado',
                'municipio',
                'parroquia',
            ];

            // 🔹 Función reutilizable para limpiar los campos
            function limpiarCampos(campos) {
                campos.forEach(id => {
                    const campo = document.getElementById(id);
                    if (campo) campo.value = '';
                });
            }

            // 🔹 Función principal de búsqueda
            
            async function buscarEmpresa() {
                const srif = inputRif.value.trim();
                console.log(srif);

                try {
                    const queryParams = new URLSearchParams({
                        srif
                    });

                    const response = await fetch(`${urlBaseEmpresa}?${queryParams}`);

                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }

                    const json = await response.json();
                    console.log(json);

                    if (json.success && json.company) {
                        const company = json.company;
                        // console.log(company.estado);
                        camposEmpresa.forEach(id => {
                            const campo = document.getElementById(id);
                            if (campo && company[id] !== undefined) {
                                campo.value = company[id] ?? '';
                                // console.log(company[id]);
                            }
                        });

                        showToast('Empresa encontrada correctamente.', 'success');
                    } else {
                        limpiarCampos(camposEmpresa);
                        // alert(json.message || '');
                        showToast(json.message || 'No se encontraron datos para el rif.', 'warning');
                    }

                } catch (error) {
                    console.error('Error al obtener los datos:', error);
                    limpiarCampos(camposEmpresa);
                    showToast('Ocurrió un error al intentar obtener los datos.', 'error');
                }
            }
            
            async function buscarPersona() {
                const snacionalidad = inputNacionalidad.value.trim();
                const ndocumento = inputDocumento.value.trim();

                try {
                    const queryParams = new URLSearchParams({
                        snacionalidad,
                        ndocumento
                    });

                    const response = await fetch(`${urlBasePersona}?${queryParams}`);

                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }

                    const json = await response.json();
                    console.log(json);

                    if (json.success && json.persona) {
                        const persona = json.persona;

                        camposPersona.forEach(id => {
                            const campo = document.getElementById(id);
                            if (campo && persona[id] !== undefined) {
                                campo.value = persona[id] ?? '';
                            }
                        });

                        showToast('Persona encontrada correctamente.', 'success');
                    } else {
                        limpiarCampos(camposPersona);
                        // alert(json.message || '');
                        showToast(json.message || 'No se encontraron datos para el documento.', 'warning');
                    }

                } catch (error) {
                    console.error('Error al obtener los datos:', error);
                    limpiarCampos(camposPersona);
                    showToast('Ocurrió un error al intentar obtener los datos.', 'error');
                }
            }

            


            // 🔹 Asignar evento
            btnBuscarPersona.addEventListener('click', buscarPersona);
            btnBuscarEmpresa.addEventListener('click', buscarEmpresa);
        });
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
    
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100"></div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection