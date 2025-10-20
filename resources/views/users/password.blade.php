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
            <button class="btn btn-primary" id="imgBtn" onClick="location.href='/profile/account'">
                <i class="fa fa-image text-center mr-1"></i>upload new image
            </button>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .passDiv {
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0px -2px 6px -3px rgba(0, 0, 0, 0.52);
            -webkit-box-shadow: 0px -2px 6px -3px rgba(0, 0, 0, 0.52);
            -moz-box-shadow: 0px -2px 6px -3px rgba(0, 0, 0, 0.52);
        }
    </style>


    <div class="tab-content p-4 p-md-5">




        <div class="alert alert-light text-center text-dark mt-0" role="alert" style="background-color: rgba(231, 255, 196, 0.469)">
            <h4>Password Settings :</h4>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <div class="passDiv">
            <form action="{{ route('update-password') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="oldPasswordInput">Old password</label>
                            <input name="old_password" type="password"
                                class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput">
                        </div>
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="newPasswordInput">New password</label>
                            <input name="new_password" type="password"
                                class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput">
                        </div>
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmNewPasswordInput">Confirm new password</label>
                            <input name="new_password_confirmation" type="password" class="form-control"
                                id="confirmNewPasswordInput">
                        </div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
