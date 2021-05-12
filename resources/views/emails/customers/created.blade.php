@component('mail::message')
# Nuevo cliente creado

El cliente {{ $customer->name }} Se ha creado correctamente

@component('mail::button', [
    'url' => 'http://sicom.local/clientes/' . $customer->id,
    'color' => 'blue'
])
Ver cliente
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent