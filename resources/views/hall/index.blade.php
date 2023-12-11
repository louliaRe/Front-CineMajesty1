@extends('layouts.app')

@section('content')

<table>
    <thead>
        <tr>
            <th>Hall ID</th>
            <th>Total Seats</th>
            <th>type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($halls as $hall)
            <tr>
          
                <td>
                <a href="{{ route('hall.info', ['id' => $hall->H_id]) }}">
                    {{ $hall->H_id }}
                </a></td>
                <td>{{ $hall->total_seats }}</td>
                <td>{{ $hall->type->name }}</td>
                <td>{{ $hall->status }}</td>
                <td>
                    <form method="POST" action="{{ route('hall.delete', ['id' => $hall->H_id]) }}">
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