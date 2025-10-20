@extends('templates.dash')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


    <h1>Ajouter une transformation</h1>

    <div class="createForm">
        <form action="/transformations" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-4">
                <div class="form-floating">
                    <textarea class="form-control @error('tra_description') is-invalid @enderror" 
                        id="floatingTextarea" name="tra_description" ></textarea>
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
                <input class="form-control @error('tra_poid') is-invalid @enderror" type="number" id="formFile"
                    name="tra_poid">
                @error('tra_poid')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <div class="input-group-append">
                    <span class="input-group-text">Date de debut de la transformation :</span>
                </div>
                <input type="date" class="form-control @error('Dtra_duree') is-invalid @enderror"
                    aria-label="Amount (to the nearest dollar)" name="Dtra_duree" value="{{ old('Dtra_duree') }}">

                @error('Dtra_duree')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-4">
                <div class="input-group-append">
                    <span class="input-group-text">Date de Fin de la transformation :</span>
                </div>
                <input type="date" class="form-control @error('Ftra_duree') is-invalid @enderror"
                    aria-label="Amount (to the nearest dollar)" name="Ftra_duree" value="{{ old('Ftra_duree') }}">

                @error('Ftra_duree')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Coach encadrement</label>
                </div>
                <select name="coach_id" class="form-select">
                    @forelse ($coaches as $coach)
                        <option value="{{ $coach->id }}"> {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                    @empty
                        <option>
                            <div class="alert alert-danger" style="display:inline;">Aucune enregistrement a afficher !</div>
                        </option>
                    @endforelse
                    <option value="">Auto Encadrement</option>
                </select>
            </div>
            @error('tra_coach')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">transformation de : </label>
                </div>
                <select name="personnel_id" class="form-select">
                    @forelse ($personnels as $per)
                        <option value="{{ $per->id }}"> {{ $per->per_nom . ' ' . $per->per_prenom }} </option>
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
            <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Ajouter</button>
        </form>
    </div>
@endsection
