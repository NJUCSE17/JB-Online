@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.assignments.management') . ' | ' . __('labels.backend.forum.assignments.deleted'))

@section('breadcrumb-links')
    @include('backend.forum.assignment.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.forum.assignments.management') }}
                    <small class="text-muted">{{ __('labels.backend.forum.assignments.deleted') }}</small>
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
                            <th>{{ __('labels.backend.forum.assignments.table.course_id') }}</th>
                            <th>{{ __('labels.backend.forum.assignments.table.name') }}</th>
                            <th>{{ __('labels.backend.forum.assignments.table.content') }}</th>
                            <th>{{ __('labels.backend.forum.assignments.table.due_time') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if ($assignments->count())
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td class="font-weight-bold">{{ $assignment->id }}</td>
                                    <td>{{ $assignment->course_name_label }}</td>
                                    <td>{{ $assignment->name }}</td>
                                    <td><div class="content">{!! $assignment->content_html !!}</div></td>
                                    <td>{{ $assignment->due_time }}</td>
                                    <td>{!! $assignment->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.forum.assignments.no_deleted') }}</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row mt-3">
            <div class="col-7">
                <div class="float-left">
                    {!! $assignments->total() !!} {{ trans_choice('labels.backend.forum.assignments.table.total', $assignments->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $assignments->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
