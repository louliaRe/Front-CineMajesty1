@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create Hall</h1>
    <form method="post" action="{{ route('hall.store') }}">
        @csrf
        <div class="form-group">
            <label for="total_seats">Total Seats</label>
            <input type="text" name="total_seats" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="col_nums">Number of the columns</label>
            <input type="text" name="col_nums" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="seat_rows">Number of the rows</label>
            <input type="text" name="row_nums" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="price">price</label>
            <input type="text" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label> 
           
       @foreach($types as $type)
      
       <input type="checkbox" name="TY_id" value="{{$type->TY_id}}"> {{$type->name}}
       @endforeach
 
        <!-- Add more genre options as needed -->
    </select>
        </div>
       
       
       <div class="form-group">
       <label for="name">Or Add ur Hall's type</label> 
       <input type="text" name="name" class="form-control" >
        </div>

        <div class="form-group">
            <label for="status">status</label>
            <select name="status" id="status">
        <option value="available">available</option>
        <option value="unavailable">unavailable</option>
 
        <!-- Add more genre options as needed -->
    </select>
        </div>
        <button type="submit" class="btn btn-primary">Create hall</button>
    </form>
</div>


@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif






@endsection
