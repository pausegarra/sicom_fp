<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h3>Información del perfil</h3>
                    <hr>
                </div>
            </div>
            <form action="#" method="POST" wire:submit.prevent="handleSubmitForm">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" placeholder="Nombre" wire:model.lazy="name" class="form-control form-control-sm" id="name">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="surname">Apellidos</label>
                            <input type="text" placeholder="Apellidos" wire:model.lazy="surname" class="form-control form-control-sm" id="surname">
                            @error('surname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company">Empresa</label>
                    <input type="text" placeholder="Introduce el nombre de empresa" wire:model.lazy="company" class="form-control form-control-sm" id="company">
                    @error('company')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="job">Cargo</label>
                    <input type="text" placeholder="Introduce un cargo" wire:model.lazy="job" class="form-control form-control-sm" id="job">
                    @error('job')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="job">Correo electrónico</label>
                    <input type="text" placeholder="Introduce un correo electrónico" wire:model.lazy="email" class="form-control form-control-sm" id="job">
                    @error('job')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input type="text" placeholder="Introduce un teléfono" wire:model.lazy="phone" class="form-control form-control-sm" id="phone">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <fieldset>
                    <legend>Ubicación</legend>
                    <div class="form-group">
                        <label for="country">País</label>
                        <select  wire:model.lazy="country" id="country" class="custom-select custom-select-sm">
                            <option value="spain">España</option>
                            <option value="andorra">Andorra</option>
                        </select>
                        @error('country')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="county">Provincia</label>
                        <select  wire:model.lazy="county" id="county" class="custom-select custom-select-sm">
                            <option value="county1">County1</option>
                            <option value="county2">County2</option>
                        </select>
                        @error('county')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row" style="margin-bottom: 1rem;">
                        <div class="col-sm-8">
                            <label for="city">Pôblación</label>
                            <select  wire:model.lazy="city" id="city" class="custom-select custom-select-sm">
                                <option value="city1">Poblacion1</option>
                                <option value="city2">Poblacion2</option>
                            </select>
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="postcode">Código Postal</label>
                            <select  wire:model.lazy="postcode" id="postcode" class="custom-select custom-select-sm">
                                <option value="postcode1">Código Postal1</option>
                                <option value="postcode2">Código Postal2</option>
                            </select>
                            @error('postcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Dirección</label>
                        <input type="text" placeholder="Introduce una dirección" wire:model.lazy="address" class="form-control form-control-sm" id="address">
                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Estado</legend>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-check">
                                <input class="form-check-input" wire:model.lazy="status" type="radio" id="status1" value="0" checked>
                                <label class="form-check-label" for="status1"> No es cliente</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" wire:model.lazy="status" id="status2" value="1">
                                <label class="form-check-label" for="status2"> Es cliente</label>
                            </div>
                        </div>
                    </div>
                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </fieldset>
                <hr>
                <input type="submit" class="btn btn-success btn-sm" value="Guardar">
            </form>
        </div>
    </div>
</div>

@push('stack_js')
    <script>
        window.onload = () => {
            Livewire.on('updatePotentialCustomers',() => {
                Swal.fire({
                    title: 'Posible cliente creado',
                    icon: 'success',
                    toast: true,
                    timer: 5000,
                    showConfirmButton: false,
                    position: 'top-end'            
                })
            })
        }
    </script>
@endpush