<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/home" class="app-brand-link">
      <img src="{{ asset('logo-hrd.png') }}" style="width: 45px; height:45px;" alt="">
      <span class="menu-text fw-bolder ms-2 text-xl">LAPORAN HARIAN</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::segment(1) === 'home' ? 'active' : null }}">
      <a href="/home" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Main menu</span>
    </li>
    @if(Auth::user()->jabatan == 'ADMIN')
    <li class="menu-item {{ Request::segment(1) === 'pengguna' ? 'active' : null }}">
      <a href="/pengguna" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-check"></i>
        <div data-i18n="Basic">Pengguna</div>
      </a>
    </li>
    @endif
    @if(Auth::user()->jabatan != 'ADMIN')
    <li class="menu-item {{ Request::segment(1) === 'kegiatan-harian' ? 'active' : null }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-stats"></i>
        <div data-i18n="Account Settings">Kegiatan</div>
      </a>
      <ul class="menu-sub">
        @if(Auth::user()->jabatan == 'SPV' || Auth::user()->jabatan == 'ASMEN')
        <li class="menu-item">
          <a href="/kegiatan-harian" class="menu-link">
            <div data-i18n="Account">Data kegiatan</div>
          </a>
        </li>
        @endif

        @if(Auth::user()->jabatan != 'ASMEN')
        <li class="menu-item">
          <a href="/kegiatan-harian/create" class="menu-link">
            <div data-i18n="Account">Kegiatan harian</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/kegiatan-mingguan" class="menu-link">
            <div data-i18n="Account">Kegiatan mingguan</div>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    <li class="menu-item {{ Request::segment(1) === 'pelayanan' ? 'active' : null }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-notepad"></i>
        <div data-i18n="Account Settings">Pelayanan</div>
      </a>

      <ul class="menu-sub">


        <li class="menu-item">
          <a href="/pelayanan/hr" class="menu-link">
            <div data-i18n="Account">Data pelayanan</div>
          </a>
        </li>
      </ul>
    </li>

    @if(Auth::user()->jabatan != 'ADMIN' && Auth::user()->jabatan != 'ASMEN')
    <li class="menu-item {{ Request::segment(1) === 'laporan-bulanan' ? 'active' : null }}">
      <a href="/kegiatan-mingguan/laporan-bulanan" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-report"></i>
        <div data-i18n="Basic">Laporan</div>
      </a>
    </li>
    @endif

    @if(Auth::user()->jabatan == 'SPV' || Auth::user()->jabatan == 'ASMEN')
    <li class="menu-item {{ Request::segment(1) === 'organisir-tim' ? 'active' : null }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cube-alt"></i>
        <div data-i18n="Misc">Organisir tim</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/organisir-tim" class="menu-link">
            <div data-i18n="Error">Data tim</div>
          </a>
        </li>
      </ul>
    </li>
    @endif
    <!-- Pengaturan -->
    @if(Auth::user()->jabatan != 'STAFF')
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
    <!-- Konfigurasi -->
    <li class="menu-item {{ Request::segment(1) === 'pengaturan' ? 'active' : null }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="User interface">Konfigurasi</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="/pengaturan/pelayanan" class="menu-link">
            <div data-i18n="Accordion">Pelayanan</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/pengaturan/waktu-kerja" class="menu-link">
            <div data-i18n="Accordion">Waktu kerja</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/pengaturan/kegiatan" class="menu-link">
            <div data-i18n="Alerts">Kegiatan</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/pengaturan/kategori-kegiatan" class="menu-link">
            <div data-i18n="Badges">Kategori</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/pengaturan/person-in-charge" class="menu-link">
            <div data-i18n="Buttons">Person in Charge</div>
          </a>
        </li>
      </ul>
    </li>
    @endif
  </ul>
</aside>