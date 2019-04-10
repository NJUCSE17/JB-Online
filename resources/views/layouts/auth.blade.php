<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('includes.stylesheets')
</head>
<body>
<div id="app">
    @include('auth.includes.navbar')

    <div class="main-content">
        @yield('content')
    </div>

    @include('includes.scripts')
</div>
</body>
</html>
