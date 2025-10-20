@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />


    <h1>Modifier membre</h1>

    <div class="createForm">
        <form action="/members/{{ $member->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="input-group mb-4">

                <div class="input-group-prepend">
                    <span class="input-group-text" id="">First and last name</span>
                </div>
                <input type="text" class="form-control @error('per_nom') is-invalid @enderror" name="per_nom"
                    value="{{ $member->per_nom }}" placeholder="Nom">
                <input type="text" class="form-control @error('per_prenom') is-invalid @enderror" name="per_prenom"
                    value="{{ $member->per_prenom }}" placeholder="Prenom">

                @error('per_nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('per_prenom')
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
                <input type="tel" class="form-control @error('per_tel') is-invalid @enderror"
                    aria-label="Amount (to the nearest dollar)" name="per_tel" value="{{ $member->per_tel }}">

                @error('per_tel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            {{-- ******************************************Sexe --}}
            <div class=" mb-4">
                <i>sexe :</i>
                <input class="form-check-input" type="radio" name="per_sexe" id="per_sexe1" checked value="1">
                <label class="form-check-label" for="per_sexe">
                    Homme
                </label>

                <input class="form-check-input" type="radio" name="per_sexe" id="per_sexe2" value="0">
                <label class="form-check-label" for="per_sexe">
                    Femme
                </label>
            </div>

            @error('per_sexe')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            {{-- ******************************************Sexe --}}



            <div class="input-group mb-4">
                <input type="email" class="form-control @error('per_email') is-invalid @enderror" placeholder="Email"
                    aria-label="Recipient's username" aria-describedby="basic-addon2" name="per_email"
                    value="{{ $member->per_email }}">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">@example.com</span>
                </div>

                @error('per_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Password</span>
                </div>
                <input type="password" class="form-control @error('per_password') is-invalid @enderror"
                    aria-label="Amount (to the nearest dollar)" name="per_password" value="{{ $member->per_password }}">

                @error('per_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">IMAGE</span>
                </div>
                <input class="form-control @error('per_pic') is-invalid @enderror" type="file" id="formFile"
                    name="per_pic">
                @error('per_pic')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="per_status">Status :</label>
                </div>
                <select name="per_status" class="form-select">
                    <option value="1">Payee</option>
                    <option value="0">non Payee</option>
                </select>
            </div>
            @error('per_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">packages</label>
                </div>
                <select name="package_id" class="form-select">
                    @foreach ($packages as $pack)
                        <option value="{{ $pack->id }}"{{ $pack->id == $member->package_id ? 'selected' : '' }}>
                            {{ $pack->pac_description }} </option>
                    @endforeach

                </select>
            </div>

            <div class="input-group mb-5">
                <label class="input-group-text" for="inputGroupSelect02">Coach</label>
                <select name="coach_id" class="form-select">
                    @foreach ($coaches as $coach)
                        <option value="{{ $coach->id }}" {{ $coach->id == $member->coach_id ? 'selected' : '' }}>
                            {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                    @endforeach
                </select>
                <div class="input-group-append">
                </div>
            </div>
            <input type="hidden" name="photo1" value="{{ $photo1 }}">
            <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Modifier Member</button>
        </form>
    </div>
@endsection
