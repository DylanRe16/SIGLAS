@extends('prototipoInterno')

@section('contenido')
<main>
    @include('modulos.prototipo.menu-prototipo')
    <div class="content-todo2 row my-3 mx-auto" style="max-width: 900px;"> 
        <div class="content-login-2 p-4 p-md-5"> 
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between align-items-center mb-3"> 
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(1.75rem + 0.3vw);"><b>Reportes</b></h4> 
                    </div>
                    <div class="requerido h6 mt-3">Campos obligatorios (*)</div> 
                </div>
            </div>
            <hr class="mt-0 mb-4"> 

            <form action="#" method="POST"> 
                @csrf 

                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-primary" style="font-size: calc(1.3rem + 0.3vw);">Gestión Productiva</h4>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="reportType" class="text-primary">Territorio - Comuna o Circuito Comunal de la Entidad de Trabajo</label><span class="requerido">*</span>
                            <select class="form-control" id="reportType" name="report_type">
                                <option value="">Seleccione</option>
                                <option value="example1">Comuna Ejemplo 1</option>
                                <option value="example2">Comuna Ejemplo 2</option>
                                <option value="example3">Círculo Ejemplo 1</option>
                                <option value="example4">Círculo Ejemplo 2</option>
                                <option value="example5">Otra Opción</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 

                <!-- <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-primary" style="font-size: calc(1.3rem + 0.3vw);">Gestión Administrativa</h4>
                    </div>
                </div> -->

                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="productivaItem" class="text-primary">Materias Primas </label><span class="requerido">*</span>
                            <select class="form-control" id="materiaPrima" name="report_type">
                                <option value="">Seleccione</option>
                                <option value="example1">Comuna Ejemplo 1</option>
                                <option value="example2">Comuna Ejemplo 2</option>
                                <option value="example3">Círculo Ejemplo 1</option>
                                <option value="example4">Círculo Ejemplo 2</option>
                                <option value="example5">Otra Opción</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-block" style="border-radius: 30px;">Agregar</button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="padding: 3px; width: 5%;"  class="text-primary">#</th>
                                    <th style="padding: 3px; width: 65%;"  class="text-primary">Materia(s) Prima(s)</th>
                                    <th class="text-center" style="padding: 3px; width: 30%;"  class="text-primary">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="productivaTableBody">
                                <tr>
                                    <td class="text-center" style="padding: 3px;">1</td>
                                    <td style="padding: 3px;">Madera de pino</td>
                                    <td class="text-center" style="padding: 3px;">
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 3px;">2</td>
                                    <td style="padding: 3px;">Acero inoxidable</td>
                                    <td class="text-center" style="padding: 3px;">
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 

                <!-- <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="font-weight-normal text-primary" style="font-size: calc(1.3rem + 0.3vw);">Insumos</h4><span class="requerido">*</span>
                    </div>
                </div> -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="insumoItem" class="text-primary">Insumo</label> <span class="requerido">*</span>
                            <select class="form-control" id="materiaPrima" name="report_type">
                                <option value="">Seleccione</option>
                                <option value="example1">Comuna Ejemplo 1</option>
                                <option value="example2">Comuna Ejemplo 2</option>
                                <option value="example3">Círculo Ejemplo 1</option>
                                <option value="example4">Círculo Ejemplo 2</option>
                                <option value="example5">Otra Opción</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-block" style="border-radius: 30px;">Agregar</button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="padding: 3px; width: 5%;"  class="text-primary">#</th>
                                    <th style="padding: 3px; width: 65%;"  class="text-primary">Insumo</th>
                                    <th class="text-center" style="padding: 3px; width: 30%;"  class="text-primary">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="insumosTableBody">
                                <tr>
                                    <td class="text-center" style="padding: 3px;">1</td>
                                    <td style="padding: 3px;">Tornillos M8</td>
                                    <td class="text-center" style="padding: 3px;">
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td> 
                                </tr> 
                                <tr> 
                                    <td class="text-center" style="padding: 3px;">2</td> 
                                    <td style="padding: 3px;">Pintura blanca</td> 
                                    <td class="text-center" style="padding: 3px;"> 
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 

                <!-- <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="font-weight-bold text-primary" style="font-size: calc(1.3rem + 0.3vw);">Producto Terminado <span class="requerido">*</span></h4>
                    </div>
                </div> -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="insumoItem" class="text-primary">Producto Terminado</label> <span class="requerido">*</span>
                            <input type="text" class="form-control" id="otherSpecification" name="other_specification" placeholder="Ingrese el producto terminado">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-primary btn-block" style="border-radius: 30px;">Agregar</button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="padding: 3px; width: 5%;"  class="text-primary">#</th>
                                    <th style="padding: 3px; width: 60%;"  class="text-primary">Producto(s) Terminado(s)</th>
                                    <th class="text-center" style="padding: 3px; width: 35%;"  class="text-primary">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="insumosTableBody">
                                <tr>
                                    <td class="text-center" style="padding: 3px;">1</td>
                                    <td style="padding: 3px;">Tornillos 45</td>
                                    <td class="text-center" style="padding: 3px;">
                                        <button type="button" class="btn btn-sm btn-primary" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem; margin-left: 3px;">Editar</button>
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 3px;">2</td>
                                    <td style="padding: 3px;">Pintura y Dorada</td>
                                    <td class="text-center" style="padding: 3px;">
                                        <button type="button" class="btn btn-sm btn-primary" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem; margin-left: 3px;">Editar</button>
                                        <button type="button" class="btn btn-sm btn-danger" style="border-radius: 15px; padding: 1px 4px; font-size: 0.7rem;">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 

                <div class="row mb-3">
                    <div class="col-12">
                        <h4 class="text-primary" style="font-weight:normal">Capacidad Instalada <span class="requerido">*</span></h4>
                    </div>
                </div>

                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" class="form-control" id="installedCapacityValue" name="installed_capacity_value" placeholder="Ingrese el valor numérico" min="0" style="height: calc(2.25rem + 2px);">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="installedCapacityUnit" class="text-primary mb-1" style="white-space: nowrap;">Unidad de Medida</label> <span class="requerido">*</span>
                            <select class="form-control" id="installedCapacityUnit" name="installed_capacity_unit" style="height: calc(2.25rem + 2px);">
                                <option value="">Seleccione</option>
                                <option value="kg">Kilogramos (kg)</option>
                                <option value="liters">Litros (L)</option>
                                <option value="units">Unidades</option>
                                <option value="tons">Toneladas</option>
                                <option value="hours">Horas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 

                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="text-primary" style="font-weight:normal; margin: 0;">Capacidad Operativa Mensual <span class="requerido">*</span></h4>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" id="monthlyCapacityPercent" name="monthly_capacity_percent" placeholder="Porcentaje (%)" min="0" max="100" style="margin: 0;">
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary btn-block" style="border-radius: 30px;">Agregar</button>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem; width: 60%; margin: auto;">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="padding: 3px;">#</th>
                                        <th style="padding: 3px;">Mes de Reporte</th>
                                        <th class="text-center" style="padding: 3px;">Porcentaje (%)</th>
                                    </tr>
                                </thead>
                                <tbody id="monthlyCapacityTableBody">
                                    <tr>
                                        <td class="text-center" style="padding: 3px;">1</td>
                                        <td style="padding: 3px;">Mayo 2025</td>
                                        <td class="text-center" style="padding: 3px;">85%</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="padding: 3px;">2</td>
                                        <td style="padding: 3px;">Abril 2025</td>
                                        <td class="text-center" style="padding: 3px;">70%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 text-center"> 
                        <button type="submit"  class="btn btn-primary btn-block" style="border-radius: 30px;">Guardar</button> 
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>
@endsection