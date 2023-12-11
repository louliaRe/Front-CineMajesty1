@extends('layouts.app')

@section('content')
<h1>Edit Snack</h1>

<form method="POST" action="{{ route('snack.update', ['id'=>$snack->S_id]) }}">
    @csrf
    @method('PUT') 
    

    <div class="form-group">
        <label for="name">name</label>
        <input type="text" name="name" value="{{ $snack->name }}">
    </div>

    <div class="form-group">
        <label for="qty">Quantity</label>
        <input type="text" name="qty" value="{{ $snack->qty }}">

    </div>
    
    <div class="form-group">
        <label for="limit">limit</label>
        <input type="text" name="limit" value="{{ $snack->limit }}">
        
    </div>
    <div class="form-group">
        <label for="price">price</label>
        <input type="text" name="price" value="{{ $snack->price }}">
        
    </div>

    <button type="submit">Update</button>
</form>
</div>

@endsection