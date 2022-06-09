@extends('layouts.plantilla')

@section('header')

<h4>Crear usuario</h4>
@endsection
@section('content')

<div class="card p-4"">
      <div class=" card-body">
        {!! Form::open(['route' => 'usuarios.store', 'autocomplete' => 'off','files' => true]) !!}
    
    @include('sistema.users.partials.form')
    
    @include('sistema.users.partials.image-form')

    {!! Form::submit('Crear usuario', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
</div>

@endsection

@section('jscript')
<script>
    @if(session('info'))
    Swal.fire('Usuario actualizado', '', 'success');
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
