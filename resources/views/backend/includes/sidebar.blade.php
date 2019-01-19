
<ul class="sidebar-nav">
    <li class="sidebar-brand">
        <a href="{{ route('frontend.index') }}">
            <img src="{{ asset('favicon.ico') }}" style="height: 25px;" class="mr-1">
            <span class="d-none d-md-inline ml-1">JB Online Admin</span>
        </a>
    </li>
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
                <span>{{ __('labels.backend.access.roles.management') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('telescope') }}">
                <i class="fas fa-chart-pie"></i>
                <span> Telescope </span>
            </a>
        </li>
    @endif

    @if ($logged_in_user->isExecutive())
        <li class="px-3 py-2">{{ __('menus.backend.sidebar.forum') }}</li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/notice*')) }}"
               href="{{ route('admin.forum.notice.index') }}">
                <i class="fas fa-broadcast-tower"></i>
                <span>{{ __('labels.backend.forum.notices.management') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/course*')) }}"
               href="{{ route('admin.forum.course.index') }}">
                <i class="fas fa-book"></i>
                <span>{{ __('labels.backend.forum.courses.management') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/assignment*')) }}"
               href="{{ route('admin.forum.assignment.index') }}">
                <i class="fas fa-pencil-ruler"></i>
                <span>{{ __('labels.backend.forum.assignments.management') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/problem*')) }}"
               href="{{ route('admin.forum.problem.index') }}">
                <i class="fas fa-lightbulb"></i>
                <span>{{ __('labels.backend.forum.problems.management') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/forum/post*')) }}"
               href="{{ route('admin.forum.post.index') }}">
                <i class="fas fa-comments"></i>
                <span>{{ __('labels.backend.forum.posts.management') }}</span>
            </a>
        </li>
    @endif
</ul>