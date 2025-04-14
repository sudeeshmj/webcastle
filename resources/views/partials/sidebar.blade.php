<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu mt-3">

            <div class="nav">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
            </div>
            <div class="nav">
                <a class="nav-link {{ Request::is('admin/doctors*') ? 'active' : '' }}"
                    href="{{ route('doctors.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-user"></i></div>
                    Doctors
                </a>
            </div>

            <div class="nav">
                <a class="nav-link {{ Request::is('admin/appointments') ? 'active' : '' }}"
                    href="{{ route('admin.appointments.index') }}">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-clipboard"></i></div>
                    Appointments
                </a>
            </div>

        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: {{ auth()->user()->name }}</div>
        </div>
    </nav>
</div>
