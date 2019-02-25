@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.forum.problems.management'))

@section('breadcrumb-links')
    @include('backend.forum.problem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.forum.problems.management') }}
                        <small class="text-muted">
                            {{ __('labels.backend.forum.problems.active') }}
                            @if (isset($specificAssignment))
                                ({{ $specificAssignment->name }})
                            @endif
                        </small>
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('backend.forum.problem.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('labels.backend.forum.problems.table.course_id') }}</th>
                                <th>{{ __('labels.backend.forum.problems.table.assignment_id') }}</th>
                                <th>{{ __('labels.backend.forum.problems.table.permalink') }}</th>
                                <th>{{ __('labels.backend.forum.problems.table.content') }}</th>
                                <th>{{ __('labels.backend.forum.problems.table.difficulty') }}</th>
                                <th>{{ __('labels.backend.forum.problems.table.updated_at') }}</th>
                                <th>{{ __('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($problems as $problem)
                                <tr>
                                    <td class="font-weight-bold">{{ $problem->id }}</td>
                                    <td>{{ $problem->course_name_label }}</td>
                                    <td>{{ $problem->assignment_name_label }}</td>
                                    <td>{{ $problem->permalink }}</td>
                                    <td>{{ $problem->content }}</td>
                                    <td>{{ $problem->difficulty_label }}</td>
                                    <td>{{ $problem->updated_at->diffForHumans() }}</td>
                                    <td>{!! $problem->action_buttons !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $problems->total() !!} {{ trans_choice('labels.backend.forum.problems.table.total', $problems->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $problems->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->

            <hr/>
            @if(isset($specificAssignment))
                {{ html()->form('POST', route('admin.forum.problem.store'))->class('form-horizontal')->open() }}
                <div class="card my-3">
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <div class="form-group row d-none">
                                    {{ html()->label(__('validation.attributes.backend.forum.problems.course_id'))->class('col-md-2 form-control-label')->for('course_id') }}
                                    <div class="col-md-10">
                                        {{ html()->text('course_id', $specificAssignment->source->id)
                                            ->readonly()
                                            ->class('form-control')
                                            ->attribute('maxlength', 191)
                                            ->required() }}
                                    </div><!--col-->
                                </div><!--form-group-->

                                <div class="form-group row d-none">
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
                                                [0=>'N/A', 1=>'☆', 2=>'★', 3=>'★☆', 4=>'★★', 5=>'★★☆',
                                                 6=>'★★★', 7=>'★★★☆', 8=>'★★★★', 9=>'★★★★☆', 10=>'★★★★★'], 0)
                                            ->class('form-control')
                                            ->attribute('maxlength', 20)
                                            ->required() }}
                                    </div><!--col-->
                                </div><!--form-group-->

                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col text-right">
                                {{ form_submit(__('buttons.general.crud.create')) }}
                            </div><!--col-->
                        </div><!--row-->
                    </div><!--card-body-->
                </div><!--card-->
                {{ html()->form()->close() }}
            @endif
        </div><!--card-body-->
    </div><!--card-->
@endsection
