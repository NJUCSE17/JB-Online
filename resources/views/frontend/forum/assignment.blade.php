@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="page-header text-justify">
        <div class="row">
            <div class="col">
                <h2 class="display-3 d-inline">
                    {{ $assignment->name }}
                </h2>
                <span class="float-right">
                    @if($sorted=='asc')
                        <a class="btn btn-outline-dark"
                           href="{{ route('frontend.forum.assignment.reverse', [$course, $assignment]) }}">
                            <i class="fas fa-arrow-down"></i> {{ __('buttons.general.reverse') }}
                        </a>
                    @else
                        <a class="btn btn-outline-dark"
                           href="{{ route('frontend.forum.assignment.view', [$course, $assignment]) }}">
                            <i class="fas fa-arrow-up"></i> {{ __('buttons.general.reverse') }}
                        </a>
                    @endif
                    <a class="btn btn-outline-success" onclick="triggerCreateModal(0)">
                        <i class="fas fa-plus"></i> {{ __('buttons.general.new_post') }}
                    </a>
                </span>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if(isset($posts[0]))
                        @include('frontend.forum.post.list',['group'=>$posts[0]])
                    @else
                        <div class="text-center">
                            {{ __('strings.frontend.no_post') }}
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
                        <span aria-hidden="true">&times;</span>
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