@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-8 text-uppercase">
        <h5>Listado de proveedores</h3>
    </div>
    <div class="col-sm-12 col-md-3 text-right mb-2">
        @can('proveedores.create')
        <a href="{{route('proveedores.create')}}" class="btn btn-secondary btn-sm">CREAR PROVEEDOR</a>
        @endcan
    </div>
    <div class="col-sm-12 col-md-1 text-right ">
        <a target="_blank" href="{{route('pdf.proveedores')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
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
                    <td colspan="3"></td>
                </tr>
            </thead>
            <tbody>
                @if(count($proveedores) == 0)
                <tr>
                    <td colspan="5" class="p-4 text-center text-secondary">
                        <h5>No hay proveedores registrados</h5>
                    </td>
                </tr>
                @endif
                @foreach ($proveedores as $proveedore)
                <tr>
                    <td>{{ $proveedore->id }}</td>
                    <td>{{ $proveedore->nombre }}</td>
                    <td width="10">
                        <button class="btn btn-sm btn-secondary" title="Ver info" onclick="info('{{ $proveedore->nombre }}','{{ $proveedore->email }}','{{ $proveedore->direccion }}','{{ $proveedore->telefono }}','{{ $proveedore->telefono_secundario }}')">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                    @can('proveedores.edit')
                    <td width="10">
                        <a href="{{ route('proveedores.edit',$proveedore->id) }}" class="btn btn-sm btn-primary" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    @endcan
                    @can('proveedores.destroy')
                    <td width="10">
                        {!! Form::open(['route'=> ['proveedores.destroy',$proveedore],'method' => 'DELETE', 'id'=>'delForm']) !!}
                        {!! Form::hidden('categoria', $proveedore->nombre) !!}
                        <button type="submit" class="btn btn-sm btn-danger show-alert-delete-box btn-sm" data-toggle="tooltip" title='Eliminar'>
                            <i class="fas fa-trash"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                    @endcan
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
        var proveedor = inputs[2].value;
        event.preventDefault();
        Swal.fire({
            title: '¿Está seguro de eliminar el proveedor <strong>"' + proveedor + '"</strong>?'
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

    function info(nombre, email, direccion, telefono, telefono2) {

        Swal.fire({
            title: nombre
            , html: "<strong>Correo electrónico:</strong> " + email + "<br><strong>Dirección:</strong> " + direccion + "<br><strong>Telefono:</strong> " + telefono + "<br><strong>Telefono secundario:</strong> " + telefono2
        });
    }

</script>
@endsection
