@extends('dashboard.layouts.app')

@section('title', 'Halaman Login')

@push('css')
    <link href="{{ asset('alsavedutech/assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/dropzone/dist/dropzone.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('alsavedutech/assets/libs/prismjs/themes/prism-okaidia.css') }}" rel="stylesheet" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('alsavedutech/assets/css/theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('alsavedutech/css/style.css') }}" />
@endpush

@section('content')
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('{{ asset('alsavedutech/images/bg-1.png') }}')">
        </div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-9">
                        <div class="card smooth-shadow-md">
                            <!-- Card body -->
                            <div class="card-body p-6">
                                <div class="mb-4">
                                    <h3 style="font-weight: 700;">Welcome Back!</h3>
                                    <p class="mb-6">Please enter your account here</p>
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

                                <!-- Form -->
                                <form action="{{ route('jalankan.login') }}" method="POST">
                                    @csrf
                                    <!-- Username -->
                                    <div class="mb-3">
                                        <label for="umail" class="form-label">Username or email</label>
                                        <input type="umail" id="umail"
                                            class="form-control @error('umail') is-invalid @enderror" name="umail"
                                            placeholder="Masukan Email Atau Username" value="{{ old('umail') }}" />
                                        @error('umail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="**************" />
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- select state login -->
                                    <div class="mb-3">
                                        {{-- <label for="statelogin" class="form-label">State Login</label>
                                        <input type="statelogin" id="statelogin"
                                            class="form-control @error('statelogin') is-invalid @enderror" name="statelogin"
                                            placeholder="**************" />
                                        @error('statelogin')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                        <label for="statelogin" class="form-label">Choose Login Session?</label>
                                        <select name="statelogin" id="statelogin"
                                            class="form-select @error('statelogin') is-invalid @enderror">
                                            <option value="" selected>Choose Login</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                        @error('statelogin')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- Checkbox -->
                                    <div class="d-lg-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check custom-checkbox">
                                            <input type="checkbox" class="form-check-input" id="rememberme" />
                                            <label class="form-check-label" for="rememberme">Remember me</label>
                                        </div>
                                    </div>
                                    <div>
                                        <!-- Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-dark">Log in</button>
                                        </div>

                                        {{-- <div class="d-md-flex justify-content-between mt-4">
                                            <div class="mb-2 mb-md-0">
                                                <p>Lupa Password? <a href="sign-up.html" class="fs-5"> Klik Here</a></p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
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
@endpush
