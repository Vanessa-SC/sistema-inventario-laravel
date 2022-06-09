<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de venta</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</head>
<style>
    body {
        text-transform: uppercase;
        font-size: 1.5em;
    }

    .center {
        text-align: center;
    }

    .right {
        text-align: end;
    }

    .line {
        width: 100vw;
        height: 1px;
        border-style: dotted hidden hidden;
        border-color: rgb(196, 196, 196);
    }

    th {
        text-align: start;
    }

    @page {
        size: 2in auto;
        margin: 0;
    }

    @media print {
        html,
        body {
            padding-right: 2mm;
        }

    }
</style>

<body>
    <div class="center">
        @if($negocio->image)
            <img src="{{ Storage::url($negocio->image->url) }}" alt="logo negocio" width="40%" style="margin-top: 5mm;">
        @endif
        <h3 style="margin-bottom: 0;">{{ $negocio->nombre }}</h3>
        <p style="margin-top: 10px;">
            {!! $negocio->direccion ? $negocio->direccion : '' !!}
            {!! $negocio->direccion2 ? __('<br>').$negocio->direccion2 : '' !!}
            {!! $negocio->codigo_postal ? __(', CP: ').$negocio->codigo_postal : '' !!}
            {!! $negocio->ciudad ? __('<br>').$negocio->ciudad : '' !!}
            {!! $negocio->telefono ? __('<br>TEL:').$negocio->telefono : '' !!}
            {!! $negocio->email ? __('<br>').$negocio->email : '' !!}
            {!! $negocio->extra ? __('<br>TEL:').$negocio->extra : '' !!}
        </p>
    </div>
    <div class="line"></div>
    <table width="100%" style="margin: 15px 0">
        <tr>
            <td>Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>ID: {{ $venta->id }}</td>
        </tr>
        <tr>
            <td>Folio: {{ $venta->folio }}</td>
        </tr>
        <tr>
            <td>Cliente: {{ $venta->cliente ?? 'General' }}</td>
        </tr>
        <tr>
            <td>Atendido por: {{ $venta->user->nombre }}</td>
        </tr>
    </table>
    <div class="line"></div>
    
    <table width="100%" style="margin: 10px 0">
        <thead>
            <tr>
                <th>Descripcion</th>
                <th class="right">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->productos as $producto)
            <tr>
                <td><strong>{{ $producto->pivot->cantidad }}</strong> - {{ $producto->descripcion }}</td>
                <td class="right">$ {{ number_format( $producto->pivot->cantidad * $producto->precio_publico, 2) }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="line"></div>
    <br>
    <div class="right">
        <strong>TOTAL:</strong> $ {{ number_format($venta->total,2) }} <span style="width: 5mm;"></span>
    </div>


    <div class="center">
        <h3>Gracias por su compra</h3>
        <svg id="barcode"></svg>
    </div>

    <script>
        JsBarcode("#barcode", "{{ $venta->folio }}", {
            format: "CODE128",
            width: 5,
            height: 200,
            // fontSize: 10
        });

        document.onload = print();
    </script>
</body>

</html>