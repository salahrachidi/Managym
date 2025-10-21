@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashHome.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    @php
        $packages      = $packages      ?? ['Basic','Pro','Elite'];
        $membersArray  = $membersArray  ?? [64,44,20];
        $monthNames    = $monthNames    ?? ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $mPm           = $mPm           ?? [5,9,12,8,11,6,10,13,7,9,8,10];
        $years         = $years         ?? [2023,2024,2025];
        $mPY           = $mPY           ?? [86,124,128];
        $status        = $status        ?? [98,30];
        $Sexe          = $Sexe          ?? [78,50];
    @endphp




    @if (session()->has('login'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('login') }} <b>{{ Auth::user()->name }}</b>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('addAdmin'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('addAdmin') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="main-cards mb-5">

        <div class="card">
            <div class="card-inner">
                <p class="text-dark">Members</p>
                <span class="material-icons-outlined text-blue">supervisor_account</span>
            </div>
            <span class="text-dark font-weight-bold"><b>{{ $members }}</b></span>
        </div>

        <div class="card">
            <div class="card-inner">
                <p class="text-dark">Coaches</p>
                <span class="material-icons-outlined text-orange">sports</span>
            </div>
            <span class="text-dark font-weight-bold"><b>{{ $coaches }}</b></span>
        </div>

        <div class="card">
            <div class="card-inner">
                <p class="text-dark">Machines</p>
                <span class="material-icons-outlined text-green">analytics</span>
            </div>
            <span class="text-dark font-weight-bold"><b>{{ $machines }}</b></span>
        </div>

        <div class="card">
            <div class="card-inner">
                <p class="text-dark">Packages</p>
                <span class="material-icons-outlined text-red"><i class="bi bi-box-seam"></i></span>
            </div>
            <span class="text-dark font-weight-bold"><b>{{ $packs }}</b></span>
        </div>

    </div>

    <hr class="mt-3 mb-4">
    <div class="charts">
        <h3 class="text-center">Presente members today </h3>
        <table class="table mt-3 text-center">
            <tr class="table-danger">
                <td class="th1">#</td>
                <td>Full Nom</td>
                <td>Package</td>
                <td>Coach </td>
                <td>Days left </td>
            </tr>
            @forelse ($personnelPresentToday as $personnelPresent)
                <tr>
                    <td class="th1"><b>{{ $personnelPresent->id }}</b></td>
                    <td>{{ $personnelPresent->per_nom.' '.$personnelPresent->per_prenom }}</td>
                    <td>{{ data_get($personnelPresent, 'package.pac_title', 'Basic') }}</td>
                    <td>
                        @php
                            $coachName = trim((string) data_get($personnelPresent, 'coach.coa_nom', '') . ' ' . (string) data_get($personnelPresent, 'coach.coa_prenom', ''));
                        @endphp
                        @if ($coachName !== '')
                            {{ $coachName }}
                        @else
                            <p class="text-primary"><b>Auto-coaching</b></p>
                        @endif
                    </td>
                    <td>
                        @php $daysLeft = $daysLeftArray[$personnelPresent->id] ?? null; @endphp
                        @if(!is_null($daysLeft))
                            {{ $daysLeft }}
                        @else
                            <p class="text-warning"><b>No payments!</b></p>
                        @endif
                    </td>
                </tr>
            @empty
            @endforelse
        </table>

        <hr class="mt-3 mb-4">

        <h3 class="text-center">Recent members</h3>
        <table class="table mt-3 text-center">
            <tr class="table-danger">
                <td class="th1">#</td>
                <td>Full Nom</td>
                <td>Package</td>
                <td>Coach </td>
                <td>Account status </td>
                <td class="th5">Actions</td>
            </tr>
            @forelse ($recentMembers as $recentMember)
                <tr>
                    <td> <b>{{ $recentMember->id }}</b></td>
                    <td>{{ $recentMember->per_nom . ' ' . $recentMember->per_prenom }}</td>
                    @php
                        $pkgTitle = data_get($recentMember, 'package.pac_title', 'Basic');
                        $pkgPrice = (int) data_get($recentMember, 'package.pac_prix', 0);
                    @endphp
                    <td>{{ $pkgTitle . ' : ' . $pkgPrice }} <b>dh</b></td>
                    <td>
                        @php
                            $coachName = trim((string) data_get($recentMember, 'coach.coa_nom', '') . ' ' . (string) data_get($recentMember, 'coach.coa_prenom', ''));
                        @endphp
                        @if ($coachName !== '')
                            {{ $coachName }}
                        @else
                            <p class="text-primary"><b>Auto-coaching</b></p>
                        @endif
                    </td>
                    <td>
                        @if ($recentMember->per_status == 0)
                            <b class="text-danger">Account is not Activated yet</b>
                        @else
                            <b class="text-success">Account is Activated</b>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-success" href="/members/{{ $recentMember->id }}/edit"> Activate this
                            account </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <p class="alert alert-warning">No records to display !</p>
                    </td>
                </tr>
            @endforelse

        </table>
        <h3 class="text-center mt-3">Members Statistics</h3>
        <section class="container mt-4">
            <div class="charts-card div1">
                <p class="chart-title">Members / Packages</p>
                <div id="bar-chart">
                    <canvas id="myChart1" height="200px" width="400px" class="myChart"> </canvas>
                </div>
            </div>
            <div class="charts-card div2">
                <p class="chart-title">Members / Months</p>
                <div id="area-chart">
                    <canvas id="myChart2" height="" width="" class="myChart"> </canvas>
                </div>
            </div>

            <div class="charts-card div3">
                <p class="chart-title">Members / Year</p>
                <div id="area-chart">
                    <canvas id="myChart3" height="" width="" class="myChart"> </canvas>
                </div>
            </div>

            <div class="charts-card div4">
                <div id="bar-chart">
                    <canvas id="myChart4" height="" width="" > </canvas>
                </div>
            </div>
            <div class="charts-card div5">
                <div id="bar-chart">
                    <canvas id="myChart5" height="" width="" > </canvas>
                </div>
            </div>
        </section>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script>
        //members/package
        var pacArray = @json($packages);
        var MemArray = @json($membersArray);
        let myChart1 = document.getElementById('myChart1').getContext('2d');
        let memTopac = new Chart(myChart1, {
            type: 'bar',
            data: {
                labels: pacArray,
                datasets: [{
                    label: 'Nombre des membre',
                    data: MemArray,
                    backgroundColor: "rgb(223, 169, 122,0.7)",
                    borderColor: "rgb(21, 25, 23)",
                    borderWidth: 3,
                    fill: true
                }]
            },

            options: {
                legend: {
                    display: true, // display/hide the legend
                    position: 'top',
                    labels: {
                        fontColor: '#000'
                    }
                },
                scales: {
                    y: {
                        suggestedMin: 15,
                        suggestedMax: 20
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            }
        });
        //Members / Months
        var jmonthNames = @json($monthNames);
        var jmPm = @json($mPm);
        let myChart2 = document.getElementById('myChart2').getContext('2d');
        let memTomon = new Chart(myChart2, {
            type: 'line',
            data: {
                labels: jmonthNames,
                datasets: [{
                    label: 'Nombre des membre',
                    data: jmPm,
                    backgroundColor: "rgb(223, 169, 122,0.4)",
                    borderColor: "rgb(223, 169, 122)",
                    borderWidth: 3,
                    pointBackgroundColor: "rgb(21, 25, 23)",
                    pointBorderColor: "rgb(223, 169, 122)",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: false,
                    tension: 0.3
                }]
            },

            options: {
                legend: {
                    display: true, // display/hide the legend
                    position: 'top',
                    labels: {
                        fontColor: '#000'
                    }
                },
                scales: {
                    y: {
                        suggestedMin: 15,
                        suggestedMax: 20
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            }
        });
        //members/year
        var jyears = @json($years);
        var jmPY = @json($mPY);
        let myChart3 = document.getElementById('myChart3').getContext('2d');
        let memToYear = new Chart(myChart3, {
            type: 'line',
            data: {
                labels: jyears,
                datasets: [{
                    label: 'Nombre des membre',
                    data: jmPY,
                    backgroundColor: "rgb(223, 169, 122,0.4)",
                    borderColor: "rgb(223, 169, 122)",
                    borderWidth: 3,
                    pointBackgroundColor: "rgb(21, 25, 23)",
                    pointBorderColor: "rgb(223, 169, 122)",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: false,
                    tension: 0.3
                }]
            },

            options: {
                legend: {
                    display: true, // display/hide the legend
                    position: 'top',
                    labels: {
                        fontColor: '#000'
                    }
                },
                scales: {
                    y: {
                        suggestedMin: 15,
                        suggestedMax: 20
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            }
        });
        // Active / inactive members
        let myChart4 = document.getElementById('myChart4').getContext('2d');
        let MembersAccountStatus = new Chart(myChart4, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    label: 'Members Account Status ',
                    data: @json($status),
                    backgroundColor: [
                        'rgba(102, 204, 153, 0.8)', /* Green color */
                        'rgba(204, 102, 102, 0.8)' /* Red color */
                    ]
                }]
            },
            options: {
                animation: {
                    duration: 1500, // Animation duration in milliseconds
                    easing: 'easeInOutQuart' // Animation easing function
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Members Account Status',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#000'
                        }
                    }
                }
            }
        });
        // Male / Female
        let myChart5 = document.getElementById('myChart5').getContext('2d');
        let MandF = new Chart(myChart5, {
            type: 'pie',
            data: {
                labels: ['Homme', 'Femme'],
                datasets: [{
                    label: 'Members Account Status',
                    data: @json($Sexe),
                    backgroundColor: [
                        'rgba(153, 184, 214, 0.8)', /* Green color */
                        'rgba(245, 166, 201, 0.8)' /* Red color */
                    ]
                }]
            },
            options: {
                animation: {
                    duration: 1500, // Animation duration in milliseconds
                    easing: 'easeInOutQuart' // Animation easing function
                },
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Gender distribution',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#000'
                        }
                    }
                }
            }
        });
    </script>
@endsection
