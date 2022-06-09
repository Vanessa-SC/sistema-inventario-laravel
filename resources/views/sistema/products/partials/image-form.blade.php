
<div class="row my-3">
    <div class="col">
        <div class="image-wrapper" style="padding-bottom: 75%;">
            @isset($producto->image)
            <img id="picture" src="{{ Storage::url($producto->image->url) }}" alt="defaul_img" width="200" height="200">
            @else
            <img id="picture" src="https://cdn.pixabay.com/photo/2017/11/10/04/47/image-2935360_960_720.png"
                width="300" height="300" alt="defaul_img">
            @endisset
        </div>
    </div>
    <div class="col m-auto">
        <div class="form-group">
            <label>
                {!! Form::label('file', 'Foto del producto') !!}
                {!! Form::file('file', ['class' => 'form-control-file', 'accept' => 'image/*']) !!}
            </label>
            @error('file')
            <br>
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
</div>