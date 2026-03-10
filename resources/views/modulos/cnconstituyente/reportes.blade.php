@extends('adminlte::page')

@include('layouts.extenciones')
@section('title', 'Gráfico de Empresas por Estado')
@section('body_class', 'page-cnconstituyente')
@section('content_header')
    
    <h4 class="font-weight-bold link-secondary">C. N Constituyente > Reportes</h4>
@stop

@section('content')
    <main class="d-flex justify-content-center align-items-center flex-column p-4">
        <div style="width:100%; height:500px;" class="mb-4">
            <iframe
                src="{{ $iframeUrl }}"
                frameborder="0"
                width="100%"
                height="100%"
                allowtransparency>
            </iframe>
        </div>


        <div style="width:100%; height:500px;" class="mt-4">
            <iframe
                src="{{ $iframeUrl1 }}"
                frameborder="0"
                width="100%"
                height="100%"
                allowtransparency>
            </iframe>
            <div>
                
            </div>
        </div>

        <div style="width:100%; height:500px;" class="mt-4">
            <iframe
                src="{{ $iframeUrl2 }}"
                frameborder="0"
                width="100%"
                height="100%"
                allowtransparency>
            </iframe>
            <div>
                
            </div>
        </div>

        <div style="width:100%; height:500px;" class="mt-4">
            <iframe
                src="{{ $iframeUrl3 }}"
                frameborder="0"
                width="100%"
                height="100%"
                allowtransparency>
            </iframe>
            <div>
                
            </div>
        </div>


        <div style="width:100%; height:500px;" class="mt-4">
            <iframe
                src="{{ $iframeUrl4 }}"
                frameborder="0"
                width="100%"
                height="100%"
                allowtransparency>
            </iframe>
            <div>
                
            </div>
        </div>
        
    </main>

@endsection


@section('footer')
    @include('layouts.footer')
@endsection