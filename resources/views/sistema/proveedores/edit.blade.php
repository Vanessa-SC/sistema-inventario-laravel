@extends('layouts.plantilla')

@section('header')
<h5>Editar proveedor</h3>
    @endsection
    @section('content')

    <div class="card">
        <div class="card-body">
            {!! Form::model($proveedore, ["route" => ["proveedores.update", $proveedore], "method" => 'PUT']) !!}
           @include('sistema.proveedores.partials.form')
            <div class="row mb-4 font-italic text-secondary" style="opacity: 0.8">
                <div class="col-sm-12 col-md-3">
                   <strong class="mr-2"> Creada: </strong> {{ $proveedore->created_at }}
                </div>
                <div class="col-sm-12 col-md-6">
                   <strong class="mr-2">Modificado por última vez: </strong> {{ $proveedore->updated_at }}
                </div>
            </div>

            {!! Form::submit('Guardar cambios', ["class" => "btn btn-primary float-right px-5"]) !!}
            {!! Form::close() !!}
        </div>
    </div>

    </div>

    </div>


    @endsection



    @section('jscript')
    <script>
        @if(session('info'))
        Swal.fire("{{ session('info') }}", '', 'success');
        @endif

    </script>
    @endsection
