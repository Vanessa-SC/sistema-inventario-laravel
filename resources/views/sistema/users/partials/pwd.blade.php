<div class='form-group'>
    {!! Form::label('password', 'Contraseña:') !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Contraseña']) !!}
    @error('password')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>