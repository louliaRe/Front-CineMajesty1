@extends('layouts.app')

@section('content')

<table>
    <thead>
        <tr>
        <th>id </th>
            <th>film name </th>
            <th>date</th>
            <th>start time</th>
            <th>hall</th>
            <th>delete</th>
            <th>update</th>

       
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
          
                <td>
                <td>{{ $booking->B_id }}</td>
                <td>{{ $booking->name }}</td>
              
                <td>{{ $booking->start_date}}</td>
                
                <td>{{ $booking->start_time }}</td>
                
                
                <td>{{ $booking->H_id}} </td>
               
                <td>
                    <form action="{{route('booking.delete',['B_id'=>$booking->B_id])}}" method="POST">
                    @csrf
                   @method('DELETE')
                   <button type="submit">delete</button>
                    </form>
                </td>
                <td>
                <form action="{{route('booking.edit',['B_id'=>$booking->B_id,'SHT_id'=>$booking->SHT_id,'H_id'=>$booking->H_id])}}" method="GET">
                    @csrf
                  
                   <button type="submit">update</button>
                </td>
             
            </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection