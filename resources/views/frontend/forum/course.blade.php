@extends('frontend.layouts.app')

@section('title', app_name() . ' | '.__('navs.general.home'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="page-header text-justify">
        <div class="row">
            <div class="col">
                <h2 class="display-3 d-inline">
                    {{ $course->name }}
                </h2>
                <h4 class="float-right d-inline align-middle">{!! $course->labels !!}</h4>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col col-md-4">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-bullhorn mr-2"></i> {{ __('labels.frontend.forum.courses.course_notice') }}
                </h4>
                <div class="card-body text-justify">
                    @if($course->notice != null)
                        {!! $course->notice !!}
                        <small class="float-right text-muted">{{ $course->time_label }}</small>
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
        <div class="col col-md-8">
            <div class="card my-3">
                <h4 class="card-header">
                    <i class="fas fa-folder-open mr-2"></i> {{ __('labels.frontend.forum.courses.assignment_list') }}
                </h4>
                <div class="card-body">
                    @if($assignments->count())
                        @foreach($assignments as $assignment)
                            <a class="btn btn-outline-{{ $assignment->label_color }} text-justify my-2"
                               href="{{ $assignment->assignment_link }}" style="width: 100%;">
                                {{ $assignment->name }}
                                <span class="float-right">
                                {{ __('labels.general.ddl') }} {{ $assignment->due_time }}
                            </span>
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
