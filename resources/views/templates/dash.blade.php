<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="{{ asset('css/dash.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js"></script>
        <link rel="shortcut icon" href="{{ asset('images/logo/daklon.svg') }}" type="image/x-icon">


    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<style>
    .btnDelete {
        border: none;
        background-color: #fff;
        position: absolute;
        right: 0;
        cursor: pointer;
    }

    .btnDelete:focus {
        background-color: #0d6efd;
        color: #ffffff
    }

    .dropdown-item:focus .btnDelete {
        background-color: #0d6efd;
        color: #ffffff
    }
</style>

<body>
    <div class="grid-container">
        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
            <div class="header-left">

            </div>
            <div class="header-right">
                {{-- //// notification --}}
                <div class="btn-group dropstart">
                    <button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false"
                        style="background-color: #151917 ;color: #ffffff; padding: 5px;margin-right: 9px;  margin-left: 5px;">
                        <span class="material-icons-outlined">notifications</span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $nbrNotifications }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </button>
                    <ul class="dropdown-menu" style="height: 250px; overflow: scroll; width: 270px;">
                        {{-- payement --}}
                        <li>
                            <div
                                style="display: flex; padding: 10px; margin-bottom: 15px; border-bottom:1px solid #151917">
                                <span class="dropdown-item">
                                    <div class="">
                                        <span class="badge text-bg-danger">Payement alerts</span>
                                    </div>
                                </span>

                                <form action="/notification/clearpa" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">clear</button>
                                </form>
                            </div>
                        </li>
                        {{-- payments alert --}}
                        {{-- @forelse ($PayAlertsnotifications as $PayAlertsnotification)
                            <li id="li_{{ $PayAlertsnotification->id }}">
                                <div style="display: flex">
                                    <div class="">
                                        <span class="material-icons-outlined mt">account_circle</span>&nbsp
                                        <a href="/payments/{{ $PayAlertsnotification->personnel_id }}"
                                            style="all: unset">
                                            {{ $PayAlertsnotification->personnel->per_nom . ' ' . $PayAlertsnotification->personnel->per_prenom }}
                                        </a>

                                        <form action="notifiaction/{{ $PayAlertsnotification->id }}/destroy"
                                            method="post" style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btnDelete" class="btn btn-danger">
                                                <span class="material-icons-outlined">delete_forever</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li>
                                <p class="text-warning p-1"><b>no notifications to display !</b></p>
                            </li>
                        @endforelse --}}

                        {{-- new members --}}
                        <li>
                            <div
                                style="display: flex; padding: 10px; margin-top: 20px; margin-bottom: 15px; border-bottom:1px solid #151917; border-top: 1px solid #151917">
                                <span class="dropdown-item">
                                    <div class="">
                                        <span class="badge text-bg-success">New users</span>
                                    </div>
                                </span>

                                <form action="/notification/clear" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">clear</button>
                                </form>
                            </div>
                        </li>
                        {{-- notifications --}}
                        {{-- @forelse ($NewUsersnotifications as $NewUsersnotification)
                            <li>
                                <div style="display: flex">
                                    <div class="">
                                        <span class="material-icons-outlined mt">account_circle</span>&nbsp
                                        <a href="/members/{{ $NewUsersnotification->personnel_id }}/edit"
                                            style="all: unset">
                                            {{ $NewUsersnotification->personnel->per_nom . ' ' . $NewUsersnotification->personnel->per_prenom }}
                                        </a>

                                        <form action="notifiaction/{{ $NewUsersnotification->id }}/destroy"
                                            method="post" style="display: inline;">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btnDelete" class="btn btn-danger">
                                                <span class="material-icons-outlined">delete_forever</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>

                        @empty
                            <li>
                                <p class="text-warning p-1"><b>no notifications to display !</b></p>
                            </li>
                        @endforelse --}}
                        {{-- notifications --}}
                    </ul>
                </div>
                {{-- //// logout --}}
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                        style="background-color: #151917 ;color: #ffffff; margin-right: -19px; padding: 5px;  margin-left: 5px;">
                        <span class="material-icons-outlined">account_circle</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/logout">
                                <span class="material-icons-outlined">logout</span>
                                &nbsp logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    {{-- <a href="/dashboard" class="logo">
                        <img src="{{ asset('images/logo/FullFormWhite_and_daklon.svg') }}"
                            class="site-logo" alt="logo" style="width:200px;height:200px;">
                    </a> --}}
                    <span class="material-icons-outlined">fitness_center</span> <a class="logo" href="/dashboard">MANAGYM</a>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>


            <ul class="sidebar-list">
                <a href="/members" class="{{ request()->is('members') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('members') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">people_alt</span> Members
                    </li>
                </a>
                <a href="/coaches" class="{{ request()->is('coaches') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('coaches') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">sports</span> Coaches
                    </li>
                </a>
                <a href="/transformations" class="{{ request()->is('transformations') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('transformations') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">shuffle</span> Transformations
                    </li>
                </a>
                <a href="/packages" class="{{ request()->is('packages') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('packages') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">inventory_2</span> Packages
                    </li>
                </a>
                <a href="/muscles" class="{{ request()->is('muscles') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('muscles') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">sports_martial_arts</span> Muscles
                    </li>
                </a>
                <a href="/machines" class="{{ request()->is('machines') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('machines') ? 'activeList' : '' }} ">
                        <span class="material-icons-outlined">precision_manufacturing</span> Machines
                    </li>
                </a>

                <a href="/payments" class="{{ request()->is('payments') ? 'activeLink' : '' }}">
                    <li class="sidebar-list-item {{ request()->is('payments') ? 'activeList' : '' }}">
                        <span class="material-icons-outlined">paid</span> Payements
                    </li>
                </a>

            </ul>
        </aside>
        <!-- Main -->
        <main class="main-container">
            @yield('content')
        </main>
    </div>


    <script src="{{ asset('js/dash.js') }}"></script>
</body>

</html>
