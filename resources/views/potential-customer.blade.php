@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Clientes potenciales</h1>
        </div>
        <div class="col text-right">
            <a href="{{ route('customer.potential.create') }}" class="btn btn-primary btn-sm">Nuevo posible cliente</a>
        </div>
    </div>
    @livewire('potential-customer')
@endsection