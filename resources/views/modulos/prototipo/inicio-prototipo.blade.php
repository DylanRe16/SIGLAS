@extends('prototipoInterno')

@section('contenido')

<main>
    @include('modulos.prototipo.menu-prototipo')
    <div class="content-todo2">
        <div class="content-login" style="padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); background: #fff; margin-top: 10px; max-width: 1100px; margin-left: auto; margin-right: auto;">

            <!-- @if (session('error'))
                <div
                    class="alert alert-danger fs-6"
                    id="alert">
                    {{ session('error') }}
                </div>
            @elseif (session('success'))
                <div
                    class="alert alert-success fs-6"
                    id="alert">
                    <i class="bi bi-shield-fill-check"></i> {{ session('success') }}
                </div>
            @endif -->

            <div class="row" style="align-items: center;">
    <div class="col-sm-12" style="text-align: center;">
        <h3 tabindex="16" style="color: #004B9D; cursor: default; font-size: 1.5rem; margin-bottom: 10px;">¡Bienvenido(a)!</h3>
    </div>
    <div class="sep"></div>
    <div class="col-sm-12">
        <p class="type-titulo" style="text-align: center; font-size: 1.8rem; margin-bottom: 0;"><b>Sistema de Gestión Productivo y Participativo CPTT</b></p>
    </div>
    <div class="sep"></div>
    <div class="col-sm-6"></div>
    <div class="col-sm-6" style="display: flex; justify-content: flex-end; align-items: center;">
        <p id="horaFecha" style="color: #2d3a47; font-size: 1rem; margin-bottom: 0;"></p>
    </div>
</div>
        </div>
    </div>
</main>

<script language="JavaScript" type="text/javascript" src="{{ asset('js/fecha_hora.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/alerts.js')}}"></script>

<style>
    .content-todo2 {
        position: relative;
        margin-top: 10px; /* Subimos un poco */
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
