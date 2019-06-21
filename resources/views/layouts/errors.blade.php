<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Error</title>

    @include('includes.stylesheets')
</head>
<body class="@yield('body-class')">
<div id="app">
    <section class="slice slice-lg min-vh-100 d-flex align-items-center bg-section-secondary">
        <div class="container py-5 px-md-0 d-flex align-items-center">
            <div class="w-100">
                @yield('content')
            </div>
        </div>
    </section>
</div>
</body>
@include('includes.scripts')
</html>
