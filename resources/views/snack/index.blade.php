@extends('layouts.app')

@section('content')

@foreach ($snacks as $snack)
<div>
    <p>
     <a href="{{route('snack.show',['id'=>$snack->S_id])}}">
         {{ $snack->name }}</a>   - {{$snack->price}} - {{$snack->qty}}
    </p>
    <div>  <img src="{{ asset('storage/' . $snack->image_path) }}" alt="{{ $snack->name }} Image"></div>

<form method="POST" action="{{ route('snack.delete', ['id' => $snack->S_id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
</div>
 @endforeach
 
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif

 
@endsection