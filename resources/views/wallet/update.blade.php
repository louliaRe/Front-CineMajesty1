@extends('layouts.app')

@section('content')
<h1>Edit wallet</h1>

<form method="POST" action="{{ route('wallet.update', ['id' => $wallet->EW_id]) }}">
    @csrf
    @method('PUT') 
    

    <div class="form-group">
        <label for="amount">amount</label>
        <input type="text" name="amount" value="{{ $wallet->amount }}">
    </div>

    <button type="submit">Update</button>
</form>
</div>
@endsection