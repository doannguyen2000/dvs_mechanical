<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.app.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('style-css')
</head>

<body>
    <div class="container text-center bg-light-subtle">
        <div class="row">
            @auth
                @include('layouts.component.sidebar')
            @endauth

            <div class="col border" id="navbar">
                @include('layouts.component.navbar')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('fontawesome-free-6.4.0-web/js/all.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.app.js') }}"></script>
    @yield('modal')
    @yield('toast')
    @yield('style-js')
</body>

</html>
