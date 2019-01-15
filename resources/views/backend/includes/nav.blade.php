<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
    <ul class="navbar-nav border-left flex-row">
        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-sm-inline d-md-none text-center border-right"
           data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
            <i class="fas fa-bars"></i>
        </a>
    </ul>
    <ul class="navbar-nav flex-row py-2">
        <li class="nav-item pr-3">
            <a href="{{ route('frontend.home') }}" class="nav-link">
                <i class="fas fa-home mr-2"></i>
                <span>{{ __('navs.general.home') }}</span>
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
    </ul>
</nav>
