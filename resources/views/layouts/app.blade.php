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
    @include('includes.navbar')

    <div class="main-content">
        <section class="header-account-page @yield('header-class') d-flex align-items-end"
                 data-offset-top="#header-main" style="padding-top: 147.188px;">
            <div class="container pt-4 pt-lg-0">
                <div class="row">
                    <div class=" col-lg-12">
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

    @include('includes.footer')
</div>
</body>
@include('includes.scripts')
</html>
