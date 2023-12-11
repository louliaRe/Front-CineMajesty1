@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Hey Employee') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in as an Employee!') }}
                    
                </div>
            </div>
        </div>
    </div>
</div>



<button>
    Add film 
</button>



<button>
    edit film 
</button>


<button>
    delete film 
</button>



<button>
    create copons 
</button>


@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@endsection
