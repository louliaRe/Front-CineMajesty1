@extends('layouts.app')

@section('content')
<h1>Edit Hall</h1>

<form method="POST" action="{{ route('hall.update', ['id' => $hall->H_id]) }}">
    @csrf
    @method('PUT') 
    

    <div class="form-group">
        <label for="total_seats">Total Seats</label>
        <input type="text" name="total_seats" value="{{ $hall->total_seats }}">
    </div>

    <div class="form-group">
            <label for="type">Type</label> 
            <select name="TY_id" id="type">
       @foreach($types as $type)
       <option value="{{$type->TY_id}}">{{$type->name}}</option>
       @endforeach
 
        <!-- Add more genre options as needed -->
    </select>
        </div>
    <div class="form-group">
        <label for="status">Status</label>
        <input type="text" name="status" value="{{ $hall->status }}">
    </div>
    <div class="form-group">
        <label for="price">price</label>
        <input type="text" name="price" value="{{ $hall->price }}">
    </div>

    <button type="submit">Update</button>
</form>
</div>
@endsection