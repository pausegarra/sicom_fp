<tr>
    <td>{{ $customer->name }}</td>
    <td>{{ $customer->phone }}</td>
    <td>{{ $customer->email }}</td>
    <td>{{ $customer->city }}</td>
    <td>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('potential.customer.show',$customer->id) }}">Ver cliente</a>
    </td>
</tr>