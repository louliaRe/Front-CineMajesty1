@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create snack offer</h1>
    <form method="post" action="{{ route('Snackoffers.store',['S_id'=>$S_id]) }}">
        @csrf
      
     

  
  
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" >
        </div>

        <div class="form-group">
            <label for="expire_date">Expire Date:</label>
            <input type="date" name="expire_date" class="form-control" >
        </div>
   
        <div class="form-group">
            <label for="req_num">Required Number of Snacks:</label>
            <input type="text" name="req_num" class="form-control" >
        </div>
        <div class="form-group">
            <label for="free_offer">Free Offer:</label>
            <input type="text" name="free_offer" class="form-control" >
        </div>
        <div class="form-group">
            <label for="free_offer">snack:</label>
            @foreach($snacks as $snack)
            <input type="radio" name="free_snack" value= "{{$snack->S_id}}"  >{{$snack->name}}
            @endforeach
           
        </div>
      
        <button type="submit" class="btn btn-primary">Create offer</button>
    </form>
</div>

 






@endsection
