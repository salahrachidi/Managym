@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />
    <style>
        .main {
            width: 100%;
            /* border: 1px solid red; */
            padding: 10px 100px 10px;
            display: flex;
            justify-content: center;

        }

        .card:nth-child(2) {
            border-left: 7px solid #dfa97a;
            border-radius: 5px;
        }

        h4 {
            text-align: center
        }
    </style>


    <h1>Assign muscle to machines</h1>


    <div class="main">
        <form action="/mus_macs/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('images/muscles/' . $muscle->mus_pic) }}" alt="image" class=" card-img-top">
                <div class="card-body">
                    <h4 class="mt-2">{{ $muscle->mus_label }}</h4>
                    <select class="form-select mt-3" aria-label="Default select example" multiple name="machines[]">
                        <option disabled value="{{ null }}">Machines</option>
                        @forelse ($machines as $machine)
                            <option value="{{ $machine->id }}">{{ $machine->mac_label }}</option>
                        @empty
                            <option value="">
                                <p class="text-danger">No rencords to show ! </p>
                            </option>
                        @endforelse
                    </select>
                </div>
                <input type="hidden" name="muscle_id" value="{{ $muscle->id }}">
                <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mt-3">Assign</button>
            </div>

        </form>
    </div>
@endsection
