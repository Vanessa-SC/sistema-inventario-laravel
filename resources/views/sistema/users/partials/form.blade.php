<div class='form-group'>
    {!! Form::label('nombre','Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'nombre del usuario'])
    !!}
    @error('nombre')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class='form-group'>
    {!! Form::label('name','Username:') !!}
    {!! Form::text('name', null, ['autocomplete' => 'off', 'class' => 'form-control', 'placeholder' =>
    'Ingrese el nombre de usuario']) !!}
    @error('name')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <button type="button" class="btn btn-dark w-50" id="btnPwd">Cambiar contraseña</button>
</div>
<div id="pwd"></div>

<div class="form-group">
    <p class="font-weight-bold"> Estatus: </p>
    <label class="mr-4">
        {!! Form::radio('activo', 'SI', true ) !!}
        Activo
    </label>
    <label>
        {!! Form::radio('activo', 'NO' ) !!}
        Inactivo
    </label>
    @error('activo')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

