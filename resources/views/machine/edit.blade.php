@extends('templates.dash')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


<h1>Edit a Machine</h1>

<div class="createForm">
    <form action="/machines/{{ $machine->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">Machine name</span>
            </div>
            <input type="text" class="form-control @error('mac_label') is-invalid @enderror" name="mac_label"
                value="{{ $machine->mac_label }}" placeholder="libelle">
            @error('mac_label')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">Machine description</span>
            </div>
            <input type="text" class="form-control @error('mac_description') is-invalid @enderror"
                name="mac_description" value="{{ $machine->mac_description }}" placeholder="description">
            @error('mac_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">First and last name</span>
            </div>
            <input type="text" class="form-control @error('mac_matricule') is-invalid @enderror" name="mac_matricule"
                value="{{ $machine->mac_matricule }}" placeholder="matricule">
            @error('mac_matricule')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text">IMAGE</span>
            </div>
            <input class="form-control @error('mac_pic') is-invalid @enderror" type="file" id="formFile" name="mac_pic">
            @error('mac_pic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="oldPhoto" value="{{ $oldPhoto }}">
        <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Edit</button>
    </form>
</div>
@endsection
