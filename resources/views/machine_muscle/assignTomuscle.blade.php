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


    <h1>Assign machine to muscles</h1>
    {{-- <div class="createForm">
        <form action="/mac_muss/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('images/machines/' . $machine->mac_pic) }}" alt="image" class=" card-img-top">
                <div class="card-body">
                    <h4>{{ $machine->mac_label }}</h4>
                    <span style="font-weight:bold;">description :</span>
                    <p>{{ $machine->mac_description }}</p><br><br><br>
                    <select class="form-select" aria-label="Default select example" multiple name="machines[]">
                        <option disabled value="{{ null }}">Muscles</option>
                        @forelse($muscles as $muscle)
                            <option value="{{ $muscle->id }}">{{ $muscle->mus_label }}</option>
                        @empty
                            <option value="">
                                <p class="text-danger">No rencords to show ! </p>
                            </option>
                        @endforelse
                    </select>
                </div>
            </div>
            <input type="hidden" name="machine_id" value="{{ $machine->id }}">
            <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Assign</button>
        </form>
    </div> --}}
    <div class="main">
        <form action="/mus_macs/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('images/machines/' . $machine->mac_pic) }}" alt="image" class=" card-img-top">
                <div class="card-body">
                    <h4 class="mt-2">{{ $machine->mac_label }}</h4>
                    <p class="mt-2">{{ $machine->mac_description }}</p>
                    <select class="form-select mt-3" aria-label="Default select example" multiple name="machines[]">
                        <option disabled value="{{ null }}">Muscles</option>
                        @forelse($muscles as $muscle)
                            <option value="{{ $muscle->id }}">{{ $muscle->mus_label }}</option>
                        @empty
                            <option value="">
                                <p class="text-danger">No rencords to show ! </p>
                            </option>
                        @endforelse
                    </select>
                </div>
                <input type="hidden" name="muscle_id" value="{{ $machine->id }}">
                <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mt-3">Assign</button>
            </div>
        </form>
    </div>
@endsection
