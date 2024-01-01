@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create Show offer</h1>
    <form method="post" action="{{ route('SnackDiscountoffers.store') }}">
        @csrf
      
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" name="amount" class="form-control" >
        </div>
        
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" >
        </div>

        <div class="form-group">
            <label for="expire_date">Expire Date:</label>
            <input type="date" name="expire_date" class="form-control" >
        </div>
        
        @foreach($snacks as $snack)
        <input type="checkbox" name="S_id[]" value="{{$snack->S_id}}"> {{$snack->name}}
        @endforeach



        <button type="submit" class="btn btn-primary">Create offer</button>
    </form>
</div>
@endsection
