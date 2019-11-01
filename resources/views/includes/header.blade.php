<div class="row align-items-center">
    <div class="col-md-8">
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

<div class="d-flex" style="position:relative;z-index:1;transform:translateY(50%);">
    @if(Route::is('home'))
        <a href="{{ route('user.show', Auth::user()) }}"
           class="btn btn-icon btn-group-nav shadow btn-neutral">
            <span class="btn-inner--icon"><i class="fas fa-user"></i></span>
            <span class="btn-inner--text d-none d-md-inline-block">我的账户</span>
        </a>
    @elseif(Route::is('user'))
        <a href="{{ route('home') }}" class="btn btn-icon btn-group-nav shadow btn-neutral">
            <span class="btn-inner--icon"><i class="fas fa-home-alt"></i></span>
            <span class="btn-inner--text d-none d-md-inline-block">主页</span>
        </a>
    @else
        <a href="#" class="btn btn-icon btn-group-nav shadow btn-neutral"
           onclick="history.go(-1)">
            <span class="btn-inner--icon"><i class="fas fa-arrow-alt-left"></i></span>
            <span class="btn-inner--text d-none d-md-inline-block">返回</span>
        </a>
    @endif
    <div class="btn-group btn-group-nav shadow ml-auto" role="group" aria-label="Basic example">
        @if(!Route::is('home') and !Route::is('user'))
            <a href="{{ route('home') }}" class="btn btn-icon shadow btn-neutral">
                <span class="btn-inner--icon"><i class="fas fa-home-alt"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">主页</span>
            </a>
        @endif
        @if(!Route::is('course'))
            <a href="{{ route('course') }}" class="btn btn-icon shadow btn-neutral">
                <span class="btn-inner--icon"><i class="fas fa-book-open"></i></span>
                <span class="btn-inner--text d-none d-md-inline-block">课程</span>
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
