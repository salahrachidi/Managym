@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/dashMembers.css') }}" />




    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('mnf'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('mnf') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('successUp'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('successUp') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('successDel'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('successDel') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif






    <h1>Manage members payments</h1>

    <div style="display:flex; width: 100%; justify-content: space-between;margin-bottom: 20px;">
        <div class="search-container">
            <form action="{{ route('pay.search') }}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <table class="table table-striped  table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Tele </th>
                <th>Photo </th>
                <th>Sexe</th>
                <th>Email</th>
                <td>Status</td>
                <th>Package</th>
                <th>Coach</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $membre)
                <tr>
                    <td><b>{{ $membre->id }}</b></td>
                    <td>{{ $membre->per_nom }}</td>
                    <td>{{ $membre->per_prenom }}</td>
                    <td>{{ $membre->per_tel }}</td>
                    <td>
                        <img src="{{ asset('images/profiles/' . $membre->per_pic) }}" alt="image" class="img-thumbnail"
                            style="width: 60px;" height="100px">
                    </td>
                    <td>
                        @if ($membre->per_sexe == 1)
                            Homme
                        @else
                            Femme
                        @endif
                    </td>
                    <td>{{ $membre->per_email }}</td>
                    <td>
                        @if ($membre->per_status == 1)
                            <b class="text-success">Payee</b>
                        @else
                            <b class="text-danger">Non Payee</b>
                        @endif
                    </td>
                    <td>{{ $membre->package->pac_description }}</td>
                    <td>
                        @if ($membre->coach_id)
                            {{ $membre->coach->coa_nom .' '.$membre->coach->coa_prenom }}
                        @else
                            <p class="text-primary" ><b>Auto-coaching</b></p>
                        @endif
                    </td>
                    <td>

                        <a href="/payments/{{ $membre->id }}" class="btn action">
                            <span class="material-icons-outlined">attach_money</span>Payments
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $members->links() }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
