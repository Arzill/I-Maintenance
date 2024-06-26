<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @include("includes._css")
</head>

<body>
    @include('sweetalert::alert')
    <div id="app-calculator">
        @include('includes.navbar')
        <main class="">
            @yield('content')
        </main>
    </div>
    @include('includes.footer')

    <!-- Scripts -->
    @include("includes._js")

</body>

</html>