<div class="main-navbar">
    <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
        <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
            <div class="d-table m-auto">
                <img src="{{ asset('favicon.ico') }}" style="height: 25px;" class="mr-1">
                <span class="d-none d-md-inline ml-1">JB Online Admin</span>
            </div>
        </a>
        <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
            <i class="fas fa-arrow-left"></i>
        </a>
    </nav>
</div>
<div class="nav-wrapper">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
               href="{{ route('admin.dashboard') }}">
                <i class="fas fa-table"></i>
                <span>{{ __('menus.backend.sidebar.dashboard') }}</span>
            </a>
        </li>

        @if ($logged_in_user->isAdmin())
            <li class="px-3 py-2">{{ __('menus.backend.sidebar.system') }}</li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
                   href="{{ route('admin.auth.user.index') }}">
                    <i class="fas fa-user"></i>
                    <span>
                        {{ __('labels.backend.access.users.management') }}
                        @if ($pending_approval > 0)
                            <span class="badge badge-danger float-right">{{ $pending_approval }}</span>
                        @endif
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
                   href="{{ route('admin.auth.role.index') }}">
                    <i class="fas fa-users"></i>
                    <span>
                        {{ __('labels.backend.access.roles.management') }}
                    </span>
                </a>
            </li>
        @endif

        @if ($logged_in_user->isExecutive())
            <li class="px-3 py-2">{{ __('menus.backend.sidebar.forum') }}</li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/notice*')) }}"
                    href="{{ route('admin.forum.notice.index') }}">
                    <i class="fas fa-broadcast-tower"></i>
                    <span>
                        {{ __('labels.backend.forum.notices.management') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/course*')) }}"
                   href="{{ route('admin.forum.course.index') }}">
                    <i class="fas fa-book"></i>
                    <span>
                        {{ __('labels.backend.forum.courses.management') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/assignment*')) }}"
                   href="{{ route('admin.forum.assignment.index') }}">
                    <i class="fas fa-pencil-ruler"></i>
                    <span>
                        {{ __('labels.backend.forum.assignments.management') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/problem*')) }}"
                   href="{{ route('admin.forum.problem.index') }}">
                    <i class="fas fa-lightbulb"></i>
                    <span>
                        {{ __('labels.backend.forum.problems.management') }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/post*')) }}"
                   href="{{ route('admin.forum.post.index') }}">
                    <i class="fas fa-comments"></i>
                    <span>
                        {{ __('labels.backend.forum.posts.management') }}
                    </span>
                </a>
            </li>
        @endif

        <li class="px-3 py-2">{{ __('menus.backend.sidebar.log') }}</li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
               href="{{ route('log-viewer::dashboard') }}">
                <i class="fas fa-table"></i>
                <span>
                    {{ __('menus.backend.log-viewer.dashboard') }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
               href="{{ route('log-viewer::logs.list') }}">
                <i class="fas fa-cookie"></i>
                <span>
                    {{ __('menus.backend.log-viewer.logs') }}
                </span>
            </a>
        </li>
    </ul>
</div>