<div class="card">
    <h3 class="card-header">
        {{ $assignment->name }}
    </h3>
    <div class="card-body">
        {!! $assignment->content_html !!}
    </div>
    <div class="card-footer">
        @if(isset($assignment->course_id))
            <rate-component
                :_api="{{ json_encode(route('api.assignment.rate', $assignment)) }}"
                :_rated="{{ json_encode($assignment->rated) }}"
                :_stats="{{ json_encode($assignment->stats) }}"
            >__RATE_COMPONENT_ASSIGNMENT_{{ $assignment->id }}_HIDDEN__</rate-component>
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