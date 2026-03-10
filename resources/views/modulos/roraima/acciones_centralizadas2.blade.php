{{--@extends('welcomeInterno')--}}
@extends('adminlte::page')
@extends('layouts.extenciones')
@section('title', 'Roraima - Accion Centralizada')


@section('content')

<main class="p-4">

 @include('layouts.alertas')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <div class="link-secondary">
                <h4 class="font-weight-bold">Variables > Accion Centralizada</h4>
            </div>
            <div class="requerido fs-6 fw-normal">Campos obligatorios (*)</div>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"> Seleccione el año de los Proyectos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modal1">
                    <i class="bi bi-info-circle"></i></i>
                </button> <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
        </div>

       <div class="card-body">
    <div class="row fs-6">
        <div class="col-md-6"> <div class="form-group">
                <div class="link-secondary mb-1">Año: <span class="requerido">*</span></div>
                
                <div class="d-flex gap-2"> 
                    <input type="date"
                     class="form-control"
                      name="año_proyecto"
                      id="año_proyecto"
                      min="2026-01-01" 
                      value="2026-01-01">
                    
                    <button type="submit" class="btn btn-guardar" id="btnBuscar">
                        <span id="textoBoton">Buscar</span>
                        <span id="spinnerBoton" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const añoproyecto = document.getElementById('año_proyecto');
    
    // Bloquear teclado pero permitir selección de calendario
    [añoproyecto].forEach(input => {
        if(input) input.addEventListener('keydown', e => e.preventDefault());
    });
</script>

</main>

@endsection

@section('footer')
@include('layouts.footer')
@endsection