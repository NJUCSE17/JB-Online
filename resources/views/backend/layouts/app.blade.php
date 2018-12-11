<!DOCTYPE html>
@langrtl
    <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
    <html lang="{{ app()->getLocale() }}">
@endlangrtl
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'JB Online')">
    <meta name="author" content="@yield('meta_author', 'CS Elite 17')">

    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    @include('includes.stylesheets')
    <!-- Required by shards dashboard -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}

    @stack('after-styles')
</head>

<body id="backend" class="h-100">
    <p id="preamble" hidden>\( @include('includes.preamble') \)</p>
    @include('includes.partials.logged-in-as')

    <div class="container-fluid @yield('appClass', '')">
        <div class="row">
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 p-0">
                @include('backend.includes.sidebar')
            </aside>

            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                <div class="main-navbar sticky-top bg-white">
                    @include('backend.includes.nav')
                    @include('includes.partials.messages')
                </div>
                <div class="main-content-container container-fluid my-3">
                    {!! Breadcrumbs::render() !!}
                    @yield('content')
                </div>
            </main>
        </div>
    </div><!-- container -->

    <!-- Scripts -->
    @stack('before-scripts')
    @include('includes.scripts')
    {!! script(mix('js/backend.js')) !!}
    @stack('after-scripts')

    @include('includes.partials.ga')
</body>
</html>
