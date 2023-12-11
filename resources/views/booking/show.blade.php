@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Book</h1>
    <form method="post" action="{{ route('booking.submitjob',['SHT_id'=>$SHT_id]) }}">
        @csrf
        
        <div class="form-group">
            <label for="code">Offer</label>
            <input type="text" name="code" class="form-control" >
        </div> 

@foreach($seats as $seat)
<input type="checkbox" name="SS_id[]" value="{{$seat->SS_id}}">
@endforeach
@foreach($snacks as $snack)
  {{$snack->name}}
  <input type="number" name="qty[{{$snack->S_id}}]" value="null">
@endforeach
        <button type="submit" class="btn btn-primary">Create offer</button>
    </form>
</div>

 






@endsection
