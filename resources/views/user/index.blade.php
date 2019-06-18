@extends('layouts.app')
@section('header-class', 'bg-warning-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">
        {!! $user->getAvatarImage() !!}
        {{ $user->name }}
    </span>
@endsection

@section('header-right')
    <span class="text-white" style="font-size: 110%;">
        {{ $user->student_id }} ({{ $user->id }}/{{ $user->privilege_level }})
    </span>
@endsection

@section('content')
    <user-info-main
            :user_id="{{ json_encode($user->id) }}"
    ></user-info-main>
    <hr/>
    @if(\Auth::user()->privilege_level <= 2 or \Auth::user()->is($user))
        <personal-assignment-list></personal-assignment-list>
        <hr/>
    @endif
    <blog-feed-list
            :user_id="{{ json_encode($user->id) }}"
            :limit="{{ json_encode(10) }}"
    ></blog-feed-list>
@endsection