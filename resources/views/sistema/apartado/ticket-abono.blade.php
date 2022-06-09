<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de apartado</title>
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
           /* font-size: 1.3rem;*/
            padding-right: 2mm;
        }

    }
</style>

<body>
    <div class="center">
        @if($negocio->image)
            <img src="{{ Storage::url($negocio->image->url) }}" alt="logo negocio" style="margin-top: 5mm; width: 30mm">
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
            <td>Fecha: {{ $abono->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>ID: {{ $abono->id }}</td>
        </tr>
        <tr>
            <td>Folio apartado: {{ $abono->apartado->folio }}</td>
        </tr>
        <tr>
            <td>Atendido por: {{ $abono->user->nombre }}</td>
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
            <tr>
                <td>{{ $abono->apartado->productos[0]->descripcion }}</td>
                <td class="right">${{ number_format($abono->apartado->productos[0]->pivot->precio,2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="line"></div>
    <br>
    <div class="right">
        <p>
            <strong>Abonó:</strong> ${{ number_format($abono->monto,2) }} <span style="width: 5mm;"></span>
            <br>
            <strong>Total abonado:</strong> ${{ number_format($abono->apartado->monto_abonado,2) }} <span style="width: 5mm;"></span>
            <br>
            <strong>Resta:</strong> ${{ number_format($abono->apartado->productos[0]->pivot->precio- $abono->apartado->monto_abonado,2) }}<span style="width: 5mm;"></span>
        </p>
    </div>
    <div class="center">
        @if(number_format($abono->apartado->productos[0]->pivot->precio - $abono->apartado->monto_abonado > 0))
        <div class="font-italic" style="margin: 15px 20px; font-size: 80%">Pase a pagar antes del {{ date('d-m-Y', strtotime($abono->apartado->fecha_limite)) }} o su producto será puesto en venta nuevamente, y perderá lo abonado hasta el momento.</div>
        @endif
        <p>Gracias por su preferencia</p>
    </div>

    <div class="center">

        <svg id="barcode"></svg>
    </div>

    <script>
       
       JsBarcode("#barcode", "{{ $abono->apartado->folio }}", {
            format: "CODE128",
            width: 5,
            height: 200,
            // fontSize: 10
        });
        document.onload = print();
    </script>
</body>

</html>