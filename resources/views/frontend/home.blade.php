@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row">
        <div class="col col-xl-3 col-12 d-none d-xl-block px-2" id="leftCol">
            @include('frontend.includes.home.account', [$ongoingCourses, $assignments])
            @include('frontend.includes.home.blogonhome', [$feeds])
        </div>
        <div class="col col-xl-6 col-md-8 col-12 px-2" id="middleCol">
            @include('frontend.includes.home.assignments', [$assignments])
        </div>

        <div class="col col-xl-3 col-md-4 col-12 px-2" id="rightCol">
            @if($logged_in_user->isExecutive() or $logged_in_user->isAdmin())
                @include('frontend.includes.home.admin')
            @endif
            @include('frontend.includes.home.notice', [$notice])
            @include('frontend.includes.home.courses', [$ongoingCourses])
        </div>
    </div>
@endsection