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
        <div class="col col-md-8">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-bullhorn"></i>
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

            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-home"></i>
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
                        <i class="fas fa-edit"></i>
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
        </div>

        <div class="col col-md-4">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-clock"></i>
                    {{ __('labels.frontend.home.assignment') }}
                </h4>
                <div class="card-body">
                    @if ($assignments->count())
                        @foreach($assignments as $assignment)
                            <div class="card my-2 text-center">
                                <a class="card-header btn-outline-dark"
                                   href="{{ $assignment->assignment_link }}" style="font-size: 120%">
                                    {{ $assignment->name }}
                                </a>
                                <div class="card-body">
                                    {!! $assignment->content !!}
                                    <p class="mb-0">{{ $assignment->due_time }}</p>
                                    <p class="mb-0">{{ $assignment->due_time->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col text-center">
                                {{ __('strings.frontend.home.no_assignment') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
