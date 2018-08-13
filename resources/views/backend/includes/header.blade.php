<header class="app-header navbar">
    <div href="#" class="navbar-item ml-5 mr-3">{{ app_name() }}</div>
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <i class="fas fa-bars"></i>
    </button>
    <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">
        <i class="fas fa-bars"></i>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('frontend.index') }}"><i class="fas fa-home"></i></a>
        </li>

        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('navs.frontend.dashboard') }}</a>
        </li>

        @if (config('locale.status') && count(config('locale.languages')) > 1)
            <li class="nav-item px-3 dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="d-md-down-none">{{ __('menus.language-picker.language') }} ({{ strtoupper(app()->getLocale()) }})</span>
                </a>

                @include('includes.partials.lang')
            </li>
        @endif
    </ul>

    <ul class="nav navbar-nav ml-auto mr-5">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ $logged_in_user->picture }}" class="img-avatar" alt="{{ $logged_in_user->email }}">
                <span class="d-md-down-none">{{ $logged_in_user->full_name }}</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">
                    <i class="fas fa-sign-out-alt mr-3"></i> {{ __('navs.general.logout') }}
                </a>
            </div>
        </li>
    </ul>
</header>