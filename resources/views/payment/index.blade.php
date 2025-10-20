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






    <h1><span class="text text-secondary" >All</span> <span class="text text-dark" >{{ $member->per_nom .' '. $member->per_prenom}}</span> <span class="text text-secondary" >payments</span></h1>

    <div style="display:flex; width: 100%; justify-content: space-between;margin-bottom: 20px;">
        <div class="search-container">
            <form action="{{ route('coache.search') }}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

        </div>
        <div>
            <a href="{{ $memberId }}/create" class="btn btn-outline-dark mb-2">Ajouter un  payment</a>
        </div>
    </div>

    <table class="table table-striped  table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Date de payment</th>
                <th>Package selectionne</th>
                <th>Prix de payment</th>
                <th>member</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td><b>{{ $payment->id }}</b></td>
                    <td>{{ date('d/m/Y', strtotime($payment->pay_date)) }}</td>
                    <td>{{ $payment->personnel->package->pac_title }}</td>
                    <td>{{ $payment->personnel->package->pac_prix }}</td>
                    <td>{{ $payment->personnel->per_nom .' '. $payment->personnel->per_prenom }}</td>
                    <td>
                        {{-- <a href="/payments/{{ $payment->id }}/edit" class="btn action">
                            <span class="material-icons-outlined">edit</span>
                        </a> --}}
                        <div style="display:inline;">
                            <form method="post" action="/payments/{{ $payment->id }}" style="display:inline;">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="idx" value="{{ $member->id }}">
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')"
                                    class="btn action delete"><span class="material-icons-outlined">delete</span></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- {{ $payments->links() }} --}}



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
