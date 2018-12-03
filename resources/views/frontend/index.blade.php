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
        <div class="col col-lg-7 col-12" id="leftCol">
            @include('frontend.includes.index.assignments', [$assignments])
        </div>

        <div class="col col-lg-5 col-12" id="rightCol">
            @include('frontend.includes.index.notice', [$notice])
            @include('frontend.includes.index.courses', [$ongoingCourses])
            @include('frontend.includes.index.blogonhome')
        </div>
    </div>
@endsection