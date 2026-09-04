<nav class="navbar navbar-dark app-navbar shadow-sm">
    <div class="container-fluid px-3 px-md-4">
        <div class="d-flex align-items-center gap-2">
            @auth
                <button class="btn btn-outline-light d-md-none border-0 px-2" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar" aria-controls="mobileSidebar" aria-label="Buka menu">
                    <span class="fs-5">&#9776;</span>
                </button>
            @endauth
            <a class="navbar-brand fw-semibold mb-0" href="{{ route('home') }}">
                Sistem Pendataan Kos
            </a>
        </div>

        <div class="ms-auto d-flex align-items-center gap-2 gap-md-3">
            @auth
                <div class="d-none d-sm-flex flex-column text-end">
                    <span class="text-white fw-semibold small">{{ auth()->user()->name }}</span>
                    <span class="text-white-50 small text-uppercase">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
            @endauth
        </div>
    </div>
</nav>
