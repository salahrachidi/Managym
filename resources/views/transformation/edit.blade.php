@extends('templates.dash')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


<h1>Modifier une transformation</h1>

<div class="createForm">
    <form action="/transformations/{{ $tran->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="input-group mb-4">
            <div class="form-floating">
                <textarea class="form-control @error('tra_description') is-invalid @enderror"
                    placeholder="Leave a comment here" id="floatingTextarea" name="tra_description">{{ $tran->tra_description }}</textarea>
                <label for="floatingTextarea" name="tra_description">Description de la transformation</label>
            </div>
            @error('tra_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text">Photo :</span>
            </div>
            <input class="form-control @error('tra_pic1') is-invalid @enderror" type="file" id="formFile"
                name="tra_pic1">
            @error('tra_pic1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text">Poid :</span>
            </div>
            <input class="form-control @error('tra_poid') is-invalid @enderror" type="numeric" id="formFile"
                name="tra_poid" value="{{ $tran->tra_poid }}">
            @error('tra_poid')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">
            <div class="input-group-append">
                <span class="input-group-text">Duree de la transformation :</span>
            </div>
            <input type="number" class="form-control @error('tra_duree') is-invalid @enderror"
                aria-label="Amount (to the nearest dollar)" name="tra_duree"
                value="{{ $tran->tra_duree }}">

            @error('tra_duree')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Coach encadrement</label>
            </div>
            <select name="coach_id" class="form-select">
                @forelse($coaches as $coach)
                    <option value="{{ $coach->id }}" {{ $coach->id == $tran->coach_id ?'selected' :'' }}>
                        {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                @empty
                    <option>
                        <div class="alert alert-danger" style="display:inline;">Aucune enregistrement a afficher !</div>
                    </option>
                @endforelse
                <option value="" {{ 0 == $tran->coach_id ?'selected' :'' }} >Auto Encadrement</option>
            </select>
        </div>
        @error('tra_coach')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Membre : </label>
            </div>
            <select name="personnel_id" class="form-select">
                @forelse($personnels as $per)
                    <option value="{{ $per->id }}" {{ $per->id == $tran->personnel_id ?'selected' :'' }} >
                        {{ $per->per_nom . ' ' . $per->per_prenom }} </option>
                @empty
                    <option>
                        <div class="alert alert-danger" style="display:inline;">Aucune enregistrement a afficher !</div>
                    </option>
                @endforelse
            </select>
        </div>
        @error('personnel_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        {{-- for image logic --}}
        <input type="hidden" value="{{ $photo1 }}" name="OldPhoto1">
        <input type="hidden" value="{{ $photo2 }}" name="OldPhoto2">

        {{-- for image logic --}}
        <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Modifier</button>
    </form>
</div>
@endsection
