@extends('dashboard.layouts.app')

@section('title', 'Absen Trainer')

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
            <div class="container-fluid px-6 py-4">
                <!-- card body -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- text -->
                        <!-- <div class="text-center mb-7"></div> -->
                        <h3 style="font-weight: 700">Absen Trainer</h3>
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
                    </div>
                </div>
                <!-- tabel kelas -->
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
                <a href="{{ route('trainer.recap.absen') }}" role="button" aria-expanded="false"
                    class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    Refresh Filter
                </a>
                <a href="{{ route('trainer.recap.absen.export.excel') }}" role="button" aria-expanded="false"
                    class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('trainer.recap.absen.export.pdf') }}" role="button" aria-expanded="false"
                    class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Export PDF
                </a>
                <!-- BEGIN::filter data -->
                <div class="collapse" id="filtersListUser">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Field Filters</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('trainer.recap.absen') }}"
                                method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="hari_jadwal_kelas">Day</label>
                                    <input type="text" id="hari_jadwal_kelas" name="hari_jadwal_kelas"
                                        class="form-control @error('hari_jadwal_kelas') is-invalid @enderror"
                                        placeholder="Search by day" value="{{ old('hari_jadwal_kelas') }}" />
                                    @error('hari_jadwal_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tanggal_jadwal_kelas">Date</label>
                                    <input type="date" id="tanggal_jadwal_kelas" name="tanggal_jadwal_kelas"
                                        class="form-control @error('tanggal_jadwal_kelas') is-invalid @enderror"
                                        placeholder="Search by date" value="{{ old('tanggal_jadwal_kelas') }}" />
                                    @error('tanggal_jadwal_kelas')
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

                <!-- list absen -->
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col">Kode Kelas</th> --}}
                                    <th scope="col">ID</th>
                                    <th scope="col">Trainer Name</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Class Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getRecapAbsen as $gra)
                                    <tr>
                                        {{-- <th>{{ $gst->kelas->kode_kelas }}</th> --}}
                                        <th>{{ $loop->iteration }}</th>
                                        <th>{{ $gra->user->name }}</th>
                                        <th>{{ $gra->jadwal->kelas->nama_kelas }}</th>
                                        <th>{{ $gra->jadwal->tanggal_jadwal_kelas }}</th>
                                        <td>{{ $gra->jadwal->jam_mulai_jadwal_kelas }}</td>
                                        <td>{{ $gra->jadwal->jam_akhir_jadwal_kelas }}</td>
                                        <td>{{ $gra->jadwal->hari_jadwal_kelas }}</td>
                                        <td>{{ $gra->jadwal->kelas->status_kelas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end -->

                <!-- modal trash absen-->
                <div class="modal fade gd-example-modal-xl" id="modalShowTrash" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Trash</h5>
                            </div>
                            <div class="modal-body">
                                <form id="restoreAll" action="{{ route('trainer.recap.absen.restore.trash.all') }}"
                                    method="POST">
                                    @csrf
                                </form>
                                <form id="deleteAll" action="{{ route('trainer.recap.absen.delete.trash.all') }}"
                                    method="POST">
                                    @csrf
                                </form>
                                <a href="{{ route('trainer.recap.absen.restore.trash.all') }}"
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
                                <a class="btn btn-primary mb-5"
                                    href="{{ route('trainer.recap.absen.delete.trash.all') }}"
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
                                                action="{{ route('trainer.recap.absen') }}" method="GET">
                                                @csrf
                                                <!-- Input -->
                                                <div class="col-md-3">
                                                    <label class="form-label" for="hari_jadwal_kelas_trash">Day</label>
                                                    <input type="text" id="hari_jadwal_kelas_trash"
                                                        name="hari_jadwal_kelas_trash"
                                                        class="form-control @error('hari_jadwal_kelas_trash') is-invalid @enderror"
                                                        placeholder="Search by day"
                                                        value="{{ old('hari_jadwal_kelas_trash') }}" />
                                                    @error('hari_jadwal_kelas_trash')
                                                        <div class="invalid-feedback">{{ $message }}.</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label"
                                                        for="tanggal_jadwal_kelas_trash">Date</label>
                                                    <input type="date" id="tanggal_jadwal_kelas_trash"
                                                        name="tanggal_jadwal_kelas_trash"
                                                        class="form-control @error('tanggal_jadwal_kelas_trash') is-invalid @enderror"
                                                        placeholder="Search by date"
                                                        value="{{ old('tanggal_jadwal_kelas_trash') }}" />
                                                    @error('tanggal_jadwal_kelas_trash')
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
                                <div class="table-responsive">
                                    <table id="trashDataTable" class="table table-striped" style="width: 100%">
                                        <thead>
                                            <tr>
                                                {{-- <th scope="col">Kode Kelas</th> --}}
                                                <th scope="col">ID</th>
                                                <th scope="col">Trainer Name</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">End Time</th>
                                                <th scope="col">Day</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getTrashByRecapAbsen as $gtbra)
                                                <tr>
                                                    {{-- <th>{{ $gts->kelas->kode_kelas }}</th> --}}
                                                    <th>{{ $loop->iteration }}</th>
                                                    <th>{{ $gtbra->user->name }}</th>
                                                    <th>{{ $gtbra->jadwal->tanggal_jadwal_kelas }}</th>
                                                    <td>{{ $gtbra->jadwal->jam_mulai_jadwal_kelas }}</td>
                                                    <td>{{ $gtbra->jadwal->jam_akhir_jadwal_kelas }}</td>
                                                    <td>{{ $gtbra->jadwal->hari_jadwal_kelas }}</td>
                                                    <td>
                                                        <form
                                                            action="{{ route('trainer.recap.absen.restore.trash', $gtbra->id) }}"
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
                                                            action="{{ route('trainer.recap.absen.delete.trash', $gtbra->id) }}"
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
