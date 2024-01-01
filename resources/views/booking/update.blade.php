@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Update Booking</h1>
    <form method="POST" action="{{ route('booking.update',['B_id'=>$B_id,'H_id'=>$H_id,'SHT_id'=>$SHT_id,'F_id'=>$F_id]) }}">
        @csrf
        @method('PUT')
        @foreach($seats as $seat)
    @php
        $isCheckedBook = false;
        $isChecked = false;
        
        foreach($booked_seats as $bs) {
            if($seat->SS_id == $bs->SS_id) {
                $isCheckedBook = true;
                break;
            }
        }
        
        if ($seat->status == 'booked') {
            $isChecked = true;
        }
    @endphp

    @if($isCheckedBook)
        <input type="checkbox" name="SS_id[]" value="{{$seat->SS_id}}" checked>
    @elseif($isChecked)
        <input type="radio" checked>
    @else
        <input type="checkbox" name="SS_id[]" value="{{$seat->SS_id}}">
    @endif
@endforeach
@foreach($snacks as $snack)
  {{$snack->name}}
  @php
    $booked_snack = $booked_snacks->first(function ($item) use ($snack) {
        return $item->S_id === $snack->S_id;
    });
    $qty = $booked_snack ? $booked_snack->Qty : 0;
  @endphp
  

  @if($booked_snack->book_snack != null)
  <input type="number" name="qty[{{$snack->S_id}}]" value="{{$booked_snack->book_snack}}" min="0">
    @else
    <input type="number" name="qty[{{$snack->S_id}}]" value="{{$qty}}" min="0">

    @endif


@endforeach
        <button type="submit" class="btn btn-primary">update </button>
    </form>
   
</div>
@endsection
