@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.about'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.about'))
@section('appClass', 'app-center')

@section('content')
    <div class="card">
        <h1 class="card-header text-center">
            <img src="{{ asset('favicon.ico') }}" style="height: 50px;">
            {{ app_name() }}
        </h1>
        <div class="card-body">
            @include('frontend.includes.about.function')
        </div>
    </div>
    @include('frontend.includes.about.copyright')
    @include('frontend.includes.about.privacy')
    @include('frontend.includes.about.disclaimer')
@endsection
