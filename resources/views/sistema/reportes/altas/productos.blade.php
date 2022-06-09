@extends('layouts.plantilla')
@section('header')
<div class="row">
    <div class="col-sm-12 col-md-7 col-lg-8 text-uppercase">
        <h5>Alta de productos</h3>
    </div>
    
    <div class="col-sm-12 col-ms-5 col-lg-4 text-right float-right ">
        <a target="_blank" href="{{route('pdf.altas-productos')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-secondary">
                    <tr>
                        <td class="pl-4"><i class="fas fa-barcode"></i></td>
                        <td>Producto</td>
                        <td class="text-center">Cantidad</td>
                        <td class="text-center">Precio</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $entrada)
                    <tr>
                        <td>{{ $entrada->producto->codigo }}</td>
                        <td>{{ $entrada->producto->descripcion }}</td>
                        <td class="text-center">{{ $entrada->cantidad }}</td>
                        <td class="text-right">${{ number_format($entrada->precio,2) }}</td>
                        <td>{{ $entrada->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $entradas->links() }}
        </div>
    </div>
</div>
@endsection