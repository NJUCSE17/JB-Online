@extends('layouts.no-vue')
@section('header-class', 'bg-info-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">文章：{{ $feed->title }}</span>
@endsection

@section('header-right')
    <span class="text-white">
        发布于：{{ $feed->published_at->setTimezone(Auth::user()->timezone) }}
    </span>
@endsection

@section('content')
    <div class="w-100 overflow-hidden blog-feed-content">
        {!! $feed->content_html !!}
    </div>
    <hr class="divider-fade"/>
    <a href="{{ $feed->permalink }}" target="_blank">&lt; 点击此处阅读原文 &gt;</a><br/>
    文章地址：<code>{{ $feed->permalink }}</code>
@endsection
