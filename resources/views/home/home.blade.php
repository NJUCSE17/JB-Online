@extends('layouts.app')
@section('header-class', 'bg-primary-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">{{ \App\Helpers\UserGreetings::greet(Auth::user()) }}</span>
@endsection

@section('header-right')

@endsection

@section('content')
    <div class="row">
        <div class="col col-md-8 col-12">
            <assignment-list-main></assignment-list-main>
        </div>
        <div class="col col-md-4 col-12">
            <hr class="d-block d-md-none"/>
            @include('home.includes.feeds', ['feeds' => $feeds])
        </div>
    </div>
@endsection