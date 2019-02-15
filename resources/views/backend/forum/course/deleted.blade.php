@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.courses.management') . ' | ' . __('labels.backend.forum.courses.deleted'))

@section('breadcrumb-links')
    @include('backend.forum.course.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.forum.courses.management') }}
                    <small class="text-muted">{{ __('labels.backend.forum.courses.deleted') }}</small>
                </h4>
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

                        @if ($courses->count())
                            @foreach ($courses as $course)
                                <tr>
                                    <td class="font-weight-bold">{{ $course->id }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->semester }}</td>
                                    <td>{{ $course->start_time }}</td>
                                    <td>{{ $course->end_time }}</td>
                                    <td>{!! $course->notice_html !!}</td>
                                    <td>{{ $course->difficulty }}</td>
                                    <td>{{ $course->restrict_level }}</td>
                                    <td>{!! $course->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.forum.courses.no_deleted') }}</p></td></tr>
                        @endif
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
