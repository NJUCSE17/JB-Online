@extends ('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.personal'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.personal'))

@section('content')
    {!! Breadcrumbs::render() !!}
    {{ html()->form('POST', route('frontend.forum.personal.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            {{ __('labels.frontend.forum.personal.management') }}
                            <small class="text-muted">{{ __('labels.frontend.forum.personal.create') }}</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr />

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.frontend.forum.personal.name'))->class('col-md-2 form-control-label')->for('name') }}

                            <div class="col-md-10">
                                {{ html()->text('name')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.forum.personal.name'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.frontend.forum.personal.content'))->class('col-md-2 form-control-label')->for('content') }}

                            <div class="col-md-10">
                                {{ html()->textarea('content')
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.forum.personal.content'))
                                    ->attribute('maxlength', 1900) }}
                            </div><!--col-->
                        </div><!--form-group-->

                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.frontend.forum.personal.due_time'))->class('col-md-2 form-control-label')->for('due_time') }}

                            <div class="col-md-10">
                                {{ html()->text('due_time', date('Y-m-d G:i:s'))
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.frontend.forum.personal.due_time'))
                                    ->attribute('maxlength', 191)
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('frontend.forum.personal.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection