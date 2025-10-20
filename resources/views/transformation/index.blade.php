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







    <h1>All Transformations</h1>

    <div style="display:flex; width: 100%; justify-content: space-between;margin-bottom: 20px;">
        <div class="search-container">
            <form action="{{ route('trans.search') }}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

        </div>
        <div>
            <button type="button" class="btn btn-outline-dark mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo">
                Ajouter une
                transformation
            </button>
            {{-- modal for adding new transformation --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Member</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/transformations" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-4">
                                    <div class="form-floating">
                                        <textarea class="form-control @error('tra_description') is-invalid @enderror" id="floatingTextarea"
                                            name="tra_description"></textarea>
                                        <label for="floatingTextarea" name="tra_description">Description :</label>
                                    </div>
                                    @error('tra_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Photo :</span>
                                    </div>
                                    <input class="form-control @error('tra_pic1') is-invalid @enderror" type="file"
                                        id="formFile" name="tra_pic1">
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


                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Coach encadrement</label>
                                    </div>
                                    <select name="coach_id" class="form-select">
                                        @forelse ($coaches as $coach)
                                            <option value="{{ $coach->id }}">
                                                {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                                        @empty
                                            <option>
                                                <div class="alert alert-danger" style="display:inline;">Aucune
                                                    enregistrement a afficher !</div>
                                            </option>
                                        @endforelse
                                        <option value="{{ null }}">Auto Encadrement</option>
                                    </select>
                                </div>
                                @error('tra_coach')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">transformation de :
                                        </label>
                                    </div>
                                    <select name="personnel_id" class="form-select">
                                        @forelse ($personnels as $per)
                                            <option value="{{ $per->id }}">
                                                {{ $per->per_nom . ' ' . $per->per_prenom }} </option>
                                        @empty
                                            <option>
                                                <div class="alert alert-danger" style="display:inline;">Aucune
                                                    enregistrement a afficher !</div>
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                                @error('personnel_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-center" ><button type="submit" class="createMem btn btn-secondary btn-lg btn-block mb-3 ">Ajouter</button></div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            {{-- modal for adding new transformation --}}

        </div>
    </div>

    <table class="table table-striped   table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Description</th>
                <th scope="col">photo</th>
                <th scope="col">Poid</th>
                <th scope="col">Duree </th>
                <th scope="col">Member</th>
                <th scope="col">Coach</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @forelse ($trans as $tran)
                <tr>
                    <th scope="row">{{ $tran->id }}</th>
                    <td>{{ $tran->tra_description }}</td>
                    <td><img class="img-thumbnail" style="width: 60px;" height="100px"
                            src="{{ asset('images/transformations/' . $tran->tra_pic1) }}" alt="image"></td>
                    <td>{{ (int)$tran->tra_poid }}</td>
                    <td>
                        @if ($tran->tra_duree == 1)
                            {{ $tran->tra_duree }} week
                        @else
                            {{ $tran->tra_duree }} weeks
                        @endif
                    </td>
                    <td>{{ $tran->personnel->per_nom . ' ' . $tran->personnel->per_prenom }}</td>
                    <td>
                        @if ($tran->coach_id == null)
                            <div class="text-info">Auto Encadrement</div>
                        @else
                            {{ $tran->coach->coa_nom . ' ' . $tran->coach->coa_prenom }}
                        @endif
                    </td>
                    <td style="">
                        <a href="/transformations/{{ $tran->id }}/edit" class="btn action">
                            <span class="material-icons-outlined">edit</span>
                        </a>
                        <form action="/transformations/{{ $tran->id }}" style="display:inline;" method="POST">
                            @csrf
                            @method('delete')
                            <button onclick="return confirm('Confirmer La suppression ? ' );"
                                class="btn action delete"><span class="material-icons-outlined">delete</span></button>
                        </form>
                    </td>
                </tr>
            @empty
                <td colspan="8">
                    <div class="alert alert-danger">Aucune enregistrement a afficher !</div>
                </td>
            @endforelse
        </tbody>
    </table>
    {{ $trans->links() }}
    <script>
        $('.alert').delay(3000).fadeOut('slow');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
@endsection
