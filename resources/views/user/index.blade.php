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
        {{ $user->student_id }} ({{ $user->id }})
    </span>
@endsection

@section('content')
    @if(Auth::user()->is($user))
        <div id="self">
            <div id="self-control">
                <p class="h3">用户设置</p>
            </div>
            <hr/>
            <div id="self-content">
                TODO: 使用Vue实现异步用户设置面板
            </div>
        </div>
        <hr />
        <personal-assignment-list></personal-assignment-list>
    @elseif(Auth::user()->privilege_level <= 1)
        <div id="admin">
            <div id="admin-control">
                <p class="h3">用户管理</p>
            </div>
            <hr/>
            <div id="admin-content">
                TODO: 使用Vue实现异步用户管理面板
            </div>
        </div>
        <hr />
        <personal-assignment-list></personal-assignment-list>
    @endif
    <div id="feed">
        <div id="feed-control">
            <p class="h3">个人博客</p>
        </div>
        <hr/>
        <div id="feed-content">
            @foreach($feeds as $feed)
                @include('blog.includes.feed-info', ['feed' => $feed])
            @endforeach
        </div>
    </div>
@endsection