@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create offer</h1>
    <form method="post" action="{{ route('offers.store') }}">
        @csrf
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" name="amount" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="expire_date">Expire Date:</label>
            <input type="date" name="expire_date" class="form-control" required>
        </div>

    <input type="radio" name="type" value="showtime" > showtime
    <div class="form-group">
            <label for="SHT_id">showtime ID</label>
            <input type="text" name="SHT_id" class="form-control" >
        </div>
    <input type="radio" name="type" value="snack"> snack
    <div class="form-group">
            <label for="S_id">select snacks</label>
            @foreach($snacks as $snack)
            <input type="checkbox" name="S_id[]" value="{{$snack->S_id}}" > {{$snack->name}}
            @endforeach
        </div>
   
        <button type="submit" class="btn btn-primary">Create offer</button>
    </form>
</div>

 






@endsection
