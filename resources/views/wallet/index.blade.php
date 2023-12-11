@extends('layouts.app')

@section('content')
<form action="{{route('customer.results')}}" method="GET">
    <input type="text" name="query" placeholder="Search">
  
    <button type="submit">Search</button>
</form> 
<table>
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>first name</th>
            <th>last name</th>
            <th>email</th>
            <th>wallet ID </th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
            <tr>
          
                <td>
                                {{ $customer->C_id }}
                </td>
                <td>{{ $customer->f_name }}</td>
                <td>{{ $customer->l_name }}</td>
                <td>{{ $customer->email }}</td>
                <td>
                <a href="{{ route('wallet.show', ['id' => $customer->EW_id]) }}">
                    {{ $customer->EW_id }}
                </a></td>
                
                
            </tr>
        @endforeach
    </tbody>
</table>

@endsection