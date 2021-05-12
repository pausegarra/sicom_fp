@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Ficha posible cliente</h1>
        </div>
        <div class="col text-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                Pasar a cliente
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h3>Información del perfil</h3>
                    <div class="row">
                        <div class="col">
                            <p class="small">Nombre</p>
                            <p class="values">{{ $customer->name }}</p>
                            <p class="small">Empresa</p>
                            <p class="values">{{ $customer->company }}</p>
                            <p class="small">Cargo</p>
                            <p class="values">{{ $customer->job }}</p>
                            <p class="small">Correo electrónico</p>
                            <p class="values">{{ $customer->email }}</p>
                            <p class="small">Teléfono</p>
                            <p class="values">{{ $customer->phone }}</p>
                        </div>
                        <div class="col">
                            <p class="small">Apellidos</p>
                            <p class="values">{{ $customer->surname }}</p>
                        </div>
                    </div>
                    <h3>Ubicación</h3>
                    <div class="row">
                        <div class="col">
                            <p class="small">Pais</p>
                            <p class="values">{{ $customer->country }}</p>
                            <p class="small">Provincia</p>
                            <p class="values">{{ $customer->county }}</p>
                            <p class="small">City</p>
                            <p class="values">{{ $customer->city }}</p>
                            <p class="small">Address</p>
                            <p class="values">{{ $customer->address }}</p>
                        </div>
                        <div class="col">
                            <p class="small">Código postal</p>
                            <p class="values">{{ $customer->postcode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('potential-to-customer', ['customer_id' => $customer->id])
@endsection

@section('css')
    <style>
        .small {
            font-size: 14px;
            margin-bottom: 0px;
        }
        .values {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endsection