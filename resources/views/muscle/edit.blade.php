@extends('templates.dash')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


<h1>Edit a muscle</h1>

<div class="createForm">
    <form action="/muscles/{{ $muscle->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="input-group mb-4">

            <div class="input-group-prepend">
                <span class="input-group-text" id="">muscle name</span>
            </div>
            <input type="text" class="form-control @error('mus_label') is-invalid @enderror" name="mus_label"
                value="{{ $muscle->mus_label }}" placeholder="name">
            @error('mus_label')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text">IMAGE</span>
            </div>
            <input class="form-control @error('mus_pic') is-invalid @enderror" type="file" id="formFile" name="mus_pic">
            @error('mus_pic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="old_photo" value="{{ $old_photo }}">
        <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Edit</button>
    </form>
</div>
@endsection
