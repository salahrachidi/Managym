<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/loginPage.css') }}" />
</head>

<body>
    {{-- _________________________________________________________________________ALERTS --}}
    @if (session()->has('logErrorPass'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto;float:initial;">
            <i class="bi bi-check-circle"></i>&nbsp;{{ session('logErrorPass') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('registred'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            <i class="bi bi-check-circle"></i>&nbsp;{{ session('registred') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- _________________________________________________________________________ALERTS --}}
    {{-- <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <h4 class="card-header">Login</h4>
            <div class="card-body">
                <form action="{{}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="Votre email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="password" placeholder="Votre password" value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary">Login !</button><br>

                </form>
            </div>
        </div>
    </div> --}}

    <div class="wrapper fadeInDown">


        <div id="formContent">

            <!-- Tabs Titles -->
            <!-- Icon -->
            <div class="fadeIn first" style="padding: 30px;">
                {{-- <img src="{{ asset('images/logo/logo.png') }}" id="icon" alt="User Icon" style="width: 30px; " /> --}}
                <img src="{{ asset('images/HomePage/Design.png') }}" class="site-logo" alt="logo" style="width: 80px; ">
            </div>
            <!-- Login Form -->
            <form action="{{ '/Plogin' }}" method="POST">
                @csrf
                <input type="email" id="login" class="fadeIn second" name="email" placeholder="login">
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="password"
                    id="password"><br>
                {{-- <button type="button" id="toggleButton" class="btn  btn-secondary"
                    style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%); z-index: 1;"
                    onclick="togglePasswordVisibility()"><i class="bi bi-eye-fill"></i> </button>
                <input type="submit" class="fadeIn fourth mt-3 mb-3" value="Log In"> --}}
                <div class="mt-3 mb-1" onclick="togglePasswordVisibility()">
                    <input class="form-check-input " type="checkbox" value="" id="flexCheckChecked">
                    <label class="form-check-label " for="flexCheckChecked">
                        Show Password
                    </label>
                </div>
                <input type="submit" class="fadeIn fourth mt-3 mb-3" value="Log In">
                
            </form>
            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
                <p><a href="/register" class="underlineHover">don't have an account ?</a></p>
                @if (session()->has('error'))
                    <div style="width: 100%; text-align: center;margin: auto">
                        <span class="badge text-bg-danger">&nbsp;&nbsp;{{ session('error') }}&nbsp;&nbsp;</span>
                    </div>
                @endif
            </div>

        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleButton = document.getElementById("toggleButton");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";

            } else {
                passwordInput.type = "password";

            }
        }
    </script>

</body>

</html>
