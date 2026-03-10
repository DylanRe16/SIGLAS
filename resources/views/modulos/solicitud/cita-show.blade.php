@extends('welcomeInterno')

@section('contenido')


<main>
    {{-- Datatables styles(en caso de que se necesite a futuro) --}}
    {{-- <link href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" rel="stylesheet" integrity="sha384-R3Uczmi4W29Y1yVAn3Bfb452Xo8/Y+z+DFG8xApppLwTDXxVI5dA2iZRyyRqk9Lm" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css" rel="stylesheet" integrity="sha384-0+lKLwiVpDialHcbXeTFy9JSb/XRx8n2QoRB76gacEVPCaxl5n/o44lSwF3+8Wr+" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/datetime/1.5.5/css/dataTables.dateTime.css" rel="stylesheet" integrity="sha384-L3cnoQJO0GDYK/4XoEEAZQwZheigM84gbNA6jjQKo5CB91h5k3VQ9epOwlhb1NJN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css" rel="stylesheet" integrity="sha384-8CzwKBlyc4q7v55PtHaeeqODP+kaouVbxp350gHt/UhVlPlaVFEnDxSFYo2HU1SQ" crossorigin="anonymous"> --}}


    @include('layouts.menu')

    <div class="content-todo2 my-3" style="width: 70%">
        <div class="content-login-2" id="contenedor2">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-between">
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Solicitudes > Consultas</b></h4>
                    </div>
                </div>
            </div>
            <hr class="mt-0">

            @if ($errors->any())
            <div class="alert alert-danger fs-6" id="alert">
                @foreach ($errors->all() as $error)
                <i class="bi bi-exclamation-triangle-fill"></i> {{$error}} <br>
                @endforeach
            </div>
            @endif

            @if(session('success'))
            <div
                class="alert alert-success fs-6"
                id="alert">
                <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div
                class="alert alert-danger fs-6"
                id="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            </div>
            @elseif(session('warning'))
            <div
                class="alert alert-warning fs-6"
                id="alert">
                <i class="bi bi-info-circle-fill"></i> {{ session('warning') }}
            </div>
            @endif


            <div class="table-responsive">
                <table class="table table-bordered table-striped table-sm fs-6" id="myTable">
                    <thead>
                        <tr class="table-primary">
                            <th style="color: #004B9D;">#</th>
                            <th style="color: #004B9D;">RIF</th>
                            <th style="color: #004B9D;">Nombre/Razón Social</th>
                            <th style="color: #004B9D;">Tipo de solicitud</th>
                            <th style="color: #004B9D;">Estatus</th>
                            <th style="color: #004B9D;">Fecha de Creación</th>
                            <th style="color: #004B9D;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($citas_user->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay solicitudes registradas</td>
                        </tr>
                        @else
                        @foreach ($citas_user as $cita)
                        <tr>
                            <td>{{ $loop->iteration + ($citas_user->currentPage()-1) * $citas_user->perPage() }}</td>
                            <td>{{ $cita->empresa->srif ?? '' }}</td>
                            <td>{{ $cita->empresa->srazon_social ?? '' }}</td>
                            <td>{{ $cita->tipoSolicitud->sdescripcion ?? '' }}</td>
                            {{-- --- CORRECCIÓN DE ERRORES --- --}}
                            <td>
                                @php
                                $ultimoEstatus = $cita->solicitudProcurador->last();
                                @endphp
                                {{ $ultimoEstatus->estatus->sdescripcion ?? 'Sin estatus' }}
                            </td>
                            <td>
                                @php
                                $solicitudProcurador = $cita->SolicitudProcurador->first();
                                @endphp
                                @if ($solicitudProcurador)
                                {{ \Carbon\Carbon::parse($solicitudProcurador->dfecha_creacion)->format('d/m/Y h:i a') }}
                                @else
                                <span>Sin fecha</span>
                                @endif
                            </td>
                            {{-- --- FIN DE CORRECCIÓN --- --}}
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('cita-show2', $cita->id_ptsolicitud) }}" type="button" class="btn btn-guardar rounded-2" style="width: 7rem;">Ver</a>


                                </div>
                            </td>

                        </tr>
                        @endforeach

                        {{ $citas_user->links() }}
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</main>
{{-- Datatables | scripts(en caso de que se necesite a futuro) --}}
{{-- <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha384-ogycHROOTGA//2Q8YUfjz1Sr7xMOJTUmY2ucsPVuXAg4CtpgQJQzGZsX768KqetU" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.js" integrity="sha384-fc3Vl3AxhkJkUU7Heq6ltkvH47iJJRM5S90vW8ILIc+9uSDFjgZdQtrjDnwvUs2c" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js" integrity="sha384-2IrcDZstSOMFTMxGhnJHQtNpSfUopdFXCOaDviGVHw/kuF34fSSaVqL20jnkJctu" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js" integrity="sha384-+1uAIhLS5hfarW0hfzcsIPg4GcIBaPaOrqoPqgwhCCNTq3nA0ve17LfVzeWq9m+p" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.bootstrap5.js" integrity="sha384-yLTXNuasglzZXWjgn0gac6fzvHP2KJ8n49mkOhmzp6rGhK41By8gXi3+/Ms+KOli" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/datetime/1.5.5/js/dataTables.dateTime.js" integrity="sha384-+toGOBi9xpY0BNP80IbcSPp3RgexLr3TjV/obfApBTe1kn49KzkFBEuIoEhZ8f47" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js" integrity="sha384-zAVoatBLtEAzOhdX4Xkli8AOOsRiPj+iFEsCh/BBYnKNHJCM/G8PNGupst4xx3Ft" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js" integrity="sha384-hyp/YDWGBMFqg7pJuS+y+2VWJkwnOyX+oMN9fWcxINo2flqjC/SdNaHj8LIV4zKJ" crossorigin="anonymous"></script>
    <script>
        let table = new DataTable('#myTable');
    </script> --}}
@endsection