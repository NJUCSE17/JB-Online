@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.courses.management') . ' | ' . __('labels.backend.forum.courses.create'))

@section('breadcrumb-links')
    @include('backend.forum.course.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.forum.course.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            {{ __('labels.backend.forum.courses.management') }}
                            <small class="text-muted">{{ __('labels.backend.forum.courses.create') }}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr />

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.name'))->class('col-md-2 form-control-label')->for('name') }}

                            <div class="col-md-10">
                                {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.courses.name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.semester'))->class('col-md-2 form-control-label')->for('semester') }}

                            <div class="col-md-10">
                                {{ html()->select('semester',
                                        [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5', 6=>'6', 7=>'7', 8=>'8'])
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.start_time'))->class('col-md-2 form-control-label')->for('start_time') }}

                            <div class="col-md-10">
                                {{ html()->text('start_time', '2017-09-01')
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.end_time'))->class('col-md-2 form-control-label')->for('end_time') }}

                            <div class="col-md-10">
                                {{ html()->text('end_time', '2021-07-01')
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.notice'))->class('col-md-2 form-control-label')->for('notice') }}

                            <div class="col-md-10">
                                {{ html()->textarea('notice')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.forum.courses.notice'))
                                    ->attribute('maxlength', 1900) }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.difficulty'))->class('col-md-2 form-control-label')->for('difficulty') }}

                            <div class="col-md-10">
                                {{ html()->select('difficulty', [
                                        0=>__('validation.attributes.backend.forum.courses.difficulty_label.0'),
                                        1=>__('validation.attributes.backend.forum.courses.difficulty_label.1'),
                                        2=>__('validation.attributes.backend.forum.courses.difficulty_label.2'),
                                        3=>__('validation.attributes.backend.forum.courses.difficulty_label.3')], 0)
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.forum.courses.restrict_level'))->class('col-md-2 form-control-label')->for('restrict_level') }}

                            <div class="col-md-10">
                                {{ html()->select('restrict_level', [
                                        0=>__('validation.attributes.backend.forum.courses.restrict_level_label.0'),
                                        1=>__('validation.attributes.backend.forum.courses.restrict_level_label.1'),
                                        2=>__('validation.attributes.backend.forum.courses.restrict_level_label.2')], 0)
                                    ->class('form-control')
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.forum.course.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection