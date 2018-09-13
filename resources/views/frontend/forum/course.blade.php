@extends('frontend.layouts.app')

@section('title', app_name() . ' | '. $course->name)

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="page-header text-justify">
        <div class="row">
            <div class="col">
                <h1 class="display-3 d-inline">
                    {{ $course->name }}
                </h1>
                <h4 class="float-right d-inline align-middle">{!! $course->labels !!}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-4 col-12">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-bullhorn mr-2"></i> {{ __('labels.frontend.forum.courses.course_notice') }}
                    @if(Auth::user()->isExecutive())
                        <span class="float-right d-flex">
                            <a class="text-sm-center text-dark" href="{{ route('admin.forum.course.edit', $course) }}">
                                <i class="fas fa-cog"></i>
                            </a>
                        </span>
                    @endif
                </h4>
                <div class="card-body text-justify">
                    @if($course->notice != null)
                        {!! $course->notice !!}
                        <p class="float-right text-muted">{{ $course->time_label }}</p>
                    @else
                        <div class="row">
                            <div class="col text-center">
                                {{ __('strings.frontend.courses.no_notice') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col col-md-8 col-12">
            <div class="card my-3">
                <h4 class="card-header py-3">
                    <i class="fas fa-folder-open mr-2"></i> {{ __('labels.frontend.forum.courses.assignment_list') }}
                    @if(Auth::user()->isExecutive())
                        <span class="float-right d-flex">
                            <a class="text-sm-center text-dark" href="{{ route('admin.forum.assignment.specific', $course) }}">
                                <i class="fas fa-cog"></i>
                            </a>
                        </span>
                    @endif
                </h4>
                <div class="card-body">
                    @if($assignments->count())
                        @foreach($assignments as $assignment)
                            <a class="btn btn-outline-{{ $assignment->label_color }} text-justify my-2"
                               style="width: 100%; display: flex; align-items: baseline;"
                               href="{{ $assignment->assignment_link }}">
                                {{ $assignment->name }}
                                <div style="margin-left: auto;">
                                    <i class="far fa-clock"></i> {{ $assignment->due_time }}
                                    <span class="badge badge-{{ $assignment->label_color }} ml-2">
                                        <i class="fas fa-comments"></i>
                                        {{ $assignment->postsCount() }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col text-center">
                                {{ __('strings.frontend.courses.no_assignment') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
