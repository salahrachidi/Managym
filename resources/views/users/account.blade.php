@extends('templates.userAcc')
@section('imgZone')
    <div class="p-4">
        <div class="img-circle text-center mb-3">
            @if ($user->per_pic)
                <img src="{{ asset('images/profiles/' . $user->per_pic) }}" alt="Image" class="shadow">
            @else
                <minidenticon-svg username="{{ $user->per_nom .' '. $user->per_prenom}}"></minidenticon-svg>
            @endif
        </div>
        <h4 class="text-center">{{ $user->per_nom }} {{ $user->per_prenom }}</h4>
        <div style=" margin: auto; width: 180px;">
            <button class="btn btn-primary" id="imgBtn" onClick="location.href='account'">
                <i class="fa fa-image text-center mr-1"></i>upload new image
            </button>
        </div>
    </div>
@endsection
@section('content')
    <style>
        /* Hide the default file input */
        .file-input {
            display: none;
        }

        /* Style the button */
        .file-input-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #337ab7;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>



    <div class="tab-content p-4 p-md-5">
        <form action="{{ route('updateUser', $user->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateUpdateProfileInfos()" >
            @csrf

            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                <div class="alert alert-light text-center text-dark mt-0" role="alert">
                    <h4>Account Settings :</h4>
                </div>

                <div class="img-circle text-start mb-3 text-center">
                    {{-- <img src="{{ asset('images/profiles/' . $user->per_pic) }}" alt="Image" class="shadow"> --}}
                    @if ($user->per_pic)
                        <img src="{{ asset('images/profiles/' . $user->per_pic) }}" alt="Image" class="shadow">
                    @else
                        <div style="width:100px;height:100px;" class="mx-auto" >
                            <minidenticon-svg username="{{ $user->per_nom .' '. $user->per_prenom}}"></minidenticon-svg>
                        </div>
                    @endif
                    <div style="width: 180px; margin: auto" class="mt-2">
                        <label for="file-input" class="file-input-label" class="btn btn-primary" id="imgBtn">upload new
                            image</label>
                        <input class="file-input btn btn-primary" type="file" name="per_pic" id="file-input">
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control @error('per_sexe') is-invalid @enderror" name="per_prenom"
                            value="{{ $user->per_prenom }}" id='Fn'>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control @error('per_sexe') is-invalid @enderror" name="per_nom"
                            value="{{ $user->per_nom }}" id='Ln'>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control @error('per_sexe') is-invalid @enderror" name="per_email"
                            value="{{ $user->per_email }}" id='Email'>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone number</label>
                        <input type="tel" class="form-control @error('per_sexe') is-invalid @enderror" name="per_tel"
                            value="{{ $user->per_tel }}" id='Fnum'>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Packages</label>
                    <select class="form-select form-control @error('per_sexe') is-invalid @enderror"
                        aria-label="multiple select example" name="package_id" id='pack'>
                        <option selected value="{{ null }}">Open this select menu</option>
                        @forelse ($packages as $pack)
                            <option value="{{ $pack->id }}" {{ $user->package->id == $pack->id ? 'selected' : '' }}>
                                {{ $pack->pac_title }}</option>
                        @empty
                            <option value="{{ null }}">
                                <p class="text-danger">NO records to display !</p>
                            </option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Coaches</label>
                    <select class="form-select form-control @error('coach_id') is-invalid @enderror"
                        aria-label="multiple select example" name="coach_id" id='coach'>
                        <option selected value="{{ null }}">Open this select menu</option>
                        @forelse ($coachs as $coa)
                            <option value="{{ $coa->coa_nom }}" {{ $coa->id == $user->coach_id ? 'selected' : '' }}> {{ $coa->coa_nom . ' ' . $coa->coa_prenom }}</option>
                        @empty
                            <option value="{{ null }}">
                                <p class="text-danger">NO records to display !</p>
                            </option>
                        @endforelse
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Sexe</label>
                    <select class="form-select form-control @error('per_sexe') is-invalid @enderror "
                        aria-label="multiple select example" name="per_sexe" id='sexe'>
                        <option selected value="{{ null }}">Open this select menu</option>
                        <option value="H" {{ $user->per_sexe == 'H' ? 'selected' : '' }}>Homme</option>
                        <option value="F" {{ $user->per_sexe == 'F' ? 'selected' : '' }}>Femme</option>
                    </select>
                </div>
                <input type="hidden" name="Old_per_pic" value="{{ $user->per_pic }}">

            </div>
            <br>
            <div>
                <button class="btn btn-primary" type="submit" >Update</button>
                <button class="btn btn-light">Cancel</button>
            </div>
        </div>

    </form>






    <script>
        function validateEmail(email) {
            var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return pattern.test(email);
        }
        function PhoneNumberValidating(phone){
            var pattern = /^(?:\+|00)?212[ -]?[67]\d{8}$|^(?:06|07)\d{8}$/;
            return pattern.test(phone);
        }
        function validateUpdateProfileInfos(){
                        //form validation stuff
                var valid = true;
            var First_name = document.getElementById('Fn').value;
            if (First_name == '' || (First_name.length >= 15 && First_name.length <= 4)) {
                alert('first name field must be between 4 and 15 characters ');
                valid = false;
            }

            var Last_name = document.getElementById('Ln').value;
            if (Last_name == '' || ( First_name.length >= 15 && First_name.length <= 4)) {
                alert('last name field must be between 4 and 15 characters ');
                valid = false;
            }

            var Email = document.getElementById('Email').value;
            if(validateEmail(Email) == false  || Email.length == 0){
                alert('Email adresse not valid ! ');
                valid = false;
            }

            // var Phone = document.getElementById('Fnum').value;
            // if( ! PhoneNumberValidating(Phone) ){
            //     alert('Phone number is not valid !');
            //     valid = false;
            // }

            var Packages = document.getElementById('pack').value;
            if(Packages === "" ){
                alert('you must select a package !');
                valid = false;
            }

            var Coaches = document.getElementById('coach').value;
            var Sexe = document.getElementById('sexe').value;
            if(Sexe === "" ){
                alert('please enter your sexe !');
                valid = false;
            }
            return valid;
        }

    </script>
@endsection
