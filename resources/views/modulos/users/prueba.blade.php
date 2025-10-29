@extends('welcomeExterno')

@section('title', 'Registro Completado')

@section('culminar-registro')

    @if ($errors->any())
        <div class="alert alert-danger fs-6">
            <ul> 
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <h1>Registro Completado</h1>
    <p>¡Gracias por registrarte!</p>
    <p>Tu cuenta ha sido creada exitosamente.</p>
    <p>Por favor, verifica tu correo electrónico para activar tu cuenta.</p>
    <p>Si no recibiste el correo, revisa tu carpeta de spam o intenta nuevamente.</p>
    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
    <p>¡Bienvenido a nuestro sitio!</p>
    <p>Atentamente,</p>
    <p>El equipo de analisis y desarrollo</p>
    
    <div>
        @if (is_array($persona))
            <ul>
                @foreach ($persona as $key => $value)
                    <li>{{ $key }}: {{ $value }}</li>
                @endforeach
            </ul>
        @else
            <p>{{ $persona }}</p>
        @endif
    </div>

    <div>
        @if (is_array($persona) || is_object($persona))
            <pre>{{ json_encode($persona, JSON_PRETTY_PRINT) }}</pre>
        @else
            <p>{{ $persona }}</p>
        @endif
    </div>
@endsection