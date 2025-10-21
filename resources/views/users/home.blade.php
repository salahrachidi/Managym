@extends('templates.userAcc')
@section('imgZone')
    <link rel="stylesheet" href="{{ asset('css/userAccHome.css') }}" />


    <div class="p-4">
        <div class="img-circle text-center mb-3">
            {{-- @if ($user->per_pic )
                <img src="{{ asset('images/profiles/' . $user->per_pic) }}" alt="Image" class="shadow">
            @else --}}
                {{-- <minidenticon-svg username="{{ $user->per_nom . ' ' . $user->per_prenom }}"></minidenticon-svg> --}}
            {{-- @endif --}}
        </div>
        {{-- <h4 class="text-center">{{ $user->per_nom }} {{ $user->per_prenom }}</h4> --}}
        <div style=" margin: auto; width: 180px;">
            <button class="btn btn-primary" id="imgBtn" onClick="location.href='/profile/account'">
                <i class="fa fa-image text-center mr-1"></i>upload new image
            </button>
        </div>
    </div>
@endsection
@section('content')
    <style>
        .content1 {
            width: 100%;
            display: flex;
            justify-content: space-around
        }

        .badge {
            font-weight: Medium;
            font-size: 18px;
        }

        .chart {
            padding: 10px;
            box-shadow: -2px 5px 9px -4px rgba(0, 0, 0, 0.4);
            -webkit-box-shadow: -2px 5px 9px -4px rgba(0, 0, 0, 0.4);
            -moz-box-shadow: -2px 5px 9px -4px rgba(0, 0, 0, 0.4);
        }

        #loading,
        #results {
            display: none;
        }

        #loading {
            width: 100%;
            height: 20%;
        }
    </style>

    <div class="tab-content p-4 p-md-5">

        <div class="alert alert-light text-center text-dark mt-0 mb-0" role="alert" style="background-color: rgba(231, 255, 196, 0.469)">
            <p>The Calorie Calculator can be used to estimate the number of calories a person needs to consume each day.
                This calculator can also provide some simple guidelines for gaining or losing weight.</p>
        </div>
        <div class="container content" style="">
            <div class="row">
                <div class="">
                    <div class="card card-body text-center mt-5">
                        <h1 class="heading display-5 pb-3">Calorie Calculator App</h1>
                        <form id="calorie-form">

                            <div class="form-group row">
                                <label for="age" class="col-sm-2 col-form-label">Age</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="age" placeholder="Ages 15-80">
                                </div>
                            </div>

                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                                    <div class="col-sm-10" id="form-radio">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="male" name="customRadioInline1"
                                                class="custom-control-input" checked="checked">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="female" name="customRadioInline1"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group row">
                                <label for="weight" class="col-sm-2 col-form-label">Weight</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="weight" placeholder="In kilograms">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="height" class="col-sm-2 col-form-label">Height</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="height" placeholder="In centimeters">
                                </div>
                            </div>

                            <div class="form-group row">
                                <legend class="col-form-label col-sm-2 pt-0">Activity</legend>
                                <select class="custom-select col-sm-10" id="list">
                                    <option selected value="1">Sedentary (little or no exercise)</option>
                                    <option value="2">Lightly active (light exercise/sports 1-3 days/week)</option>
                                    <option value="3">Moderately active (moderate exercise/sports 3-5 days/week)
                                    </option>
                                    <option value="4">Very active (hard exercise/sports 6-7 days a week)</option>
                                    <option value="5">Extra active (very hard exercise/sports & physical job or 2x
                                        training)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Calculate" class="btn btn-primary btn-block">
                            </div>

                        </form>

                        <div id="loading">
                            <img src="{{ asset('images/Loading.gif') }}" alt="">
                        </div>

                        <div id="results" class="pt-4">
                            <h5>Total Calories</h5>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" id="total-calories" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-light text-center text-dark mt-0" role="alert">
            <h4>This is your status :</h4>
        </div>

        <hr>

        <div class="container content1 mb-3">
            <div class="charts mr-5" style="width: 100%;">
                <canvas id="myChart3" height="200px" width="" data-labels='["Mon","Tue","Wed","Thu","Fri","Sat","Sun"]' data-values='[2,3,1,4,2,0,0]'> </canvas>
            </div>

            <div class="charts" style="width: 100%;">
                <canvas id="myChart5" height="200px" width="" data-days='[12]'> </canvas>
            </div>
        </div><br>

        <hr>
        <hr>
    </div>





    <script src="{{ asset('js/calorie.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script>
        // Your Presence Status (framework-agnostic)
        (function () {
            // Read labels and values from data attributes (fallback defaults provided)
            const chart3El = document.getElementById("myChart3");
            const labelsRaw = chart3El?.dataset?.labels || '["Mon","Tue","Wed","Thu","Fri","Sat","Sun"]';
            const valuesRaw = chart3El?.dataset?.values || "[1,2,1,3,2,0,0]";
            let rowArray, rowArraynbrpre;
            try { rowArray = JSON.parse(labelsRaw); } catch { rowArray = String(labelsRaw).split(","); }
            try { rowArraynbrpre = JSON.parse(valuesRaw); } catch { rowArraynbrpre = []; }

            // Build color array to match labels length
            const colArray = Array.from({ length: rowArray.length }, () => "rgb(223, 169, 122)");

            const ctx3 = chart3El.getContext("2d");
            new Chart(ctx3, {
                type: "bar",
                data: {
                    labels: rowArray,
                    datasets: [{
                        label: "sessions per Week",
                        data: rowArraynbrpre,
                        backgroundColor: colArray,
                        borderColor: "rgb(51, 51, 51)",
                        pointBackgroundColor: "rgb(51, 51, 51)",
                        pointBorderColor: "rgb(223, 169, 122)",
                        pointHoverBackgroundColor: "rgba(255, 255, 255, 1)",
                        pointHoverBorderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 2,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: { display: true, text: "Your Presence Status", font: { size: 18 } },
                        legend: { display: true, position: "top", labels: { color: "#000" } },
                    },
                    scales: {
                        y: {
                            suggestedMin: 1,
                            suggestedMax: 7,
                            grid: { color: "rgba(200, 200, 200, 0.2)" },
                            ticks: { color: "#333" },
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: "#333" },
                        },
                    },
                },
            });

            // Payment Tracker (framework-agnostic)
            const chart5El = document.getElementById("myChart5");
            const daysRaw = chart5El?.dataset?.days || "[15]";
            let days = [];
            try { days = JSON.parse(daysRaw); } catch { days = [15]; }

            const backgroundColors = days.map(function (d) {
                if (d <= 10) return "rgba(144, 238, 144, 0.8)";     // Soft green
                if (d >= 11 && d <= 25) return "rgba(255, 165, 0, 0.8)"; // Soft orange
                if (d >= 26 && d <= 29) return "rgba(255, 99, 71, 0.8)"; // Soft red
                return "rgba(255, 0, 0, 0.8)";                       // Red
            });

            const ctx5 = chart5El.getContext("2d");
            new Chart(ctx5, {
                type: "bar",
                data: {
                    labels: [""],
                    datasets: [{
                        label: "Payment Tracker",
                        data: days,
                        backgroundColor: backgroundColors,
                        borderColor: "rgb(51, 51, 51)",
                        borderWidth: 0.7,
                    }],
                },
                options: {
                    responsive: true,
                    aspectRatio: 5,
                    indexAxis: "y",
                    plugins: {
                        title: { display: true, text: "Payment Tracker", font: { size: 18 } },
                        legend: { display: true, position: "right", labels: { color: "#000" } },
                    },
                    scales: {
                        y: { grid: { display: false } },
                        x: { suggestedMin: 20, suggestedMax: 30 },
                    },
                    animation: { duration: 2000 },
                },
            });
        })();
    </script>
@endsection
