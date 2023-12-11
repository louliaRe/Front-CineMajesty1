@extends('layouts.app')

@section('content')<table>
    <thead>
        <tr>
            <th>Film</th>
            <th>Duration</th>
            <th>Hall</th>
            <th>Start Time</th>              
            <th>End Time</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
        <tr>
            <td><a href="{{ route('show.show', ['SHT_id' => $result->SHT_id,'H_id'=>$result->H_id]) }}">{{ $result->name }}</a></td>
            
            <td>{{ $result->duration }}</td>
            <td>{{ $result->H_id }}</td>
            <td>{{ $result->start_time }}</td>
            <td>{{ $result->end_time }}</td>
            <td>{{ $result->start_date }}</td>
            <td>{{ $result->end_date }}</td>
            <td>
                    <form method="POST" action="{{ route('show.delete', ['SHT_id' => $result->SHT_id,'H_id'=>$result->H_id,'SH_id'
                        =>$result->SH_id,'HS_id'=>$result->HS_id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection
         
