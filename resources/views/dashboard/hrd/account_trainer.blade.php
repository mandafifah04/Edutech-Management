@extends('dashboard.layouts.app')

@section('title', 'Halaman Trainer Account')

@push('css')
    <link href="{{ asset('alsavedutech/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('alsavedutech/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet"/>
    <link href="{{ asset('alsavedutech/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('alsavedutech/assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css"/>
    <link rel="stylesheet" href="{{ asset('alsavedutech/assets/css/theme.min.css') }}"/>
@endpush

@section('content')
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        @include('dashboard.layouts.sidebar')
        <!-- Page content -->
        <div id="page-content">
            @include('dashboard.layouts.header')
            <!-- Container fluid -->
            <div class="container-fluid px-6 py-4">
                <!-- card body -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h3 style="font-weight: 700">Trainer Account</h3>
                        <hr/>
                        @session('success')
                        {{-- <div class="alert alert-success" role="alert">
                    {{ $value }}
                </div> --}}
                        <div class="flash-data" data-flashdata="{{ $value }}"></div>
                        @endsession

                        @session('error')
                        {{-- <div class="alert alert-danger" role="alert">
                    {{ $value }}
                </div> --}}
                        <div class="flash-data" data-flashdata="{{ $value }}"></div>
                        <div class="type-flash" data-typeflash="error"></div>
                        @endsession
                    </div>
                </div>
                <!-- tabel kelas -->
                <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal"
                        data-bs-target="#modalCreateAkunTrainer">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                         fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Make Account
                </button>
                <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#modalShowTrash">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                         fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    Trash
                </button>
                <button data-bs-toggle="collapse" href="#filtersListUser" role="button" aria-expanded="false"
                        aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                         fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('hrd.trainer.account.list') }}" role="button" aria-expanded="false"
                   class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                         fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    Refresh Filter
                </a>
                <!-- BEGIN::filter data -->
                <div class="collapse" id="filtersListUser">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Field Filters</h3>
                            <hr/>
                            <form class="row g-3 needs-validation" action="{{ route('hrd.trainer.account.list') }}"
                                  method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="textInput">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="search by nama" value="{{ old('name') }}"/>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" name="username"
                                           class="form-control @error('username') is-invalid @enderror"
                                           placeholder="search by username" value="{{ old('username') }}"/>
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" id="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="search by email" value="{{ old('email') }}"/>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="level">Level</label>
                                    <select id="level" name="level" class="form-control @error('level') is-invalid @enderror">
                                        <option value="1">Beginner</option>
                                        <option value="2">Intermediate</option>
                                        <option value="3">Advanced</option>
                                    </select>
                                    @error('level')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <!-- Button Block -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-success">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                             stroke-width="2" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round" class="css-i6dzq1">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                        Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead>
                            <tr>
                                {{-- <th scope="col">Kode</th> --}}
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Level</th>
                                <th scope="col">Salary</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($trainer as $t)
                                <tr>
                                    {{-- <th>{{ $t->levelTrainer->kode_level }}</th> --}}
                                    <td>{{ $t->username }}</td>
                                    <td>{{ $t->name }}</td>
                                    <td>{{ $t->email }}</td>
                                    <td>
                                        @isset($t->levelTrainer->nama_level)
                                            {{ $t->levelTrainer->nama_level }}
                                        @else
                                            {{ __('tidak ada level') }}
                                        @endisset
                                    </td>
                                    <td>
                                        @empty($t->levelTrainer->sallary_level)
                                            {{ __('mata uang tidak di temukan') }}
                                        @else
                                            @mata_uang($t->levelTrainer->sallary_level)
                                        @endempty
                                    </td>
                                    <td>{{ $t->roles }}</td>
                                    <td>
                                        <form action="{{ route('hrd.trainer.account.delete', $t->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-warning mb-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalUpdateAkunTrainer{{ $t->id }}">
                                                <svg viewBox="0 0 24 24" width="20" height="20"
                                                     stroke="currentColor" stroke-width="2" fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="css-i6dzq1">
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </button>
                                            |
                                            <button type="submit" class="btn btn-danger mb-2 show_confirm_delete">
                                                <svg viewBox="0 0 24 24" width="20" height="20"
                                                     stroke="currentColor" stroke-width="2" fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="css-i6dzq1">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10"
                                                          y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14"
                                                          y2="17">
                                                    </line>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end -->

                @foreach ($trainer as $t)
                    <!-- Modal edit -->
                    <div class="modal fade gd-example-modal-lg" id="modalUpdateAkunTrainer{{ $t->id }}"
                         tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Trainer Account</h5>
                                </div>
                                <form action="{{ route('hrd.trainer.account.update') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <table class="table">
                                            <tbody>
                                            <input type="text" class="form-control" name="id"
                                                   placeholder="Insert ID" value="{{ $t->id }}" hidden>
                                            <tr data-dt-row="99" data-dt-column="2">
                                                <td>Name:</td>
                                                <td>
                                                    <input type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           placeholder="Masukan Nama" name="name"
                                                           aria-describedby="defaultFormControlHelp"
                                                           value="{{ $t->name }}"/>
                                                    @error('name')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </td>

                                                <td>Username:</td>
                                                <td>
                                                    <input type="text"
                                                           class="form-control @error('username') is-invalid @enderror"
                                                           placeholder="Masukan Username" name="username"
                                                           aria-describedby="defaultFormControlHelp"
                                                           value="{{ $t->username }}"/>
                                                    @error('username')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="4">
                                                <td>Email:</td>
                                                <td>
                                                    <input type="text"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           placeholder="Masukan Email" name="email"
                                                           aria-describedby="defaultFormControlHelp"
                                                           value="{{ $t->email }}"/>
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </td>

                                                <td>Password:</td>
                                                <td>
                                                    <input type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           placeholder="Masukan Password" name="password"
                                                           aria-describedby="defaultFormControlHelp"/>
                                                    @error('password')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="3">
                                                <td>Level:</td>
                                                <td>
                                                    <select
                                                        class="form-select @error('level_trainers_id') is-invalid @enderror"
                                                        name="level_trainers_id">
                                                        <option selected disabled value="">Pilih Level Trainer
                                                        </option>
                                                        @foreach ($level as $l)
                                                            <option
                                                                value="{{ $l->id }}"{{ $l->id == $t->level_trainers_id ? 'selected' : '' }}>
                                                                {{ $l->nama_level }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('level_trainers_id')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror

                                                </td>
                                                <td>Roles:</td>
                                                <td>
                                                    <input type="text"
                                                           class="form-control @error('roles') is-invalid @enderror"
                                                           placeholder="John Doe" name="roles"
                                                           aria-describedby="defaultFormControlHelp" value="trainer"
                                                           readonly/>
                                                    @error('roles')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Ya,
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                                 stroke-width="2" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round" class="css-i6dzq1">
                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                                </path>
                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                <polyline points="7 3 7 8 15 8"></polyline>
                                            </svg>
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end -->
                @endforeach

                <!-- modal tambah -->
                <div class="modal fade gd-example-modal-lg" id="modalCreateAkunTrainer" tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Make Trainer Account</h5>
                            </div>
                            <form action="{{ route('hrd.trainer.account.create') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <table class="table">
                                        <tbody>
                                        <tr data-dt-row="99" data-dt-column="2">
                                            <td>Name:</td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="Masukan Nama" name="name"
                                                       aria-describedby="defaultFormControlHelp"
                                                       value="{{ old('name') }}"/>
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror
                                            </td>

                                            <td>Username:</td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('username') is-invalid @enderror"
                                                       placeholder="Masukan Username" name="username"
                                                       aria-describedby="defaultFormControlHelp"
                                                       value="{{ old('username') }}"/>
                                                @error('username')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="4">
                                            <td>Email:</td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="Masukan Email" name="email"
                                                       aria-describedby="defaultFormControlHelp"
                                                       value="{{ old('email') }}"/>
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror
                                            </td>

                                            <td>Password:</td>
                                            <td>
                                                <input type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="Masukan Password" name="password"
                                                       aria-describedby="defaultFormControlHelp"
                                                       value="{{ old('password') }}"/>
                                                @error('password')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="3">
                                            <td>Level:</td>
                                            <td>
                                                <select
                                                    class="form-select @error('level_trainers_id') is-invalid @enderror"
                                                    name="level_trainers_id">
                                                    <option selected disabled value="">Pilih Level Trainer
                                                    </option>
                                                    @foreach ($level as $l)
                                                        <option value="{{ $l->id }}">{{ $l->nama_level }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('level_trainers_id')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror

                                            </td>
                                            <td>Roles:</td>
                                            <td>
                                                <input type="text"
                                                       class="form-control @error('roles') is-invalid @enderror"
                                                       placeholder="John Doe" name="roles"
                                                       aria-describedby="defaultFormControlHelp" value="trainer"
                                                       readonly/>
                                                @error('roles')
                                                <div class="invalid-feedback">{{ $message }}.</div>
                                                @enderror
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Ya,
                                        Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                             stroke-width="2" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round" class="css-i6dzq1">
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                            </path>
                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                            <polyline points="7 3 7 8 15 8"></polyline>
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end -->
                <!-- modal trash -->
                <div class="modal fade gd-example-modal-xl" id="modalShowTrash" tabindex="-1" role="dialog"
                     aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Trash</h5>
                            </div>
                            <div class="modal-body">
                                <form id="restoreAll" action="{{ route('trainer.restore.trash.all') }}" method="POST">
                                    @csrf
                                </form>
                                <form id="deleteAll" action="{{ route('trainer.delete.trash.all') }}" method="POST">
                                    @csrf
                                </form>
                                <a href="{{ route('trainer.restore.trash.all') }}"
                                   onclick="event.preventDefault(); document.getElementById('restoreAll').submit();"
                                   class="btn btn-primary mb-5">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                         stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                         class="css-i6dzq1">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15">
                                        </path>
                                    </svg>
                                    Restore All
                                </a>
                                <a class="btn btn-primary mb-5" href="{{ route('trainer.delete.trash.all') }}"
                                   onclick="event.preventDefault(); document.getElementById('deleteAll').submit();">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                         stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                         class="css-i6dzq1">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                    Empty Trash
                                </a>
                                <button type="button" data-bs-toggle="collapse" href="#filtersTrash" role="button"
                                        aria-expanded="false" aria-controls="filtersTrash" class="btn btn-primary mb-5">
                                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                         stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                         class="css-i6dzq1">
                                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                    </svg>
                                    Filters
                                </button>
                                <div class="collapse" id="filtersTrash">
                                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                                        <div class="card-body">
                                            <!-- Validation Form -->
                                            <h3 style="font-weight: 700">Field Filters</h3>
                                            <hr/>
                                            <form class="row g-3 needs-validation"
                                                  action="{{ route('hrd.trainer.account.list') }}" method="GET">
                                                @csrf
                                                <!-- Input -->
                                                <div class="col-md-3">
                                                    <label class="form-label" for="textInput">Nama</label>
                                                    <input type="text" id="name_trash" name="name_trash"
                                                           class="form-control @error('name_trash') is-invalid @enderror"
                                                           placeholder="search by nama" value="{{ old('name_trash') }}"/>
                                                    @error('name_trash')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="username_trash">Username</label>
                                                    <input type="text" id="username" name="username_trash"
                                                           class="form-control @error('username_trash') is-invalid @enderror"
                                                           placeholder="search by username"
                                                           value="{{ old('username_trash') }}"/>
                                                    @error('username_trash')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="form-label" for="email_trash">Email</label>
                                                    <input type="text" id="email_trash" name="email_trash"
                                                           class="form-control @error('email_trash') is-invalid @enderror"
                                                           placeholder="search by email" value="{{ old('email_trash') }}"/>
                                                    @error('email_trash')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="created_at_trash">Date</label>
                                                    <input type="date" id="created_at_trash" name="created_at_trash"
                                                           class="form-control @error('created_at_trash') is-invalid @enderror"
                                                           placeholder="search by tanggal"
                                                           value="{{ old('created_at_trash') }}"/>
                                                    @error('created_at_trash')
                                                    <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <!-- Button Block -->
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                    <button type="submit" class="btn btn-success">
                                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                                             stroke="currentColor" stroke-width="2" fill="none"
                                                             stroke-linecap="round" stroke-linejoin="round"
                                                             class="css-i6dzq1">
                                                            <circle cx="11" cy="11" r="8"></circle>
                                                            <line x1="21" y1="21" x2="16.65"
                                                                  y2="16.65"></line>
                                                        </svg>
                                                        Filter
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="trashDataTable" class="table table-striped" style="width: 100%">
                                        <thead>
                                        <tr>
                                            {{-- <th scope="col">Kode</th> --}}
                                            <th scope="col">Username</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            {{-- <th scope="col">Level</th> --}}
                                            {{-- <th scope="col">Salary</th> --}}
                                            <th scope="col">Roles</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($getTrashAccountTrainer as $gtat)
                                            <tr>
                                                {{-- <th>
                                            @empty($u->levelTrainer->kode_level)
                                                {{ $u->id }}
                                            @else
                                                {{ $u->levelTrainer->kode_level }}
                                            @endempty
                                        </th> --}}
                                                <td>{{ $gtat->username }}</td>
                                                <td>{{ $gtat->name }}</td>
                                                <td>{{ $gtat->email }}</td>
                                                {{-- <td>
                                            @empty($u->levelTrainer->nama_level)
                                                {{ __('tidak ada level') }}
                                            @else
                                                {{ $u->levelTrainer->nama_level }}
                                            @endempty
                                        </td>
                                        <td>
                                            @empty($u->levelTrainer->sallary_level)
                                                {{ __('tidak ada sallary') }}
                                            @else
                                                {{ $u->levelTrainer->sallary_level }}
                                            @endempty

                                        </td> --}}
                                                <td>{{ $gtat->roles }}</td>
                                                <td>{{ $gtat->created_at }}</td>
                                                <td>
                                                    <form action="{{ route('trainer.restore.trash', $gtat->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning mb-2 ">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                 stroke="currentColor" stroke-width="2" fill="none"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="css-i6dzq1">
                                                                <polyline points="9 14 4 9 9 4"></polyline>
                                                                <path d="M20 20v-7a4 4 0 0 0-4-4H4"></path>
                                                            </svg>
                                                            Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('trainer.delete.trash', $gtat->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-danger mb-2 show_confirm_delete">
                                                            <svg viewBox="0 0 24 24" width="20" height="20"
                                                                 stroke="currentColor" stroke-width="2" fill="none"
                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                 class="css-i6dzq1">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                                <line x1="10" y1="11" x2="10"
                                                                      y2="17">
                                                                </line>
                                                                <line x1="14" y1="11" x2="14"
                                                                      y2="17">
                                                                </line>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end -->
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script defer src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script defer src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>

    <script src="{{ asset('alsavedutech/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/plugins/toolbar/prism-toolbar.min.js') }}"></script>
    <script src="{{ asset('alsavedutech/assets/libs/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js') }}">
    </script>

    <!-- Theme JS -->
    <script src="{{ asset('alsavedutech/assets/js/theme.min.js') }}"></script>
    <script defer src="{{ asset('alsavedutech/assets/script.js') }}"></script>

    <!-- pop up show after error validation -->
    @if (count($errors) > 0)
        <script type="text/javascript">
         $( document ).ready(function() {
             $('#modalCreateAkunTrainer').modal('show');
        });
        </script>
    @endif
@endpush
