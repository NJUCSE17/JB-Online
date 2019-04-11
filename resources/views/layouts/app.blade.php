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
                        <div class="row align-items-center mb-4">
                            <div class="col-md-8 mb-4 mb-md-0">
                                @yield('header-left')
                            </div>
                            <div class="col-auto flex-fill d-none d-xl-block">
                                <ul class="list-inline row justify-content-lg-end mr-lg-2 mb-0">
                                    <li class="list-inline-item">
                                        @yield('header-right')
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex">
                            @if(Route::is('home'))
                                <a href="#" class="btn btn-icon btn-group-nav shadow btn-neutral">
                                    <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
                                    <span class="btn-inner--text d-none d-md-inline-block">我的账户</span>
                                </a>
                            @else
                                <a href="#" class="btn btn-icon btn-group-nav shadow btn-neutral"
                                   onclick="history.go(-1)">
                                    <span class="btn-inner--icon"><i class="fas fa-arrow-alt-left"></i></span>
                                    <span class="btn-inner--text d-none d-md-inline-block">返回</span>
                                </a>
                            @endif
                            <div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Basic example">
                                @if(!Route::is('home'))
                                    <a href="{{ route('home') }}" class="btn btn-icon shadow btn-neutral">
                                        <span class="btn-inner--icon"><i class="fas fa-home-alt"></i></span>
                                        <span class="btn-inner--text d-none d-md-inline-block">主页</span>
                                    </a>
                                @endif
                                @if(!Route::is('course.*'))
                                    <a href="#" class="btn btn-icon shadow btn-neutral">
                                        <span class="btn-inner--icon"><i class="fas fa-book-open"></i></span>
                                        <span class="btn-inner--text d-none d-md-inline-block">课程</span>
                                    </a>
                                @endif
                                @if(!Route::is('resource'))
                                    <a href="#" class="btn btn-icon shadow btn-neutral">
                                        <span class="btn-inner--icon"><i class="fas fa-folder"></i></span>
                                        <span class="btn-inner--text d-none d-md-inline-block">资源</span>
                                    </a>
                                @endif
                                @if(!Route::is('blog.*'))
                                    <a href="{{ route('blog.index') }}" class="btn btn-icon shadow btn-neutral">
                                        <span class="btn-inner--icon"><i class="fas fa-rss-square"></i></span>
                                        <span class="btn-inner--text d-none d-md-inline-block">博客</span>
                                    </a>
                                @endif
                            </div>
                        </div>
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

    @include('includes.scripts')
</div>
</body>
</html>
