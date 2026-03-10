@extends('welcomeInterno')

@section('contenido')

    <div class="container text-center py-5" style="min-height: 80vh;">
        <h1 class="display-4 text-danger">¡Sesión Expirada!</h1>
        <p class="lead">Tu sesión ha expirado por inactividad.<br>
        Por favor, inicia sesión nuevamente para continuar.</p>
        <a href="{{ route('ingresar') }}" class="btn btn-guardar mt-3">Ir al inicio de sesión</a>
    </div>
    
@endsection