@extends('layouts.app')
@section('header-class', 'bg-info-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">班级博客</span>
@endsection

@section('header-right')
    <span class="text-white">
        更新于：{{ $feeds->first()->created_at }}
    </span>
@endsection

@section('content')
    @foreach($feeds as $feed)
        @include('blog.includes.feed-info', ['feed' => $feed])
    @endforeach
@endsection