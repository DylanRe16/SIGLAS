@extends('base')

@section('content')

    <div class="container text-center py-5" style="min-height: 80dvh;">
        <h1 class="display-1 text-danger">404</h1>
        <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
        <h3 class="mb-4">Página no encontrada</h3>
        <p class="lead">La página que buscas no existe o fue movida.</p>
        <a href="{{ route('inicio') }}" class="btn btn-guardar mt-3">Volver al inicio</a>
    </div>
        
@endsection