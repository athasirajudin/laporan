<nav class="nav flex-column gap-1 p-3">
    <span class="nav-link fw-semibold text-secondary">Menu</span>
    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>

    @auth
        @if(auth()->user()->isSuperAdmin())
            <div class="small text-uppercase fw-semibold text-secondary mt-3 mb-1">Super Admin</div>
            <a class="nav-link" href="{{ route('super-admin.admin.index') }}">Manajemen Admin</a>
            <a class="nav-link" href="{{ route('super-admin.wilayah.index') }}">Data Wilayah</a>
            <a class="nav-link" href="{{ route('super-admin.kos.index') }}">Semua Kos</a>
        @endif
    @endauth
</nav>
