@extends ('backend.layouts.app')

@section ('title', __('labels.backend.forum.posts.management') . ' | ' . __('labels.backend.forum.posts.deleted'))

@section('breadcrumb-links')
    @include('backend.forum.post.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.forum.posts.management') }}
                    <small class="text-muted">{{ __('labels.backend.forum.posts.deleted') }}</small>
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
                            <th>{{ __('labels.backend.forum.posts.table.course_id') }}</th>
                            <th>{{ __('labels.backend.forum.posts.table.assignment_id') }}</th>
                            <th>{{ __('labels.backend.forum.posts.table.parent_id') }}</th>
                            <th>{{ __('labels.backend.forum.posts.table.user_id') }}</th>
                            <th>{{ __('labels.backend.forum.posts.table.editor_id') }}</th>
                            <th>{{ __('labels.backend.forum.posts.table.content') }}</th>
                            <th>{{ __('labels.general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if ($posts->count())
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="font-weight-bold">{{ $post->id }}</td>
                                    <td>{{ $post->course_name_label }}</td>
                                    <td>{{ $post->assignment_name_label }}</td>
                                    <td>{{ $post->parent_id }}</td>
                                    <td>{{ $post->author_name_label }}</td>
                                    <td>{{ $post->editor_name_label }}</td>
                                    <td>{!! $post->content !!}</td>
                                    <td>{!! $post->action_buttons !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9"><p class="text-center">{{ __('strings.backend.forum.posts.no_deleted') }}</p></td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $posts->total() !!} {{ trans_choice('labels.backend.forum.posts.table.total', $posts->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $posts->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
