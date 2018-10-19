@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.problems.management') . ' | ' . __('labels.backend.forum.problems.deleted'))

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
                    <small class="text-muted">{{ __('labels.backend.forum.problems.deleted') }}</small>
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

                        @if ($problems->count())
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
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.forum.problems.no_deleted') }}</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row mt-3">
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
    </div><!--card-body-->
</div><!--card-->
@endsection
