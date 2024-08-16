@extends('dashboard.layouts.app')

@section('title', 'Halaman Schedule Class')

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
                        <h3 style="font-weight: 700">Trainer Class Schedule</h3>
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
                <a data-bs-toggle="collapse" href="#MakeSchedules" role="button" aria-expanded="false"
                    aria-controls="MakeSchedules" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Make Schedules
                </a>
                <button data-bs-toggle="collapse" href="#FilterClass" role="button" aria-expanded="false"
                    aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('hrd.trainer.schedule.list') }}" role="button" aria-expanded="false"
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
                <div class="collapse" id="FilterClass">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Field Filters</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('hrd.trainer.schedule.list') }}"
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
                <!-- modal tambah -->
                <div class="collapse" id="MakeSchedules">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Create Class Schedule</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('hrd.trainer.schedule.create') }}"
                                method="POST">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="textInput">Date</label>
                                    <input type="date" id="tanggal_jadwal_kelas" name="tanggal_jadwal_kelas"
                                        class="form-control @error('tanggal_jadwal_kelas') is-invalid @enderror"
                                        placeholder="Choose Date" value="{{ old('tanggal_jadwal_kelas') }}" />
                                    @error('tanggal_jadwal_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom04" class="form-label">Choose Class</label>
                                    <select class="form-select @error('kelas_id') is-invalid @enderror"
                                        id="validationCustom04" name="kelas_id">
                                        <option selected disabled value="">Pilih Kelas</option>
                                        @foreach ($getKelas as $gk)
                                            <option value="{{ $gk->id }}">{{ $gk->nama_kelas }} |
                                                {{ $gk->status_kelas }}
                                                | {{ $gk->levelTrainer->nama_level }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="textInput">Start At</label>
                                    <input type="time" id="jam_mulai_jadwal_kelas" name="jam_mulai_jadwal_kelas"
                                        class="form-control @error('jam_mulai_jadwal_kelas') is-invalid @enderror"
                                        placeholder="Insert Start Time Of Class"
                                        value="{{ old('jam_mulai_jadwal_kelas') }}" />
                                    @error('jam_mulai_jadwal_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="pertemuan_kelas">Meets</label>
                                    <select id="pertemuan_kelas" name="pertemuan_kelas"
                                        class="form-control @error('pertemuan_kelas') is-invalid @enderror">
                                        <option value="">Select Total Meets</option>
                                        @for ($Meets = 1; $Meets <= 12; $Meets++)
                                            <option value="{{ $Meets }}">{{ $Meets }}</option>
                                        @endfor
                                    </select>
                                    @error('pertemuan_kelas')
                                        <div class="invalid-feedback">
                                            {{ $message }}.
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-success">
                                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z">
                                            </path>
                                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                            <polyline points="7 3 7 8 15 8"></polyline>
                                        </svg>
                                        Create Schedule
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end -->
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">UID Class</th>
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Class Status</th>
                                    <th scope="col">Class Level</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getKelas as $gk)
                                    <tr>
                                        <th>{{ $gk->uid_class }}</th>
                                        <th>{{ $gk->nama_kelas }}</th>
                                        <td>{{ $gk->status_kelas }}</td>
                                        <td>{{ $gk->levelTrainer->nama_level }}</td>
                                        <td>{{ $gk->created_at }}</td>
                                        <td>
                                            <a
                                                href="{{ route('hrd.trainer.schedule.detail.list', ['id_kelas' => $gk->id]) }}" class="btn btn-primary mb-5">
                                                @csrf
                                                <svg viewBox="0 0 24 24" width="20" height="20"
                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6">
                                                    </line>
                                                    <line x1="8" y1="2" x2="8" y2="6">
                                                    </line>
                                                    <line x1="3" y1="10" x2="21" y2="10">
                                                    </line>
                                                </svg>
                                                Show Schedule
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
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
