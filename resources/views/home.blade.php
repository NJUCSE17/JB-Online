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
            <assignments-collection-component
                    :assignments='{!! json_encode($assignments) !!}'
            ></assignments-collection-component>
        </div>
    </div>
@endsection