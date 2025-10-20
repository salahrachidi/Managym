@extends('templates.dash')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashMembers.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dashMemberCreate.css') }}" />




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
    @if (session()->has('assign'))
        <div class="alert alert-info alert-dismissible fade show" role="alert"
            style="width: 30%; text-align: center;margin: auto">
            {{ session('assign') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif






    <h1>All muscles</h1>

    <div style="display:flex; width: 100%; justify-content: space-between;margin-bottom: 20px;">
        <div class="search-container">
            <form action="{{ route('muscle.search') }}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

        </div>
        <div>
            <button type="button" class="btn btn-outline-dark mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo">
                Create New muscle
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create a Muscle</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/muscles" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-4">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">muscle name</span>
                                    </div>
                                    <input type="text" class="form-control @error('mus_label') is-invalid @enderror"
                                        name="mus_label" value="{{ old('mus_label') }}" placeholder="name">
                                    @error('mus_label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">IMAGE</span>
                                    </div>
                                    <input class="form-control @error('mus_pic') is-invalid @enderror" type="file"
                                        id="formFile" name="mus_pic">
                                    @error('mus_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <button type="submit"
                                    class="createMem btn btn-secondary btn-lg btn-block mb-3">Ajouter</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped  table-hover">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>muscle</th>
                <th>photo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($muscles as $musc)
                <tr>
                    <td><b>{{ $musc->id }}</b></td>
                    <td>{{ $musc->mus_label }}</td>
                    <td>
                        <img src="{{ asset('images/muscles/' . $musc->mus_pic) }}" alt="image" class="img-thumbnail"
                            style="width: 60px;" height="100px">
                    </td>
                    <td>
                        <a href="/muscles/{{ $musc->id }}/edit" class="btn action">
                            <span class="material-icons-outlined">edit</span>
                        </a>
                        <div style="display:inline;">
                            <form method="post" action="/muscles/{{ $musc->id }}" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')"
                                    class="btn action delete"><span class="material-icons-outlined">delete</span></button>
                            </form>
                        </div>
                        <a href="/mus_macs/{{ $musc->id }}" class="btn action">Assign</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $muscles->links() }}



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
