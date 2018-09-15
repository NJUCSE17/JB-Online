@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="page-header text-center">
        <div class="card">
            <img class="card-img" src="{{ app_coverart() }}" id="coverart" style="width: 100%">
            <div class="card-img-overlay text-right">
                <h4 class="card-title slide-in">
                    {{ app_name() }}
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4 col-12" id="leftCol">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ __('labels.frontend.home.assignment') }}
                    <span class="float-right d-flex">
                        @auth
                            @if(Auth::user()->isExecutive())
                                <a class="text-sm-center text-dark ml-2"
                                   href="{{ route('admin.forum.assignment.index') }}">
                                    <i class="fas fa-cog"></i>
                                </a>
                            @endif
                        @else
                            <a class="badge badge-sm badge-secondary" href="{{ route('frontend.auth.login') }}">
                                <i class="fas fa-user-secret"></i>
                            </a>
                        @endauth
                    </span>
                </h4>
                @if ($assignments->count())
                    <div class="card-body px-0 py-0">
                        <div class="list-group list-group-flush" id="assignments">
                            @foreach($assignments as $assignment)
                                <a class="list-group-item list-group-item-action border-0" id="assignment"
                                   style="border-radius: 0.625rem">
                                    <div class="d-inline w-100 justify-content-between">
                                        <object>
                                            @if($assignment->postsCount())
                                                <span class="float-right" style="font-size:120%;">
                                                    <a class="badge badge-primary"
                                                       href="{{ $assignment->assignment_link }}">
                                                        <i class="fas fa-comments"></i>
                                                        {{  $assignment->postsCount() }}
                                                    </a>
                                                </span>
                                            @endif
                                            <a href="{{ $assignment->assignment_link }}"
                                               class="mb-1" id="assignment_title" style="font-size:120%;">
                                                {{ $assignment->name }}
                                            </a>
                                        </object>
                                    </div>
                                    <div id="assignment_content">
                                        <object>
                                            {!! $assignment->content !!}
                                        </object>
                                    </div>
                                    <div class="text-center">
                                        <object>{!! $assignment->ddl_badge !!}</object>
                                    </div>
                                    <hr class="mb-0"/>
                                </a>
                            @endforeach
                        </div>
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

        <div class="col col-lg-8 col-12" id="rightCol">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-broadcast-tower mr-2"></i>
                    {{ __('labels.frontend.home.notice') }}
                    @auth
                        @if(Auth::user()->isExecutive())
                            <span class="float-right d-flex">
                                <a class="text-sm-center text-dark" href="{{ route('admin.forum.notice.index') }}">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </span>
                        @endif
                    @endauth
                </h4>
                <div class="card-body text-justify" id="notice_content">
                    @if($notice != null && $notice->content != null)
                        {!! $notice->content !!}
                        <p class="float-right text-muted">{{ $notice->time_label }}</p>
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
                <h4 class="card-header py-3">
                    <i class="fas fa-book-open mr-2"></i>
                    {{ __('labels.frontend.home.ongoing') }}
                    @auth
                        @if(Auth::user()->isExecutive())
                            <span class="float-right d-flex">
                                    <a class="text-sm-center text-dark" href="{{ route('admin.forum.course.index') }}">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </span>
                        @endif
                    @endauth
                </h4>
                <div class="card-body">
                    @if ($ongoingCourses->count())
                        @foreach($ongoingCourses as $course)
                            <a class="btn btn-sm btn-outline-{{ $course->color_label }} text-justify my-1"
                               style="width: 100%;"  href="{{ $course->course_link }}">
                                {{ __('strings.frontend.home.semester.left') }}
                                {{ $course->semester }}
                                {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                {{ $course->name }}
                                <div class="float-right">
                                        <span class="badge badge-{{ $course->color_label }}">
                                            <i class="fas fa-folder"></i>
                                            {{ $course->assignmentsCount() }}
                                            <i class="fas fa-comments"></i>
                                            {{ $course->postsCount() }}
                                        </span>
                                </div>
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
                    <h4 class="card-header py-3">
                        <i class="fas fa-book mr-2"></i>
                        {{ __('labels.frontend.home.others') }}
                        @auth
                            @if(Auth::user()->isExecutive())
                                <span class="float-right d-flex">
                                        <a class="text-sm-center text-dark"
                                           href="{{ route('admin.forum.course.index') }}">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                    </span>
                            @endif
                        @endauth
                    </h4>
                    <div class="card-body">
                        @foreach($allCourses as $course)
                            <a class="btn btn-sm btn-outline-{{ $course->color_label }} text-justify my-1"
                               style="width: 100%;" href="{{ $course->course_link }}">
                                {{ __('strings.frontend.home.semester.left') }}
                                {{ $course->semester }}
                                {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                {{ $course->name }}
                                <div class="float-right">
                                        <span class="badge badge-{{ $course->color_label }}">
                                            <i class="fas fa-folder"></i>
                                            {{ $course->assignmentsCount() }}
                                            <i class="fas fa-comments"></i>
                                            {{ $course->postsCount() }}
                                        </span>
                                </div>
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
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        $('#coverart').on('mousedown', function (e) {
            e.preventDefault()
        });
    </script>
@endpush