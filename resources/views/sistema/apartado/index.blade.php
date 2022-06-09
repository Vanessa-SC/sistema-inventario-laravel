@extends('layouts.plantilla')

@section('header')
<h5>Apartar un producto</h5>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        {{ Form::open(['route' => 'apartado.store', 'method' => 'POST', 'id' => 'formApartado']) }}

        <div class="row">
            <div class="form-group col-sm-12 col-lg-6">
                {{-- <label for="producto">Producto</label> 
                <select name="producto" id="productos" class="form-control">
                    <option value="" disabled selected>Seleccione un producto</option>
                    @foreach($productos as $producto)
                    <option value="{{ $producto->codigo }}">{{ $producto->descripcion }}</option>
                @endforeach
                </select> --}}
                {!! Form::label('producto', 'Producto') !!}
                {!! Form::select('producto', $productos, null, ["id"=> 'producto' ,'class' => 'form-control','style'=>"heigth: 38px"]) !!}

                @error('producto')
                <span class="text-danger font-weight-400" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <label for="cliente">Cliente</label>
                {!! Form::text('cliente', null, ['placeholder'=>'Nombre del cliente', 'class'=>'form-control','id'=>'cliente']) !!}
                @error('cliente')
                <span class="text-danger font-weight-400" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-group col-sm-12 col-lg-4">
                <label for="precio">Precio</label>
                {!! Form::number('precio', null, ['readonly', 'class'=>'form-control','step'=>'0.01','id'=>'precio']) !!}
            </div>

            <div class="form-group col-sm-12 col-lg-4">
                <label for="anticipo">Anticipo</label>
                <input name="anticipo" type="number" class="form-control" id="anticipo" placeholder="Anticipo" step="0.01">
                @error('anticipo')
                <span class="text-danger font-weight-400" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
            <div class="form-group col-sm-12 col-lg-4">
                <label for="resto">Resto</label>
                <input name="resto" readonly type="number" class="form-control" id="resto" placeholder="Adeudo" step="0.01">
            </div>
            <div class="form-group col-sm-12 col-lg-6">
                <label for="limite">Fecha límite de pago</label>
                <input name="limite" type="date" class="form-control" id="limite" placeholder="Fecha límite de pago" value="{{ now()->addDays(30)->format('Y-m-d') }}">
            </div>

            <div class="form-group col-sm-12 col-lg-6">
                <label class="text-white"> . </label>
                <button id="btn-finish" class="btn btn-secondary w-100">Apartar</button>

            </div>
            {!! Form::close() !!}
        </div>
        @endsection

        @section('jscript')
        <script>
            @if(session('success'))
            Swal.fire("{{ session('success') }}", '', 'success');
            Swal.fire({
                        title: '¿Imprimir ticket?'
                        , showDenyButton: true
                        , confirmButtonText: 'Sí'
                        , denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var url = '{{ Request::url() }}';
                            var path = '{{ Request::path() }}';
                            url = url.replace(path, '');
                            var win = window.open("/ticket/apartado/{{ session('id') }}", '_blank');
                            win.focus();
                            location.reload()

                        } else if (result.isDenied) {
                            location.reload()
                        }
                    });
            @endif

            @if(session('error'))
            Swal.fire("{{ session('error') }}", '', 'error');
            console.error("{{ session('mensaje') }}");
            @endif
            $(document).ready(function() {
                $('#producto').select2();
            });

            $('#producto').change(function() {
                var id = $(this).val();
                $.get('/buscar/' + id, function(data) {
                    $('#precio').val(data.producto.precio_publico);
                });
            });


            $.fn.delayKeyup = function(callback, ms) {
                var timer = 0;
                var el = $(this);
                $(this).keyup(function() {
                    clearTimeout(timer);
                    timer = setTimeout(function() {
                        callback(el)
                    }, ms);
                });
                return $(this);
            };

            $('#anticipo').delayKeyup(function(el) {
                var precio = $('#precio').val();
                var anticipo = el.val();
                var resto = Math.round((precio - anticipo) * 100) / 100;
                $('#resto').val(resto);

            }, 1000);

            $('#limite').change(function() {


                // $('#resto').val(dias_restantes);
            });

        </script>
        @endsection
