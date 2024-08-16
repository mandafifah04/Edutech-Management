@extends('dashboard.layouts.app')

@section('title', 'Halaman Trainer Account')

@push('css')
    <link href="{{ asset('alsavedutech/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css" />
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
                        <h3 style="font-weight: 700">Salary Report</h3>
                        <hr />
                    </div>
                </div>
                <!-- tabel kelas -->
                {{-- <a href="{{ route('keuangan.recap.export.pdf') }}" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    Print Report
                </a> --}}
                <button data-bs-toggle="collapse" href="#PrintReportSallary" role="button" aria-expanded="false"
                    aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    Print Report
                </button>
                <button data-bs-toggle="collapse" href="#filterBySallaryReportsFinance" role="button" aria-expanded="false"
                    aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('keuangan.reports') }}" role="button" aria-expanded="false" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    Refresh Filter
                </a>
                <div class="collapse" id="filterBySallaryReportsFinance">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Basic Filters</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('keuangan.reports') }}" method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="nama_trainer">Name Trainer</label>
                                    <input type="text" id="nama_trainer" name="nama_trainer"
                                        class="form-control @error('nama_trainer') is-invalid @enderror"
                                        placeholder="Insert trainer name" value="{{ old('nama_trainer') }}" />
                                    @error('nama_trainer')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="level_trainer">Level Trainer</label>
                                    <select id="level_trainer" name="level_trainer"
                                        class="form-control @error('level_trainer') is-invalid @enderror">
                                        <option value="">Select level trainer</option>
                                        @foreach ($GetLevelTrainer as $glt)
                                            <option value="{{ $glt->nama_level }}">{{ $glt->nama_level }}</option>
                                        @endforeach
                                    </select>
                                    @error('level_trainer')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="status_verified">Status</label>
                                    <select id="status_verified" name="status_verified"
                                        class="form-control @error('status_verified') is-invalid @enderror">
                                        <option value="">Select status verification</option>
                                        @for ($i = 0; $i <= 1; $i++)
                                            <option value="{{ $StatusVerified[$i] }}">{{ $StatusVerified[$i] }}</option>
                                        @endfor
                                    </select>
                                    @error('status_verified')
                                        <div class="invalid-feedback">
                                            {{ $message }}.
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="total_gaji">Sallary</label>
                                    <input type="text" id="total_gaji" name="total_gaji"
                                        class="form-control @error('total_gaji') is-invalid @enderror"
                                        placeholder="Insert sallary" value="{{ old('total_gaji') }}" />
                                    @error('total_gaji')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="created_at">Date</label>
                                    <input type="date" id="created_at" name="created_at"
                                        class="form-control @error('created_at') is-invalid @enderror"
                                        placeholder="Search class date" value="{{ old('created_at') }}" />
                                    @error('created_at')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="bulan">Month</label>
                                    <select id="bulan" name="bulan"
                                        class="form-control @error('bulan') is-invalid @enderror">
                                        <option value="">Select month</option>
                                        @for ($i = 0; $i <= 11; $i++)
                                            <option value="{{ $i + 1 }}">{{ $Month[$i] }}</option>
                                        @endfor
                                    </select>
                                    @error('bulan')
                                        <div class="invalid-feedback">
                                            {{ $message }}.
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tahun">Year</label>
                                    <select id="tahun" name="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror">
                                        <option value="">Select year</option>
                                        @for ($year = 1800; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('tahun')
                                        <div class="invalid-feedback">
                                            {{ $message }}.
                                        </div>
                                    @enderror
                                </div>
                                <h3 style="font-weight: 700">Range Filter</h3>
                                <hr />
                                <div class="col-md-3">
                                    <label class="form-label" for="start_at">Start At</label>
                                    <input type="date" id="start_at" name="start_at"
                                        class="form-control @error('start_at') is-invalid @enderror"
                                        placeholder="search by tanggal kelas" value="{{ old('start_at') }}" />
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="end_at">End At</label>
                                    <input type="date" id="end_at" name="end_at"
                                        class="form-control @error('end_at') is-invalid @enderror"
                                        placeholder="search by tanggal kelas" value="{{ old('end_at') }}" />
                                    @error('end_at')
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
                <div class="collapse" id="PrintReportSallary">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Choose Range Of Recap Sallary</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('keuangan.recap.export.pdf') }}"
                                method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label class="form-label" for="start_at">Start At</label>
                                    <input type="date" id="start_at" name="start_at"
                                        class="form-control @error('start_at') is-invalid @enderror"
                                        placeholder="search by tanggal kelas" value="{{ old('start_at') }}" />
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="end_at">End At</label>
                                    <input type="date" id="end_at" name="end_at"
                                        class="form-control @error('end_at') is-invalid @enderror"
                                        placeholder="search by tanggal kelas" value="{{ old('end_at') }}" />
                                    @error('end_at')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <!-- Button Block -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-success">
                                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round" class="css-i6dzq1">
                                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                            <path
                                                d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                            </path>
                                            <rect x="6" y="14" width="12" height="8"></rect>
                                        </svg>
                                        Print
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                <div class="mt-5">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Trainer Name</th>
                                    <th scope="col">Level Trainer</th>
                                    <th scope="col">Sallary</th>
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Meets</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($GetSallaryReports as $gsr)
                                    <tr>
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <button type="button"
                                                        class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                        data-bs-target="#detailSallaryReports--{{ $gsr->id }}"
                                                        data-bs-toggle="modal" data-bs-dismiss="modal">
                                                        <svg viewBox="0 0 24 24" width="44" height="44"
                                                            stroke="#0066ff" stroke-width="2" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="css-i6dzq1">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <line x1="12" y1="16" x2="12"
                                                                y2="12">
                                                            </line>
                                                            <line x1="12" y1="8" x2="12.01"
                                                                y2="8">
                                                            </line>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="ms-3 lh-1">
                                                    <h5 class="mb-1"><a href="#"
                                                            class="text-inherit">{{ $loop->iteration }}</a></h5>
                                                </div>
                                            </div>
                                        </th>
                                        <td>{{ $gsr->user->name }}</td>
                                        <td>{{ $gsr->user->levelTrainer->nama_level }}</td>
                                        <td>@mata_uang($gsr->total_gaji)</td>
                                        <td>{{ $gsr->kelas->nama_kelas }}</td>
                                        <td>{{ count($gsr->assignedKelas->kelas->jadwalKelas) }}</td>
                                        <td>
                                            @if ($gsr->status != 'unverified')
                                                <span class="badge bg-success">{{ $gsr->status }}
                                                @else
                                                    <span class="badge bg-danger">{{ $gsr->status }}
                                            @endif
                                            </span>
                                        </td>
                                        <td>{{ $gsr->created_at }}</td>
                                        <td>
                                            @if ($gsr->status == 'verified')
                                                <a class="btn btn-warning mb-2 disabled">
                                                    <svg viewBox="0 0 24 24" width="20" height="20"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                    </svg>
                                                    Approval
                                                </a>
                                            @else
                                                <a href="{{ route('keuangan.verify', ['id_sallary' => $gsr->id, 'status' => 'verified']) }}"
                                                    class="btn btn-warning mb-2">
                                                    <svg viewBox="0 0 24 24" width="20" height="20"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                    </svg>
                                                    Approval
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end -->

                <!-- modal detail -->
                @foreach ($GetSallaryReports as $gsr)
                    <div class="modal fade" id="detailSallaryReports--{{ $gsr->id }}" aria-hidden="true"
                        aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail Salary Report</h5>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <tbody>
                                            <tr data-dt-row="99" data-dt-column="1">
                                                <td>Kelas:</td>
                                                <td>{{ $gsr->kelas->nama_kelas }}|{{ $gsr->kelas->status_kelas }}|{{ $gsr->kelas->levelTrainer->nama_level }}
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="2">
                                                <td>Schedule:</td>
                                                <td>{{ $gsr->kelas->jadwalKelass->tanggal_jadwal_kelas }}
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="3">
                                                <td>Day:</td>
                                                <td>{{ $gsr->kelas->jadwalKelass->hari_jadwal_kelas }}
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="4">
                                                <td>Salary:</td>
                                                <td>@mata_uang($gsr->total_gaji)</td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="5">
                                                <td>Star At:</td>
                                                <td>{{ $gsr->kelas->jadwalKelass->jam_mulai_jadwal_kelas }}
                                                </td>
                                            </tr>
                                            <tr data-dt-row="99" data-dt-column="5">
                                                <td>End At:</td>
                                                <td>{{ $gsr->kelas->jadwalKelass->jam_akhir_jadwal_kelas }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
@endpush
