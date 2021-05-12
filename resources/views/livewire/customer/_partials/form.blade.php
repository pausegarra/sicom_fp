    @csrf
    <div class="form-row">
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Nombre</label>
            <div class="col">
                <input type="text" class="form-control" wire:model.lazy="name" id="name">
                @error('name')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">DNI/CIF</label>
            <div class="col">
                <input type="text" class="form-control" wire:model.lazy="cif" id="cif">
                @error('cif')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Email</label>
            <div class="col">
                <input type="mail" class="form-control" wire:model.lazy="email" id="mail">
                @error('email')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Telefono</label>
            <div class="col">
                <input type="text" class="form-control" wire:model.lazy="phone" id="phone">
                @error('phone')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-sm-6">
            <label for="staticEmail" class="col-form-label">Dirección</label>
            <div class="col">
                <input type="text" class="form-control" wire:model.lazy="address" id="address">
                @error('cif')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Ciudad</label>
            <div class="col">
                <select wire:model.lazy="city" id="city" class="custom-select">
                    <option value=""></option>
                    <option value="city1">Ciudad1</option>
                    <option value="city2">Ciudad2</option>
                    <option value="city3">Ciudad3</option>
                </select>
                @error('city')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Código Postal</label>
            <div class="col">
                <select wire:model.lazy="postCode" id="postcode" class="custom-select">
                    <option value=""></option>
                    <option value="post">postcode1</option>
                    <option value="post2">postcode2</option>
                    <option value="post3">postcode3</option>
                </select>
                @error('post_code')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">País</label>
            <div class="col">
                <select wire:model.lazy="country" id="country" class="custom-select">
                    <option value=""></option>
                    <option value="España">España</option>
                    <option value="Andorra">Andorra</option>
                    <option value="Portugal">Portugal</option>
                </select>
                @error('country')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Forma de pago</label>
            <div class="col">
                <select wire:model.lazy="payment_method_id" wire:change="handlePaymentMethodChange" id="payment" class="custom-select">
                    <option selected></option>
                    @foreach ($paymentMethodsToSelect as $pm)
                        <option value="{{ $pm->id }}">{{ $pm->description }}</option>
                    @endforeach
                </select>
                @error('payment_method')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Término de pago</label>
            <div class="col">
                <select wire:model.lazy="payment_term_id" id="payment_term" class="custom-select">
                    <option selected></option>
                    @foreach ($paymentTermsToSelect as $tm)
                        <option value="{{ $tm->id }}">{{ $tm->description }}</option>
                    @endforeach
                </select>
                @error('payment_term')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <label for="staticEmail" class="col-form-label">Divisiones</label>
            <div class="col">
                <select wire:model.lazy="sector_id" id="division" class="custom-select">
                    <option selected></option>
                    @foreach ($sectorsToSelect as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                    @endforeach
                </select>
                @error('division')
                    <small class="text-danger">{{ $message  }}</small>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-3 mt-3">
            <input type="submit" value="Crear cliente" class="btn btn-success btn-sm w-100">
        </div>
    </div>

@section('js')
@if ($errors->any())
    <script>
        $("#exampleModal").modal('show')
    </script>  
@endif
@endsection