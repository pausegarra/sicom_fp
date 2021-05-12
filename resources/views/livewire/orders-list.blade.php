<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <label for="">ID</label>
                    <input type="text" wire:model="idOrder" class="form-control form-control-sm">
                </div>
                <div class="col-sm-2">
                    <label for="">Estado</label>
                    <select wire:model="status" class="custom-select custom-select-sm">
                        <option value=""></option>
                        <option value="0">Pendiente</option>
                        <option value="1">Importado</option>
                    </select>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <div class="form-group m-0">
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
                            <th>ID</th>
                            <th>Nombre Cliente</th>
                            <th>Comercial</th>
                            <th>Total sin IVA</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->getOrderTotal() }} €</td>
                                <td>{{ ($order->erp_id) ? 'Importado' : 'Pendiente' }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('customer.order.show',$order->id) }}" class="btn btn-sm btn-primary">Ver pedido</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
