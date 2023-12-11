@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Hey Admin') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as an Admin!') }}
                    
                </div>
            </div>
        </div>
    </div>
</div>



<button>
    Add Employee 
</button>

<button>
    delete Employee 
</button>


<button>
    Add manager 
</button>


<button>
    Add Hall 
</button>



@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif
@endsection
