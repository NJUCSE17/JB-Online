<header class="header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white with-shadows">
        <div class="container">
            <a href="{{ route('frontend.home') }}" class="navbar-brand">
                <img src="{{ asset('favicon.ico') }}" style="height: 25px;" class="mr-2">
                <span>@yield('navBrand', app_name())</span>
            </a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('labels.general.toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a href="{{route('frontend.auth.login')}}"
                               class="nav-link text-success {{ active_class(Active::checkRoute('frontend.auth.login')) }}">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                <span>{{ __('navs.frontend.login') }}</span>
                            </a>
                        </li>
                        @if (config('access.registration'))
                            <li class="nav-item">
                                <a href="{{route('frontend.auth.register')}}"
                                   class="nav-link {{ active_class(Active::checkRoute('frontend.auth.register')) }}">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    <span>{{ __('navs.frontend.register') }}</span>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{route('frontend.about')}}"
                               class="nav-link {{ active_class(Active::checkRoute('frontend.about')) }}">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>{{ __('navs.frontend.about') }}</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('frontend.blog')}}"
                               class="nav-link {{ active_class(Active::checkRoute('frontend.blog')) }}">
                                <i class="fas fa-rss mr-2"></i>
                                <span>{{ __('navs.frontend.blog') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('elfinder.index')}}"
                               class="nav-link {{ active_class(Active::checkRoute('elfinder.index')) }}">
                                <i class="fas fa-share-alt mr-2"></i>
                                <span>{{ __('navs.frontend.filehub') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle text-nowrap px-3" role="button"
                                   id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <img class="user-avatar rounded-circle mr-2" src="{{ $logged_in_user->picture }}"
                                         style="height: 25px !important;">
                                    {{ $logged_in_user->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('frontend.user.account') }}"
                                       class="dropdown-item text-info {{ active_class(Active::checkRoute('frontend.user.account')) }}">
                                        <i class="fas fa-user-cog mr-2"></i>
                                        <span>{{ __('navs.general.account') }}</span>
                                    </a>
                                    @can('view backend')
                                        <a href="{{ route('admin.dashboard') }}"
                                           class="dropdown-item text-warning">
                                            <i class="fas fa-landmark mr-2"></i>
                                            <span>{{ __('navs.frontend.user.administration') }}</span>
                                        </a>
                                    @endcan
                                    <a href="{{ route('frontend.auth.logout') }}"
                                       class="dropdown-item text-danger"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        <span>{{ __('navs.general.logout') }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('frontend.auth.logout') }}" method="POST"
                                          style="display: none;">{{ csrf_field() }}</form>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>