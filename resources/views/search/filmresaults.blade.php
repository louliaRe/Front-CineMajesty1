@extends('layouts.app')

@section('content')<h1>Search Results</h1>

@if ($searchType === 'films')
    <h2>Films</h2>
    <ul>
        @forelse ($results as $result)
            <li>
                {{ $result->name }} {{-- Fixed the variable name here --}}
            </li>
        @empty
            <p>No movies found</p>
        @endforelse
    </ul>
@elseif ($searchType === 'casts')
    <h2>Actors</h2>
    <ul>
        @forelse ($results as $result)
            <li>
                {{ $result->f_name }} {{ $result->l_name }}
            </li>
        @empty
            <p>No actors found</p>
        @endforelse
    </ul>
@endif

@endsection
