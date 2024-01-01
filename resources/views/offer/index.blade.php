@extends('layouts.app')

@section('content')



<table>
    <thead>
        <tr>
            <th>showtime ID</th>
            <th>start time</th>
            <th>start date</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($showtimes as $showtime)
            <tr>
          
                <td>
                <a href="{{ route('Showoffers.create',['SHT_id'=>$showtime->SHT_id])}}">
                    {{ $showtime->SHT_id }}
                </a></td>
                <td>
                    {{ $showtime->start_time }} 
                 </td>

                 <td>
                    {{ $showtime->start_date }} 
                 </td>

               
            </tr>
        @endforeach
    </tbody>
</table>


<table>
    <thead>
        <tr>
            <th>snack ID</th>
            <th>snack name</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($snacks as $snack)
            <tr>
          
                <td>
                <a href="{{ route('Snackoffers.create',['S_id'=>$snack->S_id])}}">
                    {{ $snack->S_id }}
                </a></td>
                <td>
                    {{ $snack->name }} 
                 </td>

               
            </tr>
        @endforeach
    </tbody>
</table>


@endsection