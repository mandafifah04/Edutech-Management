@extends('dashboard.layouts.app')

@section('title', 'Halaman Assigned Kelas')

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

@php
    $tanggalNow = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
    $waktuNow = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('H:i:s');
@endphp

@section('content')
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        @include('dashboard.layouts.sidebar')
        <!-- Page content -->
        <div id="page-content">
            @include('dashboard.layouts.header')
            <div class="container-fluid px-6 py-4">
                <button data-bs-toggle="collapse" href="#filtersListUser" role="button" aria-expanded="false"
                    aria-controls="filtersTrash" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
                <a href="{{ route('trainers.kelas') }}" role="button" aria-expanded="false" class="btn btn-primary mb-5">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    Refresh Filter
                </a>

                <!-- filter absen kelas -->
                <div class="collapse" id="filtersListUser">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded-3">
                        <div class="card-body">
                            <!-- Validation Form -->
                            <h3 style="font-weight: 700">Filters</h3>
                            <hr />
                            <form class="row g-3 needs-validation" action="{{ route('trainers.kelas') }}" method="GET">
                                @csrf
                                <!-- Input -->
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Level Trainer</label>
                                    <select class="form-select @error('level_trainer') is-invalid @enderror"
                                        name="level_trainer" id="validationCustom04">
                                        <option selected disabled value="">Choose Level Trainer</option>
                                        @foreach ($getLevelTrainer as $glt)
                                            <option value="{{ $glt->nama_level }}">{{ $glt->nama_level }}</option>
                                        @endforeach
                                    </select>
                                    @error('level_trainer')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom04" class="form-label">Status</label>
                                    <select class="form-select @error('status_kelas') is-invalid @enderror"
                                        name="status_kelas" id="validationCustom04">
                                        <option selected disabled value="">Choose Status</option>
                                        @foreach ($status_kelas as $sk)
                                            <option value="{{ $sk }}">{{ $sk }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="nama_kelas">Class Name</label>
                                    <input type="text" id="nama_kelas" name="nama_kelas"
                                        class="form-control @error('nama_kelas') is-invalid @enderror"
                                        placeholder="Search By Class Name" value="{{ old('nama_kelas') }}" />
                                    @error('nama_kelas')
                                        <div class="invalid-feedback">{{ $message }}.</div>
                                    @enderror
                                </div>
                                <!-- Button Block -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-success">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                            stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                            class="css-i6dzq1">
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

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <span class="divider fw-bold my-3">Class Schedule and Attendance</span>
                    </div>
                </div>
                <!-- scrollspy navbar -->
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

                @foreach ($getKelasByTrainer as $gkbt)
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="rows" style="display: flex; flex-wrap: nowrap; justify-content: space-between">
                                <h3>{{ $gkbt->kelas->nama_kelas }}</h3>
                                <h3>{{ $gkbt->kelas->uid_class }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table" style="font-size: medium">
                                <tbody>
                                    <tr data-dt-row="99" data-dt-column="2">
                                        <td>Class Level</td>
                                        <td>: {{ $gkbt->kelas->levelTrainer->nama_level }}</td>
                                    </tr>
                                    <tr data-dt-row="99" data-dt-column="3">
                                        <td>Create Class</td>
                                        <td>: {{ $gkbt->kelas->created_at }}</td>
                                    </tr>
                                    <tr data-dt-row="99" data-dt-column="4">
                                        <td>Update Class</td>
                                        <td>: {{ $gkbt->kelas->updated_at }}</td>
                                    </tr>
                                    <tr data-dt-row="99" data-dt-column="5">
                                        <td>Class Status</td>
                                        <td>: <span
                                                class="badge bg-info text-dark">{{ $gkbt->kelas->status_kelas }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Button Block -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#jadwalKelas--{{ $gkbt->kelas->id }}">Attend</button>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($getKelasByTrainer as $gkbt)
                    <!-- data modals -->
                    <div class="modal fade gd-example-modal-xl" id="jadwalKelas--{{ $gkbt->kelas->id }}" tabindex="-1"
                        role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Jadwal Kelas</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table text-nowrap mb-0" style="width: 100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Hari</th>
                                                    <th>Jam Mulai</th>
                                                    <th>Jam Berakhir</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--
                                                                                    1. ambil semua data jadwal pada kelas berdasarkan dari total pertemuan kelas
                                                                                     -->
                                                @foreach ($gkbt->kelas->jadwalKelas as $jadwalOfKelas)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3 lh-1">
                                                                    <h5 class="mb-1"><a href="#"
                                                                            class="text-inherit">{{ $jadwalOfKelas->hari_jadwal_kelas }}</a>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $jadwalOfKelas->jam_mulai_jadwal_kelas }}
                                                        </td>
                                                        <td class="align-middle">
                                                            <span>{{ $jadwalOfKelas->jam_akhir_jadwal_kelas }}</span>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span>{{ $jadwalOfKelas->tanggal_jadwal_kelas }}</span>
                                                        </td>
                                                        <!--
                                                                                                2. logic set absen berdasarkan pertemuan
                                                                                                3. cek apakah tanggal sekarang sesuai dengan tanggal dari jadwal kelas yang di handle && waktu sekarang sudah melewati jam akhir jadwal dari kelas
                                                                                                (yang artinya absen akan bisa dilakukan setelah jam akhir kelas)
    -->
                                                        @if ($tanggalNow == $jadwalOfKelas->tanggal_jadwal_kelas && $waktuNow > $jadwalOfKelas->jam_akhir_jadwal_kelas)
                                                            <form
                                                                action="{{ route('trainer.absen.jadwal', ['id_jadwal' => $jadwalOfKelas->id, 'kelas_id' => $gkbt->kelas->id, 'id_trainer' => Auth::guard('user')->user()->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <td class="align-middle text-dark">
                                                                    <button type="submit" class="btn btn-primary mb-2">
                                                                        <svg viewBox="0 0 24 24" width="20"
                                                                            height="20" stroke="currentColor"
                                                                            stroke-width="2" fill="none"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="css-i6dzq1">
                                                                            <polyline points="9 11 12 14 22 4"></polyline>
                                                                            <path
                                                                                d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                            </path>
                                                                        </svg>
                                                                        Absen
                                                                    </button>
                                                                </td>
                                                            </form>
                                                        @else
                                                            <td class="align-middle text-dark">
                                                                <a href="" class="btn btn-primary mb-2 disabled">
                                                                    <svg viewBox="0 0 24 24" width="20"
                                                                        height="20" stroke="currentColor"
                                                                        stroke-width="2" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="css-i6dzq1">
                                                                        <polyline points="9 11 12 14 22 4"></polyline>
                                                                        <path
                                                                            d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                                                                        </path>
                                                                    </svg>
                                                                    Absen
                                                                </a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

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
