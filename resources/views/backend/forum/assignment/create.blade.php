@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.assignments.management') . ' | ' . __('labels.backend.forum.assignments.create'))

@section('breadcrumb-links')
    @include('backend.forum.assignment.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.forum.assignment.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            {{ __('labels.backend.forum.assignments.management') }}
                            <small class="text-muted">{{ __('labels.backend.forum.assignments.create') }}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr />

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.assignments.course_id'))->class('col-md-2 form-control-label')->for('course_id') }}
                            <div class="col-md-10">
                                {{ html()->select('course_id', $courseList, 0)
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.assignments.name'))->class('col-md-2 form-control-label')->for('name') }}

                            <div class="col-md-10">
                                {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.assignments.name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.assignments.content'))->class('col-md-2 form-control-label')->for('content') }}

                            <div class="col-md-10">
                                {{ html()->textarea('content')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.assignments.content'))
                                    ->attribute('maxlength', 1900) }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.assignments.due_time'))->class('col-md-2 form-control-label')->for('due_time') }}

                            <div class="col-md-10">
                                {{ html()->text('due_time', '2017-09-01 21:59:59')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.assignments.due_time'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.forum.assignment.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection