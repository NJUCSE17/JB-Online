<nav class="navbar navbar-expand-lg navbar-light bg-white with-shadows" id="navbar">
    <div class="container">
        <a href="{{ route('frontend.index') }}" class="navbar-brand">{{ app_name() }}</a>
        <a class="badge badge-pill float-right badge-dark text-white">
            {{ app_version() }}
        </a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('labels.general.toggle_navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownLanguageLink"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">{{ __('menus.language-picker.language') }}
                            ({{ strtoupper(app()->getLocale()) }})</a>

                        @include('includes.partials.lang')
                    </li>
                @endif

                @guest
                    <li class="nav-item">
                        <a href="{{route('frontend.auth.login')}}"
                           class="nav-link text-success {{ active_class(Active::checkRoute('frontend.auth.login')) }}">
                            {{ __('navs.frontend.login') }}
                        </a>
                    </li>

                    @if (config('access.registration'))
                        <li class="nav-item">
                            <a href="{{route('frontend.auth.register')}}"
                               class="nav-link text-danger {{ active_class(Active::checkRoute('frontend.auth.register')) }}">
                                {{ __('navs.frontend.register') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a href="{{ route('frontend.user.account') }}"
                           class="nav-link text-info {{ active_class(Active::checkRoute('frontend.user.account')) }}">
                            {{ $logged_in_user->name }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('frontend.blog')}}"
                           class="nav-link text-success {{ active_class(Active::checkRoute('frontend.blog')) }}">
                            {{ __('navs.frontend.blog') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('elfinder.index')}}"
                           class="nav-link text-success {{ active_class(Active::checkRoute('elfinder.index')) }}">
                            {{ __('navs.frontend.filehub') }}
                        </a>
                    </li>
                @endguest
                <li class="nav-item"><a href="{{route('frontend.about')}}"
                                        class="nav-link text-primary {{ active_class(Active::checkRoute('frontend.about')) }}">
                        {{ __('navs.frontend.about') }}
                    </a>
                </li>
                @auth
                    @can('view backend')
                        <li class="nav-item"><a href="{{ route('admin.dashboard') }}"
                                                class="nav-link text-warning">
                                {{ __('navs.frontend.user.administration') }}
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a href="{{ route('frontend.auth.logout') }}"
                           class="nav-link text-danger">
                            {{ __('navs.general.logout') }}
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
