@extends('adminlte::page')

@section('adminlte_css')
    <style>
        h1::after {
            content: "";
            background-color: #047bf8;
            width: 50px;
            height: 4px;
            border-radius: 0px;
            display: block;
            position: absolute;
            bottom: 6px;
            left: 9px;
        }
        p.label {
            margin: 0;
            font-style: italic;
            font-size: 16px;
        }
        p.labelValue {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <h2>Ficha de cliente</h2>
            <h1 class="border-bottom pb-4">{{ $customer->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="label">NIF/CIF</p>
            <p class="labelValue">{{ $customer->cif }}</p>
            <p class="label">Mail</p>
            <p class="labelValue">{{ $customer->email }}</p>
            <p class="label">Teléfono</p>
            <p class="labelValue">{{ $customer->phone }}</p>
        </div>
        <div class="col">
            <p class="label">Dirección</p>
            <p class="labelValue">{{ $customer->address }}</p>
            <p class="label">Fecha alta AFNET</p>
            <p class="labelValue">No</p>
            <p class="label">Perfil envío documento</p>
            <p class="labelValue">Impresión</p>
        </div>
        <div class="col">
            <p class="label">Media dias demora pago</p>
            <p class="labelValue"></p>
            <p class="label">Total ventas año pasado</p>
            <p class="labelValue">0,00 €</p>
            <p class="label">Total ventas año actual</p>
            <p class="labelValue">0,00 €</p>
        </div>
        <div class="col">
            <p class="label">División</p>
            <p class="labelValue">{{ $customer->sector->name }}</p>
            <p class="label">Saldo cliente</p>
            <p class="labelValue">0,00 €</p>
        </div>
        <div class="col">
            <p>
                <a href="{{ route('order.create') }}?customerId={{ $customer->id }}" class="btn btn-sm btn-dark btn-block">Pedido</a>
            </p>
            <p>
                {{-- <a href="#" class="btn btn-sm btn-warning btn-block">Visita</a> --}}
            </p>
        </div>
    </div>
    <div class="row mt-4">
        <h3>Pedidos</h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customer->orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->getOrderTotal() }} €</td>
                        <td>{{ ($order->erp_id == null) ? 'Pendiente' : 'Pasado' }}</td>
                        <td><a href="{{ route('customer.order.show',$order->id) }}" class="btn btn-sm btn-outline-primary">Ver pedido</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No se han encontrado pedidos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@stop