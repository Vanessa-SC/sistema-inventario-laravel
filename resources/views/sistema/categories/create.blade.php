@extends('layouts.plantilla')

@section('header')
<h5>Crear categoría</h3>
    @endsection
    @section('content')

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'categories.store', 'autocomplete' => 'off']) !!}
            <div class='form-group'>
                {!! Form::label('nombre','Nombre:') !!}
                {!! Form::text('nombre', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
                @error('nombre')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            {!! Form::submit('Registrar categoría', ["class" => "btn btn-primary float-right px-5"]) !!}
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
