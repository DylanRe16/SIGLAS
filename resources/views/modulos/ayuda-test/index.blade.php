@extends('adminlte::page')
@include('layouts.extenciones')
@section('title', 'C. N. Constituyente')
@section('body_class', 'page-cnconstituyente')

@section('content')
<main class="p-4">


    <div class="card">
        <div class="card-header bg-primary text-white">
            menu Ayuda
        </div>

        <div class="card-body">
            <h5 class="card-title">Módulo Consejo Nacional Constituyente</h5> <br>
            <p class="fw-bold">
                1. Para acceder al Sistema de Información Laboral (SIGLA), abra su navegador, preferiblemente Google Chrome, y escriba
                el siguiente enlace: <a href="https://www.mpppst.gob.ve/mpppstweb/" target="_blank">www.mpppst.gob.ve</a>. 
                Esto lo llevará a la página web del Ministerio del Poder Popular para el Proceso Social de Trabajo (MPPPST). 
                Haga clic en el menú MINISTERIO, opción Servicio al Funcionario.  Una vez dentro del Sistema de Información de 
                Gestión Laboral (SIGLA), seleccione de la lista desplegable su Nacionalidad, ingrese el número de su Cédula de Identidad, Contraseña, 
                Código de Verificación y haga clic en el botón <b>Iniciar Sesión</b>.   
            </p>
        </div>
    </div>

</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection