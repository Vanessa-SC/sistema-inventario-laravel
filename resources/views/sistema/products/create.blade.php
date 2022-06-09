@extends('layouts.plantilla')

@section('header')
<h5 class="text-uppercase">Crear producto</h5>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => 'productos.store', 'autocomplete' => 'off', 'files' => true]) !!}
        @include('sistema.products.partials.form')
        @include('sistema.products.partials.image-form')
        {!! Form::submit('Guardar producto', ['class' => 'btn btn-primary mt-4 float-right px-5']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('jscript')
<script>
    document.getElementById("file").addEventListener('change', cambiarImagen);

    function cambiarImagen(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = (event) => {
            document.getElementById("picture").setAttribute('src', event.target.result);
        };
        reader.readAsDataURL(file);
    }

</script>
@endsection
