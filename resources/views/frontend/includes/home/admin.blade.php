<div class="card my-3">
    <h5 class="card-header text-center py-2">
        <i class="fas fa-cog mr-2"></i>
        {{ __('labels.general.admin') }}
    </h5>
    <div class="card-body p-3" id="admin-panel">
        <div class="list-group text-center">
            <a class="list-group-item list-group-item-action py-1"
               href="{{ route('admin.forum.notice.index') }}">
                <i class="fas fa-broadcast-tower mr-2"></i>
                {{ __('labels.general.notice') }}
            </a>
            <a class="list-group-item list-group-item-action py-1"
               href="{{ route('admin.forum.course.index') }}">
                <i class="fas fa-book mr-2"></i>
                {{ __('labels.general.course') }}
            </a>
            <a class="list-group-item list-group-item-action py-1"
               href="{{ route('admin.forum.assignment.index') }}">
                <i class="fas fa-pencil-ruler mr-2"></i>
                {{ __('labels.general.assignment') }}
            </a>
            <a class="list-group-item list-group-item-action py-1"
               href="{{ route('telescope') }}">
                <i class="fas fa-chart-pie mr-2"></i> Telescope
            </a>
        </div>
    </div>
</div>