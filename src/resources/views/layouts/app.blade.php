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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/049b0fc622.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/foodie_scout.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        @component('components.header')
        @endcomponent

        <main class="mb-5">
            @yield('content')
        </main>

        @component('components.footer')
        @endcomponent
    </div>
</body>

</html>