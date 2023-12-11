@extends('layouts.app')

@section('content')
<form action="{{route('employee.resaults')}}" method="GET">

<input type="text" name="query" placeholder="search">

<button type="submit">
search
</button>

</form>
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
        @foreach($employees as $employee)
            <tr>
            <td>{{ $employee->R_id }}</td>
                <td>{{ $employee->E_id }}</td>
                <td>{{ $employee->f_name }}</td>
                <td>{{ $employee->l_name }}</td>
                <td>{{ $employee->email }}</td>
                <td>
                <form method="POST" action="{{ route('employee.delete', ['id' => $employee->E_id]) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
