@extends('dashboard.layouts.app')

@section('title', 'Halaman Kelas')

@push('css')
    <link href="{{ asset('alsavedutech/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('alsavedutech/assets/css/theme.min.css') }}" />
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
            <div class="container-fluid px-6 py-6">
                <!-- card body -->
                <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                    <div class="card-body">
                        <!-- Validation Form -->
                        <h3 style="font-weight: 700">Class Form</h3>
                        <hr />
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
                        <form class="row g-3 needs-validation" action="{{ route('kurikulum.kelas.create') }}"
                            method="POST">
                            @csrf
                            <!-- Input -->
                            <div class="mb-3">
                                <label class="form-label" for="textInput">Class Name</label>
                                <input type="text" id="textInput"
                                    class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas"
                                    placeholder="input class name" value="{{ old('nama_kelas') }}" />
                                @error('nama_kelas')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom04" class="form-label">Class Level</label>
                                <select name="level_trainers_id"
                                    class="form-select @error('level_trainers_id') is-invalid @enderror"
                                    id="validationCustom04">
                                    <option selected disabled value="">Choose Level</option>
                                    @foreach ($level_trainer as $lt)
                                        <option value="{{ $lt->id }}">{{ $lt->nama_level }}</option>
                                    @endforeach
                                </select>
                                @error('level_trainers_id')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="validationCustom04" class="form-label">Status</label>
                                <select class="form-select @error('status_kelas') is-invalid @enderror" name="status_kelas"
                                    id="validationCustom04">
                                    <option selected disabled value="">Choose Status</option>
                                    @foreach ($statusKelas as $sk)
                                        <option value="{{ $sk }}">{{ $sk }}</option>
                                    @endforeach
                                </select>
                                @error('status_kelas')
                                    <div class="invalid-feedback">{{ $message }}.</div>
                                @enderror
                            </div>

                            <!-- Button Block -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-primary">
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="css-i6dzq1">
                                        <polyline points="1 4 1 10 7 10"></polyline>
                                        <polyline points="23 20 23 14 17 14"></polyline>
                                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15">
                                        </path>
                                    </svg>
                                    Clear
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                        stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        class="css-i6dzq1">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </svg>
                                    Make Class
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

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
                <button data-bs-toggle="collapse" href="#filterListKelas" role="button" aria-expanded="false"
                    aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('kurikulum.kelas.list') }}" role="button" aria-expanded="false"
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
                <div class="collapse" id="filterListKelas">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Field Filters</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('kurikulum.kelas.list') }}"
                                method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="nama_kelas">Class Name</label>
                                    <input type="text" id="nama_kelas" name="nama_kelas"
                                        class="form-control @error('nama_kelas') is-invalid @enderror"
                                        placeholder="search by name class" value="{{ old('nama_kelas') }}" />
                                    @error('nama_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status_kelas">Class Status</label>
                                    <input type="text" id="status_kelas" name="status_kelas"
                                        class="form-control @error('status_kelas') is-invalid @enderror"
                                        placeholder="search by class status" value="{{ old('status_kelas') }}" />
                                    @error('status_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="created_at">Date</label>
                                    <input type="date" id="created_at" name="created_at"
                                        class="form-control @error('created_at') is-invalid @enderror"
                                        placeholder="search by date" value="{{ old('created_at') }}" />
                                    @error('created_at')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="sallary_kelas">Sallary</label>
                                    <input type="text" id="sallary_kelas" name="sallary_kelas"
                                        class="form-control @error('sallary_kelas') is-invalid @enderror"
                                        placeholder="search by sallary" value="{{ old('sallary_kelas') }}" />
                                    @error('sallary_kelas')
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
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- tabel kelas -->
                <div class="mt-10">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead class="align-middle text-center">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Class UID</th>
                                    {{-- <th scope="col">kode kelas</th> --}}
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Level ID</th>
                                    <th scope="col">Level Name</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Sallary</th>
                                    <th class="text-center" scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $k)
                                    <tr>
                                        <th>{{ $k->id }}</th>
                                        {{-- <th>{{ $k->kode_kelas }}</th> --}}
                                        <td>{{ $k->uid_class }}</td>
                                        <td class="text-justify">{{ $k->nama_kelas }}</td>
                                        <td>{{ $k->level_trainers_id }}</td>
                                        <td>{{ $k->levelTrainer->nama_level }}</td>
                                        <td>{{ $k->status_kelas }}</td>
                                        <td>
                                            @empty($k->levelTrainer->sallary_level)
                                                {{ __('sallary tidak di temukan') }}
                                            @else
                                                @mata_uang($k->levelTrainer->sallary_level)
                                            @endempty
                                        </td>
                                        <td>{{ $k->created_at }}</td>
                                        <td>
                                            <form action="{{ route('kurikulum.kelas.delete', $k->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="button"
                                                    class="btn btn-warning mb-2 px-2 py-1 text-xs md:px-3 md:py-2 md:text-sm lg:px-4 lg:py-2 lg:text-base"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#EditDataKelas--{{ $k->id }}">
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
                                                <button type="submit"
                                                    class="btn btn-danger mb-2 show_confirm_delete px-2 py-1 text-xs md:px-3 md:py-2 md:text-sm lg:px-4 lg:py-2 lg:text-base">
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
                                                    Trash
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

                <!-- Modal edit kelas -->
                @foreach ($kelas as $k)
                    <div class="modal fade" id="EditDataKelas--{{ $k->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="EditDataKelasTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="EditDataKelasTitle">Edit Data Kelas</h5>
                                </div>
                                <form action="{{ route('kurikulum.kelas.update') }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <table class="table">
                                            <tbody>
                                                <input type="text" name="id" value="{{ $k->id }}" hidden>
                                                <tr data-dt-row="99" data-dt-column="2">
                                                    <td>Class Name:</td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control @error('nama_kelas') is-invalid @enderror"
                                                            id="defaultFormControlInput" placeholder="John Doe"
                                                            name="nama_kelas" aria-describedby="defaultFormControlHelp"
                                                            value="{{ $k->nama_kelas }}" />
                                                        @error('nama_kelas')
                                                            <div class="invalid-feedback">{{ $message }}.</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr data-dt-row="99" data-dt-column="3">
                                                    <td>Class Level:</td>
                                                    <td>
                                                        <select
                                                            class="form-select @error('level_trainers_id') is-invalid @enderror"
                                                            id="validationCustom04" name="level_trainers_id">
                                                            <option selected disabled value="">Choose Level</option>
                                                            @foreach ($level_trainer as $lt)
                                                                <option value="{{ $lt->id }}"
                                                                    {{ $k->level_trainers_id == $lt->id ? 'selected' : 'null' }}>
                                                                    {{ $lt->nama_level }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                        @error('level_trainers_id')
                                                            <div class="invalid-feedback">{{ $message }}.</div>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr data-dt-row="99" data-dt-column="4">
                                                    <td>Status:</td>
                                                    <td>
                                                        <select
                                                            class="form-select @error('status_kelas') is-invalid @enderror"
                                                            id="validationCustom04" name="status_kelas">
                                                            <option selected disabled value="">Choose Status</option>
                                                            @foreach ($statusKelas as $sk)
                                                                <option value="{{ $sk }}"
                                                                    {{ $k->status_kelas == $sk ? 'selected' : '' }}>
                                                                    {{ $sk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('status_kelas')
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

                <!-- modal trash -->
                <div class="modal fade gd-example-modal-xl" id="modalShowTrash" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Trash</h5>
                            </div>
                            <div class="modal-body">
                                <form id="restoreAll" action="{{ route('kurikulum.kelas.restore.trash.all') }}"
                                    method="POST">
                                    @csrf
                                </form>
                                <form id="deleteAll" action="{{ route('kurikulum.kelas.delete.trash.all') }}"
                                    method="POST">
                                    @csrf
                                </form>
                                <a href="{{ route('kurikulum.kelas.restore.trash.all') }}"
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
                                <a class="btn btn-primary mb-5" href="{{ route('kurikulum.kelas.delete.trash.all') }}"
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
                                            <hr />
                                            <form class="row g-3 needs-validation"
                                                action="{{ route('kurikulum.kelas.list') }}" method="GET">
                                                @csrf
                                                <!-- Input -->
                                                <div class="col-md-3">
                                                    <label class="form-label" for="textInput">Class Name</label>
                                                    <input type="text" id="nama_kelas_trash" name="nama_kelas_trash"
                                                        class="form-control @error('nama_kelas_trash') is-invalid @enderror"
                                                        placeholder="search by nama level"
                                                        value="{{ old('nama_kelas_trash') }}" />
                                                    @error('nama_kelas_trash')
                                                        <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="status_kelas_trash">Class Status
                                                    </label>
                                                    <input type="text" id="username" name="status_kelas_trash"
                                                        class="form-control @error('status_kelas_trash') is-invalid @enderror"
                                                        placeholder="search by sallary level"
                                                        value="{{ old('status_kelas_trash') }}" />
                                                    @error('status_kelas_trash')
                                                        <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label" for="created_at_trash">Date</label>
                                                    <input type="date" id="created_at_trash" name="created_at_trash"
                                                        class="form-control @error('created_at_trash') is-invalid @enderror"
                                                        placeholder="search by tanggal"
                                                        value="{{ old('created_at_trash') }}" />
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
                                                        Cari
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive lg:max-w-full">
                                    <table id="trashDataTable" class="table table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Class UID</th>
                                                {{-- <th scope="col">kode kelas</th> --}}
                                                <th scope="col">Class Name</th>
                                                <th scope="col">Level ID</th>
                                                <th scope="col">Level Name</th>
                                                <th scope="col">status</th>
                                                <th scope="col">Sallary</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getTrashByKelas as $gtbk)
                                                <tr>
                                                    <th>{{ $loop->iteration }}</th>
                                                    {{-- <th>{{ $k->kode_kelas }}</th> --}}
                                                    <td>{{ $gtbk->uid_class }}</td>
                                                    <td>{{ $gtbk->nama_kelas }}</td>
                                                    <td>{{ $gtbk->level_trainers_id }}</td>
                                                    <td>{{ $gtbk->levelTrainer->nama_level }}</td>
                                                    <td>{{ $gtbk->status_kelas }}</td>
                                                    <td>
                                                        @empty($gtbk->levelTrainer->sallary_level)
                                                            {{ __('sallary tidak di temukan') }}
                                                        @else
                                                            @mata_uang($gtbk->levelTrainer->sallary_level)
                                                        @endempty
                                                    </td>
                                                    <td>{{ $gtbk->created_at }}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('kurikulum.kelas.restore.trash', $gtbk->id) }}"
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
                                                        <form
                                                            action="{{ route('kurikulum.kelas.delete.trash', $gtbk->id) }}"
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
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

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
@endpush
