<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Error</title>

    @include('includes.stylesheets')
</head>
<body>
@include('auth.includes.navbar')
<div id="app">
    <section class="slice slice-lg min-vh-100 d-flex align-items-center">
        <div class="container py-5 px-md-0 d-flex align-items-center">
            <div class="w-100">
                <div class="text-center">
                    <h1 class="display-2 text-danger">&lt;@yield('err-code')&gt;</h1>
                    <h1 class="font-weight-bold">@yield('err-status')</h1>
                </div>
                <hr class="divider-fade"/>
                <div class="card mx-3 bg-gradient-dark shadow-dark border-0">
                    <div class="card-body text-white">
                        <span class="text-info">&gt;</span> <span class="text-warning">~/oslabs/libcurl/libcurl-64</span> <span class="text-success">-X GET</span> {{ Request::url() }} <br/>
                        <span class="text-info">&lt; 服务器已在{{ round((microtime(true) - LARAVEL_START) * 1000) }}毫秒内做出响应。</span> <br/>
                        <span class="text-info">&lt;</span> <span class="text-danger">错误：</span> @yield('err-detail') <br/>
                        <span class="text-info">&lt;</span> <span class="text-danger">原因：</span>
                        @if($exception && $exception->getMessage())
                            {{ $exception->getMessage() }}
                        @else
                            服务器未提供具体的错误原因。
                        @endif
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
@include('includes.scripts')
</html>
