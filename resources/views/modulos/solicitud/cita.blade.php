@extends('welcomeInterno')

@section('contenido')

<style>
    .select {
        width: 50px;
        transition: all 0.4s ease;
        border: none;
        /* Elimina todos los bordes */
        border-bottom: 1px solid #007bff;
        /* Agrega un borde inferior sólido */
        border-radius: 12px;
    }

    .select:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }
</style>

<main>
    @include('layouts.menu')



    <div class=" content-todo2 d-flex align-items-center" style="width: 37rem;">
        <div class="content-login-2 " id="contenedor" style="height: 60%;">

            <!-- Título -->
            <div class="row">
                <div class="col-sm-12 text-start">
                    <div style="color: #004B9D;">
                        <h4 style="font-size: calc(2.150rem + 0.3vw);"><b>Agendar Solicitud</b></h4>
                    </div>
                    {{-- <div class="requerido h6 mt-3">Campos obligatorios (*)</div> --}}
                </div>
            </div>
            <hr class="mt-0">
            <form action="{{ route('cita-create') }}" method="GET">
                @csrf
                <!-- Datos de la Entidad de Trabajo -->
                <div class="row">
                    <div class="font-weight-bold text-primary">
                        <h4>Búsqueda de la Entidad de Trabajo</h4>
                    </div>
                    <div class="sep"></div>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger fs-6" id="alert">
                    @foreach ($errors->all() as $error)
                    <i class="bi bi-exclamation-triangle-fill"></i> {{$error}} <br>
                    @endforeach
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success fs-6" id="alert">
                    <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger fs-6">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
                @endif

                <div class="row mt-3 fs-6 ">
                    <label for="rif" class="type-titulo form-label">Registro de Información Fiscal (RIF)</label>
                    <div class="input-group">

                        <select class="fs-6 select" name="tipo_rif" id="tipo_rif" required>
                            <option value="">...</option>
                            <option value="J" {{ old('tipo_rif') == "J" ? 'selected' : '' }}>J.</option>
                            <option value="G" {{ old('tipo_rif') == "G" ? 'selected' : '' }}>G.</option>
                            <option value="C" {{ old('tipo_rif') == "C" ? 'selected' : '' }}>C.</option>
                        </select>
                        <span style="width: 10px; "></span>
                        <input type="text" class="form-control num_rif" id="num_rif" name="num_rif" placeholder="Ingrese el Nro. de RIF" value="{{ old('num_rif') }}" required>
                        <button class="btn btn-guardar w-25" type="submit" style="border-radius:0 30px 30px 0">Buscar</button>
                    </div>
                </div>




            </form>
            <div class="row mt-4 fs-6 text-center">
                <a href="{{ route('cita-create2') }}">En caso de desconocer el RIF de la entidad de trabajo, <br> haga clic aquí</a>
            </div>
        </div>
    </div>


</main>
<script src="{{ asset('js/datos_personales.js') }}"></script>
@endsection