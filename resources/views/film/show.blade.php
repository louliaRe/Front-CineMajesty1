@extends('layouts.app')

@section('content')
<h1>{{$film->name }}</h1>


    <!-- Display movie images -->
   
    <img src="{{ asset('storage/' . $film->image_path) }}" alt="{{ $film->name }} Image" >
    <br>
    <video controls width="320" height="240">
        <source src="{{ asset('storage/' . $film->video_path) }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
        <br>
       
      
   
<!-- Display movie videos -->

@foreach($casts as $cast)
       {{$cast->f_name}}   {{$cast->l_name}} <br>
       
        @endforeach
        @foreach($shows as $show)
<a href="{{route('booking.show',['SHT_id'=>$show->SHT_id,'H_id'=>$show->H_id,'age'=>$age])}}">
  {{$show->start_time}} {{$show->start_date}} {{$show->H_id}} {{$show->T_name}}{{$show->SHT_id}}</a><br>
  @endforeach
  
<form action="{{route('rate.film',['F_id'=>$film->F_id])}}"method="POST">
    @csrf
<label for="rate">Rate us:</label>
<input type="radio" name="rate" value="1">
<input type="radio" name="rate" value="2">
<input type="radio" name="rate" value="3">
<input type="radio" name="rate" value="4">
<button type="submit">rate</button>
</form>
<form action="{{route('comment.store',['F_id'=>$film->F_id])}}" method="POST">
    @csrf 
    <input type="text" name="comment" class="form-control" >
<button type="submit">comment</button>

</form>
 
@foreach($comments as $comment)
{{$comment->comments}} <br>
@endforeach
@endsection