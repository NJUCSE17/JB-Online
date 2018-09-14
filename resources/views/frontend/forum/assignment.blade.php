@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. $assignment->name)
@section('navBrand', app_name() . ' | ' . __('strings.frontend.breadcrumb.assignment'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="row">
        <div class="col">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-pencil-ruler mr-2"></i>
                    {{ __('labels.frontend.forum.assignments.assignment_content') }}
                    @if(Auth::user()->isExecutive())
                        <span class="float-right d-flex">
                            <a class="text-sm-center text-dark" href="{{ route('admin.forum.assignment.edit', $assignment) }}">
                                <i class="fas fa-cog"></i>
                            </a>
                        </span>
                    @endif
                </h4>
                <div class="card-body">
                    <div class="row">
                        <div class="col mx-3">
                            <h5>{!! $assignment->content !!}</h5>
                            <div class="text-right">
                                <p class="mb-0 text-muted">
                                    {{ __('labels.general.ddl') }}
                                    {{ $assignment->due_time->isoFormat("Y-MM-DD (ddd) H:mm:ss") }}<br />
                                    {{ $assignment->due_time->diffForHumans(null, null, false, 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-comments mr-2"></i>
                    {{ __('labels.frontend.forum.assignments.post_list') }}
                    <span class="float-right d-flex">
                        @if($sorted=='asc')
                            <a class="btn btn-sm btn-secondary with-shadows"
                               href="{{ route('frontend.forum.assignment.view', [$course, $assignment, 'dec']) }}">
                                <i class="fas fa-sort-amount-up mr-2"></i> {{ __('buttons.general.reverse') }}
                            </a>
                        @else
                            <a class="btn btn-sm btn-secondary with-shadows"
                               href="{{ route('frontend.forum.assignment.view', [$course, $assignment, 'asc']) }}">
                                <i class="fas fa-sort-amount-down mr-2"></i> {{ __('buttons.general.reverse') }}
                            </a>
                        @endif
                        <a class="btn btn-sm btn-success with-shadows text-white ml-2" onclick="triggerCreateModal(0)">
                            <i class="fas fa-plus mr-2"></i> {{ __('buttons.general.new_post') }}
                        </a>
                        @if(Auth::user()->isExecutive())
                            <a class="text-sm-center text-dark ml-2" href="{{ route('admin.forum.post.specific', $assignment) }}">
                                <i class="fas fa-cog"></i>
                            </a>
                        @endif
                    </span>
                </h4>
                @if(isset($posts[0]))
                    <div class="card-body px-3 py-0">
                        @include('frontend.forum.post.list',['group'=>$posts[0]])
                    </div>
                @else
                    <div class="card-body px-3 py-3">
                        <div class="text-center">
                            {{ __('strings.frontend.assignments.no_post') }}
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="createModal" aria-hidden="true" id="createModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('labels.frontend.forum.new_reply') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ html()->form('POST', route('frontend.forum.post.store', [$course, $assignment]))->open() }}
                    <div class="row">
                        <div class="col">
                            <div class="form-group hidden">
                                {{ html()->text('parent_id', 0)
                                    ->readonly()
                                    ->id('parent_id_box')
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                {{ html()->label(__('validation.attributes.frontend.content'))->for('content') }}

                                {{ html()->textarea('content')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.content'))
                                    ->attribute('rows', 3) }}
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('buttons.general.cancel') }}</button>
                    <button type="submit" class="btn btn-success">{{ __('buttons.general.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        $('#parent_id_box').hide();

        let triggerCreateModal = function(parent_id) {
            $('#createModal').modal('show');
            document.getElementById('parent_id_box').value = parent_id;
        };

        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });
    </script>
@endpush