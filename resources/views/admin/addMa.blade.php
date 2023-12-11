@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create Manager</h1>
    <form method="post" action="{{ route('manager.store') }}">
        @csrf
        <div class="form-group">
            <label for="f_name">First Name</label>
            <input type="text" name="f_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="l_name">Last Name</label>
            <input type="text" name="l_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Manager</button>
    </form>
</div>








@endsection
