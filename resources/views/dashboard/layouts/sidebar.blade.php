<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
      <h6 class="sidebar-heading d-flex justify-content-between align-item-center px-3 mb-1 text-muted">
        <span>Staff</span>
      </h6>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('karyawan') ? 'active' :'' }}" href="/karyawan">
            <span data-feather="activity" class="align-text-bottom"></span>
            Data Pegawai
          </a>
        </li>
      </ul>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('absensi') ? 'active' :'' }}" href="/absensi">
            <span data-feather="user-check" class="align-text-bottom"></span>
            Kehadiran Pegawai
          </a>
        </li>
      </ul>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('payroll/karyawan') ? 'active' :'' }} " href="/payroll/karyawan">
            <span data-feather="dollar-sign" class="align-text-bottom"></span>
            Gaji Pegawai
          </a>
        </li>
      </ul>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('report') ? 'active' :'' }} " href="/report">
            <span data-feather="book-open" class="align-text-bottom"></span>
            Laporan
          </a>
        </li>
      </ul>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('export_slip_gaji') ? 'active' :'' }} " href="/export_slip_gaji">
            <span data-feather="printer" class="align-text-bottom"></span>
            cetak Slip Gaji
          </a>
        </li>
      </ul>
      <h6 class="sidebar-heading d-flex justify-content-between align-item-center px-3 mt-4 mb-1 text-muted">
        <span>Supervisor</span>
      </h6>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('slipgaji') ? 'active' :'' }} " href="/slipgaji">
            <span data-feather="command" class="align-text-bottom"></span>
            Approve Slip Gaji
          </a>
        </li>
      </ul>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('user') ? 'active' :'' }} " href="/user">
            <span data-feather="users" class="align-text-bottom"></span>
            Edit Admin
          </a>
        </li>
      </ul>
      <h6 class="sidebar-heading d-flex justify-content-between align-item-center px-3 mt-4 mb-1 text-muted">
        <span>Pengaturan</span>
      </h6>
      <ul class="nav flex-column">
        <li class="nav-item">
          <div class="navbar-nav">
            <div class="nav-item">
              <form action="/logout" method="post" style="margin-left: 20px">
                @csrf
                <button type="submit" class="nav-link border-0 bg-light"><span data-feather="log-out" class="align-text-bottom"></span> Logout  </button>
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>