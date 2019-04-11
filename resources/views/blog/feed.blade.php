@extends('layouts.app')
@section('header-class', 'bg-info-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">文章：{{ $feed->title }}</span>
@endsection

@section('header-right')
    <span class="text-white">
        发布于：{{ $feed->published_at }}
    </span>
@endsection

@section('content')
    <div class="w-100 overflow-hidden blog-feed-content">
        {!! $feed->content_html !!}
    </div>
@endsection