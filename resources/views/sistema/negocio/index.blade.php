@extends('layouts.plantilla')

@section('header')
<h4 class="text-uppercase">Datos del negocio</h5>
    @endsection

    @section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::model($negocio, ["route" => ["negocio.update", $negocio], "method" => "PUT", 'files' => true]) !!}

            <div class="form-row">
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('nombre','Nombre:') !!}
                    {!! Form::text('nombre', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                    @error('nombre')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('email','Correo electrónico:') !!}
                    {!! Form::email('email', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class='form-group'>
                {!! Form::label('direccion','Direccion 1:') !!}
                {!! Form::text('direccion', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                @error('direccion')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class='form-group'>
                {!! Form::label('direccion2','Direccion 2:') !!}
                {!! Form::text('direccion2', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                @error('direccion2')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('ciudad','Ciudad:', []) !!}
                    {!! Form::text('ciudad', null, ['class' => 'form-control'] ) !!}
                    @error('ciudad')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('codigo_postal','C.P.:', []) !!}
                    {!! Form::text('codigo_postal', null, ['class' => 'form-control', 'placeholder' => 'Código Postal']
                    ) !!}
                </div>
            </div>

            <div class="form-row">
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('telefono','Telefono:', []) !!}
                    {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => '(888) 937-7238'] )
                    !!}
                </div>
                <div class='col-sm-12 col-md-6 mb-2'>
                    {!! Form::label('telefono2','Telefono 2:', []) !!}
                    {!! Form::text('telefono2', null, ['class' => 'form-control'] ) !!}
                </div>
            </div>

            @include('sistema.negocio.image-form')

            {!! Form::submit('ACTUALIZAR', ["class" => "btn btn-secondary px-5 float-right"]) !!}
            {!! Form::close() !!}
        </div>
    </div>
    @endsection

    @section('jscript')
    <script>
        @if (session('info'))
            Swal.fire("{{ session('info') }}", '', 'success');
        @endif

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