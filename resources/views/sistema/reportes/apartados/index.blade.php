@extends('layouts.plantilla')

@section('header')
<div class="row">
    <div class="col-sm-12 col-md-10 text-uppercase">
        <h4>Historial de apartados</h4>
    </div>
    <div class="col-sm-12 col-md-2 text-right ">
        <a target="_blank" href="{{route('pdf.apartados')}}" class="btn btn-secondary btn-sm">PDF <i class="fas fa-file-pdf"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form action="{{  route('reporte.apartados-filtro') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="">Filtrar por</label>
                        <select name="filtro" class="form-control" id="filtro">
                            <option value="" {{ $filtro == '' ? 'selected' : '' }}>Default</option>
                            <option value="fecha" {{ $filtro == 'fecha' ? 'selected' : '' }}>Fecha</option>
                            <option value="usuario" {{ $filtro == 'usuario' ? 'selected' : '' }}>Vendedor</option>
                            <option value="cliente" {{ $filtro == 'cliente' ? 'selected' : '' }}>Cliente</option>
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
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}" {{$usuario->id == 1 ? 'selected' :
                                ''}}>{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3" id="cliente" style="display: none;">
                    <div class="form-group">
                        <label for="">Cliente</label>
                        <select name="cliente" class="form-control">
                            @foreach($clientes as $cliente)
                            <option value="{{$cliente->cliente}}" >{{$cliente->cliente}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 d-flex justify-content-end pt-4 pb-3" id="button">
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
                        <th class="text-center">Producto</th>
                        <th class="text-right">Precio</th>
                        <th class="text-right">Anticipo</th>
                        <th class="text-right">Resto</th>
                        <th class="text-center">Estado</th>
                        <th class="text-right">Cliente</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Abonos</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($apartados) == 0)
                    <tr>
                        <td colspan="12" class="p-4 text-center text-secondary">
                            <h5>No hay apartados</h5>
                        </td>
                    </tr>
                    @endif
                    @foreach ($apartados as $apartado)
                    <tr>
                        <td class="text-center">{{ $apartado->id }}</td>
                        <td>{{ $apartado->folio }}</td>
                        <td>
                            {{ $apartado->productos[0]->descripcion }}
                        </td>
                        <td class="text-right">${{ number_format($apartado->productos[0]->pivot->precio, 2) }}</td>
                        <td class="text-right">${{ number_format($apartado->anticipo, 2) }}</td>
                        <td class="text-right">${{ number_format($apartado->productos[0]->pivot->precio -
                            $apartado->monto_abonado, 2) }}</td>
                        <td style="text-transform: uppercase">
                            @if($apartado->estado == 'pendiente')
                            <span class="badge badge-info">{{ $apartado->estado }}</span>
                            @else
                            <span class="badge badge-success">{{ $apartado->estado }}</span>
                            @endif
                        </td>
                        <td>{{ $apartado->cliente }}</td>
                        <td>{{ $apartado->user->nombre }}</td>
                        <td>{{ $apartado->created_at->format('d-m-Y H:i') }}</td>
                        <td width="10">
                            <div class="input-group-prepend d-flex justify-content-center">
                                <button type="button" class="btn">{{ count($apartado->abonos) }}</button>
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Lista de abonos</span>
                                </button>
                                <div class="dropdown-menu px-2">
                                    @foreach ($apartado->abonos as $abono)
                                    <table class="table table-sm">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th>Monto</th>
                                                <th>Vendedor</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>${{ number_format($abono->monto, 2) }}</td>
                                                <td>{{ $abono->user->nombre }}</td>
                                                <td>{{ $abono->created_at->format('d-m-Y H:i') }}</td>
                                                <td>
                                                    @if($loop->index == count($apartado->abonos) - 1)
                                                    <button class="btn btn-sm btn-dark" onclick="imprimirTicketAbono('{{ $abono->id }}')">
                                                        <i class="fas fa-print"></i>
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        <td width="10">
                            <button class="btn btn-sm btn-info" onclick="imprimirTicket('{{ $apartado->id }}')">
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
       @if ($filtro != 'usuario')
         {{ $apartados->links() }}
       @endif
    </div>
</div>
@endsection

@section('jscript')
<script>
    function imprimirTicket(id) {
        var url = '{{ Request::url() }}';
        var path = '{{ Request::path() }}';
        url = url.replace(path, '');
        var win = window.open(url + 'ticket/apartado/' + id, '_blank');
        win.focus();
    }

    function imprimirTicketAbono(id) {
        var url = '{{ Request::url() }}';
        var path = '{{ Request::path() }}';
        url = url.replace(path, '');
        var win = window.open(url + 'ticket/abono/' + id, '_blank');
        win.focus();
    }

    window.onload = function() {
        document.getElementsByName('fecha_inicio')[0].value = "{{ now()->format('Y-m-d') }}";
        document.getElementsByName('fecha_fin')[0].value = "{{ now()->format('Y-m-d') }}";
        cambiarFiltro();
    }

    filtro.addEventListener('change', function() {
        cambiarFiltro();
    });

    function cambiarFiltro() {
        let filtro = document.getElementById('filtro');
        var btn = document.getElementsByTagName('button')[0];
        btn.style.display = 'block';
        if (filtro.value == 'fecha') {
            document.getElementById('fecha_inicio').style.display = 'block';
            document.getElementById('fecha_fin').style.display = 'block';
            document.getElementById('vendedor').style.display = 'none';
            document.getElementById('cliente').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-6");
            document.getElementById('button').classList.remove("col-md-9");
            document.getElementById('button').classList.add('col-md-3');
        } else if (filtro.value == 'usuario') {
            document.getElementById('vendedor').style.display = 'block';
            document.getElementById('cliente').style.display = 'none';
            document.getElementById('fecha_inicio').style.display = 'none';
            document.getElementById('fecha_fin').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-3");
            document.getElementById('button').classList.remove("col-md-9");
            document.getElementById('button').classList.add('col-md-6');
        } else if (filtro.value == 'cliente'){
            document.getElementById('cliente').style.display = 'block';
            document.getElementById('vendedor').style.display = 'none';
            document.getElementById('fecha_inicio').style.display = 'none';
            document.getElementById('fecha_fin').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-3");
            document.getElementById('button').classList.remove("col-md-9");
            document.getElementById('button').classList.add('col-md-6');
        } else {
            document.getElementById('fecha_inicio').style.display = 'none';
            document.getElementById('fecha_fin').style.display = 'none';
            document.getElementById('vendedor').style.display = 'none';
            document.getElementById('cliente').style.display = 'none';
            document.getElementById('button').classList.remove("col-md-6");
            document.getElementById('button').classList.remove("col-md-3");
            document.getElementById('button').classList.add('col-md-9');
        }
    }

</script>
@endsection
