@extends('layouts.app')

@section('content')<h1>Search Results</h1>


<table>
    <thead>
        <tr>
       
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>wallet id</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr>
            
                <td>{{ $result->C_id }}</td>
                <td>{{ $result->f_name }}</td>
                <td>{{ $result->l_name }}</td>
                <td>{{ $result->email }}</td>
                <td><a href="{{ route('wallet.show', ['id' => $result->EW_id]) }}">
                    {{ $result->EW_id }}
                </a>
            </td></td>
                
                </td>
</tr>
                
@endforeach
@endsection
