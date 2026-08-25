<nav class="navbar navbar-expand-md navbar-dark app-navbar shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">Sistem Pendataan Kos</a>

        @auth
            <span class="navbar-text text-white">
                {{ auth()->user()->name }}
            </span>
        @endauth
    </div>
</nav>
