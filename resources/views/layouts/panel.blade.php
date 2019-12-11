<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="layout layout-panel">
    <div id="app">
        
        <!-- Navbar -->
        @include('includes.navbar')
        
        <!-- Main -->
        <main>

            <!-- Sidebar -->
            @include('includes.sidebar')

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
            
        </main>
    </div>
</body>
</html>