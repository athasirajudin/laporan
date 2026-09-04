<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#1e4f6d">
        <title>@yield('title', config('app.name')) — {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('layouts.partials.navbar')

        @auth
            <div class="offcanvas offcanvas-start app-sidebar-drawer" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
                <div class="offcanvas-header">
                    <div>
                        <div class="fw-semibold" id="mobileSidebarLabel">Sistem Pendataan Kos</div>
                        <div class="small text-secondary">{{ auth()->user()->name }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="app-sidebar h-100 border-0">
                        @include('layouts.partials.sidebar')
                    </div>
                </div>
            </div>
        @endauth

        <div class="container-fluid px-0">
            <div class="row g-0">
                @auth
                    <aside class="col-md-3 col-lg-2 d-none d-md-block app-sidebar">
                        @include('layouts.partials.sidebar')
                    </aside>
                    <main class="col-md-9 col-lg-10 app-content">
                @else
                    <main class="col-12 app-content">
                @endauth
                    @include('layouts.partials.flash-message')
                    @yield('content')
                </main>
            </div>
        </div>
        @include('layouts.partials.footer')
    </body>
</html>
