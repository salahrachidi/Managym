<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Account Settings UI Design</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/userAcc.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js"></script>

    <script type="module">
    import { minidenticonSvg } from 'https://cdn.jsdelivr.net/npm/minidenticons@4.2.0/minidenticons.min.js'
</script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}

</head>

<body>
    <section class="">
        <div class="container ">
            <u>
                <h1 class="mb-3 mt-3 text-center" style="font-family: 'Kaushan Script';">My Account</h1>
            </u>
            @if (session()->has('success'))
                {{-- <div class="alert alert-success alert-dismissible fade show" role="alert"
                    style="width: 30%; text-align: center;margin: auto">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> --}}
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="width: 40%; text-align: center;margin: auto">
                    <strong>Holy 🥳🥳!</strong> {{ session('success') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="profile-tab-nav border-right">
                    <div class="p-4">
                        @yield('imgZone')
                    </div>
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="/profile">
                            <i class="fa fa-home text-center mr-1"></i>
                            Home
                        </a>
                        <a class="nav-link {{ request()->is('profile/account') ? 'active' : '' }}"
                            href="/profile/account">
                            <i class="fa fa-pencil text-center mr-1"></i>
                            Account
                        </a>
                        <a class="nav-link {{ request()->is('profile/transformation') ? 'active' : '' }}"
                            href="/profile/transformation">
                            <i class="fa fa-line-chart text-center mr-1"></i>
                            Transformations
                        </a>
                        <a class="nav-link {{ request()->is('profile/password') ? 'active' : '' }}"
                            href="/profile/password"">
                            <i class="fa fa-key text-center mr-1"></i>
                            Password
                        </a>
                        <a class="nav-link" href="#application">
                            <i class="fa fa-tv text-center mr-1"></i>
                            Presences
                        </a>
                        <a class="nav-link" href="#notification">
                            <i class="fa fa-bell text-center mr-1"></i>
                            Notifications
                        </a>
                        <a class="nav-link" href="/logout">
                            <i class="fa fa-sign-out text-center mr-1"></i>
                            logout
                        </a>
                    </div>
                </div>

                @yield('content')

            </div>
        </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
