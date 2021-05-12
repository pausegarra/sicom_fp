@extends('adminlte::page')

@section('content')
    <h1>Pedido No {{ $order->id }}</h1>
    <h3>Información del pedido</h3>
    <div class="row">
        <div class="col-sm">
            <p><strong>Ref. Obra:</strong> {{ $order->work_reference }}</p>
            <p><strong>Transporte</strong> {{ $order->carrier }}</p>
            <p><strong>Como recibe factura:</strong> {{ $order->howRecieveInvoice }}</p>
        </div>
        <div class="col-sm">
            <p><strong>Método de pago:</strong> {{ $order->paymentMethod->description }}</p>
            <p><strong>Términos de pago:</strong> {{ $order->paymentTerm->description }}</p>
            <p><strong>IVA:</strong> {{ $order->vat }}</p>
        </div>
    </div>
    <h3>Observaciones</h3>
    <div class="row">
        <div class="col-sm">
            <h5><strong>Pedido:</strong></h5>
            <p>{{ ($order->notes) ? $order->notes : 'No hay observaciones sobre el pedido' }}</p>
        </div>
        <div class="col-sm">
            <h5><strong>Precio:</strong></h5>
            <p>{{ ($order->price_notes) ? $order->price_notes : 'No hay observaciones del precio' }}</p>
        </div>
    </div>
    <h3>Líneas del pedido</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producto</th>
                            <th>Unidades</th>
                            <th>Precio</th>
                            <th>Descuento</th>
                            <th>Total línea</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->rows as $row)
                            <tr>
                                <td>{{ $row->product->name }}</td>
                                <td>{{ $row->units }}</td>
                                <td>{{ $row->price }}</td>
                                <td>{{ $row->discount }}</td>
                                <td>{{ ($row['units'] * $row['price']) - (($row['units'] * $row['price']) * $row['discount'] / 100)  }}</td>       
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm text-right">
                    <p><strong>TOTAL: </strong> {{ $order->getOrderTotal() }} €</p>
                </div>
            </div>
        </div>
    </div>
@endsection