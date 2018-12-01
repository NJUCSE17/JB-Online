<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
    <ul class="navbar-nav border-left flex-row">
        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-right"
           data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
            <i class="fas fa-bars"></i>
        </a>
    </ul>
    <nav class="nav">
        <a href="{{ route('frontend.user.account') }}"
           class="nav-link text-info py-3 px-3">
            {{ $logged_in_user->name }}
        </a>
        <a href="{{ route('frontend.index') }}"
           class="nav-link text-success py-3 px-3">
            {{ __('navs.general.home') }}
        </a>
        <a href="{{ route('frontend.auth.logout') }}"
           class="nav-link text-danger py-3 px-3"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('navs.general.logout') }}
        </a>
        <form id="logout-form" action="{{ route('frontend.auth.logout') }}" method="POST"
              style="display: none;">{{ csrf_field() }}</form>
    </nav>
</nav>
