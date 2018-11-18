<div class="btn-toolbar float-right btn-sm" role="toolbar" aria-label="Toolbar with button groups">
    <a href="{{ route('admin.forum.problem.deleted') }}" class="btn btn-danger ml-1" data-toggle="tooltip" title="Trash"><i class="fas fa-trash"></i></a>
    @if(isset($specificAssignment))
        <a href="{{ route('admin.forum.problem.specific.create', [$specificAssignment]) }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i></a>
    @endif
</div><!--btn-toolbar-->