@extends('layouts.app')

@section('content')

<table>
    <thead>
        <tr>
        <th>id </th>
            <th>film name </th>
            <th>date</th>
            <th>start time</th>
            <th>seat booked</th>
            <th>hall</th>
            <th>action</th>

       
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
                <td><a href="{{route('booking.update',['B_id'=>$booking->B_id])}}">
                  {{$booking->SE_id}}
                  </a>
                </td>
                <td>{{ $booking->H_id}} </td>
               
                <td>
                    <form action="{{route('booking.delete',['B_id'=>$booking->B_id])}}" method="POST">
                    @csrf
                   @method('DELETE')
                   <button type="submit">delete</button>
                    </form>
                </td>
             
            </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection