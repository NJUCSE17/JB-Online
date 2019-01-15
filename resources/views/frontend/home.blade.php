@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="page-header text-center">
        <div class="card">
            <img class="card-img" src="{{ app_coverart() }}" id="coverart" style="width: 100%">
            <div class="card-img-overlay text-right">
                <h4 class="card-title flipInX animated">
                    {{ app_name() }}
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xl-3 col-12 pr-2 d-none d-xl-block" id="leftCol">
            @include('frontend.includes.index.heatmap')
            @include('frontend.includes.index.blogonhome', [$feeds])
        </div>
        <div class="col col-xl-6 col-md-8 col-12 px-xl-2 pr-md-2" id="middleCol">
            @include('frontend.includes.index.assignments', [$assignments])
        </div>

        <div class="col col-xl-3 col-md-4 col-12 pl-2" id="rightCol">
            @if(Auth::user()->isAdmin())
                @include('frontend.includes.index.admin')
            @endif
            @include('frontend.includes.index.notice', [$notice])
            @include('frontend.includes.index.courses', [$ongoingCourses])
        </div>
    </div>
@endsection