@extends('layouts.app')

@section('content')
@foreach ($films as $film)
    <p>
        Film Name: {{ $film->name }}
        <br>
        Genres:
        @foreach ($film->genres as $genre)
            {{ $genre->name }}
        @endforeach
    </p>
@endforeach
@endsection