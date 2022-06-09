@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-10 text-uppercase">
        <h4>Historial de ventas</h4>
    </div>
    <div class="col-sm-12 col-md-2 text-right ">
        <a target="_blank" href="{{route('pdf.ventas')}}" class="btn btn-secondary btn-sm">PDF <i
                class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{  route('reporte.ventas-filtro') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="">Filtrar</label>
                        <select name="filtro" class="form-control" id="filtro">
                            <option value="" {{ $filtro == '' ? 'selected' : '' }}>Todas</option>
                            <option value="fecha" {{ $filtro == 'fecha' ? 'selected' : '' }}>Fecha</option>
                            <option value="usuario" {{ $filtro == 'usuario' ? 'selected' : '' }}>Vendedor</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" id="fecha_inicio" style="display: none;">
                    <div class="form-group">
                        <label for="">Fecha inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" id="fecha_fin" style="display: none;">
                    <div class="form-group">
                        <label for="">Fecha fin</label>
                        <input type="date" class="form-control" name="fecha_fin" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" id="vendedor" style="display: none;">
                    <div class="form-group">
                        <label for="">Vendedor</label>
                        <select name="usuario" class="form-control">
                            <option value="">Todos</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}" {{$usuario->id == 1 ? 'selected' :
                                ''}}>{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 d-flex justify-content-end pt-4 pb-3" id="button" >
                    <button type="submit" class="btn btn-primary btn-sm px-5" style="display: none;">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="bg-secondary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Folio</th>
                        <th class="text-center">Productos</th>
                        <th class="text-right">Total</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($ventas) == 0)
                    <tr>
                        <td colspan="7" class="p-4 text-center text-secondary">
                            <h5>No hay ventas</h5>
                        </td>
                    </tr>
                    @endif
                    @foreach ($ventas as $venta)
                    <tr>
                        <td class="text-center">{{ $venta->id }}</td>
                        <td>{{ $venta->folio }}</td>
                        <td class="text-center">
                            <div class="input-group-prepend d-flex justify-content-center">
                                <button type="button" class="btn">{{ $venta->cantidad }}</button>
                                <button type="button"
                                    class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Lista de productos</span>
                                </button>
                                <div class="dropdown-menu px-2">
                                    @foreach ($venta->productos as $producto)

                                    <div>{{ $producto->pivot->cantidad }} - {{ $producto->descripcion }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td class="text-right">$ {{ number_format($venta->total, 2) }}</td>
                        <td>{{ $venta->user->nombre }}</td>
                        <td>{{ $venta->created_at->format('d-m-Y H:i') }}</td>
                        <td width="10">
                            <button class="btn btn-sm btn-info" onclick="imprimirTicket('{{ $venta->id }}')">
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $ventas->links() }}
    </div>
</div>
@endsection

@section('jscript')
<script>
    function imprimirTicket(id) {
        var url = '{{ Request::url() }}';
        var path = '{{ Request::path() }}';
        url = url.replace(path, '');
        var win = window.open(url + 'ticket/' + id, '_blank');
        win.focus();
    }

    document.onload = cambiarFiltro();
    filtro.addEventListener('change', function () {
        cambiarFiltro();
    });
    
    function cambiarFiltro(){
        let filtro = document.getElementById('filtro');
        var btn = document.getElementsByTagName('button')[0];
        btn.style.display = 'block';
        if (filtro.value == 'fecha') {
            document.getElementById('fecha_inicio').style.display = 'block';
            document.getElementById('fecha_fin').style.display = 'block';
            document.getElementById('vendedor').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-6");
            document.getElementById('button').classList.remove("col-md-9");
            document.getElementById('button').classList.add('col-md-3');
        } else if (filtro.value == 'usuario') {
            document.getElementById('vendedor').style.display = 'block';
            document.getElementById('fecha_inicio').style.display = 'none';
            document.getElementById('fecha_fin').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-3");
            document.getElementById('button').classList.remove("col-md-9");
            document.getElementById('button').classList.add('col-md-6');
        } else {
            document.getElementById('fecha_inicio').style.display = 'none';
            document.getElementById('fecha_fin').style.display = 'none';
            document.getElementById('vendedor').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-6");
            document.getElementById('button').classList.remove("col-md-3");
            document.getElementById('button').classList.add('col-md-9');
        }
    }

</script>
@endsection