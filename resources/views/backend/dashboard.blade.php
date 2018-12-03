@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row my-3">
        <div class="col">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">用户</span>
                            <h6 class="stats-small__value count my-3">
                                {{ \App\Models\Auth\User::all()->count() }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">作业</span>
                            <h6 class="stats-small__value count my-3">
                                {{ \App\Models\Forum\Assignment::all()->where('due_time', '>', now())->count() }} /
                                {{ \App\Models\Forum\Assignment::all()->count() }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">帖子</span>
                            <h6 class="stats-small__value count my-3">
                                {{ \App\Models\Forum\Post::all()->count() }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <h4 class="card-header">
                    <strong>{{ __('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</strong>
                </h4><!--card-header-->
                <div class="card-body px-3 py-3">
                    {!! __('strings.backend.welcome') !!}
                </div><!--card-block-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
