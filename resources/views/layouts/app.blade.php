<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name')) — {{ config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-body-tertiary">
        @include('layouts.partials.navbar')

        <div class="container-fluid">
            <div class="row">
                <aside class="col-md-3 col-lg-2 d-none d-md-block p-0 app-sidebar">
                    @include('layouts.partials.sidebar')
                </aside>
                <main class="col-md-9 col-lg-10 p-4 app-content">
                    @include('layouts.partials.flash-message')
                    @yield('content')
                </main>
            </div>
        </div>

        @include('layouts.partials.footer')
    </body>
</html>
