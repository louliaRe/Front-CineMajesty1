@extends('layouts.app')

@section('content')
<form action="{{route('search.resaults')}}" method="GET">
    <input type="text" name="query" placeholder="Search">
    <input type="radio" name="search_type" value="films" > Films
    <input type="radio" name="search_type" value="casts"> Actors
    <button type="submit">Search</button>
</form> 



<form action="{{ route('film.filter') }}" method="get">
    <label for="genre">Select a Genre:</label>
   <select name="genre" id="genre">
      @foreach($geners as $gener)
    <!-- Add more genre options as needed -->
    <option value="{{$gener->name}}">{{$gener->name}}</option>
    @endforeach
</select>


<button type="submit">Filter</button>
</form>

<form action="{{route('rate.app')}}"method="POST">
    @csrf
<label for="rate">Rate us:</label>
<input type="radio" name="rate" value="1">
<input type="radio" name="rate" value="2">
<input type="radio" name="rate" value="3">
<input type="radio" name="rate" value="4">
<button type="submit">rate</button>
</form>
@foreach ($films as $film)
    <p>
        {{ $film->name }}
    </p>

    <!-- Display movie images -->
    <h3>Images</h3>
@foreach ($film->Images as $image)
<a href="{{ route('film.show', ['id' => $film->F_id]) }}">
    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $film->name }} Image">
</a>
   
@endforeach

<!-- Display movie videos -->

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
@if(Session::has('booking_success'))
    <div class="alert alert-success">
        {{ Session::get('booking_success') }}
    </div>
@endif

@if(Session::has('booking_error'))
    <div class="alert alert-danger">
        {{ Session::get('booking_error') }}
    </div>
@endif
<!-- <script>
  // Select the file input, form, and progress bar elements
  var movieInput = document.getElementById('movie-input');
  var uploadForm = document.getElementById('upload-form');
  var progressBar = document.querySelector('.progress-bar');

  // Add an event listener to the form when it is submitted
  uploadForm.addEventListener('submit', function (event) {
    // Check if the file input has a selected file
    if (movieInput.files.length === 0) {
      return; // No file selected, exit the function
    }

    event.preventDefault(); // Prevent the default form submission

    var file = movieInput.files[0];
    var formData = new FormData();
    formData.append('movie', file);

    var xhr = new XMLHttpRequest();

    // Track the upload progress
    xhr.upload.addEventListener('progress', function (event) {
      if (event.lengthComputable) {
        var percentComplete = (event.loaded / event.total) * 100;
        progressBar.style.width = percentComplete + '%';
        progressBar.innerHTML = percentComplete.toFixed(2) + '%';
      }
    });

    // Handle the upload completion
    xhr.addEventListener('load', function () {
      // File upload completed
      progressBar.style.width = '100%';
      progressBar.innerHTML = '100%';

      // Submit the form after the upload is complete
      uploadForm.submit();
    });

    // Handle the upload error
    xhr.addEventListener('error', function () {
      // File upload failed
      progressBar.innerHTML = 'Error occurred';
      progressBar.classList.add('progress-bar-danger');
    });

    // Set up the request to upload the file
    xhr.open('POST', uploadForm.getAttribute('action'), true);
    xhr.send(formData);
  });
</script> -->
@endsection