@extends('layouts.app')
@section('header-class', 'bg-success-dark')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">
        课程列表
    </span>
@endsection

@section('header-right')
@endsection

@section('content')
    <course-list-main
        :timezone="{{ json_encode(Auth::user()->timezone) }}"
    ></course-list-main>
@endsection
