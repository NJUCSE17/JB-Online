@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.about'))
@section('navBrand', app_name() . ' | ' . __('navs.frontend.about'))

@section('content')
    <div class="row my-4 justify-content-center">
        <div class="col">
            {!!  __('strings.frontend.about') !!}
        </div>
    </div><!--row-->
@endsection
