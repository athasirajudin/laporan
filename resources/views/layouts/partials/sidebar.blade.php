<nav class="nav flex-column gap-1 p-3">
    <span class="nav-link fw-semibold text-secondary">Menu</span>
    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>

    @auth
        @if(auth()->user()->isSuperAdmin())
            <div class="small text-uppercase fw-semibold text-secondary mt-3 mb-1">Super Admin</div>
            <a class="nav-link" href="{{ route('super-admin.admin.index') }}">Manajemen Admin</a>
            <a class="nav-link" href="{{ route('super-admin.wilayah.index') }}">Data Wilayah</a>
            <a class="nav-link" href="{{ route('super-admin.kos.index') }}">Semua Kos</a>
        @elseif(auth()->user()->isAdmin())
            <div class="small text-uppercase fw-semibold text-secondary mt-3 mb-1">Admin</div>
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Wilayah</a>
            <a class="nav-link" href="{{ route('admin.kos.index') }}">Data Kos</a>
            <a class="nav-link" href="{{ route('admin.penghuni.index') }}">Data Penghuni</a>
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">Laporan Wilayah</a>
        @elseif(auth()->user()->isPemilikKos())
            <div class="small text-uppercase fw-semibold text-secondary mt-3 mb-1">Pemilik Kos</div>
            <span class="nav-link text-secondary">Modul pemilik kos akan tersedia pada phase berikutnya.</span>
        @endif
    @endauth
</nav>
