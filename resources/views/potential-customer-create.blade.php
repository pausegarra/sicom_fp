@extends('adminlte::page')



@section('content')
    <div class="row">
        <div class="col">
            <h1>Nuevo posible cliente</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @livewire('potential-customer-form')
        </div>
    </div>
@endsection

@section('css')
    <style>
        label {
            font-size: 0.9rem;
            font-weight: normal !important;
        }
        legend {
            font-size: 0.99rem;
            display: block;
            margin-bottom: 1.5rem;
            position: relative;
            color: #047bf8;
        }
        legend:before {
            content: "";
            position: absolute;
            left: 0px;
            right: 0px;
            height: 1px;
            top: 50%;
            background-color: rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
    </style>
@endsection