@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Nuevo pedido</h1>
        </div>
        <div class="col text-right my-auto">
            @livewire('customer-form')
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @livewire('order-form')
                </div>
            </div>
        </div>
    </div>
@endsection