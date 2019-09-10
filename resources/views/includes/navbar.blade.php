<header class="header @yield('header-class')" id="header-main">
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark @yield('header-class')">
        <div class="container">
            <a class="navbar-brand mr-lg-5" href="{{ route('home') }}">
                {{ env('APP_NAME') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#MainNavigationBar" aria-controls="MainNavigationBar" aria-expanded="false"
                    aria-label="navigation toggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="MainNavigationBar">
                <ul class="navbar-nav align-items-lg-end ml-lg-auto">
                    @if(Auth::user()->privilege_level <= 1)
                        <li class="nav-item">
                            <a class="nav-link pr-lg-0" href="/telescope" target="_blank">
                                <i class="fas fa-chart-pie mr-1"></i> 日志
                            </a>
                        </li>
                    @endif
                    @if(env('DISCOURSE_URL'))
                        <li class="nav-item">
                            <a class="nav-link pr-lg-0" href="{{ env('DISCOURSE_URL') }}" target="_blank">
                                <i class="fab fa-discourse mr-1"></i> 讨论区
                            </a>
                        </li>
                    @endif
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
