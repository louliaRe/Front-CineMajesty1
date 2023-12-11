@extends('layouts.app')

@section('content')

<form method="post" action="{{ route('wallet.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="address">address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="PIN">PIN</label>
            <input type="text" name="PIN" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Wallet</button>
    </form>

@endsection