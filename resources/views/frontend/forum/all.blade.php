@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.course'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.course'))

@section('content')
    {!! Breadcrumbs::render() !!}
    <div class="card">
        <h4 class="card-header py-3">
            <i class="fas fa-book-open mr-2"></i>
            {{ __('labels.frontend.home.course') }}
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
            @if ($courses->count())
                @foreach($courses as $course)
                    <a class="btn btn-outline-{{ $course->color_label }} text-justify my-1"
                       style="width: 100%; line-height: 30px" href="{{ $course->course_link }}">
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
                <div class="row mt-3 mb-0">
                    <div class="col">
                        <div class="float-left">
                            {{ __('strings.frontend.home.total.left') }}
                            {!! $courses->total() !!}
                            {{ __('strings.frontend.home.total.right') }}
                        </div>
                    </div>
                    <div class="col">
                        <div class="float-right">
                            {!! $courses->render() !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col text-center">
                        {{ __('strings.frontend.home.no_course') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
