@if ($assignments->count())
    <div id="assignments" class="my-3">
        @foreach($assignments as $assignment)
            <div class="card my-3">
                <div class="card-body p-3" id="assignment">
                    <div class="d-inline w-100 justify-content-between">
                        <span class="float-right ddlBtnContainer" id="ddlBtnContainer-{{ $assignment->id }}">
                            {!! $assignment->ddl_button !!}
                        </span>
                        <a href="{{ $assignment->assignment_link }}" class="text-dark"
                           id="assignment_title_{{ $assignment->id }}" style="font-size:120%; font-weight: bold;">
                            {{ $assignment->course_name }} - {{ $assignment->name }}
                            @if($assignment->postsCount())
                                <span class="badge badge-light">
                                        <i class="fas fa-comments"></i>
                                        {{  $assignment->postsCount() }}
                                    </span>
                            @endif
                        </a>
                        <br />
                        <small id="ddlContentContainer-{{ $assignment->id }}">
                            {!! $assignment->ddl_content !!}
                        </small>
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
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card my-3">
        <div class="card-body p-3">
            <div class="row">
                <div class="col text-center">
                    {{ __('strings.frontend.home.no_assignment') }}
                </div>
            </div>
        </div>
    </div>
@endif

@push('after-scripts')
    <script type="text/javascript" id="assignmentBtnScript">
        $('#coverart').on('mousedown', function (e) {
            e.preventDefault();
        });
        $('.ddlBtnContainer').on('click', '.ddlBtn', function (e) {
            e.preventDefault();
            let api = this.dataset.api;
            let aid = this.dataset.aid;
            axios.post(api, {})
                .then(function (response) {
                    $('#ddlBtnContainer-' + aid).html(response.data.button_html);
                    $('#ddlContentContainer-' + aid).html(response.data.ddl_html);
                })
                .catch(function (error) {
                    $.alert({
                        title: 'Fail',
                        content: "Failed to proceed. Error: " + error,
                        type: 'red',
                        typeAnimated: true,
                        backgroundDismiss: 'close',
                        buttons: {
                            close: function () {
                            }
                        }
                    });
                });
        });
    </script>
@endpush