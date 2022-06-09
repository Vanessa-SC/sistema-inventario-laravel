@extends('layouts.plantilla')

@section('header')

<h4>Editar usuario</h4>
@endsection
@section('content')

<div class="card p-4"">
      <div class=" card-body">
    {!! Form::model($user, ["route" => ["usuarios.update", $user], "method" => "PUT", 'autocomplete' => 'off','files' =>
    true]) !!}

    @include('sistema.users.partials.form')

    @include('sistema.users.partials.image-form')

    {!! Form::submit('Actualizar usuario', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
</div>

@endsection

@section('jscript')
<script>
    @if(session('info'))
    Swal.fire(session('info'), '', 'success');
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

    $('#btnPwd').click(function(event) {
       $('#pwd').load('/pwd');
       $('#btnPwd').hide();
       
    });

</script>
@endsection
