@extends('layouts.app')
@section('header-class', 'bg-info-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">班级博客</span>
    <small class="text-white">
        第{{ $feeds->currentPage() }}页，共{{ $feeds->lastPage() }}页（共{{ $feeds->total() }}篇）
    </small>
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
    <hr class="divider-fade" />
    <div class="row mx-2 mb-3">
        <p>
            第{{ $feeds->currentPage() }}页，共{{ $feeds->lastPage() }}页（共{{ $feeds->total() }}篇）
        </p>
        <span class="ml-auto">
            {!! $feeds->render() !!}
        </span>
    </div>
@endsection