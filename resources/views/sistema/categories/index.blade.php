@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-8 text-uppercase">
        <h5>Listado de categorías</h3>
    </div>
    @can('categories.create')
    <div class="col-sm-12 col-md-4 text-right mb-2">
        <a href="{{route('categories.create')}}" class="btn btn-secondary btn-sm">CREAR CATEGORÍA</a>
    </div>
    @endcan
    <div class="col-sm-12 text-right float-right ">
        <a target="_blank" href="{{route('pdf.categorias')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection
@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="bg-secondary">
                <tr>
                    <td>ID</td>
                    <td>Nombre</td>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                @if(count($categories) == 0)
                    <tr>
                        <td colspan="4" class="p-4 text-center text-secondary"><h5>No hay categorías</h5></td>
                    </tr>
                    @endif
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->nombre }}</td>
                    <td width="10">
                        @can('categories.edit')

                        <a href="{{ route('categories.edit',$category->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                    </td>
                    <td width="10">
                        @can('categories.destroy')

                        {!! Form::open(['route'=> ['categories.destroy',$category],'method' => 'DELETE', 'id'=>'delForm']) !!}
                        {!! Form::hidden('categoria', $category->nombre, ['id'=>'categoria']) !!}
                        <button type="submit" class="btn btn-sm btn-danger show-alert-delete-box btn-sm" data-toggle="tooltip" title='Eliminar'>
                            <i class="fas fa-trash"></i>
                        </button>
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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

    $('.show-alert-delete-box').click(function(event) {
        var form = $(this).closest("form");
        var inputs = form.serializeArray();
        var categoria = inputs[2].value;
        event.preventDefault();
        Swal.fire({
            title: '¿Está seguro de eliminar la categoría <strong>"' + categoria + '"</strong>?'
            , text: "Esta acción no puede revertirse"
            , icon: 'warning'
            , showCancelButton: true
            , cancelButtonColor: '#aaa'
            , confirmButtonColor: '#d33'
            , cancelButtonText: 'Cancelar'
            , confirmButtonText: 'Sí, eliminar!'
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                form.submit();
            }
        });
    });

</script>
@endsection
