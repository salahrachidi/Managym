<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</head>

<body>
    <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <h4 class="card-header">Register</h4>
            <div class="card-body">
                <form action="{{ 'Pregister' }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Nom</label>
                        <input type="text" class="form-control @error('per_nom') is-invalid @enderror" name="per_nom"
                            id="per_nom" placeholder="Votre nom" value="{{ old('per_nom') }}">
                        @error('per_nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Prenom</label>
                        <input type="text" class="form-control @error('per_prenom') is-invalid @enderror"
                            name="per_prenom" id="per_prenom" placeholder="Votre prenom"
                            value="{{ old('per_prenom') }}">
                        @error('per_prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Numero de telephone</label>
                        <input type="tel" class="form-control @error('per_tel') is-invalid @enderror" name="per_tel"
                        id="per_tel" placeholder="Votre numero de telephone" value="{{ old('per_tel') }}">
                        @error('per_tel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Sexe</label>
                        <select class="form-select form-control" aria-label="multiple select example" name="per_sexe">
                            <option selected value="{{ null }}">Open this select menu</option>
                            <option value="H" {{ old('per_sexe') == 'H' ? 'selected' : '' }} >Homme</option>
                            <option value="F" {{ old('per_sexe') == 'F' ? 'selected' : '' }} >Femme</option>
                        </select>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Email</label>
                        <input type="text" class="form-control @error('per_email') is-invalid @enderror"
                            name="per_email" id="per_email" placeholder="Votre email" value="{{ old('per_email') }}">
                        @error('per_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- ******************************************** --}}
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Photo de profile</label>
                        <input class="form-control @error('per_pic') is-invalid @enderror" type="file" id="per_pic" name="per_pic">
                    </div>
                    {{-- ******************************************** --}}
                    <div class="col-md-6">
                        <label>Packages</label>
                        <select class="form-select form-control"  aria-label="multiple select example"
                            name="package_id">
                            <option selected value="{{ null }}" >Open this select menu</option>
                            @forelse ($packages as $pack)
                                <option value="{{ $pack->id }}" {{ old('package_id') ==$pack->id ? 'selected' : '' }} >{{ $pack->pac_title }}</option>
                            @empty
                                <option value="{{ null }}"  ><p class="text-danger" >NO records to display !</p></option>
                            @endforelse
                        </select>
                    </div>
                <div class="col-md-6">
                    <label>Coaches</label>
                    <select class="form-select form-control"  aria-label="multiple select example" name="coach_id">
                        <option selected value="{{ null }}" >Open this select menu</option>
                        @forelse ($coaches as $coach)
                            <option value="{{ $coach->id }}" {{ $coach->id == old('coach_id')? 'selected' : '' }} >{{ $coach->coa_nom.' '.$coach->coa_prenom }}</option>
                        @empty
                            <option value="{{ null }}"  ><p class="text-danger" >NO records to display !</p></option>
                        @endforelse
                    </select>
                </div>
                <br>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Password</label>
                        <input type="password" class="form-control @error('per_password') is-invalid @enderror"
                            name="password" id="per_password" placeholder="Votre mot de passe" >
                        @error('per_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Password confirmation</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" id="password_confirmation" placeholder="Votre password confirmation" >
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary">Sign Up !</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
