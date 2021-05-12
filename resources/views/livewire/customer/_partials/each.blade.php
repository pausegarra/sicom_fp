<tr>
    <td>{{ $customer->name }}</td>
    <td>{{ $customer->email }}</td>
    <td>{{ $customer->cif }}</td>
    <td>{{ $customer->phone }}</td>
    <td>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('customer.show',$customer->id) }}">Ver cliente</a>
    </td>
</tr>