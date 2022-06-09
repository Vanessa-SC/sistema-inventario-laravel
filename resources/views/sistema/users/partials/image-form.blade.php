
<div class="row mb-3">
    <div class="col">
        <div class="image-wrapper">
            @isset($user->image)
            <img id="picture" src="{{ Storage::url($user->image->url) }}" alt="defaul_img" width="300" height="300">
            @else
            <img id="picture" src="https://cdn.pixabay.com/photo/2016/09/28/02/14/user-1699635_960_720.png"
                width="300" height="300" alt="defaul_img">
            @endisset
        </div>
    </div>
    <div class="col m-auto">
        <div class="form-group">
            <label>
                {!! Form::label('file', 'Foto del usuario') !!}
                {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
            </label>
            @error('file')
            <br>
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>