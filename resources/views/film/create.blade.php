@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Add Film</h1>
    <form method="post" action="{{ route('film.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="gener">Gener</label><br>
            @foreach($geners as $gener)
    <!-- Add more genre options as needed -->
    <input type="checkbox" name="gener[]" value="{{ $gener->G_id }}"> {{$gener->name}} <br>
    @endforeach
                <!-- Add more genre options as needed -->
        
        </div>

        <div class="form-group">
            <label for="age_req">Age Required</label>
            <input type="text" name="age_req" class="form-control" required>
        </div>
    
      
        <div class="form-group">
            <label for="image_path">Film Image</label>
            <input type="file" name="image_path" class="form-control-file" required accept="image/*">
        </div>

        <div class="form-group">
            <label for="video_path">Film Video (Trailer)</label>
            <input type="file" name="video_path" class="form-control-file" required accept="video/*">
        </div>
        <div class="form-group">
            <label for="editable">editable</label>
            <input type="text" name="editable" class="form-control" default="no"  required>
        </div>

        <div class="form-group">
            <label for="value_cut">value cut</label>
            <input type="text" name="value_cut" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time_allowed">time allowed </label>
            <input type="number" name="time_allowed" class="form-control" min="1" required>
        </div>
        

      
<div class="form-group">
<label for="duration">Select Duration:</label><br>
<select name="duration" class="form-control" required>
    <option value="01:30">01:30</option>
    <option value="02:00">02:00</option>
    <option value="02:30">02:30</option>
    <option value="02:30">03:00</option>
    <option value="02:30">03:30</option>
    <option value="02:30">04:00</option>
</select>
</div> 



        <div class="form-group">
        <label for="release_date">Select start Dates:</label><br>
            <input type="date" name="release_date" class="form-control" required>
        <button type="submit" class="btn btn-primary">Create Film</button>
    </form> 
    
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
</div>


@endsection