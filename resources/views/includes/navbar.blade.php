<header class="header header-transparent" id="header-main">
    <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-dark bg-dark" id="navbar-main">
        <div class="container">
            <span class="navbar-brand mr-lg-5">
                {{ env('APP_NAME') }}
            </span>
            <button class="navbar-toggler pr-0" type="button" data-toggle="collapse"
                    data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main-collapse">
                <ul class="navbar-nav align-items-lg-center">
                </ul>
                <ul class="navbar-nav align-items-lg-end ml-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link pr-lg-0" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-1"></i> 退出 [{{ \Auth::user()->name }}]
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>