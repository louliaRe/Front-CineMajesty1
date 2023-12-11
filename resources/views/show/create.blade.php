@extends('layouts.app')


@section('content')

<div class="container">

    <h1>Create Show and Showtime</h1>
    <table>
    <thead>
        <tr>
        <th>Film</th>
            <th>Duration</th>
            <th>Hall</th>
            <th>start</th>              
            <th>end time</th>
            <th>start date</th>
            <th>end date</th>
        </tr>
    </thead>
    @foreach ($results as $result)
    <tr>
        <td>{{ $result->name }}</td>
        <td>{{ $result->duration }}</td>
        <td>{{ $result->H_id }}</td>
        <td>{{ $result->start_time }}</td>
        <td>{{ $result->end_time }}</td>
        <td>{{ $result->start_date }}</td>
        <td>{{ $result->end_date }}</td>
    </tr>
@endforeach
    </tbody></table>

        <form method="post" action="{{ route('show.store') }}">
        @csrf

        <div id="showtimes-container">
            <div class="showtime-entry">
                <div class="form-group">
                <label for="film-select">Select Film:</label>
<select id="film-select" name="F_id" class="film-select">
                        @foreach($films as $film)
                            <option value="{{ $film->F_id }}">{{ $film->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
            <label for="start_date">start Date:</label>
            <input type="date" name="start_date" class="form-control" required>

        </div>
        <div class="form-group">
            <label for="end_date">end Date:</label>
            <input type="date" name="end_date" class="form-control" required>
            
        </div>

                <div class="form-group">
                    <label for="start_time">Start Time:</label>
                    <input type="time" id="start_time" name="showtimes[0][start_time]" class="form-control" required>
                </div>

                <div class="form-group">
                <label for="hall-select">Select Hall:</label>

                <div class="form-group">
    <label for="halls">Halls:</label>
    @foreach ($halls as $hall)
        <input type="checkbox" id="halls" name="showtimes[0][H_id][]" value="{{ $hall->H_id }}">
        {{ $hall->H_id }}-{{ $hall->type->name}}
    @endforeach
</div>


        <button type="button" id="add-showtime-btn" class="btn btn-primary">Add Showtime</button>
        <button type="submit" class="btn btn-primary">Create Show and Showtime</button>
    </form>

</div>


@if (session('error'))
    <div class="alert alert-success">
        {{ session('error') }}
    </div>
@endif
@endsection
@section('scripts')
<script>
    window.onload = function() {
        const showtimesContainer = document.getElementById('showtimes-container');
        const addShowtimeButton = document.getElementById('add-showtime-btn');
        let showtimesCount = 1;

        addShowtimeButton.addEventListener('click', function(event) {
            event.preventDefault();
            const showtimeEntry = createShowtimeEntry(showtimesCount);
            showtimesContainer.appendChild(showtimeEntry);
            showtimesCount++;
        });

        function createShowtimeEntry(count) {
            const showtimeEntry = document.createElement('div');
            showtimeEntry.className = 'showtime-entry';

            // Populate the film select with available films

            const startTimeLabel = document.createElement('label');
            startTimeLabel.htmlFor = `start_time-${count}`;
            startTimeLabel.textContent = 'Start Time:';

            const startTimeInput = document.createElement('input');
            startTimeInput.type = 'time';
            startTimeInput.name = `showtimes[${count}][start_time]`;
            startTimeInput.id = `start_time-${count}`;
            startTimeInput.className = 'form-control';
            startTimeInput.required = true;

            const hallLabel = document.createElement('label');
            hallLabel.htmlFor = `hall-select-${count}`;
            hallLabel.textContent = 'Select Hall:';

            const hallSelect = document.createElement('div');
            hallSelect.className = 'form-group';

            // Populate the hall select with available halls
            const halls = {!! json_encode($halls) !!};
            halls.forEach(function(hall) {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = `showtimes[${count}][H_id][]`;
                checkbox.value = hall.H_id;
                checkbox.id = `hall-${count}-${hall.H_id}`;

                const label = document.createElement('label');
                label.htmlFor = `hall-${count}-${hall.H_id}`;
                label.textContent = `${hall.H_id} - ${hall.type.name}`;

                hallSelect.appendChild(checkbox);
                hallSelect.appendChild(label);
            });

            showtimeEntry.appendChild(startTimeLabel);
            showtimeEntry.appendChild(startTimeInput);
            showtimeEntry.appendChild(hallLabel);
            showtimeEntry.appendChild(hallSelect);
           

            return showtimeEntry;
        }
    };
</script>
@endsection