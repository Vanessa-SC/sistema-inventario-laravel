@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <h1>Listado de usuarios</h1>
    </div>
    <div class="col-sm-12 col-md-4 text-right">
        <a href="{{route('usuarios.create')}}" class="btn btn-secondary btn-sm">CREAR USUARIO</a>
    </div>
</div>
@endsection

@section('content')
<div class="card p-4"">
    <div class=" card-body">
        <div class="table-responsive">
            <table class=" table table-striped">
                <thead class="bg-secondary">
                    <tr>
                        <td class="text-center">ID</td>
                        <td>Nombre</td>
                        <td>Username</td>
                        <td class="text-center">Activo</td>
                        <td colspan="3"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td>{{ $user->nombre }}</td>
                        <td>{{ $user->name }}</td>
                        <td class="text-center">
                            @if($user->activo == 'SI')
                            <i class="fas fa-check-circle text-green rounded-img" title="Activo"></i>
                            @else
                            <i class="fas fa-times-circle text-red rounded-img" title="Inactivo"></i>
                            @endif
                        </td>
                        <td width="10">

                            <button class="btn btn-sm btn-secondary" title='Ver foto' onclick="user_info('{{ $user->nombre }}', @if($user->image) '{{ Storage::url($user->image->url) }}' @else  'https://cdn.pixabay.com/photo/2016/09/28/02/14/user-1699635_960_720.png' @endif)">
                                <i class="fas fa-image"></i>
                            </button>
                        </td>
                        <td width="10">
                            <a href="{{ route('usuarios.edit', $user) }}">
                                <button class="btn btn-sm btn-primary" title='Editar'>
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                        </td>
                        <td width="10">

                            <form method="POST" action="{{ route('usuarios.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" @if($user->id == auth()->user()->id) disabled @endif class="btn btn-sm btn-danger show_confirm" data-toggle="tooltip" title='Eliminar'>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                            {{-- <form action="{{ route('usuarios.destroy', $user) }}" method="post">
                            @csrf
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('jscript')
<script>
    function user_info(nombre, imagen) {
        Swal.fire({
            title: nombre
            , imageUrl: imagen
            , imageWidth: 300
            , imageHeight: 300
            , imageAlt: 'Foto'
        , });
    }
    @if(session('info'))
    Swal.fire("{{ session('info') }}", '', 'success');
    @endif

    $('.show_confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        Swal.fire({
            title: '¿Está seguro de eliminar este usuario?'
            , text: "Esta acción no puede revertirse."
            , icon: 'warning'
            , showCancelButton: true
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
            , confirmButtonText: 'Sí, eliminar'
            , cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
