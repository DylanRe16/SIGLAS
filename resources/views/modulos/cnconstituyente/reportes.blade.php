@extends('adminlte::page')

@include('layouts.extenciones')
@section('title', 'Gráfico de Empresas por Estado')
@section('body_class', 'page-cnconstituyente')
@section('content_header')
    
    <h4 class="font-weight-bold link-secondary">C. N Constituyente > Reportes</h4>
@stop

@section('content')
    
    <div style="width:100%; height:600px;">
        <iframe
            src="{{ $iframeUrl }}"
            frameborder="0"
            width="100%"
            height="100%"
            allowtransparency>
        </iframe>
    </div>

@endsection


@section('footer')
    @include('layouts.footer')
@endsection