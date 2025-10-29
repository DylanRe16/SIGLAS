@extends('welcomeInterno')

@section('contenido')

<main>

    @include('layouts.menu')


    <div class=" content-todo2 my-3" style="width: 70%">
        <div class="content-login-2" id="contenedor">
            <!-- Botón Minimizar -->
            <div class="row" style="margin-top: -15px;">
                <div class="col-sm-4"></div>
                <div class="col-sm-4"></div>
            </div>
            <div class="sep"></div>

            <!-- Título -->
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Solicitudes > Consultas > </b></h4>
                    </div>
                </div>
            </div>
            <hr class="mt-0">

            @if ($cita)

            <div class="font-weight-bold text-primary mb-3">
                <h4 style="font-size: calc(1.500rem + 0.3vw);">Datos de la Entidad de Trabajo</h4>
            </div>

            <table class="table table-bordered table-striped table-sm fs-6" style="width: 100%">

                <tr class="table-primary">
                    <th style="color: #004B9D;" colspan="1">RIF</th>
                    <th style="color: #004B9D;" colspan="3">Nombre/Razón Social</th>
                </tr>
                <tr>
                    <td colspan="1">{{ $cita->empresa->srif ?? '' }}</td>
                    <td colspan="3">{{ $cita->empresa->srazon_social ?? '' }}</td>
                </tr>


                <tr class="table-primary">
                    <th style="color: #004B9D;">Estado</th>
                    <th style="color: #004B9D;">Municipio</th>
                    <th style="color: #004B9D;">Parroquia</th>
                </tr>

                <tr>
                    <td>{{ $cita->empresa->estado->sdescripcion ?? '' }}</td>
                    <td>{{ $cita->empresa->municipio->sdescripcion ?? '' }}</td>
                    <td>{{ $cita->empresa->parroquia->sdescripcion ?? '' }}</td>
                </tr>


                <tr class="table-primary">
                    <th colspan="1" style="color: #004B9D;">Sector al cual pertenece</th>
                    <th colspan="3" style="color: #004B9D;">Dirección</th>
                </tr>

                <tr>
                    <td colspan="1">{{ $cita->empresa->sector->sdescripcion ?? '' }}</td>
                    <td colspan="3">{{ $cita->empresa->sdireccion_fiscal ?? '' }}</td>
                </tr>
            </table>

            <div class="font-weight-bold text-primary my-4">
                <h4 style="font-size: calc(1.500rem + 0.3vw);">Trámite</h4>
            </div>

            <table class="table table-bordered table-striped table-sm fs-6">
                <tr class="table-primary">
                    <th style="color: #004B9D;">Solicitud</th>
                    <th style="color: #004B9D;">Tipo de Solicitud</th>
                    <th style="color: #004B9D;">Estatus</th>
                </tr>

                <tr>
                    <td>{{ $cita->tipoSolicitud->solicitud->first()->sdescripcion ?? '' }}</td>
                    <td>{{ $cita->tipoSolicitud->sdescripcion ?? '' }}</td>
                    <td>{{ $cita->solicitudProcurador->last()->estatus->sdescripcion ?? 'Sin estatus asignado' }}</td>
                </tr>


                <tr class="table-primary">
                    <th style="color: #004B9D;">¿Su cargo es de dirección?</th>
                    <th style="color: #004B9D;">Último cargo que desempeñó</th>
                    <th style="color: #004B9D;">Fecha de solicitud</th>
                </tr>

                <tr>
                    <td>{{ $cita->bcargo_direccion == 1 ? 'SI' : 'NO' }}</td>
                    <td>{{ $cita->sult_cargo_desempenado ?? '' }}</td>
                    <td>
                        @if($cita->solicitudProcurador && $cita->solicitudProcurador->last()->dfecha_cita)
                        {{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->format('d/m/Y') ?? '' }}
                        @else
                        sin fecha asignada
                        @endif
                    </td>
                </tr>
                {{-- <tr class="table-primary">
                        <th style="color: #004B9D;">Fecha de Solicitud</th>
                        <th style="color: #004B9D;">Fecha de Cita</th>
                        <th style="color: #004B9D;">Hora de Cita</th>
                        <th style="color: #004B9D;">Estatus de Cita</th>
                        <th style="color: #004B9D;">Acción</th>
                    </tr>

                    <tr>
                        <td>{{ $cita->dfecha_solicitud ?? '' }}</td>
                <td>{{ $cita->dfecha_cita ?? '' }}</td>
                <td>{{ $cita->hora_cita ?? '' }}</td>
                <td>{{ $cita->estatusCita->sdescripcion ?? '' }}</td>
                <td>
                    @if ($cita->estatus->id_estatus == 1)
                    <a href="{{ route('cita-edit', ['id' => $cita->id]) }}" class="btn btn-editar rounded-pill" title="Editar Cita">Editar</a>
                    @endif
                </td>
                </tr> --}}
            </table>

            <div class="row ">
                <div class="col-sm-6 d-flex justify-content-end {{ $cita->solicitudProcurador->last()->estatus->id_estatus === 12 ? 'col-sm-6 d-flex justify-content-end' : 'col-sm-12 d-flex justify-content-center' }}">
                    <a href="{{ route('cita-show') }}" class="btn btn-limpiar rounded-pill me-3" title="Regresar">Regresar</a>
                </div>
                @if ($cita->solicitudProcurador->last()->estatus->id_estatus === 12)
                <div class="col-sm-6 d-flex justify-content-start">
                    <button type="submit" value="Guardar" class="btn btn-guardar rounded-pill" title="Imprimir Solicitud" data-bs-toggle="modal" data-bs-target="#requisitosModal">Ver recaudos</button>
                </div>
                @endif
            </div>

            @else
            <div class="alert alert-danger fs-6" id="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> No se encontró la solicitud.
            </div>
            @endif
        </div>
    </div>



    <!-- Modal de Requisitos -->
    <div class="modal fade" id="requisitosModal" tabindex="-1" aria-labelledby="requisitosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content fs-6">
                <div class="modal-header" style="background-color: rgb(70, 162, 253)">
                    <h5 class="modal-title text-white" id="requisitosModalLabel">Recaudos a consignar para la atención</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button> --}}
                </div>
                <div class="modal-body p-3" style="text-align: justify;">
                    {{Auth::user()->ssexo == 'F' ? 'Estimada ' : 'Estimado '}}{{ Auth::user()->ssexo == 'F' ? 'ciudadana ' : 'ciudadano ' }}{{ Auth::user()->sprimer_nombre }} {{ Auth::user()->sprimer_apellido }}.
                    {{Auth::user()->snacionalidad}}.- {{ Auth::user()->ndocumento }}.
                    Le informamos que su atención para la solicitud de {{ $cita->tipoSolicitud->sdescripcion }}, está programada para el día
                    <!--  @if( $cita->solicitudProcurador && $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdescripcion)
                        {{ $cita->solicitudProcurador->last()->personalRolUnidadSust !== null ? $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdescripcion : '[unidad no encontrada]' }},
                        {{ $cita->solicitudProcurador->last()->personalRolUnidadSust !== null ? $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdireccion : '[dirección no encontrada]' }},
                        @else
                        [Datos de ubicación no disponibles]
                        @endif -->
                    <!-- {{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->translatedFormat('l, d') }}  de--> {{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->translatedFormat('l d \d\e F \d\e Y') }}
                    a las
                    {{ \Carbon\Carbon::parse($cita->solicitudProcurador->last()->dfecha_cita)->translatedFormat('h:i a') }} en la Inspectoria del Trabajo "{{ $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdescripcion }}",
                    {{ $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdireccion }}, será {{Auth::user()->ssexo == 'F' ? 'atendida' : 'atendido'}}
                    por {{ $cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->sexo == '1' ? 'la' : 'el' }} Abg.
                    {{ trim(ucfirst(strtolower($cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->primer_nombre)) ?? '[nombre no encontrado]' )}}
                    {{ trim(ucfirst(strtolower($cita->solicitudProcurador->last()->personalRolUnidadSust->personalRol->personales->primer_apellido))) ?? '[apellido no encontrado]'}},
                    es necesario presentar copias de los siguientes recaudos, si los tiene:

                    <ul class="mt-4">
                        @forelse($cita->tipoSolicitud->requisitos as $requisito)
                        @if ($requisito->benabled == 1)
                        <li>{{ $requisito->sdescripcion }}</li>
                        @endif
                        @empty
                        <p>No hay recaudos registrados para este tipo de solicitud.</p>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-limpiar rounded-pill" data-bs-dismiss="modal">Cerrar</button>
                    <!-- Botón para imprimir realmente -->
                    <button type="button" class="btn btn-guardar rounded-pill" onclick="openPDF('{{ route('pdf-print', $cita->id_ptsolicitud) }}')">Imprimir</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        function openPDF(pdfUrl) {
            window.open(pdfUrl, '_blank'); // Abre el PDF sin ejecutar la impresión en la página actual
        }
    </script>
</main>





<script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

@endsection