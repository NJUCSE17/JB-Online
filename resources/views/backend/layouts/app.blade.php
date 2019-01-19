<!DOCTYPE html>
@langrtl
<html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
    @endlangrtl
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <meta name="description" content="@yield('meta_description', 'JB Online')">
        <meta name="author" content="@yield('meta_author', 'CS Elite 17')">

        @yield('meta')

        @stack('before-styles')
        @include('includes.stylesheets')
        {{ style(mix('css/app-' . $theme . '.css')) }}
        @stack('after-styles')
    </head>

    <body id="backend">
    <p id="preamble" hidden>\( @include('includes.preamble') \)</p>
    @include('includes.partials.logged-in-as')

    <div id="wrapper">
        <div id="sidebar-wrapper">
            @include('backend.includes.sidebar')
        </div>
        <div id="page-content-wrapper" class="p-0">
            <div class="container-fluid p-0 @yield('appClass', '')">
                <div class="main-navbar sticky-top bg-light">
                    @include('backend.includes.nav')
                    @include('includes.partials.messages')
                </div>
                <div class="main-content-container container-fluid my-3">
                    {!! Breadcrumbs::render() !!}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/app.js')) !!}
    @include('includes.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
    @stack('after-scripts')

    @include('includes.partials.ga')
    </body>
    </html>
