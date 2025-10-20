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

    <div class="alert alert-success alert-dismissible fade show" role="alert"
        style="width: 30%; text-align: center;margin: auto; display: none" id="delSes">
        member deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>






    <h1>All Members</h1>

    <div style="display:flex; width: 100%; justify-content: space-between;margin-bottom: 20px;">
        <div class="search-container">
            <form action="{{ route('member.search') }}" method="post">
                @csrf
                <input type="text" placeholder="Search.." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <div>
            {{-- <a href="members/create" class="btn btn-outline-dark mb-2">Create New Coache</a> --}}
            <button type="button" class="btn btn-outline-dark mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal"
                data-bs-whatever="@mdo">
                Create New Member
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Member</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/members" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-4">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">First and last name</span>
                                    </div>
                                    <input type="text" class="form-control @error('per_nom') is-invalid @enderror"
                                        name="per_nom" value="{{ old('per_nom') }}" placeholder="Nom">
                                    <input type="text" class="form-control @error('per_prenom') is-invalid @enderror"
                                        name="per_prenom" value="{{ old('per_prenom') }}" placeholder="Prenom">

                                    @error('per_nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('per_prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tele :</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+212</span>
                                    </div>
                                    <input type="tel" class="form-control @error('per_tel') is-invalid @enderror"
                                        aria-label="Amount (to the nearest dollar)" name="per_tel"
                                        value="{{ old('per_tel') }}">

                                    @error('per_tel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class=" mb-4">
                                    <i>sexe :</i>
                                    <input class="form-check-input" type="radio" name="per_sexe" id="per_sexe1" checked
                                        value="1">
                                    <label class="form-check-label" for="per_sexe">
                                        Homme
                                    </label>

                                    <input class="form-check-input" type="radio" name="per_sexe" id="per_sexe2"
                                        value="0">
                                    <label class="form-check-label" for="per_sexe">
                                        Femme
                                    </label>
                                </div>

                                @error('per_sexe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- ******************************************Sexe --}}
                                <div class="input-group mb-4">
                                    <input type="email" class="form-control @error('per_email') is-invalid @enderror"
                                        placeholder="Email" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2" name="per_email" value="{{ old('per_email') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">@example.com</span>
                                    </div>

                                    @error('per_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Password</span>
                                    </div>
                                    <input type="password"
                                        class="form-control @error('per_password') is-invalid @enderror"
                                        aria-label="Amount (to the nearest dollar)" name="per_password">

                                    @error('per_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">IMAGE</span>
                                    </div>
                                    <input class="form-control @error('per_pic') is-invalid @enderror" type="file"
                                        id="formFile" name="per_pic">
                                    @error('per_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="per_status">Status :</label>
                                    </div>
                                    <select name="per_status" class="form-select">
                                        <option value="1">Payee</option>
                                        <option value="0" selected>non Payee</option>
                                    </select>
                                </div>
                                @error('per_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">packages</label>
                                    </div>
                                    <select name="package_id" class="form-select">
                                        @foreach ($packages as $pack)
                                            <option value="{{ $pack->id }}"> {{ $pack->pac_description }} </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="input-group mb-5">
                                    <label class="input-group-text" for="inputGroupSelect02">Coach</label>
                                    <select name="coach_id" class="form-select">
                                        @foreach ($coaches as $coach)
                                            <option value="{{ $coach->id }}">
                                                {{ $coach->coa_nom . ' ' . $coach->coa_prenom }} </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                    </div>
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
                <tr id="tr_{{ $membre->id }}">
                    <td><b>{{ $membre->id }}</b></td>
                    <td>{{ $membre->per_nom }}</td>
                    <td>{{ $membre->per_prenom }}</td>
                    <td>{{ $membre->per_tel }}</td>
                    <td>
                        <img src="{{ asset('images/profiles/' . $membre->per_pic) }}" alt="image"
                            class="img-thumbnail" style="width: 60px;" height="100px">
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
                            <b class="text-success ">Payee</b>
                        @else
                            <b class="text-danger ">Non Payee</b>
                        @endif
                    </td>
                    <td>{{ $membre->package->pac_description }}</td>
                    @if ($membre->coach_id == null)
                        <td>
                            <p class="text-primary"><b>Auto-coaching</b></p>
                        </td>
                    @else
                        <td>{{ $membre->coach->coa_nom }}</td>
                    @endif
                    <td>
                        <a href="/members/{{ $membre->id }}/edit" class="btn action">
                            <span class="material-icons-outlined">edit</span>
                        </a>
                        {{-- <div style="display:inline;">
                            <form method="post" action="/members/{{ $membre->id }}" style="display:inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('Confirmer la suppression ?')"
                                    class="btn action delete"><span class="material-icons-outlined">delete</span></button>
                            </form>
                        </div> --}}
                        <a href="javascript:void(0)" class="btn action delete" onclick="deleteMem({{ $membre->id }})">
                            <span class="material-icons-outlined">delete</span>
                        </a>
                        {{-- <span>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn action delete" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <a href="javascript:void(0)" class="">
                                    <span class="material-icons-outlined">delete</span>
                                </a>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you sure to delete
                                                this ?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="myCheck"></button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn action" id="myCheck"
                                                data-bs-dismiss="modal">Close</button>
                                            <button class="btn action delete">
                                                <a href="javascript:void(0)" onclick="deleteMem({{ $membre->id }})">
                                                    Confirme
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span> --}}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $members->links() }}


    {{-- delete member without reloading the page --}}
    <script type="text/javascript">
        function deleteMem(id) {
            if (confirm('Confirmer la suppression ?')) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/members/' + id,
                    type: 'DELETE',
                    success: function(result) {
                        $("#" + result['tr']).slideUp("slow");
                    }
                });

            }
        }
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
