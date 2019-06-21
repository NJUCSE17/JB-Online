<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('includes.stylesheets')
</head>
<body class="bg-section-secondary">
@include('includes.navbar')
<div id="app">
    <div class="main-content">
        <section class="@yield('header-class') d-flex align-items-end pt-5 pt-lg-8">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        @include('includes.header')
                    </div>
                </div>
            </div>
        </section>
        <section class="slice bg-section-secondary">
            <div class="container">
                @yield('content')
            </div>
        </section>
    </div>
</div>
@include('includes.footer')
</body>
@include('includes.scripts')
</html>
