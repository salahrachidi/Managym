@extends('templates.dash')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />

<h1>Create New payment</h1>
@if (session()->has('NoPayments'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('NoPayments') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<div class="createForm">
    <form action="/payments" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-4">

            <div class="input-group-prepend">
                <span class="input-group-text" id="">Date de payment</span>
            </div>
            <input type="date" class="form-control @error('pay_date') is-invalid @enderror" name="pay_date"
                value="{{ old('pay_date') }}" placeholder="">
            @error('pay_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input type="hidden" name="personnel_id" value="{{ $memberId }}">
        <button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3">Ajouter</button>
    </form>
</div>
@endsection
