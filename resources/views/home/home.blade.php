@extends('layouts.app')
@section('header-class', 'bg-primary-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">{{ \App\Helpers\UserGreetings::greet(Auth::user()) }}</span>
@endsection

@section('header-right')

@endsection

@section('content')
    <div class="row">
        <div class="col col-md-8">
            @include('home.includes.assignmentslist', ['assignments' => $assignments])
        </div>
        <div class="col col-md-4">
            @include('home.includes.feeds', ['feeds' => $feeds])
        </div>
    </div>
@endsection