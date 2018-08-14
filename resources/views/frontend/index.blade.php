@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    <div class="page-header">
        <h1 class="display-2">
            {{ __('strings.frontend.jumbo_title') }}
        </h1>
        <h4>
            {{ __('strings.frontend.welcome_to', ['place' => app_name()]) }}
        </h4>
    </div>
    <div class="row my-4">
        <div class="col col-md-4">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ __('labels.frontend.home.assignment') }}
                </h4>
                @if ($assignments->count())
                    <div class="card-body px-0 py-0">
                        @foreach($assignments as $assignment)
                            <div class="card mx-3 my-3">
                                <a class="card-header btn-outline-dark"
                                   href="{{ $assignment->assignment_link }}" style="font-size: 120%">
                                    {{ $assignment->name }}
                                </a>
                                <div class="card-body">
                                    {!! $assignment->content !!}
                                    <div class="text-right">
                                        <small class="mb-0 text-muted">
                                            {{ __('labels.general.ddl') }}
                                            {{ $assignment->due_time }}
                                            {{ $assignment->due_time->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center">
                                {{ __('strings.frontend.home.no_assignment') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col col-md-8">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-broadcast-tower mr-2"></i>
                    {{ __('labels.frontend.home.notice') }}
                </h4>
                <div class="card-body text-justify">
                    @if($notice != null && $notice->content != null)
                        {!! $notice->content !!}
                        <small class="float-right text-muted">{{ $notice->time_label }}</small>
                    @else
                        <div class="row">
                            <div class="col text-center">
                                {{ __('strings.frontend.home.no_notice') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @auth
                <div class="card my-3">
                    <h4 class="card-header">
                        <i class="fas fa-book-open mr-2"></i>
                        {{ __('labels.frontend.home.ongoing') }}
                    </h4>
                    <div class="card-body">
                        @if ($ongoingCourses->count())
                            @foreach($ongoingCourses as $course)
                                <a class="btn btn-outline-success text-justify my-2"
                                   href="{{ $course->course_link }}" style="width: 100%;">
                                    {{ __('strings.frontend.home.semester.left') }}
                                    {{ $course->semester }}
                                    {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                    {{ $course->name }}
                                    <span class="float-right">
                                        {!! $course->labels !!}
                                    </span>
                                </a>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col text-center">
                                    {{ __('strings.frontend.home.no_ongoing') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($allCourses->count())
                    <div class="card my-3">
                        <h4 class="card-header">
                            <i class="fas fa-book mr-2"></i>
                            {{ __('labels.frontend.home.others') }}
                        </h4>
                        <div class="card-body">
                            @foreach($allCourses as $course)
                                <a class="btn btn-outline-primary text-justify my-2"
                                   href="{{ $course->course_link }}" style="width: 100%;">
                                    {{ __('strings.frontend.home.semester.left') }}
                                    {{ $course->semester }}
                                    {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                    {{ $course->name }}
                                    <span class="float-right">
                                    {!! $course->labels !!}
                                </span>
                                </a>
                            @endforeach
                            <div class="row mt-3">
                                <div class="col-7">
                                    <div class="float-left">
                                        {{ __('strings.frontend.home.total.left') }}
                                        {!! $allCourses->total() !!}
                                        {{ __('strings.frontend.home.total.right') }}
                                    </div>
                                </div><!--col-->

                                <div class="col-5">
                                    <div class="float-right">
                                        {!! $allCourses->render() !!}
                                    </div>
                                </div><!--col-->
                            </div><!--row-->
                        </div>
                    </div>
                @endif
            @endauth
            @guest
                <div class="card my-3">
                    <h4 class="card-header">
                        <i class="fas fa-user mr-2"></i>
                        {{ __('labels.frontend.home.login') }}
                    </h4>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <a class="btn btn-secondary" href="{{ route('frontend.auth.login') }}">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                {{ __('labels.frontend.home.login_button') }}
                            </a>
                        </div>
                        <div>
                            {{ __('strings.frontend.home.not_logged_in') }}
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
@endsection
