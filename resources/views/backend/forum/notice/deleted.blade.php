@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.notices.management') . ' | ' . __('labels.backend.forum.notices.deleted'))

@section('breadcrumb-links')
    @include('backend.forum.notice.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.forum.notices.management') }}
                    <small class="text-muted">{{ __('labels.backend.forum.notices.deleted') }}</small>
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
                            <th>{{ __('labels.backend.forum.notices.table.user_id') }}</th>
                            <th>{{ __('labels.backend.forum.notices.table.content') }}</th>
                            <th>{{ __('labels.backend.forum.notices.table.last_updated') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notices as $notice)
                            <tr>
                                <td class="font-weight-bold">{{ $notice->id }}</td>
                                <td>{{ $notice->user_id }}</td>
                                <td>{!! $notice->content_html !!}</td>
                                <td>{{ $notice->updated_at->diffForHumans() }}</td>
                                <td>{!! $notice->action_buttons !!}</td>
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
                    {!! $notices->total() !!} {{ trans_choice('labels.backend.forum.notices.table.total', $notices->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $notices->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
