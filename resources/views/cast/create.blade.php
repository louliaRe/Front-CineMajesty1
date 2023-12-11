@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Cast</h1>
  
    <form method="post" action="{{ route('cast.store',['F_id'=>$filmId]) }}">
        @csrf
        @foreach($casts as $cast)
            <div class="form-group">
                <label>{{ $cast->f_name }} {{ $cast->l_name }}</label>
                <input type="radio" name="cat{{ $cast->CA_id }}" value="dir"> Director
                <input type="radio" name="cat{{ $cast->CA_id }}" value="act"> Actor
                <input type="radio" name="cat{{ $cast->CA_id }}" value="both"> Both
            </div>
        @endforeach
    



        <div id="casts-container">
            <div class="cast-entry">
                <div class="form-group">
                    <label for="f_name">First Name</label>
                    <input type="text" name="casts[0][f_name]" class="form-control" >
                </div>
                <div class="form-group">
                    <label for="l_name">Last Name</label>
                    <input type="text" name="casts[0][l_name]" class="form-control" >
                </div>
                <div class="form-group">
                    <label>Type:</label>
                    <input type="radio" name="casts[0][type]" value="dir"> Director
                    <input type="radio" name="casts[0][type]" value="act"> Actor
                    <input type="radio" name="casts[0][type]" value="both"> Both
                </div>
            </div>
        </div>

        <button type="button" id="add-cast-btn" class="btn btn-primary">Add Cast</button>
        <button type="submit" class="btn btn-primary">Create Cast</button>
    </form>
</div>

@endsection

@section('scripts')
<script>
    window.onload = function() {
        const castsContainer = document.getElementById('casts-container');
        const addCastButton = document.getElementById('add-cast-btn');
        let castsCount = 1;

        addCastButton.addEventListener('click', function(event) {
            event.preventDefault();
            const castEntry = createCastEntry(castsCount);
            castsContainer.appendChild(castEntry);
            castsCount++;
        });

        function createCastEntry(count) {
            const castEntry = document.createElement('div');
            castEntry.className = 'cast-entry';

            const firstNameLabel = document.createElement('label');
            firstNameLabel.htmlFor = `f_name-${count}`;
            firstNameLabel.textContent = 'First Name:';

            const firstNameInput = document.createElement('input');
            firstNameInput.type = 'text';
            firstNameInput.name = `casts[${count}][f_name]`;
            firstNameInput.id = `f_name-${count}`;
            firstNameInput.className = 'form-control';
            firstNameInput.required = true;

            const lastNameLabel = document.createElement('label');
            lastNameLabel.htmlFor = `l_name-${count}`;
            lastNameLabel.textContent = 'Last Name:';

            const lastNameInput = document.createElement('input');
            lastNameInput.type = 'text';
            lastNameInput.name = `casts[${count}][l_name]`;
            lastNameInput.id = `l_name-${count}`;
            lastNameInput.className = 'form-control';
            lastNameInput.required = true;

            const typeLabel = document.createElement('label');
            typeLabel.textContent = 'Type:';

            const directorRadio = document.createElement('input');
            directorRadio.type = 'radio';
            directorRadio.name = `casts[${count}][type]`;
            directorRadio.value = 'dir';

            const directorLabel = document.createElement('label');
            directorLabel.textContent = 'Director';

            const actorRadio = document.createElement('input');
            actorRadio.type = 'radio';
            actorRadio.name = `casts[${count}][type]`;
            actorRadio.value = 'act';

            const actorLabel = document.createElement('label');
            actorLabel.textContent = 'Actor';

            const bothRadio = document.createElement('input');
            bothRadio.type = 'radio';
            bothRadio.name = `casts[${count}][type]`;
            bothRadio.value = 'both';

            const bothLabel = document.createElement('label');
            bothLabel.textContent = 'Both';

            castEntry.appendChild(firstNameLabel);
            castEntry.appendChild(firstNameInput);
            castEntry.appendChild(lastNameLabel);
            castEntry.appendChild(lastNameInput);
            castEntry.appendChild(typeLabel);
            castEntry.appendChild(directorRadio);
            castEntry.appendChild(directorLabel);
            castEntry.appendChild(actorRadio);
            castEntry.appendChild(actorLabel);
            castEntry.appendChild(bothRadio);
            castEntry.appendChild(bothLabel);

            return castEntry;
        }
   };
</script>
@endsection