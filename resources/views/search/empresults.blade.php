@extends('layouts.app')

@section('content')<h1>Search Results</h1>
<table>
    <thead>
        <tr>
        <th>Employee Role</th>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
            <tr>
            <td>{{ $result->R_id }}</td>
                <td>{{ $result->E_id }}</td>
                <td>{{ $result->f_name }}</td>
                <td>{{ $result->l_name }}</td>
                <td>{{ $result->email }}</td>
                <td>
                <form method="POST" action="{{ route('search.delete', ['id' => $result->E_id]) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
                </td>
</tr>
                
@endforeach
@endsection
