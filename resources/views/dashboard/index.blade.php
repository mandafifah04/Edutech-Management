@extends('dashboard.layouts.app')

@php
    if (Auth::guard('admin')->check()) {
        $title = 'Welcome To Dashboard Admin';
    } elseif (Auth::guard('user')->check()) {
        $title = 'Welcome To Dashboard User';
    }

    $Carbon = \Carbon\Carbon::now()->timezone(config('app.timezone'));
@endphp

@section('title', $title)

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
            <div class="bg-primary pt-10 pb-21"></div>
            <div class="container-fluid mt-n22 px-6">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mb-2 mb-lg-0">
                                    <h3 class="mb-0 text-white">Welcome Back,
                                        @if (Auth::guard('user')->check())
                                            {{ Auth::guard('user')->user()->roles }}
                                        @elseif(Auth::guard('admin')->check())
                                            {{ Auth::guard('admin')->user()->roles }}
                                        @endif!
                                    </h3>
                                </div>
                                @if (Auth::guard('admin')->check())
                                    @if (Auth::guard('admin')->user()->roles == 'admin')
                                        {{-- <div>
                                            <a href="#" class="btn btn-white">See Other Schedule</a>
                                        </div> --}}
                                    @endif
                                @elseif(Auth::guard('user')->check())
                                    @if (Auth::guard('user')->user()->roles != 'hrd')
                                        {{-- <div>
                                            <a href="#" class="btn btn-white">See Other Schedule</a>
                                        </div> --}}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (Auth::guard('user')->check())

                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                @if (Auth::guard('user')->user()->roles == 'trainer')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Handle Class</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-box-arrow-up-right fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getTotalHandleKelasTrainer }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'hrd')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">All Trainers Account</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-person-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countAkunTrainer }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Class</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-filter-square-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countKelasOfKurikulum }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'keuangan')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Reports</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-filter-square-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getTotalSallaryReports }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                @if (Auth::guard('user')->user()->roles == 'trainer')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Schedule Class</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-calendar-date-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getScheduleOnClassAndTotalTime }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'hrd')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">All Schedule</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-calendar-week-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countJadwalKelas }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Class Is Deleted</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-x-square-fill"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countKelasHasDeleteOfKurikulum }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'keuangan')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Verify Sallary</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-check-circle-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getTotalVerifySallaryReports }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                @if (Auth::guard('user')->user()->roles == 'trainer')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Time</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-clock-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getScheduleOnClassAndTotalTime }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'hrd')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Sallary And Level</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-cash fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countSallaryAndLevels }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Assigned Class</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-briefcase fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countAssignedClassOfKurikulum }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'keuangan')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Unverify Sallary</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-file-earmark-x-fill fs-4"></i>

                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getTotalUnerifySallaryReports }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                @if (Auth::guard('user')->user()->roles == 'trainer')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Total Absen Recap</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-archive-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $getTotalAbsenRecapOnTrainer }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'hrd')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Delete Schedule</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-calendar-x-fill fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countJadwalKelasHasDelete }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Assigned Class Is Deleted</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-briefcase fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h1 class="fw-bold">{{ $countAssignedClassHasDeleteOfKurikulum }}</h1>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'keuangan')
                                    <div class="card-body">
                                        <!-- heading -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="mb-0">Expand Total</h4>
                                            </div>
                                            <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                                <i class="bi bi-currency-dollar fs-4"></i>
                                            </div>
                                        </div>
                                        <!-- project number -->
                                        <div>
                                            <h3 class="fw-bold">@mata_uang($getExpandTotalSallaryReports)</h3>
                                            {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif(Auth::guard('admin')->check())
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->

                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">User Account</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                            <i class="bi bi-briefcase fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div>
                                        <h1 class="fw-bold">{{ $getAccountUser }}</h1>
                                        {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Sallary Submmited</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                            <i class="bi bi-briefcase fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div>
                                        <h1 class="fw-bold">{{ $getCountTotalGaji['verified'] }}</h1>
                                        <p class="mb-0"><span
                                                class="text-dark me-2">{{ $getCountTotalGaji['unverified'] }}</span>Unverified
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Trainer Account</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                            <i class="bi bi-briefcase fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div>
                                        <h1 class="fw-bold">{{ $getAccountTrainer }}</h1>
                                        {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                <div class="card-body">
                                    <!-- heading -->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h4 class="mb-0">Account user has deleted</h4>
                                        </div>
                                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                                            <i class="bi bi-briefcase fs-4"></i>
                                        </div>
                                    </div>
                                    <!-- project number -->
                                    <div>
                                        <h1 class="fw-bold">{{ $getAccountUserHasDeleted }}</h1>
                                        {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- row  -->
                <div class="row mt-6">
                    <div class="col-md-12 col-12">
                        <!-- card  -->
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

                        <div class="card">
                            @if (Auth::guard('admin')->check())
                                @if (Auth::guard('admin')->user()->roles == 'admin')
                                    <!-- admin -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="margin-left: 30px" class="py-4">
                                            <h4 class="mb-0">Make user account in here!</h4>
                                        </div>
                                        <div style="margin-right: 30px" class="py-4">
                                            <a href="{{ route('admin.account.user.list') }}" class="btn btn-primary mb-2"
                                                target="_blank">Make
                                                Account User</a>
                                        </div>
                                    </div>
                                @endif
                            @elseif(Auth::guard('user')->check())
                                @if (Auth::guard('user')->user()->roles == 'hrd')
                                    <!-- hrd -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="margin-left: 30px" class="py-4">
                                            <h4 class="mb-0">Make trainer account in here!</h4>
                                        </div>
                                        <div style="margin-right: 30px" class="py-4">
                                            <a href="{{ route('hrd.trainer.account.list') }}"
                                                class="btn btn-primary mb-2">Make
                                                Trainer Account</a>
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                                    <!-- kurikulum -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="margin-left: 30px" class="py-4">
                                            <h4 class="mb-0">Create Class Here!</h4>
                                        </div>
                                        <div style="margin-right: 30px" class="py-4">
                                            <a href="{{ route('kurikulum.kelas.list') }}"
                                                class="btn btn-primary mb-2">Create Class</a>
                                        </div>
                                    </div>
                                @elseif(Auth::guard('user')->user()->roles == 'trainer')
                                    <!-- trainers  -->
                                    <!-- check attendance hide-->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="margin-left: 30px" class="py-4">
                                            <h4 class="mb-0">Has the trainer taken absen today?</h4>
                                        </div>
                                        <div style="margin-right: 30px" class="py-4">
                                            <a href="{{ route('trainer.recap.absen') }}"
                                                class="btn btn-primary mb-2">Check Absen</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <!-- data modal -->
                {{-- <div class="modal fade gd-example-modal-xl" id="exampleModal-2" tabindex="-1" role="dialog"
                    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Teaching Attendance</h5>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="example" class="table text-nowrap mb-0" style="width: 100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Project name</th>
                                                <th>Hours</th>
                                                <th>priority</th>
                                                <th>Members</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#"
                                                                    class="text-inherit">Dropbox Design System</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">34</td>
                                                <td class="align-middle"><span class="badge bg-warning">Medium</span></td>
                                                <td class="align-middle">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-1.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-2.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-3.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+5</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark">
                                                    <div class="float-start me-3">15%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 15%" aria-valuenow="15" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#"
                                                                    class="text-inherit">Slack Team UI Design</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">47</td>
                                                <td class="align-middle"><span class="badge bg-danger">High</span></td>
                                                <td class="align-middle">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-4.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-5.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-6.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+5</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark">
                                                    <div class="float-start me-3">35%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#"
                                                                    class="text-inherit">GitHub Satellite</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">120</td>
                                                <td class="align-middle"><span class="badge bg-info">Low</span></td>
                                                <td class="align-middle">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-7.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-8.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-9.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+1</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark">
                                                    <div class="float-start me-3">75%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#" class="text-inherit">3D
                                                                    Character Modelling</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">89</td>
                                                <td class="align-middle"><span class="badge bg-warning">Medium</span></td>
                                                <td class="align-middle">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-10.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-11.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-12.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+5</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark">
                                                    <div class="float-start me-3">63%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 63%" aria-valuenow="63" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#"
                                                                    class="text-inherit">Webapp Design System</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle">108</td>
                                                <td class="align-middle"><span class="badge bg-success">Track</span></td>
                                                <td class="align-middle">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-13.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-14.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-15.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+5</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark">
                                                    <div class="float-start me-3">100%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="align-middle border-bottom-0">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <button type="button"
                                                                class="btn btn-icon btn-white border border-2 rounded-circle btn-dashed ms-2"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                <svg viewBox="0 0 24 24" width="44" height="44"
                                                                    stroke="#0066ff" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <circle cx="12" cy="12" r="10"></circle>
                                                                    <line x1="12" y1="16" x2="12"
                                                                        y2="12"></line>
                                                                    <line x1="12" y1="8" x2="12.01"
                                                                        y2="8"></line>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="ms-3 lh-1">
                                                            <h5 class="mb-1"><a href="#"
                                                                    class="text-inherit">Github Event Design</a></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle border-bottom-0">120</td>
                                                <td class="align-middle border-bottom-0"><span
                                                        class="badge bg-info">Low</span></td>
                                                <td class="align-middle border-bottom-0">
                                                    <div class="avatar-group">
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-13.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-14.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm">
                                                            <img alt="avatar"
                                                                src="{{ asset('alsavedutech/assets/images/avatar/avatar-15.jpg') }}"
                                                                class="rounded-circle" />
                                                        </span>
                                                        <span class="avatar avatar-sm avatar-primary">
                                                            <span class="avatar-initials rounded-circle fs-6">+1</span>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-dark border-bottom-0">
                                                    <div class="float-start me-3">75%</div>
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 5px">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->
                        </div>
                    </div>
                </div> --}}
                <!-- data modal -->

                <!-- data detail -->
                <div class="modal fade" id="exampleModalToggle2" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Detail Teaching Attendance</h5>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <tbody>
                                        <tr data-dt-row="99" data-dt-column="2">
                                            <td>Tanggal Pinjam:</td>
                                            <td>01 Januari 2024</td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="3">
                                            <td>Tanggal Kembali:</td>
                                            <td>03 Maret 2024</td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="4">
                                            <td>Tujuan:</td>
                                            <td>Pribadi</td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="5">
                                            <td>Keterangan:</td>
                                            <td>Apapun yang penting saya pinjam</td>
                                        </tr>
                                        <tr data-dt-row="99" data-dt-column="8">
                                            <td>Aksi:</td>
                                            <td>
                                                <button type="button" class="btn btn-danger">
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="css-i6dzq1">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10"
                                                            y2="17"></line>
                                                        <line x1="14" y1="11" x2="14"
                                                            y2="17"></line>
                                                    </svg>
                                                    Hapus
                                                </button>
                                                <!-- |
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button" class="btn btn-warning" data-bs-target="#modalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="bx bx-edit-alt" style="margin-right: 5px"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                Edit
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="modal-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->
                        </div>
                    </div>
                </div>
                <!-- end -->

                <!-- row  -->
                <div class="row my-6">
                    <!-- teach progress hide -->
                    {{-- <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
                        <!-- card  -->
                        <div class="card h-100">
                            <!-- card body  -->
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4 class="mb-0">teach progress</h4>
                                    </div>
                                </div>
                                <!-- chart  -->
                                <div class="mb-8">
                                    <div id="perfomanceChart"></div>
                                </div>
                                <!-- icon with content  -->
                                <div class="d-flex align-items-center justify-content-around">
                                    <div class="text-center">
                                        <i class="icon-sm text-success" data-feather="check-circle"></i>
                                        <h1 class="mt-3 mb-1 fw-bold">5</h1>
                                        <p>Total</p>
                                    </div>
                                    <div class="text-center">
                                        <i class="icon-sm text-warning" data-feather="trending-up"></i>
                                        <h1 class="mt-3 mb-1 fw-bold">18</h1>
                                        <p>In-Progress</p>
                                    </div>
                                    <div class="text-center">
                                        <i class="icon-sm text-danger" data-feather="trending-down"></i>
                                        <h1 class="mt-3 mb-1 fw-bold">12</h1>
                                        <p>Complete</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- card  -->
                    @if (Auth::guard('user')->check())

                        @if (Auth::guard('user')->user()->roles == 'hrd')
                            <!-- begin::hrd trainer account -->
                            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                <div class="card h-100">
                                    <!-- card header  -->
                                    <div class="card-header bg-white py-4">
                                        <h4 class="mb-0">Trainer Account</h4>
                                    </div>
                                    <!-- table  -->
                                    <div class="table-responsive">
                                        <table class="table text-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Trainer</th>
                                                    <th>Level</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($listAkunTrainer as $lat)
                                                    <tr>
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3 lh-1">
                                                                    <h5 class="mb-1">{{ $lat->name }}</h5>
                                                                    <p class="mb-0">{{ $lat->created_at }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">{{ $lat->levelTrainer->nama_level }}</td>
                                                        <td class="align-middle">{{ $lat->levelTrainer->sallary_level }}
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="card-footer bg-white text-center">
                                        <a href="{{ route('hrd.trainer.account.list') }}" class="link-primary">Show all
                                            account</a>
                                    </div>
                                </div>
                            </div>


                            <!-- Ringkasan Jadwal-->
                            <div class="col-xl-8 col-lg-12 col-md-12 col-12 mt-8">
                                <div class="card h-100">
                                    <!-- card header  -->
                                    <div class="card-header bg-white py-4">
                                        <h4 class="mb-0">Ringkasan Jadwal</h4>
                                    </div>
                                    <!-- table  -->
                                    <div class="table-responsive">
                                        <table class="table text-nowrap">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Kelas Hari Ini</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($getRingkasanJadwal as $KelasHariIni)
                                                    @empty($KelasHariIni)
                                                        <tr>

                                                            <td class="align-middle">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-3 lh-1">
                                                                        <h5 class="mb-1">
                                                                            {{ 'belum ada data' }}
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            @if ($KelasHariIni->tanggal_jadwal_kelas == $Carbon->format('Y-m-d'))
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-3 lh-1">
                                                                            <h5 class="mb-1">
                                                                                {{ $KelasHariIni->kelas->nama_kelas }} -
                                                                                {{ $KelasHariIni->jam_mulai_jadwal_kelas }}-{{ $KelasHariIni->jam_akhir_jadwal_kelas }}
                                                                                <b>(Trainer Name:
                                                                                    @isset($KelasHariIni->kelas->AssignedClassTrainer->user->name)
                                                                                        {{ $KelasHariIni->kelas->AssignedClassTrainer->user->name }}
                                                                                    @else
                                                                                        {{ __('Belum ada trainer') }}
                                                                                    @endisset)</b>
                                                                                -
                                                                                {{ $Carbon->parse($KelasHariIni->tanggal_jadwal_kelas)->format('d M Y') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endempty
                                                @endforeach
                                            </tbody>
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Kelas Mendatang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($getRingkasanJadwal as $KelasMendatang)
                                                    @empty($KelasMendatang)
                                                        <tr>
                                                            <td class="align-middle">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-3 lh-1">
                                                                        <h5 class="mb-1">
                                                                            {{ 'belum ada data' }}
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            @if ($KelasMendatang->tanggal_jadwal_kelas > $Carbon->format('Y-m-d'))
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-3 lh-1">
                                                                            <h5 class="mb-1">
                                                                                {{ $KelasMendatang->kelas->nama_kelas }} -
                                                                                {{ $KelasMendatang->jam_mulai_jadwal_kelas }}-{{ $KelasMendatang->jam_akhir_jadwal_kelas }}
                                                                                <b>(Trainer Name:
                                                                                    @isset($KelasMendatang->kelas->AssignedClassTrainer->user->name)
                                                                                        {{ $KelasMendatang->kelas->AssignedClassTrainer->user->name }}
                                                                                    @else
                                                                                        {{ __('Belum ada trainer') }}
                                                                                    @endisset)</b>
                                                                                -
                                                                                {{ $Carbon->parse($KelasMendatang->tanggal_jadwal_kelas)->format('d M Y') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>

                                                    @endif
                            @endforeach

                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <!-- Statistik Jadwal-->
            <div class="col-xl-8 col-lg-12 col-md-12 col-12 mt-8">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Statistik Jadwal</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Jumlah Kelas per Trainer</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <thead class="table-light">
                                <tr>
                                    <th>Trainer</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getStatistikJadwalKelasPerTrainer as $GetStatistikJadwalKelasPerTrainer)
                                    @empty($GetStatistikJadwalKelasPerTrainer)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ 'belum ada data' }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ $GetStatistikJadwalKelasPerTrainer->name }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                {{ $GetStatistikJadwalKelasPerTrainer->AssignedClass->count() }}
                                            </td>
                                        </tr>
                                    @endempty
                                @endforeach
                            </tbody>
                            <thead class="table-light">
                                <tr>
                                    <th>Jumlah Kelas per Hari</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getStatistikJadwalKelasPerHari as $GetStatistikJadwalKelasPerHari)
                                    @empty($GetStatistikJadwalKelasPerHari)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ 'belum ada data' }}:
                                                            {{ 'belum ada data' }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle"></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ $Carbon->parse($GetStatistikJadwalKelasPerHari->date)->englishDayOfWeek }}:
                                                            {{ $GetStatistikJadwalKelasPerHari->views }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle"></td>
                                        </tr>
                                    @endempty
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-12 col-md-12 col-12 mt-8">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Analisis Absensi</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Tabel Absensi</th>
                                    <th></th>
                                </tr>

                            </thead>
                            <thead class="table-light">
                                <tr>
                                    <th>Trainer Name</th>
                                    <th>Count Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getAnalisisAbsensi as $GetAnalisisAbsensi)
                                    @empty($GetAnalisisAbsensi)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ 'belum ada ada' }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3 lh-1">
                                                        <h5 class="mb-1">
                                                            {{ $GetAnalisisAbsensi->name }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                {{ $GetAnalisisAbsensi->absen->count() }}
                                            </td>
                                        </tr>
                                    @endempty
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-8 col-lg-12 col-md-12 col-12 mt-12">
                                <div class="card h-100">
                                    <!-- card body  -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h4 class="mb-0">teach progress</h4>
                                            </div>
                                            <!-- dropdown  -->
                                            <div class="dropdown dropstart">
                                                <a class="text-muted text-primary-hover" href="#" role="button"
                                                    id="dropdownTask" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="icon-xxs" data-feather="more-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownTask">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- chart  -->
                                        <div class="mb-8">
                                            <div id="perfomanceChart"></div>
                                        </div>
                                        <!-- icon with content  -->
                                        <div class="d-flex align-items-center justify-content-around">
                                            <div class="text-center">
                                                <i class="icon-sm text-success" data-feather="check-circle"></i>
                                                <h1 class="mt-3 mb-1 fw-bold">12</h1>
                                                <p>Total</p>
                                            </div>
                                            <div class="text-center">
                                                <i class="icon-sm text-warning" data-feather="trending-up"></i>
                                                <h1 class="mt-3 mb-1 fw-bold">60</h1>
                                                <p>In-Progress</p>
                                            </div>
                                            <div class="text-center">
                                                <i class="icon-sm text-danger" data-feather="trending-down"></i>
                                                <h1 class="mt-3 mb-1 fw-bold">50</h1>
                                                <p>Complate</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
            <!-- end::trainer -->
        @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
            <!-- begin::trainer -->
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Class Schedule</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Class Name</th>
                                    <th>Class Status</th>
                                    <th>Class Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kurikulumKelas as $k)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3 lh-1">
                                                    <h5 class="mb-1">{{ $k->nama_kelas }}</h5>
                                                    <p class="mb-0">{{ $k->kode_kelas }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $k->status_kelas }}</td>
                                        <td class="align-middle">{{ $k->levelTrainer->nama_level }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('kurikulum.kelas.list') }}" class="link-primary">All Class</a>
                    </div>
                </div>
            </div>
            <!-- end::trainer -->
        @elseif(Auth::guard('user')->user()->roles == 'keuangan')
            <!-- begin::trainer -->
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Sallary Reports</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Trainer Name</th>
                                    <th>Class Name</th>
                                    <th>Sallary</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getSallaryReports as $getSallaryReport)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3 lh-1">
                                                    <h5 class="mb-1">{{ $getSallaryReport->user->name }}
                                                    </h5>
                                                    <p class="mb-0">
                                                        {{ $getSallaryReport->user->levelTrainer->nama_level }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            {{ $getSallaryReport->kelas->nama_kelas }}</td>
                                        <td class="align-middle">
                                            @mata_uang($getSallaryReport->total_gaji)
                                        </td>
                                        <td class="align-middle">
                                            @if ($getSallaryReport->status != 'verified')
                                                <span class="badge bg-danger">{{ $getSallaryReport->status }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $getSallaryReport->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('keuangan.reports') }}" class="link-primary">Show all
                            sallary reports</a>
                    </div>
                </div>
            </div>
            <!-- end::trainer -->
        @elseif(Auth::guard('user')->user()->roles == 'trainer')
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Absen Trainer</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Class Name</th>
                                    <th>Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getAbsenOfTrainer as $getAbsenOfTrainers)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3 lh-1">
                                                    <h5 class="mb-1">
                                                        {{ $getAbsenOfTrainers->jadwal->kelas->nama_kelas }}
                                                    </h5>
                                                    <p class="mb-0">
                                                        {{ $getAbsenOfTrainers->jadwal->kelas->levelTrainer->nama_level }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            {{ $getAbsenOfTrainers->jadwal->tanggal_jadwal_kelas }}</td>
                                        <td class="align-middle">
                                            {{ $getAbsenOfTrainers->jadwal->jam_mulai_jadwal_kelas }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $getAbsenOfTrainers->jadwal->jam_akhir_jadwal_kelas }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('trainer.recap.absen') }}" class="link-primary">Show all
                            recap absen</a>
                    </div>
                </div>
            </div>
            @endif
        @elseif(Auth::guard('admin')->check())
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="card h-100">
                    <!-- card header  -->
                    <div class="card-header bg-white py-4">
                        <h4 class="mb-0">Akun User</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listAkunUser as $lau)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3 lh-1">
                                                    <h5 class="mb-1">{{ $lau->name }}</h5>
                                                    <p class="mb-0">{{ $lau->created_at }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $lau->email }}</td>
                                        <td class="align-middle">{{ $lau->roles }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center">
                        <a href="{{ route('admin.account.user.list') }}" class="link-primary" target="_blank">Show all
                            account</a>
                    </div>
                </div>
            </div>
            @endif

        </div>
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

        <script>
            new Chart(document.getElementById("chartjs-bar"), {
                type: "bar",
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: "Last year",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                        barPercentage: .75,
                        categoryPercentage: .5
                    }, {
                        label: "This year",
                        backgroundColor: "#dee2e6",
                        borderColor: "#dee2e6",
                        hoverBackgroundColor: "#dee2e6",
                        hoverBorderColor: "#dee2e6",
                        data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
                        barPercentage: .75,
                        categoryPercentage: .5
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false
                            },
                            stacked: false
                        }],
                        xAxes: [{
                            stacked: false,
                            gridLines: {
                                color: "transparent"
                            }
                        }]
                    }
                }
            });
        </script>

        <script>
            if ($("#perfomanceChart").length) {
                new ApexCharts(document.querySelector("#perfomanceChart"), {
                    series: [20, 78, 89],
                    chart: {
                        height: 320,
                        type: "radialBar"
                    },
                    colors: ["#28a745", "#ffc107", "#dc3545"],
                    stroke: {
                        lineCap: "round"
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -168,
                            endAngle: -450,
                            hollow: {
                                size: "55%"
                            },
                            track: {
                                background: "transaprent"
                            },
                            dataLabels: {
                                show: !1
                            },
                        },
                    },
                }).render();
            }
        </script>
    @endpush
