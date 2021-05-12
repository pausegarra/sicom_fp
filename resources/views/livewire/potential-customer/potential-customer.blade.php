<div>
    <div class="card">
        <div class="card-body">
            <h5>Filtra posibles clientes</h5>
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="company">Name</label>
                        <input type="text" placeholder="Buscar por nombre" wire:model="name" class="form-control form-control-sm" id="name">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="company">Empresa</label>
                        <input type="text" placeholder="Buscar por empresa" wire:model="company" class="form-control form-control-sm" id="company">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="state">Estado</label>
                        <select name="state" class="custom-select custom-select-sm" wire:model.lazy="state" id="state">
                            <option value="2">Todos</option>
                            <option value="0">No es cliente</option>
                            <option value="1">Es cliente</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <div class="form-group">
                        <button class="btn btn-warning btn-sm" wire:click="resetFilters">Limpiar filtros</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Phone</th>
                            <th>E-mail</th>
                            <th>City</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @each('livewire.potential-customer._partials.each',$customers,'customer','livewire.potential-customer._partials.no-results')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>