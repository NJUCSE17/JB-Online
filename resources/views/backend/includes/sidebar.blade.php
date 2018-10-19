<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownLanguageLink">
    <a class="dropdown-header">
        {{ __('menus.backend.sidebar.general') }}
    </a>
    <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/dashboard')) }}"
       href="{{ route('admin.dashboard') }}">
        <div class="row">
            <div class="col-3 text-center">
                <i class="fas fa-table"></i>
            </div>
            <div class="col-9">
                {{ __('menus.backend.sidebar.dashboard') }}
            </div>
        </div>
    </a>

    <div class="dropdown-header">
        {{ __('menus.backend.sidebar.system') }}
    </div>

    @if ($logged_in_user->isAdmin())
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}"
           href="{{ route('admin.auth.user.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.access.users.management') }}
                    @if ($pending_approval > 0)
                        <span class="badge badge-danger float-right">{{ $pending_approval }}</span>
                    @endif
                </div>
            </div>
        </a>
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}"
           href="{{ route('admin.auth.role.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-users"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.access.roles.management') }}
                </div>
            </div>
        </a>
    @endif

    @if ($logged_in_user->isExecutive())
        <div class="dropdown-header">
            {{ __('menus.backend.sidebar.forum') }}
        </div>

        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/forum/notice*')) }}"
           href="{{ route('admin.forum.notice.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-broadcast-tower"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.forum.notices.management') }}
                </div>
            </div>
        </a>
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/forum/course*')) }}"
           href="{{ route('admin.forum.course.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-book"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.forum.courses.management') }}
                </div>
            </div>
        </a>
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/forum/assignment*')) }}"
           href="{{ route('admin.forum.assignment.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-pencil-ruler"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.forum.assignments.management') }}
                </div>
            </div>
        </a>
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/forum/problem*')) }}"
           href="{{ route('admin.forum.problem.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.forum.problems.management') }}
                </div>
            </div>
        </a>
        <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/forum/post*')) }}"
           href="{{ route('admin.forum.post.index') }}">
            <div class="row">
                <div class="col-3 text-center">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="col-9">
                    {{ __('labels.backend.forum.posts.management') }}
                </div>
            </div>
        </a>
    @endif

    <div class="dropdown-header">
        {{ __('menus.backend.sidebar.log') }}
    </div>

    <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}"
       href="{{ route('log-viewer::dashboard') }}">
        <div class="row">
            <div class="col-3 text-center">
                <i class="fas fa-table"></i>
            </div>
            <div class="col-9">
                {{ __('menus.backend.log-viewer.dashboard') }}
            </div>
        </div>
    </a>
    <a class="dropdown-item {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}"
       href="{{ route('log-viewer::logs.list') }}">
        <div class="row">
            <div class="col-3 text-center">
                <i class="fas fa-cookie"></i>
            </div>
            <div class="col-9">
                {{ __('menus.backend.log-viewer.logs') }}
            </div>
        </div>
    </a>
</div><!--sidebar-->