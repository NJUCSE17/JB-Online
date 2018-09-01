<nav class="navbar navbar-expand-lg navbar-light bg-light">
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

            <li class="nav-item">
                <a href="{{ route('frontend.user.account') }}"
                   class="nav-link text-info">
                    {{ $logged_in_user->name }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.index') }}"
                   class="nav-link text-success">
                    {{ __('navs.general.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('frontend.auth.logout') }}"
                   class="nav-link text-danger">
                    {{ __('navs.general.logout') }}
                </a>
            </li>
        </ul>
    </div>
</nav>
