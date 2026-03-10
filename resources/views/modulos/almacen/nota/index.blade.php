@extends('welcomeInterno')

@section('contenido')
<main>
    @include('layouts.menu')
    <div class="content-todo2 row my-3" style="display: flex; flex-direction:column; width: 70%;">
        <div class="content-login-2" style="height: auto;">

        </div>
    </div>
</main>
@endsection
@section('footer')
@include('layouts.footer')
@endsection