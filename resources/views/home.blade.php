@extends('layouts.app')

@section('header-left')
    <span class="h2 mb-0 text-white d-block">{{ \App\Helpers\UserGreetings::greet(Auth::user()) }}</span>
@endsection

@section('header-right')

@endsection

@section('content')
    <assignments-collection-component
            :assignments='{!! json_encode($assignments) !!}'
    ></assignments-collection-component>
@endsection