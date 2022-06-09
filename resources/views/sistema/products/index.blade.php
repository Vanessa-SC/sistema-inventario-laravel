@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-8 text-uppercase">
        <h5>Inventario de productos</h3>
    </div>
    @can('productos.create')
    <div class="col-sm-12 col-md-3 text-right mb-2">
        <a href="{{route('productos.create')}}" class="btn btn-secondary btn-sm">CREAR PRODUCTO</a>
    </div>
    <div class="col-sm-12 col-md-1 text-right ">
        <a target="_blank" href="{{route('pdf.inventario')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
    @endcan
</div>
@endsection
@section('content')

@livewire('products-index')

@endsection



@section('jscript')
<script>
    function info(producto, folio, preciov, preciop, proveedor, categoria, registro, imagen) {
        Swal.fire({
            title: producto
            , html: "<table><tr><th>Folio</th><td>"+folio+"</td></tr><tr><th>Precio</th><td>$"+preciov+"</td></tr><tr><th>Precio proveedor</th><td>$"+preciop+"</td></tr><tr><th>Proveedor</th><td>"+proveedor+"</td></tr><tr><th>Categoría</th><td>"+categoria+"</td></tr><tr><th>Registro</th><td>"+registro+"</td></tr></table>"
            , imageUrl: imagen
            , imageWidth: 300
            , imageHeight: 300
            , imageAlt: 'Foto'
        , });
    }
    @if(session('info'))
    Swal.fire("{{ session('info') }}", '', 'success');
    @endif

</script>
@endsection
