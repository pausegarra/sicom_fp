@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Clientes</h1>
        </div>
        <div class="col text-right my-auto">
            @livewire('customer-form')
        </div>
    </div>
    @livewire('customer-list')
@stop