@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.problems.management') . ' | ' . __('labels.backend.forum.problems.create'))

@section('breadcrumb-links')
    @include('backend.forum.problem.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.forum.problem.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            {{ __('labels.backend.forum.problems.management') }}
                            <small class="text-muted">{{ __('labels.backend.forum.problems.create') }}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr />

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.problems.course_id'))->class('col-md-2 form-control-label')->for('course_id') }}
                            <div class="col-md-10">
                                {{ html()->text('course_id', $specificAssignment->source->id)
                                    ->readonly()
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.problems.assignment_id'))->class('col-md-2 form-control-label')->for('assignment_id') }}
                            <div class="col-md-10">
                                {{ html()->text('assignment_id', $specificAssignment->id)
                                    ->readonly()
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.problems.permalink'))->class('col-md-2 form-control-label')->for('permalink') }}

                            <div class="col-md-10">
                                {{ html()->text('permalink')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.problems.permalink'))
                                    ->attribute('maxlength', 500) }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.problems.content'))->class('col-md-2 form-control-label')->for('content') }}

                            <div class="col-md-10">
                                {{ html()->text('content')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.problems.content'))
                                    ->attribute('maxlength', 500)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.problems.difficulty'))->class('col-md-2 form-control-label')->for('difficulty') }}

                            <div class="col-md-10">
                                {{ html()->select('difficulty',
                                        [0=>'0', 1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5',
                                         6=>'6', 7=>'7', 8=>'8', 9=>'9', 10=>'10'], 5)
                                    ->class('form-control')
                                    ->attribute('maxlength', 20)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->
        </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.forum.problem.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection