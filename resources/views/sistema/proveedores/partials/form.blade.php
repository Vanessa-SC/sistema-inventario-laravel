<div class="form-group row">
    <div class='col-sm-12 col-md-6'>
        {!! Form::label('nombre','Nombre:') !!}
        {!! Form::text('nombre', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        @error('nombre')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class='col-sm-12 col-md-6'>
        {!! Form::label('email','Correo electrónico:') !!}
        {!! Form::email('email', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class='form-group'>
    {!! Form::label('direccion','Dirección:') !!}
    {!! Form::text('direccion', null, ['autocomplete' => 'off', 'class' => 'form-control', 'placeholder' => 'Calle N° Colonia/Fracc C.P.']) !!}
    @error('direccion')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group row">
    <div class='col-sm-12 col-md-6'>
        {!! Form::label('telefono','Telefono:') !!}
        {!! Form::text('telefono', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        @error('telefono')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class='col-sm-12 col-md-6'>
        {!! Form::label('telefono_secundario','Telefono secundario:') !!}
        {!! Form::text('telefono_secundario', null, ['autocomplete' => 'off', 'class' => 'form-control']) !!}
        @error('telefono_secundario')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
