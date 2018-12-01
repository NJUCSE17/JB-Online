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
    <meta name="description" content="@yield('meta_description', 'Homework Forum')">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa + doowzs')">

    @yield('meta')

    {{-- See https://laravel.com/docs/5.5/blade#stacks for usage --}}
    @stack('before-styles')

    <!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    @include('includes.stylesheets')
    {{ style(mix('css/frontend.css')) }}

    @stack('after-styles')
</head>
<body id="frontend"
      style="background-image: url('{{ asset('images/frontend/background/bg_'.random_int(1, 20).'.svg')}}');
              background-size: auto; background-position: center center;">
    <p id="preamble" hidden>\( @include('includes.preamble') \)</p>
    @include('includes.partials.logged-in-as')
    @include('frontend.includes.nav')

    <div id="app" class="@yield('appClass', '')">
        <div class="container my-3">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->
    </div><!-- #app -->

    <footer class="site-footer clearfix">
        <div class="container">
            <div class="row">
                <div class="footer-logo col-3">
                    <h4> JB Online </h4>
                </div>
                UIX
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('before-scripts')
    @include('includes.scripts')
    @include('includes.votejs')
    {!! script(mix('js/frontend.js')) !!}
    @stack('after-scripts')

    @include('includes.partials.ga')
</body>
</html>
