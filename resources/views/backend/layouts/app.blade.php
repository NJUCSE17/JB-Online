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
    <meta name="description" content="@yield('meta_description', 'Homework Forum Backend')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa + doowzs')">

    @include('includes.utilities')

    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{ style(mix('css/backend.css')) }}

    @stack('after-styles')
</head>

<body id="backend">
    <p id="preamble" hidden>\( @include('includes.preamble') \)</p>
    <div id="app">
        @include('includes.partials.logged-in-as')
        @include('backend.includes.nav')
        @include('backend.includes.sidebar')

        <div id="app" class="@yield('appClass', '')">
            <div class="container-fluid my-4">
                @include('includes.partials.messages')
                <div style="vertical-align: center; line-height: 50px">
                    {!! Breadcrumbs::render() !!}
                </div>
                @yield('content')
            </div><!-- container -->
        </div><!-- #app -->
    </div><!-- #app -->

    <!-- Scripts -->
    @stack('before-scripts')
    {!! script(mix('js/frontend.js')) !!}
    @stack('after-scripts')

    @include('includes.partials.ga')
</body>
</html>
