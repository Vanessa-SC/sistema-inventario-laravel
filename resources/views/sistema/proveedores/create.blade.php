@extends('layouts.plantilla')

@section('header')
<h5>Crear proveedor</h3>
    @endsection
    @section('content')

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'proveedores.store', 'autocomplete' => 'off']) !!}
            @include('sistema.proveedores.partials.form')
           
            {!! Form::submit('Registrar proveedor', ["class" => "btn btn-primary float-right px-5"]) !!}
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
