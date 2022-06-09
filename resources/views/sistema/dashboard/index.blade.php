@extends('layouts.plantilla')
@section('header')
<h3>Dashboard</h3>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card color="teal" tipo="dinero" texto="En ventas del mes" cantidad="{{ $ventasMes }}" icon="boxes">
                </x-card>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card tipo="dinero" color="success" texto="En ventas del día" cantidad="{{ $ventas }}" icon="cash-register">
                </x-card>
            </div>
            @can('productos.edit')
            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card tipo="dinero" color="danger" texto="Compras del mes" cantidad="{{ $compras }}" icon="money-bill-alt">
                </x-card>
            </div>
            @endcan
            @can('productos.create')
            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card tipo="dinero" color="indigo" texto="Invertido en stock" cantidad="{{ $invertido }}" icon="tags">
                </x-card>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card color="info" texto="Productos registrados" cantidad="{{ $productos }}" icon="archive"></x-card>
            </div>
            @endcan

            @can('usuarios.index')

            <div class="col-sm-12 col-md-6 col-lg-4">
                <x-card color="slate" texto="Usuarios registrados" cantidad="{{ $usuarios }}" icon="user-plus"></x-card>
            </div>
            @endcan
        </div>

    </div>
</div>

<div class="row mx-1">
    <div class="accordion w-100" id="accordion">
        <div class="card">
            <div class="card-header bg-secondary" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-white text-center" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Compras y ventas del año
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-secondary" id="headingTwo">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-white text-center collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Ventas del día
                    </button>
                </h2>
            </div>

            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <canvas id="chartVentas" width="400" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('jscript')
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line'
        , data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
            , datasets: [{
                    label: 'Compras'
                    , data: "{{ $comprasPorMes }}".split(",")
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
                , {
                    label: 'Ventas'
                    , data: "{{ $ventasPorMes }}".split(",")
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
            ]
        }
        , options: {
            plugins: {
                legend: {
                    position: 'top'
                , }
                , title: {
                    display: true
                    , text: '{{ now()->year }}'
                }
            }
            , scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    let ventasPorHora = '{{$ventasPorHora}}'.split(',');
    let abonosPorHora = '{{$abonosPorHora}}'.split(',');
    let apartadosPorHora = '{{$apartadosPorHora}}'.split(',');
    let productosVendidosPorHora = '{{$productosVendidosPorHora}}'.split(',');

    const ctx2 = document.getElementById('chartVentas').getContext('2d');
    const chartVentas = new Chart(ctx2, {
        type: 'line'
        , data: {
            labels: [5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
            , datasets: [{
                    label: 'Productos vendidos y apartados por hora'
                    , data: productosVendidosPorHora
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
                , {
                    label: 'Ventas por hora'
                    , data: ventasPorHora
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
                , {
                    label: 'Apartados por hora'
                    , data: apartadosPorHora
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
                , {
                    label: 'Abonos por hora'
                    , data: abonosPorHora
                    , backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                        , 'rgba(54, 162, 235, 0.2)'
                        , 'rgba(255, 206, 86, 0.2)'
                        , 'rgba(90, 207, 58, 0.2)'
                        , 'rgba(153, 102, 255, 0.2)'
                        , 'rgba(255, 159, 64, 0.2)'
                    ]
                    , borderColor: [
                        'rgba(255, 99, 132, 1)'
                        , 'rgba(54, 162, 235, 1)'
                        , 'rgba(255, 206, 86, 1)'
                        , 'rgba(90, 207, 58, 1)'
                        , 'rgba(153, 102, 255, 1)'
                        , 'rgba(255, 159, 64, 1)'
                    ]
                    , borderWidth: 1
                }
            ]
        }
        , options: {
            responsive: true
            , plugins: {
                legend: {
                    position: 'top'
                , }
                , title: {
                    display: true
                    , text: '{{ now()->format("d-M-Y") }}'
                }
            }
            , scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

</script>

@endsection
