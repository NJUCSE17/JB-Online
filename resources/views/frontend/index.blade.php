@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    <div class="page-header text-center">
        <div class="card">
            <img class="card-img" src="{{ app_coverart() }}" id="coverart" style="width: 100%">
            <div class="card-img-overlay text-right">
                <h4 class="card-title display-4 slide-in">
                    {{ app_name() }}
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4 col-12">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ __('labels.frontend.home.assignment') }}
                    @auth
                        @if(Auth::user()->isExecutive())
                            <span class="float-right d-flex">
                                <a class="text-sm-center text-dark" href="{{ route('admin.forum.assignment.index') }}">
                                    <i class="fas fa-cog"></i>
                                </a>
                            </span>
                        @endif
                    @endauth
                </h4>
                @if ($assignments->count())
                    <div class="card-body px-0 py-0">
                        <div class="list-group list-group-flush" id="assignments">
                            <?php $lastAssignment = $assignments->pop(); ?>
                            @foreach($assignments as $assignment)
                                <a href="{{ $assignment->assignment_link }}"
                                   class="list-group-item list-group-item-action" id="assignment">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1" id="assignment_title">
                                            {{ $assignment->name }}
                                        </h5>
                                    </div>
                                    <object id="assignment_content">
                                        <p class="mb-1">
                                            {!! $assignment->content !!}
                                        </p>
                                    </object>
                                    <small class="float-right" id="assignment_ddl">
                                        {{ __('labels.general.ddl') }}
                                        {{ $assignment->due_time }}
                                        {{ $assignment->due_time->diffForHumans() }}
                                    </small>
                                </a>
                            @endforeach
                            <!-- Last Assignment with Border Radius !-->
                            <a href="{{ $lastAssignment->assignment_link }}"
                               class="list-group-item list-group-item-action" id="assignment"
                               style="border-bottom-left-radius: 0.625rem; border-bottom-right-radius: 0.625rem">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1" id="assignment_title">
                                        {{ $lastAssignment->name }}
                                    </h5>
                                </div>
                                <object id="assignment_content">
                                    <p class="mb-1">
                                        {!! $lastAssignment->content !!}
                                    </p>
                                </object>
                                <small class="float-right" id="assignment_ddl">
                                    {{ __('labels.general.ddl') }}
                                    {{ $assignment->due_time }}
                                    {{ $assignment->due_time->diffForHumans() }}
                                </small>
                            </a>
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

        <div class="col col-md-8 col-12">
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
                                <a class="btn btn-outline-{{ $course->color_label }} text-justify my-2"
                                   href="{{ $course->course_link }}" style="width: 100%;">
                                    {{ __('strings.frontend.home.semester.left') }}
                                    {{ $course->semester }}
                                    {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                    {{ $course->name }}
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
                                <a class="btn btn-outline-{{ $course->color_label }} text-justify my-2"
                                   href="{{ $course->course_link }}" style="width: 100%;">
                                    {{ __('strings.frontend.home.semester.left') }}
                                    {{ $course->semester }}
                                    {{ __('strings.frontend.home.semester.right') }} &nbsp;
                                    {{ $course->name }}
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
            @else
                <div class="card my-3">
                    <h4 class="card-header py-3">
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
            @endauth
        </div>
    </div>
@endsection

@push('after-scripts')
    <script type="text/javascript">
        $('#coverart').on('mousedown', function (e) {
            e.preventDefault()
        })
    </script>
@endpush