@extends('layouts.plantilla')

@section('header')
<div class="d-flex justify-content-between">
    <div class="p-2">
        <h5>Realizar venta</h5>
    </div>
    <div class="p-2">
        <span class="font-italic float-right">
            <strong>Fecha: </strong>{{ now()->format('d-m-Y') }}</span>
    </div>
</div>
@endsection
@section('content')

{!! Form::open(['route' => 'venta.store', 'id' => 'formVenta']) !!}
<div class="row">

    <div class="col-sm-12 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    {!! Form::label('cliente', 'Cliente:', ['class' => 'col-sm-3 col-form-label']) !!}
                    {!! Form::text('cliente', null, ['id'=>'cliente', 'class' => 'form-control col-sm-9', 'placeholder' => 'Nombre del cliente']) !!}
                </div>

                <div class="form-group row">
                    {!! Form::label('producto', 'Producto:', ['class' => 'col-sm-3 col-form-label']) !!}
                    {!! Form::select('producto', $productos, null, ["id"=> 'codigo' ,'class' => 'form-control col-sm-9 js-example-basic-single','style'=>"heigth: 38px"]) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card w-100">
                <div class="card-body">
                    <table class="table table-sm table-striped" id="tablaProductos">
                        <thead class="bg-secondary">
                            <td>Código</td>
                            <td>Producto</td>
                            <td>Precio</td>
                            <td>Cantidad</td>
                            <td></td>
                        </thead>
                        <tbody>
                            {{-- <tr>
                                <td>0xxxxxxxx0</td>
                                <td>Producto de prueba</td>
                                <td>20.00</td>
                                <td>2</td>
                                <td>40.00</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" title="Remover de la venta">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <span class="col-sm-3">Total: </span>
                    {!! Form::text('total', number_format(0,2), ["id"=>"totalVenta", "class" => "col-sm-9 form-control bg-light text-right", 'readonly']) !!}
                </div>
                <div class="form-group row">
                    {!! Form::label('pago', 'Pago:', ['class' => 'col-sm-3 col-form-label']) !!}
                    {!! Form::text('pago', 0, ['id'=>'pago','class' => 'form-control col-sm-9 text-right', 'placeholder' => '0.00']) !!}
                </div>
                <div class="form-group row">
                    <span class="col-sm-3">Cambio: </span>
                    <input id="cambio" class="col-sm-9 form-control bg-light text-right" value="{{number_format(0,2) }}" readonly>
                </div>
                <button id="btn-finish" class="btn btn-secondary w-100" disabled>Terminar venta</button>

            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
@endsection


@section('jscript')
<script>
    @if(session('info'))
    Swal.fire("{{ session('info') }}", '', 'success');
    @endif

    let productos = [];
    let index = 0;

    $('#formVenta').submit(function(event) {
        event.preventDefault();
    });

    $("#codigo").change(function(e) {
        var barcode = $('select option:selected').val();
        const found = productos.find(e => e.codigo == barcode);
        if (found) {
            Swal.fire('Ya añadió este producto', '', 'warning');
        } else {
            $.ajax({
                url: "/buscar/" + barcode
            }).done(function(result) {
                if (result.status == 200) {
                    addProducto(result.producto);
                }
                if (result.status == 204)
                    Swal.fire(result.message, '', 'warning');
            });
        }
        $('#codigo').val("0");
    });

    function rows() {
        var body = document.querySelector("#tablaProductos tbody");
        body.innerHTML = '';
        productos.forEach(function(x, i) {
            var tr = document.createElement("tr")
                , tdCodigo = document.createElement("td")
                , tdDescripcion = document.createElement("td")
                , tdCantidad = document.createElement("td")
                , tdPrecio = document.createElement("td")
                , tdRemove = document.createElement("td")
                , btnRemove = document.createElement("button");

            tdCodigo.innerHTML = x.codigo;
            tdDescripcion.innerHTML = x.descripcion;
            tdCantidad.innerHTML = "<input type='number' class='form-control' min='1' max='" + x.existencias + "'' value='" + x.cantidad + "'>"
            tdPrecio.innerHTML = x.precio_publico;

            tdCantidad.setAttribute('width', '100')
            tdCantidad.addEventListener('change', function(evt) {
                var value = evt.target.value;
                cambiarCantidad(i, value);
                calcular();
            });

            btnRemove.textContent = 'Quitar';
            btnRemove.className = 'btn btn-sm btn-danger';
            btnRemove.type = 'button';
            btnRemove.addEventListener('click', function() {
                quitarProducto(i);
            });

            tdRemove.appendChild(btnRemove);

            tr.appendChild(tdCodigo);
            tr.appendChild(tdDescripcion);
            tr.appendChild(tdPrecio);
            tr.appendChild(tdCantidad);
            tr.appendChild(tdRemove);

            body.append(tr);

            actualizarTotal();

            var tds = document.getElementsByTagName('td');
            for (let index = 0; index < tds.length; index++) {
                const td = tds[index];
                td.className = 'align-middle';
            }

        });
    }

    function addProducto(producto) {
        producto.cantidad = 1;
        productos.push(producto);
        rows();
        calcular();
    }

    function quitarProducto(index) {
        productos.splice(index, 1);
        rows();
        calcular();
    }

    function cambiarCantidad(index, cantidad) {
        if (cantidad < 1) {
            Swal.fire('', 'La cantidad mínima es 1', 'warning');
            productos[index].cantidad = 1;
            rows();
        } else if (cantidad > productos[index].existencias) {
            Swal.fire('La cantidad máxima es ' + productos[index].existencias, '', 'warning');
            productos[index].cantidad = 1;
            rows();
        } else {
            productos[index].cantidad = cantidad;
        }
        actualizarTotal();
    }

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

    $('#pago').delayKeyup(function(el) {
        calcular();
    }, 1000);

    function actualizarTotal() {
        var total = 0;
        productos.forEach(function(x, i) {
            total += (x.precio_publico * x.cantidad);
        });
        $('#totalVenta').val((Math.round(total * 100) / 100).toFixed(2));
    }

    function calcular() {
        var total = parseFloat($('#totalVenta').val().replace('$', ''));
        var pago = $('#pago').val();
        var cambio = $('#cambio');
        if (productos.length == 0 || pago < total) {
            $('#btn-finish').prop('disabled', true);
        }
        if (pago < total && pago != 0) {
            Swal.fire('', 'El pago debe ser igual o mayor al total de la venta', 'warning')
            $('#btn-finish').prop('disabled', true);
            $('#pago').val(0)
            cambio.val(0);
        } else if (pago >= total) {
            cambio.val((Math.round((pago - total) * 100) / 100).toFixed(2));
            if (productos.length > 0) {
                $('#btn-finish').prop('disabled', false)
            }
        }
    }

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $("#btn-finish").click(function(e) {
        var form = document.getElementById('formVenta');
        // form.submit();

        let cliente = $('#cliente').val();
        let products = productos;
        let total = $('#totalVenta').val();
        let pago = $('#pago').val();

        $.ajax({
            url: "/venta/crear"
            , type: "POST"
            , data: {
                "_token": "{{ csrf_token() }}"
                , cliente: cliente
                , productos: productos
                , total: total
                , pago: pago
            , }
            , success: function(response) {
                if (response.status == 200) {
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
                            var win = window.open(url + 'ticket/' + response.id, '_blank');
                            win.focus();
                            location.reload()

                        } else if (result.isDenied) {
                            location.reload()
                        }
                    });
                } else {
                    Swal.fire('Ocurrió un error al guardar la venta', '', 'error');
                    console.error(response.message);
                }

            }
            , error: function(response) {
                Swal.fire('Ocurrió un error', response.status + ": " + response.statusText, 'error');
                console.error(response);
            }
        , });
    });

    $('.span.select2.select2-container').removeAttr('style');

</script>
@endsection
