@extends('layouts.app')

@section('content')
<h1>Edit schedule</h1>

<form method="POST" action="{{ route('show.update', ['SHT_id' => $showtime->SHT_id,'H_id'=>$showtime->H_id]) }}">
    @csrf
    @method('PUT') 
    

    <div class="form-group">
        <label for="start_time">strat time</label>
        <input type="text" name="start_time" value="{{ $showtime->start_time }}">
    </div>

    <div class="form-group">
        <label for="H_id">Hall</label>
        <input type="text" name="H_id" value="{{ $showtime->H_id }}">
    </div>

    <button type="submit">Update</button>
</form>
</div>

@endsection