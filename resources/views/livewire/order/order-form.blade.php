<div>
    <form action="#" method="POST" wire:submit.prevent="handleFormSubmit">
        <div class="row">
            <div class="col-sm-2">
                <label for="date">Fecha inicio</label>
                <input type="date" class="form-control" name="dateStart" value="{{ Date('Y-m-d') }}" disabled>
            </div>
            <div class="col-sm-2">
                <label for="date">Hora inicio</label>
                <input type="time" class="form-control" name="hourStart" value="{{ Date('H:i') }}" disabled>
            </div>
            <div class="col" wire:ignore>
                <label for="customer">Cliente</label>
                {{-- @livewire('search-dropdown',[
                    'resource' => 'customer',
                    'field'    => 'name',
                    'event'    => 'updateCustomer',
                    'search'   => (isset($customer)) ? $customer->name : '',
                    'show'     => false,
                ]) --}}
                <select wire:model.lazy="customerId" wire:change="handleCustomerSelect" id="customer" class="custom-select">
                    <option value=""></option>
                    @foreach ($customers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                    @endforeach
                </select>
                @error('customerId')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <hr>
        @if ($customer != null)
            <div class="row">
                <div class="col">
                    <h3>Información del cliente</h3>
                    <h2 class="font-weight-bold">{{ $customer->name }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <p class="font-weight-bold">Datos personales</p>
                    <p class="mb-0">NIF: {{ $customer->cif }}</p>
                    <p class="mb-0">Email: {{ $customer->email }}</p>
                    <p class="mb-0">Teléfono: {{ $customer->phone }}</p>
                </div>
                <div class="col-sm-3">
                    <p class="font-weight-bold">Dirección</p>
                    <p>{{ $customer->address }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h3>Información del pedido</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Referencia de obra</label>
                    <input type="text" wire:model.lazy="work_reference" class="form-control">
                </div>
                <div class="col-sm-3">
                    <label for="">Formas de pago</label>
                    <select wire:model.lazy="payment_method_id" class="custom-select" wire:change="handlePaymentMethodChange" autocomplete="off">
                        <option value=""></option>
                        @foreach ($paymentMethods as $pm)
                            <option value="{{ $pm->id }}">{{ $pm->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="">Términos de pago</label>
                    <select wire:model.lazy="payment_term_id" class="custom-select">
                        <option value=""></option>
                        @if ($paymentTerms != null)
                            @foreach ($paymentTerms as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->description }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="">Día de pago</label>
                    <select wire:model.lazy="payment_day" class="custom-select">
                        <option value=""></option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label for="">Transporte</label>
                    <select wire:model.lazy="carrier" class="custom-select">
                        <option value="standard">ESTANDARD</option>
                        <option value="trans_express">TRANS EXPRESS</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">Tipo IVA</label>
                    <select wire:model.lazy="vat" class="custom-select">
                        <option value="4">4%</option>
                        <option value="10">10%</option>
                        <option value="21">21%</option>
                        <option value="0">EXENTO IVA COVID</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">Contacto</label>
                    <select wire:model.lazy="contact_id" class="custom-select">
                        <option value="con1">Contacto 1</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="">NIF</label>
                    <input type="text" wire:model.lazy="cif" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="">Teléfono</label>
                    <input type="text" wire:model.lazy="phone" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="">Email</label>
                    <input type="text" wire:model.lazy="email" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label for="">¿Como recibe factura?</label>
                    <select wire:model.lazy="howRecieveInvoice" id="" class="custom-select">
                        <option value="print">IMPRESO</option>
                        <option value="mail">EMAIL</option>
                    </select>
                </div>
            </div>
            <hr>
        @endif
        <div class="row">
            <div class="col">
                <h3>Líneas de pedido</h3>
            </div>
        </div>
        @foreach ($rows as $key => $row)
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Producto</label>
                    <select class="custom-select productSelect" wire:model.lazy="rows.{{ $key }}.product" data-key="{{ $key }}">
                        <option value=""></option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>                            
                        @endforeach
                    </select>
                    {{ $rows[$key]['product'] }}
                </div>
                <div class="col-sm-1">
                    <label for="">U. con cargo</label>
                    <input type="text" class="form-control" wire:model.lazy="rows.{{ $key }}.units">
                </div>
                <div class="col-sm-2">
                    <label for="">Descuento</label>
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model.lazy="rows.{{ $key }}.discount" aria-label="Text input with dropdown button">
                        {{-- <div class="input-group-append">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $row['discountLabel'] }}</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" wire:click.prevent="setDiscount('percent',{{ $key }})">%</a>
                            <a class="dropdown-item" href="#" wire:click.prevent="setDiscount('units',{{ $key }})">Sin cargo</a>
                        </div>
                        </div> --}}
                    </div>
                </div>
                {{-- <div class="col-sm-2">
                    <label for="">Tarifa</label>
                    <select wire:model.lazy="rows.{{ $key }}.tarifa" class="custom-select" @if ($row['product'] == null) disabled @endif>
                        <option value="" selected>Selecciona tarifa</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div> --}}
                <div class="col-sm-1">
                    <label for="">Precio unitario</label>
                    <input type="text" class="form-control" disabled value="{{ $rows[$key]['price'] }} €">
                </div>
                <div class="col-sm-1">
                    <label for="">Precio total</label>
                    <input type="text" class="form-control" disabled value="{{ ($row['price'] != null && $row['units'] != null) ? ($row['units'] * $row['price']) - (($row['units'] * $row['price']) * $row['discount'] / 100) ." €" : '0.00 €' }}">
                </div>
                <div class="col-sm d-flex flex-column text-right justify-content-end">
                    <div>
                        <a href="#" class="btn btn-outline-primary" wire:click.prevent="add('rows')"><i class="fas fa-plus"></i></a>
                        <a href="#" class="btn btn-outline-danger @if (count($rows) == 1) disabled @endif" wire:click.prevent="remove({{ $key }},'rows')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
        <div class="row">
            <div class="col-sm-9 text-right">
                <p class="mb-0">
                    <strong>DESCUENTO</strong>
                </p>
                <p class="mb-0">
                    <strong>TOTAL</strong>
                </p>
            </div>
            <div class="col-sm-3 text-right">
                <p class="mb-0">
                    @foreach ($rows as $row)
                        @php
                            $total += $row['discount'];
                            $totalPrice += ($row['price'] * $row['units']) - $row['price'] * $row['units'] * $row['discount'] / 100;
                        @endphp
                    @endforeach
                    <strong>{{ $total }} %</strong>
                </p>
                <p class="mb-0">
                    <strong>{{ $totalPrice }} €</strong>
                </p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <h3>Añadir merchandising</h3>
            </div>-
        </div>
        @foreach ($merchanRows as $key => $row)
            <div class="row">
                <div class="col-sm-4">
                    <label for="">Producto</label>
                    <select wire:model.lazy="merchanRows.{{ $key }}.product" class="custom-select merchanProductSelect" data-key="{{ $key }}">
                        <option value=""></option>
                        @foreach ($merchan as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="">Unidades</label>
                    <input type="text" class="form-control" wire:model.lazy="merchanRows.{{ $key }}.units">
                </div>
                <div class="col-sm-4 d-flex flex-column text-right justify-content-end">
                    <div>
                        <a href="#" class="btn btn-outline-primary" wire:click.prevent="add('merchanRows')"><i class="fas fa-plus"></i></a>
                        <a href="#" class="btn btn-outline-danger @if (count($merchanRows) == 1) disabled @endif" wire:click.prevent="remove({{ $key }},'merchanRows')"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
        <hr>
        <div class="row">
            <div class="col">
                <label for="">Observaciones del pedido</label>
                <textarea wire:model.lazy="orderNotes" class="form-control" rows="8"></textarea>
                <hr>
                <label for="">Observaciones del precio</label>
                <textarea wire:model.lazy="priceNotes" class="form-control" rows="8"></textarea>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <h3>Adjuntos</h3>
                <input wire:model.lazy="files" type="file" multiple>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <a href="#" class="btn btn-success btn-sm" wire:click.prevent="saveOrder">Guardar</a>
                <a href="#" class="btn btn-primary btn-sm">Guardar en retén</a>
            </div>
        </div>
    </form>
</div>

@push('stack_js')
    <script>
        $("#customer").select2(select2Config)
        $('#customer').on('change',() => {
            var data = $('#customer').select2('val')
            @this.set('customerId',data)
            @this.handleCustomerSelect()
        })
        Livewire.on('orderSaved',() => {
            Swal.fire({
                title: 'Pedido creado',
                icon: 'success',
                toast: true,
                timer: 5000,
                showConfirmButton: false,
                position: 'top-end'            
            })
        })
        const productSelects = () => {
            $(".productSelect").select2(select2Config)
            $(".productSelect").each(function(index){
                $(this).on('change',(evt) => {
                    var key     = evt.currentTarget.dataset['key']
                    var product = evt.currentTarget.value
                    var price   = this.options[this.selectedIndex].dataset['price']
                    @this.set('rows.' + key + '.product',product)
                    @this.set('rows.' + key + '.price',parseFloat(price))
                })
            })
            $(".merchanProductSelect").select2(select2Config)
            $(".merchanProductSelect").each(function(index){
                $(this).on('change',(evt) => {
                    var key = evt.currentTarget.dataset['key']
                    var product = evt.currentTarget.value
                    @this.set('merchanRows.' + key + '.product',product)
                })
            })
        }
        // Livewire.on('rowAdded',productSelects)
        productSelects()
        document.addEventListener("livewire:load", (evt) => {
            window.livewire.hook('element.removed', (message,component) => {
                productSelects()
                // $(".productSelect").select2(select2Config)
                // $(".merchanProductSelect").select2(select2Config)
            })
        })
    </script>
@endpush