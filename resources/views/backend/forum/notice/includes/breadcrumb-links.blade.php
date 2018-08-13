<li class="breadcrumb-menu">
    <div class="btn-group" role="group" aria-label="Button group">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('menus.backend.forum.notices.main') }}</a>

            <div class="dropdown-menu" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.forum.notice.index') }}">{{ __('menus.backend.forum.notices.all') }}</a>
                <a class="dropdown-item" href="{{ route('admin.forum.notice.create') }}">{{ __('menus.backend.forum.notices.create') }}</a>
                <a class="dropdown-item" href="{{ route('admin.forum.notice.deleted') }}">{{ __('menus.backend.forum.notices.deleted') }}</a>
            </div>
        </div><!--dropdown-->

        <!--<a class="btn" href="#">Static Link</a>-->
    </div><!--btn-group-->
</li>