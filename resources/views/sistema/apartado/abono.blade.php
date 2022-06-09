@extends('layouts.plantilla')

@section('header')
<h4>Registrar abono</h4>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <form id="abonoForm">
            <div class="row">
                <div class="form-group col-sm-12 col-lg-6">
                    <label for="apartado">Apartado:</label>
                    <select class="form-control" name="apartado" id="apartado">
                        <option value="0">Seleccione el apartado</option>
                        @foreach ($apartados as $apartado)
                        <option value="{{ $apartado->id }}">{{ $apartado->folio }} - {{ $apartado->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-12 col-lg-6">
                    <label>Producto:</label>
                    <input class="form-control" type="text" id="producto" readonly>
                </div>
                <div class="form-group col-sm-12 col-lg-4">
                    <label>Cliente:</label>
                    <input class="form-control" type="text" id="cliente" readonly>
                </div>

                <div class="form-group col-sm-12 col-lg-4">
                    <label>Precio:</label>
                    <input class="form-control" type="text" id="precio" readonly>
                </div>

                <div class="form-group col-sm-12 col-lg-4">
                    <label>Anticipo:</label>
                    <input class="form-control" type="text" id="anticipo" readonly>
                </div>
                <div class="form-group col-sm-12 col-lg-4">
                    <label>Total abonado:</label>
                    <input class="form-control" type="text" id="abonado" readonly>
                </div>
                <div class="form-group col-sm-12 col-lg-4">
                    <label>Resto:</label>
                    <input class="form-control" type="text" id="resto" readonly>
                </div>
                <div class="form-group col-sm-12 col-lg-4">
                    <label for="limite">Fecha límite de pago</label>
                    <input class="form-control" name="limite" type="text" class="form-control" id="limite" readonly>
                </div>
                <div class="form-group col-sm-12 col-lg-4">
                    <label for="monto">Monto</label>
                    <input type="number" class="form-control" id="monto" name="monto" placeholder="Monto" step="0.01" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-lg-12 text-right">
                    <button id="btn-finish" class="btn btn-primary px-5">Registrar abono</button>
                </div>
            </div>

        </form>
    </div>
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
            var win = window.open("/ticket/abono/{{ session('id') }}", '_blank');
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
        $('#apartado').select2();
    });

    $('#apartado').change(function() {
        var id = $(this).val();
        $.get('/buscar/apartado/' + id, function(data) {
            $('#producto').val(data.producto.descripcion);
            $('#cliente').val(data.apartado.cliente);
            $('#precio').val(data.producto.pivot.precio);
            $('#anticipo').val(data.apartado.anticipo);
            $('#abonado').val(data.apartado.monto_abonado);
            $('#resto').val(Math.round((data.producto.pivot.precio - data.apartado.monto_abonado) * 100) / 100);
            $('#limite').val(data.apartado.fecha_limite.substring(0, 10));
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

    $('#monto').delayKeyup(function(el) {
        var monto = el.val();
        var resto = $('#resto').val();
        if (+monto > +resto) {
            Swal.fire('El monto no puede ser mayor al resto');
            el.val('');
        }
    }, 1000);

    $('#abonoForm').on('submit', function(e) {
        e.preventDefault();
        let monto = $('#monto').val();
        let apartado = $('#apartado').val();

        $.ajax({
            url: '/abonar/' + apartado
            , type: 'POST'
            , data: {
                _token: '{{ csrf_token() }}'
                , monto: monto
            }
            , success: function(data) {
                console.log(data);
                if(data.success){
                    Swal.fire({
                        icon: 'success'
                        , title: 'Abono registrado'
                        , text: '¿Imprimir ticket?'
                        , showDenyButton: true
                        , confirmButtonText: 'Sí'
                        , denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var url = '{{ Request::url() }}';
                            var path = '{{ Request::path() }}';
                            url = url.replace(path, '');
                            var win = window.open("/ticket/abono/"+data.id, '_blank');
                            win.focus();
                            location.reload()
                        } else if (result.isDenied) {
                            location.reload()
                        }
                    });
                }
            }
            , error: function(data) {
                Swal.fire(data.responseJSON.message, '', 'error');
            }
        });
    });


    /*  $('#btn-finish').click(function() {
         var id = $('#apartado').val();
         var monto = $('#monto').val();
         var url = '/abonar/' + id;
         $.ajax({
             url: url
             , type: 'POST'
             , data: {
                 _token: '{{ csrf_token() }}',
                 monto: monto
             }
             , success: function(data) {
                 Swal.fire(data.success, '', 'success');
                 var url = '{{ Request::url() }}';
                 var path = '{{ Request::path() }}';
                 url = url.replace(path, '');
                 var win = window.open("/ticket/abono/" + data.id, '_blank');
                 win.focus();
                 location.reload()
             }
             , error: function(data) {
                 Swal.fire(data.error, '', 'error');
             }
         });
     }); */

</script>
@endsection
