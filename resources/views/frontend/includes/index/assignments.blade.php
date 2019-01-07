<div class="card my-3">
    <h4 class="card-header">
        <i class="fas fa-calendar-alt mr-2"></i>
        {{ __('labels.frontend.home.assignment') }}
        <span class="float-right d-flex">
            @auth
                @if(Auth::user()->isExecutive())
                    <a class="text-sm-center text-dark ml-2"
                       href="{{ route('admin.forum.assignment.create') }}">
                        <i class="fas fa-plus mr-2"></i>
                    </a>
                    <a class="text-sm-center text-dark ml-2"
                       href="{{ route('admin.forum.assignment.index') }}">
                        <i class="fas fa-cog"></i>
                    </a>
                @endif
            @else
                <a class="badge badge-sm badge-secondary" href="{{ route('frontend.auth.login') }}">
                                <i class="fas fa-user-secret mr-2"></i>
                                {{ __('labels.frontend.auth.not_logged_in') }}
                            </a>
            @endauth
                    </span>
    </h4>
    @if ($assignments->count())
        <div class="card-body px-0 py-0">
            <ul class="list-group list-group-flush" id="assignments">
                @foreach($assignments as $assignment)
                    <li class="list-group-item" id="assignment">
                        <div class="d-inline w-100 justify-content-between">
                            @if($assignment->isPersonal())
                                <span class="float-right" style="font-size:120%;">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                <a href="{{ $assignment->assignment_link }}"
                                   class="mb-1 text-success"
                                   id="assignment_title_{{ $assignment->id }}" style="font-size:120%;">
                                    {{ $assignment->name }}
                                </a>
                            @else
                                @if($assignment->postsCount())
                                    <span class="float-right" style="font-size:120%;">
                                                        <a class="badge badge-primary"
                                                           href="{{ $assignment->assignment_link }}">
                                                            <i class="fas fa-comments"></i>
                                                            {{  $assignment->postsCount() }}
                                                        </a>
                                                    </span>
                                @endif
                                <a href="{{ $assignment->assignment_link }}"
                                   class="mb-1" id="assignment_title_{{ $assignment->id }}"
                                   style="font-size:120%;">
                                    {{ $assignment->name }}
                                </a>
                            @endif
                        </div>
                        <div id="assignment_content_{{ $assignment->id }}" class="pt-3">
                            <object class="my-0">
                                {!! $assignment->content !!}
                            </object>
                        </div>
                        @if ($assignment->problems_table)
                            <div id="assignment_problems_{{ $assignment->id }}">
                                <object>
                                    {!! $assignment->problems_table !!}
                                </object>
                            </div>
                        @endif
                        <div class="text-center mt-3">
                            <object>{!! $assignment->ddl_badge !!}</object>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="card-body">
            <div class="row">
                <div class="col text-center">
                    {{ __('strings.frontend.home.no_assignment') }}
                </div>
            </div>
        </div>
    @endif
</div>

@push('after-scripts')
    <script type="text/javascript">
        $('#coverart').on('mousedown', function (e) {
            e.preventDefault();
        });
    </script>
    <script type="text/javascript" id="assignmentBtnScript">
        $('.assignmentBtn').on('click', function (e) {
            e.preventDefault();
            if ('<?php echo \Auth::hasUser(); ?>') {
                let ddl_badge = this;
                let aid = this.dataset.aid;
                let api = this.dataset.api;
                let isFinished = this.dataset.finished === '1';
                let name = $("#assignment_title_" + aid.toString())[0].innerHTML;
                let content = $("#assignment_content_" + aid.toString())[0].innerHTML;
                let ddl_date = this.innerHTML;
                $.confirm({
                    icon: isFinished ? 'far fa-calendar-times' : 'far fa-calendar-check',
                    title: name,
                    content: content + ddl_date
                        + '<hr /><b>'
                        + (isFinished ? "{{ __('strings.frontend.assignments.reset_prompt') }}" : "{{ __('strings.frontend.assignments.finish_prompt') }}")
                        + '</b>',
                    type: isFinished ? 'red' : 'green',
                    theme: 'supervan',
                    columnClass: 'medium',
                    escapeKey: 'cancel',
                    backgroundDismiss: 'cancel',
                    buttons: {
                        confirm: {
                            text: '{{ __('labels.general.yes') }}',
                            btnClass: 'btn-success',
                            action: function () {
                                $.getJSON(api, function (res) {
                                    if (res.status === 1) {
                                        console.log(res);
                                        ddl_badge.dataset.api = res.ddl_badge_api;
                                        ddl_badge.dataset.finished = res.ddl_badge_finished;
                                        ddl_badge.innerHTML = res.ddl_badge_content;
                                        ddl_badge.setAttribute('class', res.ddl_badge_class);
                                    }
                                    $.dialog({
                                        title: (res.status === 1) ? 'Success' : 'Fail',
                                        content: res.prompt,
                                        type: (res.status === 1) ? 'green' : 'red',
                                        theme: 'supervan',
                                        typeAnimated: true,
                                        backgroundDismiss: 'close',
                                        buttons: {
                                            close: function () {
                                            }
                                        }
                                    });
                                });
                            }
                        },
                        cancel: {
                            text: '{{ __('labels.general.no') }}',
                            btnClass: 'btn-danger',
                            action: function () {
                                //
                            }
                        },
                    },
                });
            } else {
                document.location.href = '{{ route("frontend.auth.login") }}';
            }
        });
    </script>
@endpush