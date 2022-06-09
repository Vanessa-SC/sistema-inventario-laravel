<div class="form-row">
    <div class='col-sm-12 col-md-6 mb-2'>
        {!! Form::label('codigo','Código:', []) !!}
        {!! Form::text('codigo', null, ['class' => 'form-control', 'placeholder' => 'Código de barras'] ) !!}
        @error('codigo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class='col-sm-12 col-md-6 mb-2'>
        {!! Form::label('folio','Folio:', []) !!}
        {!! Form::text('folio', null, ['class' => 'form-control', 'placeholder' => 'Folio del producto'] ) !!}
    </div>
</div>
<div class='form-group'>
    {!! Form::label('descripcion','Descripción:', []) !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción del producto'] ) !!}
    @error('descripcion')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="form-row">
    <div class='col-sm-12 col-md-4 mb-2'>
        @if($editando)
        {!! Form::label('add_stock','Añadir stock:', []) !!}
        {!! Form::number('add_stock', 0, ['class' => 'form-control', 'placeholder' => 'Añadir stock del producto'] ) !!}
        @else 
        {!! Form::label('stock_inicial','Stock inicial:', []) !!}
        {!! Form::number('stock_inicial', 0, ['class' => 'form-control', 'placeholder' => 'Stock inicial del producto'] ) !!}
        @error('stock_inicial')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @endif
    </div>
    <div class='col-sm-12 col-md-4 mb-2'>
        {!! Form::label('precio_publico','Precio de venta:', []) !!}
        {!! Form::number('precio_publico', 0, ['class' => 'form-control', 'placeholder' => 'Precio de venta del producto', 'step'  => '0.01'] ) !!}
        @error('precio_publico')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class='col-sm-12 col-md-4 mb-2'>
        {!! Form::label('precio_proveedor','Precio del proveedor:', []) !!}
        {!! Form::number('precio_proveedor', 0, ['class' => 'form-control', 'placeholder' => 'Precio del proveedor del producto', 'step'  => '0.01'] ) !!}
        @error('precio_proveedor')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="form-row">
    <div class='col-sm-12 col-md-4 mb-2'>
        {!! Form::label('marca','Marca:', []) !!}
        {!! Form::text('marca', null, ['class' => 'form-control', 'placeholder' => 'Marca del producto'] ) !!}
    </div>
    <div class='col-sm-12 col-md-4 mb-2'>
        {!! Form::label('proveedore_id','Proveedor:', []) !!}
        {!! Form::select('proveedore_id', $proveedores, null, ['placeholder'=>'Seleccione un proveedor', 'class' => 'custom-select']) !!}
    </div>
    <div class='col-sm-12 col-md-4 mb-2'>
        {!! Form::label('category_id','Categoría:', []) !!}
        {!! Form::select('category_id', $categorias, null, ['placeholder'=>'Seleccione una categoría', 'class' => 'custom-select']) !!}
    </div>
</div>