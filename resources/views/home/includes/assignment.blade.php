<div class="card">
    <h3 class="card-header">
        {{ $assignment->name }}
    </h3>
    <div class="card-body">
        {!! $assignment->content_html !!}
    </div>
    <div class="card-footer">
        @if(($isPublic = isset($assignment->course_id)))
            <rate-component
                    :_api="{{ json_encode(route('api.assignment.rate', $assignment)) }}"
                    :_rated="{{ json_encode($assignment->rated) }}"
                    :_stats="{{ json_encode($assignment->stats) }}"
            >
                __RATE_COMPONENT_ASSIGNMENT_{{ $assignment->id }}__
            </rate-component>
        @endif
        <span class="float-right">
            <ddl-component
                    :_api_finish="{{ json_encode($isPublic ? route('api.assignment.finish', $assignment) : route('api.personalAssignment.finish', $assignment)) }}"
                    :_api_reset="{{ json_encode($isPublic ? route('api.assignment.reset', $assignment) : route('api.personalAssignment.reset', $assignment)) }}"
                    :_due_time="{{ json_encode($assignment->due_time) }}"
                    :_finished_at="{{ json_encode($assignment->finished_at) }}"
            >
                __DDL_COMPONENT_{{ $isPublic ? 'PUBLIC' : 'PRIVATE' }}_{{ $assignment->id }}__
            </ddl-component>
        </span>
    </div>
</div>