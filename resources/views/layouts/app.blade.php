<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- style --}}
    @include("includes._css")
</head>

<body>
    @include('sweetalert::alert')
    <div id="app">
        @include('includes.navbar')

        <main class="">
            @yield('content')
        </main>
    </div>

    @include('includes.footer')
    @include("includes._js")
</body>

</html>