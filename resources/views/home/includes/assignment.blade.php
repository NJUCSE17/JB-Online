<div class="card">
    <h3 class="card-header">
        {{ $assignment->name }}
    </h3>
    <div class="card-body">
        {!! $assignment->content_html !!}
    </div>
    <div class="card-footer">
        @if(isset($assignment->course_id))
            <div class="d-inline-flex">
                <span class="mr-3">
                    <a href="#" class="text-dark">
                        <i class="fas fa-heart-broken mr-1"></i> 0
                    </a>
                </span>
                <span>
                    <a href="#" class="text-dark">
                        <i class="fas fa-heart mr-1"></i> 0
                    </a>
                </span>
            </div>
        @endif
        <span class="float-right">
            <a href="#" class="{{ \App\Helpers\AssignmentDeadlines::DDLColor($assignment) }}">
                @if(isset($assignment->finished_at))
                    <i class="fas fa-times mr-1"></i>
                    <span>
                        <s>{{ \App\Helpers\AssignmentDeadlines::DDLForHuman($assignment) }}</s>
                    </span>
                @else
                    <i class="fas fa-check mr-1"></i>
                    <span>
                        {{ \App\Helpers\AssignmentDeadlines::DDLForHuman($assignment) }}
                    </span>
                @endif
            </a>
        </span>
    </div>
</div>