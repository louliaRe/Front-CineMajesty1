@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create Show offer</h1>
    <form method="post" action="{{ route('Showoffers.store',['SHT_id'=>$SHT_id]) }}">
        @csrf
       
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="text" name="D_amount" class="form-control" >
        </div>
        
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="D_start_date" class="form-control" >
        </div>

        <div class="form-group">
            <label for="expire_date">Expire Date:</label>
            <input type="date" name="D_expire_date" class="form-control" >
        </div>

    
        <button type="submit" class="btn btn-primary">Create offer</button>
    </form>
</div>

 






@endsection
