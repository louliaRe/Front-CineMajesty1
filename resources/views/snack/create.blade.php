@extends('layouts.app')

@section('content')

<form method="post" action="{{ route('snack.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="text" name="price" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="qty">Quantity</label>
        <input type="text" name="qty" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="limit">Limit wanted</label>
        <input type="text" name="limit" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="CAT_id">Category</label>
        @foreach($categories as $category)
        <input type="radio" name="CAT_id" value="{{$category->CAT_id}}">{{$category->name}}
        @endforeach
    </div>

    <div class="form-group">
        <label for="c_name">Or Add your snack's Category</label>
        <input type="text" name="c_name" class="form-control">
    </div>

    <div class="form-group">
        <label for="image_path">Snack Image</label>
        <input type="file" name="image_path" class="form-control-file" required accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Create Snack</button>
</form>

@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif

@endsection