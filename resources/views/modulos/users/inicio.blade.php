{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'Inicio')


@section('content')

<main class="p-4">
    {{-- @include('layouts.menu') --}}

    <div class="card">
        <div class="card-header">
            @if (session('error'))
            <div
                class="alert alert-danger fs-6"
                id="alert">
                {{ session('error') }}
            </div>
            {{--@elseif (session('success'))--}}
            <div
                class="alert alert-success fs-6"
                id="alert" role="alert">
                <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
            </div>
            @endif
            <h3 tabindex="16" class="card-title" style="color: #004B9D; cursor: default; font-size: 1.5rem; margin-bottom: 10px;">Bienvenido(a) {{ Auth::user()->sprimer_nombre }} {{ Auth::user()->sprimer_apellido }}</h3>


            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <span class="badge badge-primary">Label</span>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body text-center">
            <img src="{{ asset('img/Sigla_logo.png') }}" alt="" style="width:330px;">
            <!-- <p class="type-titulo" style="text-align: center; font-size: 1.8rem; margin-bottom: 0;"><b>SIGLAS</b></p> -->

        </div>
        <!-- /.card-body -->
        <div class="card-footer text-right">
            <p id="horaFecha" style="color: #2d3a47; font-size: 1rem; margin-bottom: 0;"></p>

        </div>
        <!-- /.card-footer -->
    </div>

</main>


@if(session('show_modal') && session('cita'))
@php $cita = session('cita'); @endphp
<!-- Modal de Cita Creada -->
@if($cita)
<div class="modal fade" id="modalCitaCreada" tabindex="-1" aria-labelledby="modalCitaCreadaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fs-6">
            <div class="modal-header" style="background-color: rgb(70, 162, 253)">
                <h5 class="modal-title text-white" id="modalCitaCreadaLabel">Su solicitud fue procesada exitosamente.</h5>
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
                {{ $cita->solicitudProcurador->last()->personalRolUnidadSust->unidadSust->sdireccion }}, será {{Auth::user()->ssexo == 'F' ? 'atendida ' : 'atendido '}}
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
                <button type="button" class="btn btn-limpiar rounded-pill" onclick="cerrarModalCitaCreada()">Cerrar</button>
                <button type="button" class="btn btn-guardar rounded-pill" onclick="openPDF('{{ route('pdf-print', $cita->id_ptsolicitud) }}')">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('modalCitaCreada');
        if (modalEl) {
            window.modalCitaCreadaInstance = new bootstrap.Modal(modalEl);
            window.modalCitaCreadaInstance.show();
        }
    });

    function openPDF(pdfUrl) {
        window.open(pdfUrl, '_blank');
    }

    function cerrarModalCitaCreada() {
        if (document.activeElement) {
            document.activeElement.blur();
        }
        if (window.modalCitaCreadaInstance) {
            window.modalCitaCreadaInstance.hide();
        }
    }
</script>
@endif
@endif


<script language="JavaScript" type="text/javascript" src="{{ asset('js/fecha_hora.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

<style>
    .content-todo2 {
        position: relative;
        margin-top: 10px;
        /* Subimos un poco */
        top: 0;
    }

    .menu {
        margin-bottom: 0;
    }

    h3[tabindex="16"] {
        cursor: default;
    }
</style>

@endsection
@section('footer')
@include('layouts.footer')
@endsection