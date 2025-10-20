@extends('templates.userAcc')
@section('imgZone')
    <div class="p-4">
        <div class="img-circle text-center mb-3">
            @if ($user->per_pic)
                <img src="{{ asset('images/profiles/' . $user->per_pic) }}" alt="Image" class="shadow">
            @else
                <minidenticon-svg username="{{ $user->per_nom . ' ' . $user->per_prenom }}"></minidenticon-svg>
            @endif
        </div>
        <h4 class="text-center">{{ $user->per_nom }} {{ $user->per_prenom }}</h4>
        <div style=" margin: auto; width: 180px;">
            <a class="btn btn-primary" id="imgBtn" href="/profile/account">
                <i class="fa fa-image text-center mr-1"></i>upload new image
            </a>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .custom-select:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 0.2rem #dfa97a;
        }

        .card-group {
            margin-bottom: 20px;
            /* Add margin at the bottom of each card group */
            margin-top: 20px;
            /* Add margin at the bottom of each card group */
        }

        .card {
            margin-bottom: 10px;
            /* Add margin at the bottom of each card */
            margin-top: 10px;
            /* Add margin at the bottom of each card */
        }
    </style>


    <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
        <div class="alert alert-light text-center text-dark mt-0" role="alert" style="background-color: rgba(231, 255, 196, 0.469)">
            <h4>Your transformations :</h4>
        </div>

        <div style="width: 100%;" class="container">
            <button type="button" class="btn btn-primary mb-4 mx-auto d-block"data-toggle="modal"
                data-target="#exampleModal" data-whatever="@mdo">Add new transformation</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Transformation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('addTransUser', $user->id) }}" method='post'
                                enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Description</span>
                                    </div>
                                    <textarea class="form-control @error('tra_description') is-invalid @enderror" aria-label="With textarea"
                                        name="tra_description">{{ old('tra_descriptio') }}</textarea>
                                    @error('tra_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Photo :</span>
                                    </div>
                                    <input class="form-control @error('tra_pic1') is-invalid @enderror" type="file"
                                        id="formFile" name="tra_pic1">
                                    @error('tra_pic1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Photo :</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01" name="tra_pic1">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                    @error('tra_pic1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Poid :</span>
                                    </div>
                                    <input class="form-control @error('tra_poid') is-invalid @enderror" type="number"
                                        id="formFile" name="tra_poid">
                                    @error('tra_poid')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Duree :</span>
                                    </div>
                                    <input class="form-control @error('tra_duree') is-invalid @enderror" type="number"
                                        id="formFile" name="tra_duree">
                                    @error('tra_duree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Coach encadrement</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect01" name="coach_id">
                                        @forelse ($coaches as $coach)
                                            <option value="{{ $coach->id }}">
                                                {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                                        @empty
                                            <option>
                                                <div class="alert alert-danger" style="display:inline;">Aucune
                                                    enregistrement a afficher !</div>
                                            </option>
                                        @endforelse
                                        <option value="">Auto Encadrement</option>
                                    </select>
                                </div>
                                @error('tra_coach')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <input type="hidden" value="{{ $user->id }}" name="personnel_id">
                                <div class="modal-footer">
                                    <button type="button"
                                        class="btn btn-secondary"style="color: #e3e2e2;background-color:  #151917;border-radius: 5px;"data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="alert alert-light text-center text-dark mt-0" role="alert">
                <h4>Your weight tracker :</h4>
            </div>
            <canvas id="myChart6"></canvas>
        </div>

        <hr>

        <div class="container">
            <div class="row ">
                <div class="alert alert-light text-center text-dark mt-0" style="width: 100%; text-align: center" role="alert">
                    <h4>Your Achievements :</h4>
                </div>
                <br>
                @forelse ($trans as $transformation)
                    <div class="col-4">
                        <div class="card">
                            <img src="{{ asset('images/profiles/8530_1685816101_62345.jpg') }}" class="card-img-top"
                                alt="trans pic">
                            <div class="card-body">
                                <h5 class="card-title">{{ $transformation->tra_description }}</h5>
                                @if ($transformation != null)
                                    {{-- <p><b>Coach :</b>  <br> {{ $transformation->coach->coa_nom.' '. $transformation->coach->coa_prenom}}</p> --}}
                                    <p><b>Coach :</b> <br> {{ $transformation->coach_id }}</p>
                                @else
                                    <p><b class="text-primary">Auto-coaching</b></p>
                                @endif
                                <p> <b>Actual weight :</b> <br> {{ $transformation->tra_poid }} kg</p>
                                <p> <b>Transformation time :</b> <br>
                                    @if ($transformation->tra_duree == 1)
                                        {{ $transformation->tra_duree }} week
                                    @else
                                        {{ $transformation->tra_duree }} weeks
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">{{ date('Y-m-d', strtotime($transformation->created_at)) }}
                                    <b>,at :</b> {{ date('H:i:s', strtotime($transformation->created_at)) }} </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger">you have no transformations, Add one !</div>
                @endforelse
            </div>
        </div>
        <script>
            //poid Tracker
            var colArray = [];
            var rowArray = @json($weekx);
            for (let i = 0; i < rowArray.length; i++) {
                colArray.push('rgb(223, 169, 122)');
            }
            let myChart6 = document.getElementById("myChart6").getContext("2d");
            const poidTracker = new Chart(myChart6, {
                type: "line",
                data: {
                    labels: @json($weekx),
                    datasets: [{
                        label: "weight Tracker",
                        data: @json($poids),
                        backgroundColor: colArray,
                        borderColor: "rgb(223, 169, 122)", // Custom border color
                        pointBackgroundColor: "rgb(51, 51, 51)", // Custom point color
                        pointBorderColor: "rgb(223, 169, 122)", // Custom point border color
                        pointHoverBackgroundColor: "rgba(255, 255, 255, 1)", // Custom point hover color
                        pointHoverBorderColor: "rgba(54, 162, 235, 1)", // Custom point hover border color
                        borderWidth: 2, // Custom border width

                    }, ],
                },
                options: {
                    title: {
                        display: true,
                        text: "Your Presence Status",
                        fontSize: 18,
                    },
                    legend: {
                        display: true, //display/hide the legend
                        position: "top",
                        labels: {
                            fontColor: "#000",
                        },
                    },
                    scales: {
                        y: {
                            suggestedMin: 5,
                            suggestedMax: 7,
                            grid: {
                                color: "rgba(200, 200, 200, 0.2)", // Custom grid color
                            },
                            ticks: {
                                fontColor: "#333", // Custom tick font color
                            },
                        },
                        x: {
                            grid: {
                                display: false, // Hide x-axis grid lines
                            },
                            ticks: {
                                fontColor: "#333", // Custom tick font color
                            },
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                },
            });
        </script>
    @endsection
