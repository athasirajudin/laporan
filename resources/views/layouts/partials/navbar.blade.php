<nav class="navbar navbar-expand-md navbar-dark app-navbar shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">Sistem Pendataan Kos</a>

        <div class="ms-auto d-flex align-items-center gap-3">
            @auth
                <span class="navbar-text text-white">
                    {{ auth()->user()->name }}
                </span>

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
