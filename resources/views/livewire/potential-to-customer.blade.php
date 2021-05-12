<div>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
        Pasar a cliente
    </button>

    {{-- MODAL --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pasar a cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="handleSave">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="form-group">
                            <label for="">CIF:</label>
                            <input type="text" name="cif" wire:model.lazy="cif" class="form-control">
                            @error('cif')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Método de pago:</label>
                            <select name="paymentMethod" wire:model.lazy="paymentMethod" id="" class="custom-select" wire:change="handlePaymentMethodSelect">
                                <option value=""></option>
                                @foreach ($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->description }}</option>
                                @endforeach
                            </select>
                            @error('paymentMethod')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Terminos de pago:</label>
                            <select name="paymentTerm" wire:model.lazy="paymentTerm" class="custom-select">
                                <option value=""></option>
                                @foreach ($paymentTerms as $pt)
                                    <option value="{{ $pt->id }}">{{ $pt->description }}</option>                                    
                                @endforeach
                            </select>
                            @error('paymentTerm')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Sector</label>
                            <select name="sector" wire:model.lazy="sector" class="custom-select">
                                <option value=""></option>
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>                                    
                                @endforeach
                            </select>
                            @error('sector')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Convertir a cliente" class="btn btn-sm btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
