<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="company">Nombre</label>
                        <input type="text" placeholder="Buscar por nombre" wire:model="name" class="form-control form-control-sm" id="name">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="company">Código</label>
                        <input type="text" placeholder="Buscar por código" wire:model="code" class="form-control form-control-sm" id="code">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="nif">NIF</label>
                        <input type="text" placeholder="Buscar por nif" wire:model="nif" class="form-control form-control-sm" id="nif">
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
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>DNI/CIF</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @each('livewire.customer._partials.each',$customers,'customer','livewire.customer._partials.no-results')
            </tbody>
        </table>
    </div>
</div>
