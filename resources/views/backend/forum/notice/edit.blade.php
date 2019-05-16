@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.notices.management') . ' | ' . __('labels.backend.forum.notices.edit'))

@section('breadcrumb-links')
    @include('backend.forum.notice.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->modelForm($notice, 'PATCH' , route('admin.forum.notice.update', $notice->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.forum.notices.management') }}
                        <small class="text-muted">{{ __('labels.backend.forum.notices.edit') }}</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.forum.notices.content'))->class('col-md-2 form-control-label')->for('content') }}

                        <div class="col-md-10">
                            {{ html()->textarea('content')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.forum.notices.content'))
                                ->attribute('maxlength', 1900) }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->

            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.forum.notice.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
    {{ html()->closeModelForm() }}
@endsection