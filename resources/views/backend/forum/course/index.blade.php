@extends ('backend.layouts.app')

@section ('title', app_name() . ' | ' . __('labels.backend.forum.courses.management'))

@section('breadcrumb-links')
    @include('backend.forum.course.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.forum.courses.management') }} <small class="text-muted">{{ __('labels.backend.forum.courses.active') }}</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.forum.course.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('labels.backend.forum.courses.table.name') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.semester') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.start_time') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.end_time') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.notice') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.difficulty') }}</th>
                            <th>{{ __('labels.backend.forum.courses.table.restrict_level') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td class="font-weight-bold">{{ $course->id }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->semester }}</td>
                                <td>{{ $course->start_time }}</td>
                                <td>{{ $course->end_time }}</td>
                                <td>{!! $course->notice !!}</td>
                                <td>{!!  $course->difficulty_label !!}</td>
                                <td>{!! $course->restrict_label !!}</td>
                                <td>{!! $course->action_buttons !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row mt-3">
            <div class="col-7">
                <div class="float-left">
                    {!! $courses->total() !!} {{ trans_choice('labels.backend.forum.courses.table.total', $courses->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $courses->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
