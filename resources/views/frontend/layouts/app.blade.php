<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=yes">
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
<body id="frontend">
    <p id="preamble" hidden>\( @include('includes.preamble') \)</p>
    @include('includes.partials.logged-in-as')
    @include('frontend.includes.nav')

    <div id="app" class="@yield('appClass', '')">
        <div class="container mt-3">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->
    </div><!-- #app -->

    @include('frontend.includes.footer')

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/app.js')) !!}
    @include('includes.scripts')
    @include('includes.votejs')
    @stack('after-scripts')

    @include('includes.partials.ga')
</body>
</html>
