@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <style>
        .action {
            margin-top: 10px;
            background-color: #dfa97a;
            /* Green */
            border: none;
            color: #151917;
            padding: 5px 8px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .action:hover {
            color: #151917;
            background-color: #e3e2e2;
            border-radius: 5px;
        }

        .card:first-child {
            border-left: 7px solid #dfa97a;
        }

        .bg-dark {
            background-color: red
        }

        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 0.2rem #dfa97a;
        }

        .form-select:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 0.2rem #dfa97a;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            margin-top: 10px;
        }
    </style>


    <h1>Create New Admin</h1>
    <br>
    <div class="container">
        <div class="row card text-white" style="background-color: #151917">
            <h4 class="card-header">Hello Admin</h4>
            <div class="card-body">
                <form action="{{ route('storeAdmin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder=" name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder=" email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder=" password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn action">create !</button>
                </form>
            </div>
        </div>
    </div>
@endsection
