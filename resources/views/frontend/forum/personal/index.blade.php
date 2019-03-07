@extends ('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.personal'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.personal'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.frontend.forum.personal.management') }}
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    @include('frontend.forum.personal.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('labels.frontend.forum.personal.table.name') }}</th>
                                <th>{{ __('labels.frontend.forum.personal.table.content') }}</th>
                                <th>{{ __('labels.frontend.forum.personal.table.due_time') }}</th>
                                <th>{{ __('labels.general.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($assignments as $assignment)
                            <tr>
                                <td class="font-weight-bold">{{ $assignment->id }}</td>
                                <td>{{ $assignment->name }}</td>
                                <td><div class="content">{!! $assignment->content_html !!}</div></td>
                                <td>{{ $assignment->due_time }}</td>
                                <td>{!! $assignment->action_buttons !!}</td>
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
                    {!! $assignments->total() !!} {{ trans_choice('labels.frontend.forum.personal.table.total', $assignments->total()) }}
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
