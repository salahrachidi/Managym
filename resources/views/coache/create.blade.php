@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


    <h1>Create New Member</h1>

    <div class="createForm">
        <form action="/coaches" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-4">

                <div class="input-group-prepend">
                    <span class="input-group-text" id="">First and last name</span>
                </div>
                <input type="text" class="form-control @error('coa_nom') is-invalid @enderror" name="coa_nom"
                    value="{{ old('coa_nom') }}" placeholder="Nom">
                <input type="text" class="form-control @error('coa_prenom') is-invalid @enderror" name="coa_prenom"
                    value="{{ old('coa_prenom') }}" placeholder="Prenom">

                @error('coa_nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('coa_prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <div class="input-group-append">
                    <span class="input-group-text">Tele :</span>
                </div>
                <div class="input-group-prepend">
                    <span class="input-group-text">+212</span>
                </div>
                <input type="tel" class="form-control @error('coa_tele') is-invalid @enderror"
                    aria-label="Amount (to the nearest dollar)" name="coa_tele" value="{{ old('coa_tele') }}">

                @error('coa_tele')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="input-group mb-4">
                <input type="email" class="form-control @error('coa_email') is-invalid @enderror" placeholder="Email"
                    aria-label="Recipient's username" aria-describedby="basic-addon2" name="coa_email"
                    value="{{ old('coa_email') }}">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>

                @error('coa_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">IMAGE</span>
                </div>
                <input class="form-control @error('coa_pic') is-invalid @enderror" type="file" id="formFile"
                    name="coa_pic">
                @error('coa_pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Ajouter</button>
        </form>
    </div>
@endsection
