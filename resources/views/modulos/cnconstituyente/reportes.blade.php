@extends('adminlte::page')

{{-- @include('layouts.extenciones') --}}
@section('title', 'Gráfico de Empresas por Estado')
@section('body_class', 'page-cnconstituyente')
@section('content_header')
    <h1>Distribución de Empresas por Estado</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <canvas id="empresasChart" style="height:400px;"></canvas>
        </div>
    </div>
@stop

@section('js')
<script>
const ctx = document.getElementById('empresasChart').getContext('2d');
const empresasChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Miranda', 'Zulia', 'Lara', 'Carabobo', 'Distrito Capital'],
        datasets: [{
            label: 'Número de Empresas',
            data: [120, 90, 70, 85, 110],
            backgroundColor: '#007bff'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@stop
