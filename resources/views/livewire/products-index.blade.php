<div>
    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control"
                placeholder="Ingrese el codigo o descripcion de un producto para filtrar">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead class="bg-secondary">
                        <tr>
                            <td>ID</td>
                            <td>Código</td>
                            <td>Descripcion</td>
                            <td>Stock inicial</td>
                            <td>Existencias</td>
                            <td>Entradas</td>
                            <td>Salidas</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) == 0)
                        <tr>
                            <td colspan="9" class="p-4 text-center text-secondary">
                                <h5>No hay produsctos registrados</h5>
                            </td>
                        </tr>
                        @endif
                        @foreach($products as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->stock_inicial }}</td>
                            <td>{{ $producto->existencias }}</td>
                            <td>{{ $producto->entradas()->sum('cantidad') }}</td>
                            <td>{{ $producto->salidas()->sum('cantidad') }}</td>
                            <td>
                                @can('productos.edit')
                                <button class="btn btn-sm btn-secondary" title="Ver"
                                    onclick="info('{{ $producto->descripcion }}', '{{ $producto->folio }}', '{{ number_format($producto->precio_publico,2) }}','{{ number_format($producto->precio_proveedor,2) }}','@if($producto->proveedor){{ $producto->proveedor->nombre }}@endif', '@if($producto->categoria){{ $producto->categoria->nombre }}@endif', '{{ $producto->created_at }}',@if($producto->image)'{{Storage::url($producto->image->url)}}'@else 'https://cdn.pixabay.com/photo/2017/11/10/04/47/image-2935360_960_720.png'@endif)">
                                    <i class="fas fa-image"></i>
                                </button>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('productos.edit', $producto) }}"
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>
</div>