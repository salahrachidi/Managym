@extends('templates.dash')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


<h1>Create New package</h1>

<div class="createForm">
    <form action="/packages" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-4">

            <div class="input-group-prepend">
                <span class="input-group-text" id="">titre de package</span>
            </div>
            <input type="text" class="form-control @error('pac_title') is-invalid @enderror" name="pac_title"
                value="{{ old('pac_title') }}" placeholder="titre">

            @error('pac_title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">

            <div class="input-group-prepend">
                <span class="input-group-text" id="">description de package</span>
            </div>
            <input type="text" class="form-control @error('pac_description') is-invalid @enderror" name="pac_description"
                value="{{ old('pac_description') }}" placeholder="description">

            @error('pac_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">

            <div class="input-group-prepend">
                <span class="input-group-text" id="">prix de package</span>
            </div>
            <input type="number" class="form-control @error('pac_prix') is-invalid @enderror" name="pac_prix"
                value="{{ old('pac_prix') }}" placeholder="prix">

            @error('pac_prix')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Ajouter</button>
    </form>
</div>
@endsection
