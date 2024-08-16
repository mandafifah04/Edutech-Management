<!-- navbar vertical -->
<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="index.html">
            <p style="color: #fdfdfd; font-weight: bold; font-size: larger">
                {{ __('Dashboard') }}
                {{-- @if (Auth::guard('user')->check())
                    {{ Auth::guard('user')->user()->roles }}
                @elseif(Auth::guard('admin')->check())
                    {{ Auth::guard('admin')->user()->roles }}
                @endif --}}
            </p>
            <!-- <img src="./assets/images/brand/logo/logo.svg" alt="" /> -->
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            @if (Auth::guard('admin')->check())
                @if (Auth::guard('admin')->user()->roles == 'admin')
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('admin/user/account') ? 'active' : '' }}"
                            href="{{ route('admin.account.user.list') }}">
                            <i data-feather="users" class="nav-icon icon-xs me-2"></i>
                            Akun User
                        </a>
                    </li>
                @endif
            @elseif(Auth::guard('user')->check())
                @if (Auth::guard('user')->user()->roles == 'hrd')
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard.utama') }}">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/hrd/trainer/account') ? 'active' : '' }}"
                            href="{{ route('hrd.trainer.account.list') }}">
                            <i data-feather="users" class="nav-icon icon-xs me-2"></i>
                            Trainer Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/hrd/trainer/sallary') ? 'active' : '' }}"
                            href="{{ route('hrd.trainer.sallary.list') }}">
                            <i data-feather="dollar-sign" class="nav-icon icon-xs me-2"></i>
                            Trainer Sallary
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/hrd/trainer/class') ? 'active' : '' }}"
                            href="{{ route('hrd.trainer.schedule.list') }}">
                            <i data-feather="calendar" class="nav-icon icon-xs me-2"></i>
                            Trainer Class Schedules
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/hrd/trainer/sallary_report') ? 'active' : '' }}"
                            href="{{ route('hrd.trainer.sallary_report.list') }}">
                            <i data-feather="clipboard" class="nav-icon icon-xs me-2"></i>
                            Salary Report
                        </a>
                    </li>
                @elseif(Auth::guard('user')->user()->roles == 'kurikulum')
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard.utama') }}">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/kurikulum/kelas') ? 'active' : '' }}"
                            href="{{ route('kurikulum.kelas.list') }}">
                            <i data-feather="file-plus" class="nav-icon icon-xs me-2"></i>
                            Create Class
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/kurikulum/kelas/assigned') ? 'active' : '' }}"
                            href="{{ route('kurikulum.assigned.list') }}">
                            <i data-feather="calendar" class="nav-icon icon-xs me-2"></i>
                            Assigned Class
                        </a>
                    </li>
                @elseif(Auth::guard('user')->user()->roles == 'trainer')
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard.utama') }}">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/trainers') ? 'active' : '' }}"
                            href="{{ route('trainers.kelas') }}">
                            <i data-feather="book-open" class="nav-icon icon-xs me-2"></i>
                            Class Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/trainers/absen/recap') ? 'active' : '' }}"
                            href="{{ route('trainer.recap.absen') }}">
                            <i data-feather="file-text" class="nav-icon icon-xs me-2"></i>
                            Absen
                        </a>
                    </li>
                @elseif(Auth::guard('user')->user()->roles == 'keuangan')
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard.utama') }}">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link has-arrow {{ request()->is('user/dashboard/keuangan/reports') ? 'active' : '' }}"
                            href="{{ route('keuangan.reports') }}">
                            <i data-feather="dollar-sign" class="nav-icon icon-xs me-2"></i>
                            Sallary Reports
                        </a>
                    </li>
                @endif
            @endif

        </ul>
    </div>
</nav>
